<?php
session_start();
// contact-feedback.php
// Rate limiting – prevent multiple submissions from same IP
$ip = $_SERVER['REMOTE_ADDR'];
$time_window = 300; // 5 minutes
$max_requests = 3;

if (!isset($_SESSION['contact_requests'])) {
    $_SESSION['contact_requests'] = [];
}

$_SESSION['contact_requests'][] = time();
$_SESSION['contact_requests'] = array_filter($_SESSION['contact_requests'], function ($t) use ($time_window) {
    return $t > (time() - $time_window);
});

if (count($_SESSION['contact_requests']) > $max_requests) {
    returnJson('error', 'Too many requests. Please try again later.');
}

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    // Helper function to return JSON response
    function returnJson($status, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'message' => $message]);
        exit; // Stop further execution
    }

    // Check honeypot – if filled, it's a bot
    if (!empty($_POST['honeypot'])) {
        // Silently reject without response
        header('HTTP/1.1 403 Forbidden');
        exit;
    }

    // Verify reCAPTCHA token
    $recaptcha_token = $_POST['recaptcha_token'] ?? '';
    $secret_key = $_ENV['RECAPTCHA_SECRET_KEY']; // Ensure this is set in your environment variables
    $response = file_get_contents("https://www.google.com/recaptcha/api/siteverify?secret=$secret_key&response=$recaptcha_token");
    $response_keys = json_decode($response, true);

    if (!$response_keys['success'] || $response_keys['score'] < 0.5) {
        returnJson('error', 'Failed verification. Please try again.');
    }

    // 1. Sanitize and Capture Incoming Data
    $fullname = htmlspecialchars(trim($_POST['fullname']));
    $email = filter_var(trim($_POST['email']), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone']));
    $subject = htmlspecialchars(trim($_POST['subject']));
    $message = htmlspecialchars(trim($_POST['message']));

    // Basic Validation
    if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
        returnJson('error', 'Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnJson('error', 'Invalid email address.');
    }

    // --- CONFIGURATION ---
    $to_admin = "info@programmerscity.com";
    $whatsapp_phone_number = "2349019606166"; // Your business WhatsApp phone number (no '+' or spaces)
    $admin_headers = "MIME-Version: 1.0" . "\r\n";
    $admin_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $admin_headers .= "From: " . $email . "\r\n";

    // --- 2. SEND EMAIL TO ADMIN ---
    $admin_msg_body = "
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

    mail($to_admin, "Website Contact: " . $subject, $admin_msg_body, $admin_headers);

    // --- 3. SEND WHATSAPP NOTIFICATION TO TEAM ---
    function sendWhatsAppMessage($message_data)
    {
        $phone_number_id = "YOUR_WHATSAPP_PHONE_NUMBER_ID";
        $access_token = "YOUR_WHATSAPP_ACCESS_TOKEN";
        $recipient_number = "2349019606166";

        $whatsapp_url = "https://graph.facebook.com/v18.0/" . $phone_number_id . "/messages";
        $payload = [
            "messaging_product" => "whatsapp",
            "recipient_type" => "individual",
            "to" => $recipient_number,
            "type" => "text",
            "text" => [
                "preview_url" => false,
                "body" => "🔔 *NEW WEBSITE INQUIRY*\n\n*From:* {$message_data['name']}\n*Email:* {$message_data['email']}\n*Phone:* " . ($message_data['phone'] ?? 'N/A') . "\n*Subject:* {$message_data['subject']}\n*Message:* {$message_data['message']}"
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

        $response = curl_exec($ch);
        $err = curl_error($ch);
        curl_close($ch);
        return ($err) ? false : true;
    }

    $messageData = [
        'name' => $fullname,
        'email' => $email,
        'phone' => $phone,
        'subject' => $subject,
        'message' => $message
    ];
    sendWhatsAppMessage($messageData);

    // --- 4. SEND ACKNOWLEDGMENT EMAIL TO CLIENT ---
    $to_client = $email;
    $client_headers = "MIME-Version: 1.0" . "\r\n";
    $client_headers .= "Content-type:text/html;charset=UTF-8" . "\r\n";
    $client_headers .= "From: Programmers City <info@programmerscity.com>" . "\r\n";

    $client_msg_body = "
    <html>
    <head><title>We received your message</title></head>
    <body style='font-family: Arial, sans-serif;'>
        <p>Hello <strong>{$fullname}</strong>,</p>
        <p>Thank you for reaching out to <strong>Programmers City</strong>! We have successfully received your inquiry regarding: <strong>\"{$subject}\"</strong>.</p>
        <p>Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.</p>
        <hr>
        <p><em>For urgent inquiries, please feel free to call us directly at <a href='tel:+2349019606166'>+234 9019 606166</a>.</em></p>
        <br>
        <p>Warm regards,<br>
        <strong>The Programmers City Team</strong></p>
        <p style='font-size: 12px; color: #475569;'>Whetheral Junction, Owerri, Imo State, Nigeria.</p>
    </body>
    </html>
    ";

    mail($to_client, "We have received your inquiry, " . $fullname, $client_msg_body, $client_headers);

    // --- 5. SUCCESS RESPONSE ---
    // If it's an AJAX/Fetch request, return JSON. If standard HTML form, redirect.
    if (isset($_SERVER['HTTP_X_REQUESTED_WITH']) && strtolower($_SERVER['HTTP_X_REQUESTED_WITH']) == 'xmlhttprequest') {
        returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
    } else {
        header("Location: contact-us.php?status=success");
        exit;
    }
} else {
    // If someone tries to access this script directly without POST
    header("Location: /");
    exit;
}
