<?php
// contact-feedback.php

require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

use PHPMailer\PHPMailer\PHPMailer;
// use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

// Helper function to return JSON response
function returnJson($status, $message)
{
    header('Content-Type: application/json');
    echo json_encode(['status' => $status, 'message' => $message]);
    exit;
}

// Helper function to send email using PHPMailer
function sendEmail($to, $subject, $body, $fromEmail = null, $fromName = null)
{
    $mail = new PHPMailer(true);

    try {
        // SMTP Configuration
        $mail->SMTPDebug = 0; // Set to 2 for debugging
        $mail->isSMTP();
        $mail->Host       = $_ENV['MAIL_HOST'];
        $mail->SMTPAuth   = true;
        $mail->Username   = $_ENV['MAIL_USERNAME'];
        $mail->Password   = $_ENV['MAIL_PASSWORD'];
        $mail->SMTPSecure = $_ENV['MAIL_ENCRYPTION'];
        $mail->Port       = $_ENV['MAIL_PORT'];

        // Sender
        $mail->setFrom(
            $fromEmail ?? $_ENV['MAIL_FROM_ADDRESS'],
            $fromName ?? $_ENV['MAIL_FROM_NAME']
        );

        // Recipient
        $mail->addAddress($to);

        // Content
        $mail->isHTML(true);
        $mail->Subject = $subject;
        $mail->Body    = $body;
        $mail->AltBody = strip_tags($body); // Plain text version

        return $mail->send();
    } catch (Exception $e) {
        error_log("Email sending failed: " . $mail->ErrorInfo);
        return false;
    }
}

// Helper function to send WhatsApp notification (using Meta API)
function sendWhatsAppMessage($messageData)
{
    // Skip if WhatsApp credentials are not set
    if (empty($_ENV['WHATSAPP_PHONE_NUMBER_ID']) || empty($_ENV['WHATSAPP_ACCESS_TOKEN'])) {
        error_log("WhatsApp credentials not configured");
        return false;
    }

    $phone_number_id = $_ENV['WHATSAPP_PHONE_NUMBER_ID'];
    $access_token = $_ENV['WHATSAPP_ACCESS_TOKEN'];
    $recipient_number = $_ENV['WHATSAPP_RECIPIENT'] ?? '2349019606166';

    $whatsapp_url = "https://graph.facebook.com/v18.0/{$phone_number_id}/messages";

    $payload = [
        "messaging_product" => "whatsapp",
        "recipient_type" => "individual",
        "to" => $recipient_number,
        "type" => "text",
        "text" => [
            "preview_url" => false,
            "body" => "🔔 *NEW WEBSITE INQUIRY*\n\n" .
                "*From:* {$messageData['name']}\n" .
                "*Email:* {$messageData['email']}\n" .
                "*Phone:* " . ($messageData['phone'] ?? 'N/A') . "\n" .
                "*Subject:* {$messageData['subject']}\n" .
                "*Message:* {$messageData['message']}"
        ]
    ];

    $ch = curl_init($whatsapp_url);
    curl_setopt($ch, CURLOPT_HTTPHEADER, [
        "Authorization: Bearer " . $access_token,
        "Content-Type: application/json"
    ]);
    curl_setopt($ch, CURLOPT_POST, true);
    curl_setopt($ch, CURLOPT_POSTFIELDS, json_encode($payload));
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);

    $response = curl_exec($ch);
    $err = curl_error($ch);
    curl_close($ch);

    if ($err) {
        error_log("WhatsApp Error: " . $err);
        return false;
    }

    return true;
}

// =============================================
// MAIN HANDLER
// =============================================

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // 1. Sanitize and Validate Input
    $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Basic Validation
    if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
        returnJson('error', 'Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnJson('error', 'Invalid email address.');
    }

    // =============================================
    // 2. SEND EMAIL TO ADMIN
    // =============================================
    $admin_subject = "Website Contact: " . $subject;
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

    $admin_email_sent = sendEmail(
        $_ENV['ADMIN_EMAIL'] ?? 'info@programmerscity.com',
        $admin_subject,
        $admin_body,
        $email,
        $fullname
    );

    // =============================================
    // 3. SEND ACKNOWLEDGMENT EMAIL TO CLIENT
    // =============================================
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

    $client_email_sent = sendEmail(
        $email,
        $client_subject,
        $client_body
    );

    // =============================================
    // 4. SEND WHATSAPP NOTIFICATION (Optional)
    // =============================================
    $messageData = [
        'name' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message
    ];
    $whatsapp_sent = sendWhatsAppMessage($messageData);

    // =============================================
    // 5. LOG THE INQUIRY (Optional - for database)
    // =============================================
    // You can add database logging here if needed

    // =============================================
    // 6. RESPONSE
    // =============================================
    if ($admin_email_sent || $client_email_sent) {
        returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
    } else {
        returnJson('error', 'There was a problem sending your message. Please try again or call us directly.');
    }
} else {
    // If someone tries to access this script directly without POST
    header("Location: /");
    exit;
}

?>