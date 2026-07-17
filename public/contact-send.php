<?php
// contact-send.php - STANDALONE ENDPOINT
// This file bypasses all .htaccess rewrite rules

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 1);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/logs/contact-errors.log');

// Create logs directory if it doesn't exist
if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

// Helper to return JSON
function returnJson($status, $message)
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// Log the request for debugging
error_log("Contact form submitted: " . print_r($_POST, true));

// =============================================
// 1. Ensure POST request
// =============================================
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    returnJson('error', 'Invalid request method.');
}

// =============================================
// 2. Validate input
// =============================================
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
// 3. Build emails (plain text for reliability)
// =============================================

// Admin email
$admin_to = 'info@programmerscity.com';
$admin_subject = "Website Contact: " . $subject;
$admin_body = "New Inquiry from Programmers City Website\n";
$admin_body .= "-----------------------------------------\n";
$admin_body .= "Full Name: $fullname\n";
$admin_body .= "Email: $email\n";
$admin_body .= "Phone: " . (!empty($phone) ? $phone : 'Not Provided') . "\n";
$admin_body .= "Subject: $subject\n\n";
$admin_body .= "Message:\n$message\n";

$admin_headers = "From: $email\r\n";
$admin_headers .= "Reply-To: $email\r\n";
$admin_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// Client acknowledgment
$client_subject = "We received your inquiry, $fullname";
$client_body = "Hello $fullname,\n\n";
$client_body .= "Thank you for reaching out to Programmers City Software Hub! We have successfully received your inquiry regarding: \"$subject\".\n\n";
$client_body .= "Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.\n\n";
$client_body .= "For urgent inquiries, please feel free to call us directly at +234 9019 606166.\n\n";
$client_body .= "Warm regards,\n";
$client_body .= "The Programmers City Team\n";
$client_body .= "181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State, Nigeria.\n";

$client_headers = "From: Programmers City <info@programmerscity.com>\r\n";
$client_headers .= "Reply-To: info@programmerscity.com\r\n";
$client_headers .= "X-Mailer: PHP/" . phpversion() . "\r\n";

// =============================================
// 4. Send emails
// =============================================

$admin_sent = mail($admin_to, $admin_subject, $admin_body, $admin_headers);
$client_sent = mail($email, $client_subject, $client_body, $client_headers);

error_log("Admin sent: " . ($admin_sent ? 'YES' : 'NO'));
error_log("Client sent: " . ($client_sent ? 'YES' : 'NO'));

// =============================================
// 5. Response
// =============================================
if ($admin_sent && $client_sent) {
    returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
} else {
    returnJson('error', 'There was a problem sending your message. Please try again or call us directly at +234 9019 606166.');
}
