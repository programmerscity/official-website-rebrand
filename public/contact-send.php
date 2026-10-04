<?php
// =============================================
// contact-send.php - Custom Spam Scoring + Turnstile
// =============================================

// ---- 1. Load environment ----
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ---- 2. Start session ----
session_start();

// ---- 3. Create logs directory ----
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// ---- 4. JSON response helper ----
function returnJson(string $status, string $message): void
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// ---- 5. Log helper ----
function logBlock(string $reason, array $data = []): void
{
    $log  = "[" . date('Y-m-d H:i:s') . "] BLOCKED: $reason\n";
    $log .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
    $log .= "UA: " . ($_SERVER['HTTP_USER_AGENT'] ?? 'unknown') . "\n";
    if (!empty($data)) {
        $log .= "Data: " . json_encode($data) . "\n";
    }
    $log .= "-----\n";
    file_put_contents(__DIR__ . '/logs/spam-blocks.log', $log, FILE_APPEND);
}

// =============================================
// LAYER 1: Request Method Check
// =============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnJson('error', 'Invalid request method.');
}

// =============================================
// LAYER 2: Honeypot Check
// =============================================
if (!empty($_POST['honeypot'])) {
    logBlock('Honeypot field filled');
    returnJson('success', 'Message sent.'); // Silent success
}

// =============================================
// LAYER 3: Minimum Submission Time Check
// =============================================
$form_start_time = (int) ($_POST['form_start_time'] ?? 0);
$elapsed = time() - $form_start_time;

if ($form_start_time === 0 || $elapsed < 3) {
    logBlock('Form submitted too fast', ['elapsed' => $elapsed]);
    returnJson('success', 'Message sent.');
}
if ($elapsed > 7200) {
    logBlock('Form session expired', ['elapsed' => $elapsed]);
    returnJson('error', 'Your session expired. Please refresh and try again.');
}

// =============================================
// LAYER 4: IP-Based Rate Limiting
// =============================================
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_file = __DIR__ . '/logs/rate-limit-' . md5($ip) . '.json';
$time_window = 300; // 5 minutes
$max_requests = 3;

$requests = [];
if (file_exists($rate_file)) {
    $requests = json_decode(file_get_contents($rate_file), true) ?: [];
}
$requests = array_filter($requests, fn($t) => $t > (time() - $time_window));

if (count($requests) >= $max_requests) {
    logBlock('Rate limit exceeded', ['ip' => $ip, 'count' => count($requests)]);
    returnJson('error', 'Too many requests. Please try again in a few minutes.');
}
$requests[] = time();
file_put_contents($rate_file, json_encode($requests));

// =============================================
// LAYER 5: Cloudflare Turnstile Validation
// =============================================
$turnstile_secret = $_ENV['TURNSTILE_SECRET_KEY'] ?? '';
$turnstile_response = $_POST['cf-turnstile-response'] ?? '';

if (!empty($turnstile_secret)) {
    if (empty($turnstile_response)) {
        logBlock('Missing Turnstile token');
        returnJson('error', 'Verification failed. Please refresh and try again.');
    }

    $verify_url = 'https://challenges.cloudflare.com/turnstile/v0/siteverify';
    $data = [
        'secret' => $turnstile_secret,
        'response' => $turnstile_response,
        'remoteip' => $ip,
    ];

    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    $context  = stream_context_create($options);
    $result = file_get_contents($verify_url, false, $context);
    $response = json_decode($result, true);

    if (!$response || !$response['success']) {
        logBlock('Turnstile validation failed', ['response' => $response]);
        returnJson('error', 'Verification failed. Please try again.');
    }
}

// =============================================
// LAYER 6: Sanitize Input
// =============================================
$fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''), ENT_QUOTES, 'UTF-8');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
$subject  = htmlspecialchars(trim($_POST['subject'] ?? ''), ENT_QUOTES, 'UTF-8');
$message  = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');

