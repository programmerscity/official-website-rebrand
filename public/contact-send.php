<?php
// =============================================
// contact-send.php - Optimized Multi-Layer Defense
// =============================================

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

session_start();

// ---- Logs directory ----
$logDir = __DIR__ . '/logs';
if (!is_dir($logDir)) {
    @mkdir($logDir, 0755, true);
}

// ---- JSON response helper ----
function returnJson(string $status, string $message): void
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// ---- Log helper (only logs when blocking) ----
function logBlock(string $reason, array $data = []): void
{
    global $logDir;
    $log  = "[" . date('Y-m-d H:i:s') . "] BLOCKED: $reason\n";
    $log .= "IP: " . ($_SERVER['REMOTE_ADDR'] ?? 'unknown') . "\n";
    if (!empty($data)) {
        $log .= "Data: " . json_encode($data, JSON_UNESCAPED_SLASHES) . "\n";
    }
    $log .= "-----\n";
    @file_put_contents($logDir . '/spam-blocks.log', $log, FILE_APPEND | LOCK_EX);
}

// =============================================
// LAYER 1: Request Method
// =============================================
if (($_SERVER['REQUEST_METHOD'] ?? '') !== 'POST') {
    returnJson('error', 'Invalid request method.');
}

// =============================================
// LAYER 2: Honeypot
// =============================================
if (!empty($_POST['honeypot'])) {
    logBlock('Honeypot filled');
    returnJson('success', 'Message sent.');
}

// =============================================
// LAYER 3: Minimum Submission Time
// =============================================
$formStart = (int) ($_POST['form_start_time'] ?? 0);
$elapsed = time() - $formStart;

if ($formStart === 0 || $elapsed < 3) {
    logBlock('Too fast', ['elapsed' => $elapsed]);
    returnJson('success', 'Message sent.');
}
if ($elapsed > 7200) {
    returnJson('error', 'Your session expired. Please refresh and try again.');
}

// =============================================
// LAYER 4: Sanitize Input
// =============================================
$fullname = trim($_POST['fullname'] ?? '');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = trim($_POST['phone'] ?? '');
$subject  = trim($_POST['subject'] ?? '');
$message  = trim($_POST['message'] ?? '');

