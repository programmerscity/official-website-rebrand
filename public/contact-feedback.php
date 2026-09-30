<?php
// =============================================
// contact-feedback.php
// Complete anti-spam + email handler
// =============================================

// ---- 1. Load environment FIRST ----
require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;
use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// ---- 2. Start session AFTER autoload (for rate limiting) ----
session_start();

// ---- 3. Create logs directory ----
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// ---- 4. JSON response helper (MUST be defined before use) ----
function returnJson(string $status, string $message): void
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// ---- 5. Log helper for debugging ----
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
    returnJson('success', 'Message sent.'); // Silent success to fool bots
}

// =============================================
// LAYER 3: Minimum Submission Time Check
// =============================================
// Bots submit forms instantly. Humans take at least 3 seconds.
$form_start_time = (int) ($_POST['form_start_time'] ?? 0);
$elapsed = time() - $form_start_time;

if ($form_start_time === 0 || $elapsed < 3) {
    logBlock('Form submitted too fast', ['elapsed' => $elapsed]);
    returnJson('success', 'Message sent.');
}

// Also block if form was open for more than 2 hours (likely bot replay)
if ($elapsed > 7200) {
    logBlock('Form session expired', ['elapsed' => $elapsed]);
    returnJson('error', 'Your session expired. Please refresh and try again.');
}

// =============================================
// LAYER 4: Referer Check
// =============================================
$referer = $_SERVER['HTTP_REFERER'] ?? '';
$allowed_hosts = ['programmerscity.com', 'www.programmerscity.com', 'localhost'];

if (!empty($referer)) {
    $referer_host = parse_url($referer, PHP_URL_HOST);
    if (!in_array($referer_host, $allowed_hosts)) {
        logBlock('Invalid referer', ['referer' => $referer]);
        returnJson('success', 'Message sent.');
    }
}

// =============================================
// LAYER 5: User-Agent Check
// =============================================
$user_agent = $_SERVER['HTTP_USER_AGENT'] ?? '';

// Block if no user agent
if (empty($user_agent)) {
    logBlock('Empty user agent');
    returnJson('success', 'Message sent.');
}

// Block known bot user agents
$bot_patterns = [
    'curl',
    'wget',
    'python',
    'python-requests',
    'python-urllib',
    'java/',
    'libwww',
    'httpclient',
    'go-http-client',
    'ruby',
    'perl',
    'php',
    'scrapy',
    'axios',
    'node-fetch',
    'okhttp',
    'headlesschrome',
    'phantomjs',
    'selenium',
    'puppeteer',
    'bot',
    'crawler',
    'spider',
    'scraper',
    'postman'
];

foreach ($bot_patterns as $pattern) {
    if (stripos($user_agent, $pattern) !== false) {
        logBlock('Bot user agent detected', ['ua' => $user_agent]);
        returnJson('success', 'Message sent.');
    }
}

// =============================================
// LAYER 6: IP-Based Rate Limiting
// =============================================
$ip = $_SERVER['REMOTE_ADDR'] ?? 'unknown';
$rate_file = __DIR__ . '/logs/rate-limit-' . md5($ip) . '.json';
$time_window = 300; // 5 minutes
$max_requests = 3;

$requests = [];
if (file_exists($rate_file)) {
    $requests = json_decode(file_get_contents($rate_file), true) ?: [];
}

// Filter out old requests
$requests = array_filter($requests, fn($t) => $t > (time() - $time_window));

if (count($requests) >= $max_requests) {
    logBlock('Rate limit exceeded', ['ip' => $ip, 'count' => count($requests)]);
    returnJson('error', 'Too many requests. Please try again in a few minutes.');
}

// Record this request
$requests[] = time();
file_put_contents($rate_file, json_encode($requests));

// =============================================
// LAYER 7: reCAPTCHA v3 Verification
// =============================================
$recaptcha_token  = $_POST['recaptcha_token'] ?? '';
$recaptcha_secret = $_ENV['RECAPTCHA_SECRET_KEY'] ?? '';

