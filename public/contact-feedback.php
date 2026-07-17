<?php
// contact-feedback.php - SIMPLIFIED VERSION

// Enable error logging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/contact-errors.log');

// Helper to return JSON
function returnJson($status, $message)
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

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
// 3. Build emails
// =============================================

// Admin email
$admin_to = 'info@programmerscity.com';
$admin_subject = "Website Contact: " . $subject;
$admin_body = "
New Inquiry from Programmers City Website
-----------------------------------------
Full Name: $fullname
Email: $email
Phone: " . (!empty($phone) ? $phone : 'Not Provided') . "
Subject: $subject

Message:
$message
";

$admin_headers = "From: $email\r\n";
$admin_headers .= "Reply-To: $email\r\n";
$admin_headers .= "X-Mailer: PHP/" . phpversion();

// Client acknowledgment
$client_subject = "We received your inquiry, $fullname";
$client_body = "
Hello $fullname,

Thank you for reaching out to Programmers City Software Hub! We have successfully received your inquiry regarding: \"$subject\".

Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.

For urgent inquiries, please feel free to call us directly at +234 9019 606166.

Warm regards,
The Programmers City Team

181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State, Nigeria.
";

$client_headers = "From: Programmers City <info@programmerscity.com>\r\n";
$client_headers .= "Reply-To: info@programmerscity.com\r\n";
$client_headers .= "X-Mailer: PHP/" . phpversion();

// =============================================
// 4. Send emails
// =============================================

$admin_sent = mail($admin_to, $admin_subject, $admin_body, $admin_headers);
$client_sent = mail($email, $client_subject, $client_body, $client_headers);

// =============================================
// 5. Response
// =============================================
if ($admin_sent && $client_sent) {
    returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
} else {
    // Log the error for debugging
    error_log("Contact form: admin_sent=$admin_sent, client_sent=$client_sent");
    returnJson('error', 'There was a problem sending your message. Please try again or call us directly at +234 9019 606166.');
}