// Required validation
if ($fullname === '' || $email === '' || $subject === '' || $message === '') {
    returnJson('error', 'Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    returnJson('error', 'Invalid email address.');
}

// Header injection prevention
if (preg_match('/[\r\n]/', $fullname . $email . $subject)) {
    logBlock('Header injection');
    returnJson('error', 'Invalid input detected.');
}

// =============================================
// LAYER 5: Fast Spam Scoring
// =============================================
function isGibberish(string $text): bool
{
    $clean = preg_replace('/\s+/', '', $text);
    $len = strlen($clean);
    if ($len < 5) return false;

    // Vowel/consonant ratio
    $vowels = preg_match_all('/[aeiouAEIOU]/', $clean);
    $consonants = preg_match_all('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', $clean);

    if ($consonants > 0 && $vowels === 0) return true;
    if ($vowels > 0 && $consonants > 0 && ($consonants / $vowels) > 6) return true;

    // Long consonant runs
    if (preg_match('/[bcdfghjklmnpqrstvwxyz]{6,}/i', $clean)) return true;

    // Random case transitions
    if ($len > 15) {
        $transitions = 0;
        for ($i = 1; $i < $len; $i++) {
            if (ctype_upper($clean[$i - 1]) !== ctype_upper($clean[$i])) $transitions++;
        }
        if ($transitions / $len > 0.45) return true;
    }

    return false;
}

function calculateSpamScore(string $name, string $email, string $phone, string $subject, string $message): array
{
    $score = 0;
    $reasons = [];

    // Gibberish checks
    if (isGibberish($name)) {
        $score += 15;
        $reasons[] = 'Gibberish name';
    }
    if (isGibberish($subject)) {
        $score += 15;
        $reasons[] = 'Gibberish subject';
    }
    if (isGibberish($message)) {
        $score += 15;
        $reasons[] = 'Gibberish message';
    }

    // Disposable email
    $disposable = [
        'mailinator.com',
        'guerrillamail.com',
        'tempmail.com',
        '10minutemail.com',
        'yopmail.com',
        'sharklasers.com',
        'temp-mail.org',
        'fakeinbox.com',
        'trashmail.com',
        'dispostable.com',
        'getnada.com',
        'throwawaymail.com',
        'mohmal.com',
        'tempinbox.com'
    ];
    $domain = strtolower(substr(strrchr($email, '@') ?: '', 1));
    if (in_array($domain, $disposable, true)) {
        $score += 20;
        $reasons[] = 'Disposable email';
    }

    // Spam keywords
    $keywords = [
        'viagra' => 20,
        'cialis' => 20,
        'casino' => 15,
        'porn' => 20,
        'bitcoin' => 8,
        'crypto investment' => 10,
        'seo services' => 8,
        'guest post' => 8,
        'backlink' => 8,
        'buy followers' => 10,
        'make money fast' => 10,
        'work from home' => 5,
        'loan offer' => 8,
        'claim your prize' => 15,
        'winner' => 8
    ];
    $combined = strtolower($name . ' ' . $subject . ' ' . $message);
    foreach ($keywords as $kw => $pts) {
        if (strpos($combined, $kw) !== false) {
            $score += $pts;
            $reasons[] = "Keyword: $kw";
        }
    }

    // URLs
    $urlCount = preg_match_all('/https?:\/\//i', $message);
    if ($urlCount > 2) {
        $score += 15;
        $reasons[] = "Too many URLs ($urlCount)";
    }

    // Invalid phone format
    if ($phone !== '' && !preg_match('/^[0-9+\-\s()]{7,20}$/', $phone)) {
        $score += 5;
        $reasons[] = 'Invalid phone format';
    }

    return ['score' => $score, 'reasons' => $reasons];
}

$spamResult = calculateSpamScore($fullname, $email, $phone, $subject, $message);
$spamThreshold = 25;

if ($spamResult['score'] >= $spamThreshold) {
    logBlock('Spam score exceeded', [
        'score' => $spamResult['score'],
        'reasons' => $spamResult['reasons'],
        'name' => $fullname,
        'email' => $email,
    ]);
    returnJson('success', 'Message sent.');
}

// =============================================
// LAYER 6: Rate Limiting (optimized)
// =============================================
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rateFile = $logDir . '/rate-' . md5($ip) . '.json';

$requests = [];
if (is_file($rateFile)) {
    $raw = @file_get_contents($rateFile);
    if ($raw) $requests = json_decode($raw, true) ?: [];
}

$now = time();
$requests = array_values(array_filter($requests, fn($t) => $t > ($now - 300)));

if (count($requests) >= 5) {
    logBlock('Rate limit exceeded', ['ip' => $ip]);
    returnJson('error', 'Too many requests. Please wait a few minutes and try again.');
}

$requests[] = $now;
@file_put_contents($rateFile, json_encode($requests), LOCK_EX);

// =============================================
// LAYER 7: Cloudflare Turnstile (FAST cURL)
// =============================================
$turnstileSecret   = $_ENV['TURNSTILE_SECRET_KEY'] ?? '';
$turnstileResponse = $_POST['cf-turnstile-response'] ?? '';

if ($turnstileSecret !== '') {
    if ($turnstileResponse === '') {
        logBlock('Missing Turnstile token');
        returnJson('error', 'Verification failed. Please refresh and try again.');
    }

    $ch = curl_init('https://challenges.cloudflare.com/turnstile/v0/siteverify');
    curl_setopt_array($ch, [
        CURLOPT_POST           => true,
        CURLOPT_POSTFIELDS     => http_build_query([
            'secret'   => $turnstileSecret,
            'response' => $turnstileResponse,
            'remoteip' => $ip,
        ]),
        CURLOPT_RETURNTRANSFER => true,
        CURLOPT_TIMEOUT        => 5,   // 5-second timeout
        CURLOPT_CONNECTTIMEOUT => 3,   // 3-second connect timeout
        CURLOPT_SSL_VERIFYPEER => true,
        CURLOPT_HTTPHEADER     => ['Content-Type: application/x-www-form-urlencoded'],
    ]);
    $verifyResult = curl_exec($ch);
    $curlError = curl_error($ch);
    curl_close($ch);

    if ($curlError || !$verifyResult) {
        error_log('Turnstile cURL error: ' . $curlError);
        // Fail-open: allow through if Cloudflare is unreachable
    } else {
        $verifyData = json_decode($verifyResult, true);
        if (empty($verifyData['success'])) {
            logBlock('Turnstile failed', ['response' => $verifyData]);
            returnJson('error', 'Verification failed. Please try again.');
        }
    }
}

// =============================================
// ALL CHECKS PASSED - BUILD & SEND EMAILS
// =============================================

$safeName    = htmlspecialchars($fullname, ENT_QUOTES, 'UTF-8');
$safePhone   = htmlspecialchars($phone, ENT_QUOTES, 'UTF-8');
$safeSubject = htmlspecialchars($subject, ENT_QUOTES, 'UTF-8');
$safeMessage = nl2br(htmlspecialchars($message, ENT_QUOTES, 'UTF-8'));
$safeEmail   = htmlspecialchars($email, ENT_QUOTES, 'UTF-8');
$phoneDisplay = $safePhone !== '' ? $safePhone : '<span style="color:#475569;">Not Provided</span>';

// ---- Admin email ----
$admin_body = '<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>New Inquiry - Procity Software Hub</title></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
<tr><td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
<img src="https://programmerscity.com/public/assets/images/procity-logo-2.png" alt="Procity" style="display:block;max-width:80px;margin:0 auto 8px;" />
<h1 style="color:#fff;font-size:24px;margin:0;">&#128233; New Contact Form Inquiry</h1>
</td></tr>
<tr><td style="padding:40px;">
<p style="color:#0f172a;font-size:16px;margin:0 0 24px;"><strong>You have received a new inquiry</strong> from your website contact form.</p>
<table width="100%" style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #0b83de;">
<tr><td style="padding-bottom:8px;"><strong>Full Name:</strong> ' . $safeName . '</td></tr>
<tr><td style="padding-bottom:8px;"><strong>Email:</strong> <a href="mailto:' . $safeEmail . '" style="color:#0b83de;">' . $safeEmail . '</a></td></tr>
<tr><td style="padding-bottom:8px;"><strong>Phone:</strong> ' . $phoneDisplay . '</td></tr>
<tr><td style="padding-bottom:8px;"><strong>Subject:</strong> ' . $safeSubject . '</td></tr>
<tr><td style="padding-top:12px;border-top:1px solid #e2e8f0;"><strong>Message:</strong><br>' . $safeMessage . '</td></tr>
</table>
<p style="text-align:center;margin-top:24px;">
<a href="mailto:' . $safeEmail . '" style="display:inline-block;background:#0b83de;color:#fff;font-weight:600;padding:12px 32px;border-radius:50px;text-decoration:none;">Reply to Client</a>
</p>
</td></tr>
<tr><td style="background:#f8fafc;padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center;">
<p style="margin:0;font-size:14px;color:#0f172a;font-weight:700;">Procity Software Hub</p>
<p style="margin:4px 0;font-size:13px;color:#475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
<p style="margin:0;font-size:13px;color:#475569;">
<a href="tel:+2349019606166" style="color:#0b83de;">+234 9019 606166</a> &bull;
<a href="mailto:info@programmerscity.com" style="color:#0b83de;">info@programmerscity.com</a>
</p>
</td></tr>
</table>
</td></tr>
</table>
</body>
</html>';

// ---- Client email ----
$client_body = '<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>We received your inquiry</title></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
<tr><td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
<img src="https://programmerscity.com/public/assets/images/procity-logo-2.png" alt="Procity" style="display:block;max-width:80px;margin:0 auto 8px;" />
<h1 style="color:#fff;font-size:24px;margin:0;">&#9989; Thank You for Reaching Out!</h1>
</td></tr>
<tr><td style="padding:40px;">
<p style="color:#0f172a;font-size:16px;margin:0 0 8px;">Hello <strong>' . $safeName . '</strong>,</p>
<p style="color:#0f172a;font-size:16px;margin:0 0 20px;">Thank you for reaching out to <strong>Procity Software Hub</strong>! We have received your inquiry regarding:</p>
<div style="background:#f8fafc;border-radius:8px;padding:12px 16px;margin:20px 0;border-left:3px solid #0b83de;">
<p style="margin:0;color:#0b83de;font-weight:600;">"' . $safeSubject . '"</p>
</div>
<h3 style="color:#0f172a;">&#128203; What Happens Next?</h3>
<ol style="color:#0f172a;line-height:1.8;">
<li><strong>Review</strong> &ndash; Our team is reviewing your message.</li>
<li><strong>Response</strong> &ndash; We will respond within <strong>24 hours</strong>.</li>
<li><strong>Consultation</strong> &ndash; We will schedule a call to discuss your project.</li>
</ol>
<div style="background:#f8fafc;border-radius:12px;padding:20px;border:1px solid #e2e8f0;text-align:center;margin-top:24px;">
<p style="margin:0 0 12px;color:#0f172a;font-weight:700;">&#128222; Need Immediate Assistance?</p>
<p style="margin:0 0 16px;font-size:14px;color:#475569;">Reach us via phone or WhatsApp.</p>
<a href="tel:+2349019606166" style="display:inline-block;background:#0b83de;color:#fff;font-weight:600;padding:14px 28px;border-radius:50px;text-decoration:none;margin:4px;">&#128222; Call Us</a>
<a href="https://wa.me/2349019606166" style="display:inline-block;background:#25D366;color:#fff;font-weight:600;padding:14px 28px;border-radius:50px;text-decoration:none;margin:4px;">&#128172; WhatsApp</a>
</div>
</td></tr>
<tr><td style="background:#f8fafc;padding:20px 40px;border-top:1px solid #e2e8f0;text-align:center;">
<p style="margin:0;font-size:14px;color:#0f172a;font-weight:700;">Procity Software Hub</p>
<p style="margin:4px 0;font-size:13px;color:#475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
<p style="margin:0;font-size:13px;color:#475569;">
<a href="tel:+2349019606166" style="color:#0b83de;">+234 9019 606166</a> &bull;
<a href="mailto:info@programmerscity.com" style="color:#0b83de;">info@programmerscity.com</a>
</p>
</td></tr>
</table>
</td></tr>
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
    $mail->Port       = (int) ($_ENV['MAIL_PORT'] ?? 465);
    $mail->CharSet    = 'UTF-8';
    $mail->Timeout    = 15;

    $mail->setFrom('info@programmerscity.com', 'Procity Software Hub');
    $mail->addReplyTo($email, $fullname);

    // Admin
    $mail->addAddress('info@programmerscity.com');
    $mail->Subject = 'New Inquiry: ' . $subject;
    $mail->Body    = $admin_body;
    $mail->AltBody = "New Inquiry from $fullname\nEmail: $email\nPhone: $phone\nSubject: $subject\n\n$message";
    $adminSent = $mail->send();

    // Client
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = 'We received your inquiry, ' . $fullname;
    $mail->Body    = $client_body;
    $mail->AltBody = "Hello $fullname,\n\nThank you for contacting Procity Software Hub.\n\n$subject\n\nWe'll respond within 24 hours.\n\nCall: +234 9019 606166\nWhatsApp: https://wa.me/2349019606166";
    $clientSent = $mail->send();

    $success = $adminSent && $clientSent;
} catch (Exception $e) {
    error_log('PHPMailer error: ' . $e->getMessage());
}

if ($success) {
    returnJson('success', 'Your message has been sent successfully!');
} else {
    returnJson('error', 'There was a problem sending your message. Please call us at +234 9019 606166.');
}
