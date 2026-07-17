<?php
// contact-send.php - with PHPMailer

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/contact-errors.log');

if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

function returnJson(string $status, string $message): void {
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// =============================================
// 1. Validate POST
// =============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnJson('error', 'Invalid request method.');
}

$fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
$email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
$phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
$subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
$message = htmlspecialchars(trim($_POST['message'] ?? ''));

if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
    returnJson('error', 'Please fill in all required fields.');
}
if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    returnJson('error', 'Invalid email address.');
}

// =============================================
// 2. Build email content
// =============================================
$admin_body = "New Inquiry from Programmers City Website\n";
$admin_body .= "-----------------------------------------\n";
$admin_body .= "Full Name: $fullname\n";
$admin_body .= "Email: $email\n";
$admin_body .= "Phone: " . (!empty($phone) ? $phone : 'Not Provided') . "\n";
$admin_body .= "Subject: $subject\n\n";
$admin_body .= "Message:\n$message\n";

$client_body = "Hello $fullname,\n\n";
$client_body .= "Thank you for reaching out to Programmers City Software Hub! We have successfully received your inquiry regarding: \"$subject\".\n\n";
$client_body .= "Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.\n\n";
$client_body .= "For urgent inquiries, please call us directly at +234 9019 606166.\n\n";
$client_body .= "Warm regards,\nThe Programmers City Team\n";
$client_body .= "181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State, Nigeria.\n";

// =============================================
// 3. Send via SMTP
// =============================================
try {
    $mail = new PHPMailer(true);
    
    // SMTP Configuration (cPanel)
    $mail->isSMTP();
    $mail->Host       = 'programmerscity.com';   // or smtp.programmerscity.com
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@programmerscity.com';   // full email address
    $mail->Password   = 'Procity2024*'; // your actual password
    $mail->SMTPSecure = 'ssl';                        // ssl for port 465
    $mail->Port       = 465;                          // or 587 with tls
    
    $mail->setFrom('info@programmerscity.com', 'Programmers City Software Hub');
    $mail->addReplyTo($email, $fullname);
    
    // Admin
    $mail->addAddress('info@programmerscity.com');
    $mail->Subject = "Website Contact: " . $subject;
    $mail->Body    = $admin_body;
    $mail->AltBody = $admin_body;
    $admin_sent = $mail->send();
    
    // Client
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = "We received your inquiry, $fullname";
    $mail->Body    = $client_body;
    $mail->AltBody = $client_body;
    $client_sent = $mail->send();
    
    $success = $admin_sent && $client_sent;
    
} catch (Exception $e) {
    error_log("PHPMailer error: " . $e->getMessage());
    $success = false;
}

// =============================================
// 4. Response
// =============================================
if ($success) {
    returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
} else {
    returnJson('error', 'There was a problem sending your message. Please try again or call us directly at +234 9019 606166.');
}