// Only verify if secret key is configured
if (!empty($recaptcha_secret)) {
    if (empty($recaptcha_token)) {
        logBlock('Missing reCAPTCHA token');
        returnJson('error', 'Verification failed. Please refresh and try again.');
    }

    $recaptcha_url = 'https://www.google.com/recaptcha/api/siteverify';
    $recaptcha_response = file_get_contents(
        $recaptcha_url . '?secret=' . urlencode($recaptcha_secret) . '&response=' . urlencode($recaptcha_token) . '&remoteip=' . urlencode($ip)
    );
    $recaptcha_data = json_decode($recaptcha_response, true);

    $score = $recaptcha_data['score'] ?? 0;
    $success = $recaptcha_data['success'] ?? false;
    $action = $recaptcha_data['action'] ?? '';

    // Require score >= 0.5 and correct action
    if (!$success || $score < 0.5 || $action !== 'contact_submit') {
        logBlock('reCAPTCHA failed', [
            'score' => $score,
            'success' => $success,
            'action' => $action,
            'response' => $recaptcha_data
        ]);
        returnJson('error', 'Verification failed. Please try again.');
    }
}

// =============================================
// LAYER 8: Sanitize Input
// =============================================
$fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''), ENT_QUOTES, 'UTF-8');
$email    = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone    = htmlspecialchars(trim($_POST['phone'] ?? ''), ENT_QUOTES, 'UTF-8');
$subject  = htmlspecialchars(trim($_POST['subject'] ?? ''), ENT_QUOTES, 'UTF-8');
$message  = htmlspecialchars(trim($_POST['message'] ?? ''), ENT_QUOTES, 'UTF-8');

// =============================================
// LAYER 9: Required Field Validation
// =============================================
if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
    returnJson('error', 'Please fill in all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    returnJson('error', 'Invalid email address.');
}

// =============================================
// LAYER 10: Gibberish / Entropy Detection
// =============================================
function isGibberish(string $text): bool
{
    // Strip spaces
    $clean = preg_replace('/\s+/', '', $text);

    // Too short = suspicious
    if (strlen($clean) < 2) return false;

    // Check vowel/consonant ratio
    $vowels     = preg_match_all('/[aeiouAEIOU]/', $clean);
    $consonants = preg_match_all('/[bcdfghjklmnpqrstvwxyzBCDFGHJKLMNPQRSTVWXYZ]/', $clean);

    // If there are consonants but very few vowels, it's likely gibberish
    if ($consonants > 0 && $vowels === 0) return true;

    // Normal English words have a vowel-to-consonant ratio between 0.3 and 1.5
    if ($vowels > 0 && $consonants > 0) {
        $ratio = $consonants / $vowels;
        if ($ratio > 6) return true; // Too many consonants = gibberish
    }

    // Check for long runs of consonants (>5 in a row)
    if (preg_match('/[bcdfghjklmnpqrstvwxyz]{6,}/i', $clean)) {
        return true;
    }

    // Check for random mixed case (e.g., "mVAOBnxrYyilReutuKGooGLG")
    $upperCount = preg_match_all('/[A-Z]/', $clean);
    $lowerCount = preg_match_all('/[a-z]/', $clean);
    if (strlen($clean) > 15 && $upperCount > 3 && $lowerCount > 3) {
        // Count case transitions
        $transitions = 0;
        $len = strlen($clean);
        for ($i = 1; $i < $len; $i++) {
            $prevUpper = ctype_upper($clean[$i - 1]);
            $currUpper = ctype_upper($clean[$i]);
            if ($prevUpper !== $currUpper) $transitions++;
        }
        // Too many case transitions = random string
        if ($transitions / $len > 0.5) return true;
    }

    return false;
}

// Apply gibberish check to name and subject (not message — real messages can be short)
if (isGibberish($fullname)) {
    logBlock('Gibberish name detected', ['name' => $fullname]);
    returnJson('success', 'Message sent.');
}

if (isGibberish($subject)) {
    logBlock('Gibberish subject detected', ['subject' => $subject]);
    returnJson('success', 'Message sent.');
}

if (isGibberish($message) && strlen($message) < 100) {
    logBlock('Gibberish message detected', ['message' => $message]);
    returnJson('success', 'Message sent.');
}

// =============================================
// LAYER 11: Link / Spam Keyword Detection
// =============================================
$spam_keywords = [
    'viagra',
    'cialis',
    'casino',
    'porn',
    'xxx',
    'bitcoin',
    'crypto investment',
    'loan offer',
    'seo services',
    'guest post',
    'backlink',
    'buy followers',
    'make money fast',
    'work from home'
];

$combined = strtolower($fullname . ' ' . $subject . ' ' . $message);

foreach ($spam_keywords as $keyword) {
    if (strpos($combined, $keyword) !== false) {
        logBlock('Spam keyword detected', ['keyword' => $keyword]);
        returnJson('success', 'Message sent.');
    }
}