// =============================================
// LAYER 7: Required Field Validation
// =============================================
if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
    returnJson('error', 'Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    returnJson('error', 'Invalid email address.');
}

// =============================================
// LAYER 8: CUSTOM SPAM SCORING ENGINE
// =============================================
function calculateSpamScore(string $name, string $email, string $phone, string $subject, string $message): array
{
    $score = 0;
    $reasons = [];

    // --- Gibberish Detection (Name) ---
    if (isGibberish($name)) {
        $score += 10;
        $reasons[] = "Gibberish name";
    }
    // --- Gibberish Detection (Subject) ---
    if (isGibberish($subject)) {
        $score += 10;
        $reasons[] = "Gibberish subject";
    }
    // --- Gibberish Detection (Message) ---
    if (isGibberish($message)) {
        $score += 10;
        $reasons[] = "Gibberish message";
    }

    // --- Disposable Email Check ---
    $disposable_domains = [
        'mailinator.com',
        'guerrillamail.com',
        'tempmail.com',
        '10minutemail.com',
        'throwawaymail.com',
        'yopmail.com',
        'getnada.com',
        'sharklasers.com',
        'temp-mail.org',
        'fakeinbox.com',
        'trashmail.com',
        'dispostable.com'
    ];
    $email_domain = strtolower(substr(strrchr($email, "@"), 1));
    if (in_array($email_domain, $disposable_domains)) {
        $score += 15;
        $reasons[] = "Disposable email domain";
    }

    // --- Spam Keywords ---
    $spam_keywords = [
        'viagra' => 15,
        'cialis' => 15,
        'casino' => 10,
        'porn' => 15,
        'bitcoin' => 5,
        'crypto investment' => 10,
        'seo services' => 8,
        'guest post' => 8,
        'backlink' => 8,
        'buy followers' => 10,
        'make money fast' => 10,
        'work from home' => 5,
        'loan offer' => 8,
        'winner' => 8,
        'claim your prize' => 15,
        'urgent' => 2
    ];
    $combined = strtolower($name . ' ' . $subject . ' ' . $message);
    foreach ($spam_keywords as $keyword => $points) {
        if (strpos($combined, $keyword) !== false) {
            $score += $points;
            $reasons[] = "Keyword: $keyword (+$points)";
        }
    }

    // --- URL Analysis ---
    $url_count = preg_match_all('/https?:\/\//i', $message);
    if ($url_count > 0) {
        $score += ($url_count * 5);
        $reasons[] = "Contains $url_count URL(s)";
    }
    if ($url_count > 2) {
        $score += 10;
        $reasons[] = "Excessive URLs";
    }

    // --- Phone Number Validity (Basic) ---
    if (!empty($phone) && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
        $score += 5;
        $reasons[] = "Invalid phone format";
    }

    // --- Header Injection ---
    if (preg_match('/[\r\n]/', $name . $email . $subject)) {
        $score += 20;
        $reasons[] = "Header injection attempt";
    }

    return ['score' => $score, 'reasons' => $reasons];
}

// --- Helper: Gibberish Detector ---
function isGibberish(string $text): bool
{
    $clean = preg_replace('/\s+/', '', $text);
    if (strlen($clean) < 2) return false;

    $vowels     = preg_match_all('/[aeiouAEIOU]/', $clean);
    $consonants = preg_match_all('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', $clean);

    if ($consonants > 0 && $vowels === 0) return true;
    if ($vowels > 0 && $consonants > 0) {
        $ratio = $consonants / $vowels;
        if ($ratio > 6) return true;
    }
    if (preg_match('/[bcdfghjklmnpqrstvwxyz]{6,}/i', $clean)) return true;

    $upperCount = preg_match_all('/[A-Z]/', $clean);
    $lowerCount = preg_match_all('/[a-z]/', $clean);
    if (strlen($clean) > 15 && $upperCount > 3 && $lowerCount > 3) {
        $transitions = 0;
        $len = strlen($clean);
        for ($i = 1; $i < $len; $i++) {
            if (ctype_upper($clean[$i - 1]) !== ctype_upper($clean[$i])) $transitions++;
        }
        if ($transitions / $len > 0.5) return true;
    }
    return false;
}

