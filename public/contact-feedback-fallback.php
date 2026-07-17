<?php
// contact-feedback.php (Fallback version without PHPMailer)

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    function returnJson($status, $message)
    {
        header('Content-Type: application/json');
        echo json_encode(['status' => $status, 'message' => $message]);
        exit;
    }

    // Sanitize input
    $fullname = htmlspecialchars(trim($_POST['fullname'] ?? ''));
    $email = filter_var(trim($_POST['email'] ?? ''), FILTER_SANITIZE_EMAIL);
    $phone = htmlspecialchars(trim($_POST['phone'] ?? ''));
    $subject = htmlspecialchars(trim($_POST['subject'] ?? ''));
    $message = htmlspecialchars(trim($_POST['message'] ?? ''));

    // Validation
    if (empty($fullname) || empty($email) || empty($subject) || empty($message)) {
        returnJson('error', 'Please fill in all required fields.');
    }

    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        returnJson('error', 'Invalid email address.');
    }

    // =============================================
    // SEND EMAIL TO ADMIN (using mail() function)
    // =============================================
    $to_admin = "info@programmerscity.com";
    $admin_subject = "Website Contact: " . $subject;

    $admin_body = "
    New Inquiry from Programmers City Website
    -----------------------------------------
    Full Name: {$fullname}
    Email: {$email}
    Phone: " . (!empty($phone) ? $phone : 'Not Provided') . "
    Subject: {$subject}
    Message:
    {$message}
    ";

    $admin_headers = "From: " . $email . "\r\n";
    $admin_headers .= "Reply-To: " . $email . "\r\n";
    $admin_headers .= "X-Mailer: PHP/" . phpversion();

    $admin_sent = mail($to_admin, $admin_subject, $admin_body, $admin_headers);

    // =============================================
    // SEND ACKNOWLEDGMENT TO CLIENT
    // =============================================
    $client_subject = "We received your inquiry, " . $fullname;
    $client_body = "
    Hello {$fullname},
    
    Thank you for reaching out to Programmers City Software Hub! We have successfully received your inquiry regarding: \"{$subject}\".
    
    Our team is currently reviewing your message and will get back to you within the next 24 hours via email or phone.
    
    For urgent inquiries, please feel free to call us directly at +234 9019 606166.
    
    Warm regards,
    The Programmers City Team
    
    181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State, Nigeria.
    ";

    $client_headers = "From: Programmers City <info@programmerscity.com>\r\n";
    $client_headers .= "Reply-To: info@programmerscity.com\r\n";
    $client_headers .= "X-Mailer: PHP/" . phpversion();

    $client_sent = mail($email, $client_subject, $client_body, $client_headers);

    // =============================================
    // RESPONSE
    // =============================================
    if ($admin_sent || $client_sent) {
        returnJson('success', 'Your message has been sent successfully! We will get back to you shortly.');
    } else {
        returnJson('error', 'There was a problem sending your message. Please try again or call us directly.');
    }
} else {
    header("Location: /");
    exit;
}
?>