// Block messages with too many URLs
$url_count = preg_match_all('/https?:\/\//i', $message);
if ($url_count > 2) {
    logBlock('Too many URLs', ['count' => $url_count]);
    returnJson('success', 'Message sent.');
}

// Block messages that are mostly URLs
if (strlen($message) > 0 && $url_count > 0) {
    $url_length = preg_match_all('/https?:\/\/\S+/i', $message, $matches);
    $total_url_chars = 0;
    foreach ($matches[0] as $url) $total_url_chars += strlen($url);
    if ($total_url_chars / strlen($message) > 0.6) {
        logBlock('Message is mostly URLs');
        returnJson('success', 'Message sent.');
    }
}

// =============================================
// LAYER 12: Header Injection Prevention
// =============================================
if (preg_match('/[\r\n]/', $fullname . $email . $subject)) {
    logBlock('Header injection attempt');
    returnJson('error', 'Invalid input detected.');
}

// =============================================
// ALL CHECKS PASSED - BUILD AND SEND EMAILS
// =============================================

// ---- Admin email ----
$admin_body = '
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>New Inquiry - Procity Software Hub</title></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
<tr><td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
<img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity" style="display:block;max-width:60px;margin:0 auto 8px;" />
<h1 style="color:#fff;font-size:24px;margin:0;">📩 New Contact Form Inquiry</h1>
</td></tr>
<tr><td style="padding:40px;">
<p style="color:#0f172a;font-size:16px;"><strong>You have received a new inquiry</strong> from your website contact form.</p>
<table width="100%" style="background:#f8fafc;border-radius:12px;padding:20px;border-left:4px solid #0b83de;">
<tr><td style="padding-bottom:8px;"><strong>Full Name:</strong> ' . $fullname . '</td></tr>
<tr><td style="padding-bottom:8px;"><strong>Email:</strong> <a href="mailto:' . $email . '" style="color:#0b83de;">' . $email . '</a></td></tr>
<tr><td style="padding-bottom:8px;"><strong>Phone:</strong> ' . (!empty($phone) ? $phone : 'Not Provided') . '</td></tr>
<tr><td style="padding-bottom:8px;"><strong>Subject:</strong> ' . $subject . '</td></tr>
<tr><td style="padding-top:12px;border-top:1px solid #e2e8f0;"><strong>Message:</strong><br>' . nl2br($message) . '</td></tr>
</table>
<p style="text-align:center;margin-top:24px;">
<a href="mailto:' . $email . '" style="display:inline-block;background:#0b83de;color:#fff;font-weight:600;padding:12px 32px;border-radius:50px;text-decoration:none;">Reply to Client</a>
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

// ---- Client acknowledgment email ----
$client_body = '
<!DOCTYPE html>
<html lang="en">
<head><meta charset="UTF-8"><title>We received your inquiry</title></head>
<body style="margin:0;padding:0;font-family:Arial,sans-serif;background:#f8fafc;">
<table width="100%" cellpadding="0" cellspacing="0" style="background:#f8fafc;padding:40px 0;">
<tr><td align="center">
<table width="600" cellpadding="0" cellspacing="0" style="background:#fff;border-radius:16px;box-shadow:0 4px 24px rgba(0,0,0,.08);overflow:hidden;max-width:600px;">
<tr><td style="background:linear-gradient(135deg,#0b83de,#004c98);padding:32px 40px;text-align:center;">
<img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity" style="display:block;max-width:60px;margin:0 auto 8px;" />
<h1 style="color:#fff;font-size:24px;margin:0;">✅ Thank You for Reaching Out!</h1>
</td></tr>
<tr><td style="padding:40px;">
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
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = 'We received your inquiry, ' . $fullname;
    $mail->Body    = $client_body;
    $mail->AltBody = "Hello $fullname,\n\nThank you for contacting Procity Software Hub.\n\n$subject\n\nWe'll respond within 24 hours.\n\nCall: +234 9019 606166\nWhatsApp: https://wa.me/2349019606166";
    $client_sent = $mail->send();

    $success = $admin_sent && $client_sent;
} catch (Exception $e) {
    error_log('PHPMailer error: ' . $e->getMessage());
}

// ---- Final response ----
if ($success) {
    returnJson('success', 'Your message has been sent successfully!');
} else {
    returnJson('error', 'There was a problem sending your message. Please call us at +234 9019 606166.');
}