// --- Calculate the score ---
$spamResult = calculateSpamScore($fullname, $email, $phone, $subject, $message);

// --- Set your spam threshold ---
// A score of 20 or more is considered spam. Adjust this value to be more or less strict.
$spam_threshold = 20;

if ($spamResult['score'] >= $spam_threshold) {
    logBlock('Spam score exceeded', [
        'score' => $spamResult['score'],
        'reasons' => $spamResult['reasons'],
        'name' => $fullname,
        'email' => $email,
        'subject' => $subject
    ]);
    returnJson('success', 'Message sent.'); // Silent success to fool bots
}

// =============================================
// ALL CHECKS PASSED - BUILD AND SEND EMAILS
// =============================================

// ---- Admin email ----
$admin_body = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>New Inquiry - Procity Software Hub</title>
</head>

<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
                            <img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity" style="display:block;max-width:60px;margin:0 auto 8px;" />
                            <h1 style="color:#fff;font-size:24px;margin:0;">📩 New Contact Form Inquiry</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <p style="color:#0f172a;font-size:16px;"><strong>You have received a new inquiry</strong> from your website contact form.</p>
                            <table width="100%" style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #0b83de;">
                                <tr>
                                    <td style="padding-bottom:8px;"><strong>Full Name:</strong> ' . $fullname . '</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:8px;"><strong>Email:</strong> <a href="mailto:' . $email . '" style="color:#0b83de;">' . $email . '</a></td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:8px;"><strong>Phone:</strong> ' . (!empty($phone) ? $phone : 'Not Provided') . '</td>
                                </tr>
                                <tr>
                                    <td style="padding-bottom:8px;"><strong>Subject:</strong> ' . $subject . '</td>
                                </tr>
                                <tr>
                                    <td style="padding-top:12px;border-top:1px solid #e2e8f0;"><strong>Message:</strong><br>' . nl2br($message) . '</td>
                                </tr>
                            </table>
                            <p style="text-align:center;margin-top:24px;">
                                <a href="mailto:' . $email . '" style="display:inline-block;background:#0b83de;color:#fff;font-weight:600;padding:12px 32px;border-radius:50px;text-decoration:none;">Reply to Client</a>
                            </p>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8fafc;padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center;">
                            <p style="margin:0;font-size:14px;color:#0f172a;font-weight:700;">Procity Software Hub</p>
                            <p style="margin:4px 0;font-size:13px;color:#475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
                            <p style="margin:0;font-size:13px;color:#475569;">
                                <a href="tel:+2349019606166" style="color:#0b83de;">+234 9019 606166</a> &bull;
                                <a href="mailto:info@programmerscity.com" style="color:#0b83de;">info@programmerscity.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

// ---- Client acknowledgment email ----
$client_body = '
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <title>We received your inquiry</title>
</head>

