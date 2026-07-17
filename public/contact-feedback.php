<?php
// contact-feedback.php

require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

// Helper to return JSON response
function returnJson($status, $message)
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// =============================================
// 1. Ensure this is a POST request
// =============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnJson('error', 'Invalid request method. Please use POST.');
}

// =============================================
// 2. Validate Input
// =============================================
$fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

// Required field validation
if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
    returnJson('error', 'Please fill in all required fields.');
}

if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    returnJson('error', 'Invalid email address.');
}

// =============================================
// 3. Build Email Content
// =============================================
$admin_subject = "Website Contact: " . $subject;

// Admin email body (HTML)
$admin_body = "
<html>
<head><title>New Contact Form Inquiry</title></head>
<body style='font-family: Arial, sans-serif;'>
    <h2 style='color: #0b83de;'>New Inquiry from Programmers City Website</h2>
    <p><strong>Full Name:</strong> {$fullname}</p>
    <p><strong>Email:</strong> {$email}</p>
    <p><strong>Phone:</strong> " . (!empty($phone) ? $phone : 'Not Provided') . "</p>
    <p><strong>Subject:</strong> {$subject}</p>
    <hr>
    <p><strong>Message:</strong></p>
    <p style='background: #f8fafc; padding: 15px; border-left: 4px solid #0b83de;'>{$message}</p>
</body>
</html>
";

// Client acknowledgment email body (HTML)
$client_subject = "We received your inquiry, " . $fullname;
$client_body = "
<html>
<head><title>We received your message</title></head>
<body style='font-family: Arial, sans-serif;'>
    <p>Hello <strong>{$fullname}</strong>,</p>
    <p>Thank you for reaching out to <strong>Programmers City Software Hub</strong>! We have successfully received your inquiry regarding: <strong>\"{$subject}\"</strong>.</p>
    <p>Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.</p>
    <hr>
    <p><em>For urgent inquiries, please feel free to call us directly at <a href='tel:+2349019606166'>+234 9019 606166</a>.</em></p>
    <br>
    <p>Warm regards,<br>
    <strong>The Programmers City Team</strong></p>
    <p style='font-size: 12px; color: #475569;'>181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State, Nigeria.</p>
</body>
</html>
";

// =============================================
// 4. Send Emails Using PHPMailer with cPanel SMTP
// =============================================

$success = false;

try {
    // Load PHPMailer classes
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/PHPMailer.php';
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/SMTP.php';
    require_once __DIR__ . '/../vendor/phpmailer/phpmailer/src/Exception.php';

    $mail = new \PHPMailer\PHPMailer\PHPMailer(true);

    // Enable verbose debug output (set to 0 for production, 2 for testing)
    $mail->SMTPDebug = 2; // Change to 2 to see detailed SMTP logs

    // SMTP Configuration (cPanel Webmail)
    $mail->isSMTP();
    $mail->Host       = $_ENV['MAIL_HOST'] ?? 'programmerscity.com';  // cPanel mail server
    $mail->SMTPAuth   = true;
    $mail->Username   = $_ENV['MAIL_USERNAME'] ?? 'info@programmerscity.com'; // Full email address
    $mail->Password   = $_ENV['MAIL_PASSWORD'] ?? ''; // Email account password
    $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'] ?? 'ssl'; // ssl (port 465) or tls (port 587)
    $mail->Port       = $_ENV['MAIL_PORT'] ?? 465; // 465 for SSL, 587 for TLS
    $mail->CharSet    = 'UTF-8';

    // Sender
    $mail->setFrom(
        $_ENV['MAIL_FROM_ADDRESS'] ?? 'info@programmerscity.com',
        $_ENV['MAIL_FROM_NAME'] ?? 'Programmers City Software Hub'
    );
    $mail->addReplyTo($email, $fullname);

    // Admin recipient
    $mail->addAddress($_ENV['ADMIN_EMAIL'] ?? 'info@programmerscity.com');

    // Email content
    $mail->isHTML(true);
    $mail->Subject = $admin_subject;
    $mail->Body    = $admin_body;
    $mail->AltBody = strip_tags($admin_body);

    $admin_sent = $mail->send();

    // Send client acknowledgment
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = $client_subject;
    $mail->Body    = $client_body;
    $mail->AltBody = strip_tags($client_body);

    $client_sent = $mail->send();

    $success = ($admin_sent && $client_sent);
} catch (\Exception $e) {
    error_log("PHPMailer Error: " . $e->getMessage());
    $success = false;
}

// =============================================
// 5. Fallback to native mail() if SMTP fails
// =============================================
if (!$success) {
    // Admin email using mail()
    $admin_headers = "MIME-Version: 1.0" . "\r\n";
    $admin_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $admin_headers .= "From: " . $email . "\r\n";
    $admin_headers .= "Reply-To: " . $email . "\r\n";

    $admin_sent = mail(
        $_ENV['ADMIN_EMAIL'] ?? 'info@programmerscity.com',
        $admin_subject,
        $admin_body,
        $admin_headers
    );

    // Client acknowledgment using mail()
    $client_headers = "MIME-Version: 1.0" . "\r\n";
    $client_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $client_headers .= "From: Programmers City Software Hub <" . ($_ENV['MAIL_FROM_ADDRESS'] ?? 'info@programmerscity.com') . ">" . "\r\n";

    $client_sent = mail(
        $email,
        $client_subject,
        $client_body,
        $client_headers
    );

    $success = ($admin_sent && $client_sent);
}

// =============================================
// 6. Return JSON Response (No Redirects!)
// =============================================
if ($success) {
    returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
} else {
    returnJson('error', 'There was a problem sending your message. Please try again or call us directly at +234 9019 606166.');
}