<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
    <table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
        <tr>
            <td align="center">
                <table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
                    <tr>
                        <td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
                            <img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity" style="display:block;max-width:60px;margin:0 auto 8px;" />
                            <h1 style="color:#fff;font-size:24px;margin:0;">✅ Thank You for Reaching Out!</h1>
                        </td>
                    </tr>
                    <tr>
                        <td style="padding:40px;">
                            <p style="color:#0f172a;font-size:16px;">Hello <strong>' . $fullname . '</strong>,</p>
                            <p style="color:#0f172a;font-size:16px;">Thank you for reaching out to <strong>Procity Software Hub</strong>! We have received your inquiry regarding:</p>
                            <div style="background:#f8fafc;border-radius:8px;padding:12px 16px;margin:20px 0;border-left:3px solid #0b83de;">
                                <p style="margin:0;color:#0b83de;font-weight:600;">"' . $subject . '"</p>
                            </div>
                            <h3 style="color:#0f172a;">📋 What Happens Next?</h3>
                            <ol style="color:#0f172a;line-height:1.8;">
                                <li><strong>Review</strong> – Our team is reviewing your message.</li>
                                <li><strong>Response</strong> – We will respond within <strong>24 hours</strong>.</li>
                                <li><strong>Consultation</strong> – We\'ll schedule a call to discuss your project.</li>
                            </ol>
                            <div style="background:#f8fafc;border-radius:12px;padding:20px;border:1px solid #e2e8f0;text-align:center;margin-top:24px;">
                                <p style="margin:0 0 12px;color:#0f172a;font-weight:700;">📞 Need Immediate Assistance?</p>
                                <p style="margin:0 0 16px;font-size:14px;color:#475569;">Reach us via phone or WhatsApp.</p>
                                <a href="tel:+2349019606166" style="display:inline-block;background:#0b83de;color:#fff;font-weight:600;padding:14px 28px;border-radius:50px;text-decoration:none;margin:4px;">📞 Call Us</a>
                                <a href="https://wa.me/2349019606166" style="display:inline-block;background:#25D366;color:#fff;font-weight:600;padding:14px 28px;border-radius:50px;text-decoration:none;margin:4px;">💬 WhatsApp</a>
                            </div>
                        </td>
                    </tr>
                    <tr>
                        <td style="background:#f8fafc;padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center;">
                            <p style="margin:0;font-size:14px;color:#0f172a;font-weight:700;">Procity Software Hub</p>
                            <p style="margin:4px 0;font-size:13px;color:#475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
                            <p style="margin:0;font-size:13px;color:#475569;">
                                <a href="tel:+2349019606166" style="color:#0b83de;">+234 9019 606166</a> &bull;
                                <a href="mailto:info@programmerscity.com" style="color:#0b83de;">info@programmerscity.com</a>
                            </p>
                        </td>
                    </tr>
                </table>
            </td>
        </tr>
    </table>
</body>

</html>';

// ---- Send via SMTP ----
$success = false;
try {
    $mail = new PHPMailer(true);
    $mail->isSMTP();
    $mail->Host       = $_ENV['MAIL_HOST']       ?? 'programmerscity.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USERNAME']   ?? 'info@programmerscity.com';
    $mail->Password   = $_ENV['MAIL_PASSWORD']   ?? '';
    $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? 'ssl';
    $mail->Port       = $_ENV['MAIL_PORT']       ?? 465;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('info@programmerscity.com', 'Procity Software Hub');
    $mail->addReplyTo($email, $fullname);

    // Admin
    $mail->addAddress('info@programmerscity.com');
    $mail->Subject = 'New Inquiry: ' . $subject;
    $mail->Body    = $admin_body;
    $mail->AltBody = "New Inquiry from $fullname\nEmail: $email\nPhone: $phone\nSubject: $subject\n\n$message";
    $admin_sent = $mail->send();

    // Client
    // $mail->clearAddresses();
    // $mail->addAddress($email);
    // $mail->Subject = 'We received your inquiry, ' . $fullname;
    // $mail->Body    = $client_body;
    // $mail->AltBody = "Hello $fullname,\n\nThank you for contacting Procity Software Hub.\n\n$subject\n\nWe'll respond within 24 hours.\n\nCall: +234 9019 606166\nWhatsApp: https://wa.me/2349019606166";
    // $client_sent = $mail->send();

    // $success = $admin_sent && $client_sent;
    $success = $admin_sent;
} catch (Exception $e) {
    error_log('PHPMailer error: ' . $e->getMessage());
}

// ---- Final response ----
if ($success) {
    returnJson('success', 'Your message has been sent successfully!');
} else {
    returnJson('error', 'There was a problem sending your message. Please call us at +234 9019 606166.');
}
