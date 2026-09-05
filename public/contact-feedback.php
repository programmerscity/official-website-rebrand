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

require __DIR__ . '/../vendor/autoload.php';

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
use PHPMailer\PHPMailer\Exception;

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

if (!is_dir(__DIR__ . '/logs')) {
    mkdir(__DIR__ . '/logs', 0755, true);
}

function returnJson(string $status, string $message): void
{
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
// 2. Build Professional Email Templates
// =============================================

// =============================================
// 2a. ADMIN NOTIFICATION EMAIL
// =============================================
$admin_body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>New Inquiry - Procity Software Hub</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8fafc; -webkit-text-size-adjust: 100%;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; max-width: 600px; width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0b83de 0%, #004c98 100%); padding: 32px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity Software Hub" style="display: block; max-width: 60px; height: auto; margin-bottom: 8px;" />
                                        <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0; letter-spacing: -0.5px;">📩 New Contact Form Inquiry</h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-bottom: 8px;">
                                        <p style="color: #0f172a; font-size: 16px; line-height: 1.6; margin: 0 0 24px 0;">
                                            <strong>You have received a new inquiry</strong> from your website contact form. Details are below:
                                        </p>
                                    </td>
                                </tr>
                                
                                <!-- Inquiry Details -->
                                <tr>
                                    <td style="background-color: #f8fafc; border-radius: 12px; padding: 20px 24px; border-left: 4px solid #0b83de;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding-bottom: 12px;">
                                                    <p style="margin: 0; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Sender Information</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 4px;">
                                                    <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Full Name:</strong> ' . $fullname . '</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 4px;">
                                                    <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Email:</strong> <a href="mailto:' . $email . '" style="color: #0b83de; text-decoration: none;">' . $email . '</a></p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 4px;">
                                                    <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Phone:</strong> ' . (!empty($phone) ? $phone : '<span style="color: #475569;">Not Provided</span>') . '</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 4px;">
                                                    <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Subject:</strong> ' . $subject . '</p>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-top: 16px; border-top: 1px solid #e2e8f0;">
                                                    <p style="margin: 0 0 8px 0; font-size: 12px; color: #475569; font-weight: 700; text-transform: uppercase; letter-spacing: 0.5px;">Message</p>
                                                    <p style="margin: 0; font-size: 15px; color: #0f172a; line-height: 1.6; background-color: #ffffff; padding: 12px 16px; border-radius: 8px; border: 1px solid #e2e8f0;">' . nl2br($message) . '</p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Quick Actions -->
                                <tr>
                                    <td style="padding-top: 24px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td align="center" style="padding-bottom: 8px;">
                                                    <a href="mailto:' . $email . '" style="display: inline-block; background-color: #0b83de; color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 32px; border-radius: 50px; text-decoration: none; margin: 0 6px 8px 6px;">Reply to Client</a>
                                                    <a href="tel:+2349019606166" style="display: inline-block; background-color: #0f172a; color: #ffffff; font-weight: 600; font-size: 14px; padding: 12px 32px; border-radius: 50px; text-decoration: none; margin: 0 6px 8px 6px;">📞 Call Client</a>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 40px; border-top: 1px solid #e2e8f0;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 4px 0; font-size: 14px; color: #0f172a; font-weight: 700;">Procity Software Hub</p>
                                        <p style="margin: 0 0 4px 0; font-size: 13px; color: #475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
                                        <p style="margin: 0 0 8px 0; font-size: 13px; color: #475569;">
                                            <a href="tel:+2349019606166" style="color: #0b83de; text-decoration: none;">+234 9019 606166</a> &bull;
                                            <a href="mailto:info@programmerscity.com" style="color: #0b83de; text-decoration: none;">info@programmerscity.com</a>
                                        </p>
                                        <p style="margin: 0; font-size: 12px; color: #475569;">
                                            <a href="https://www.linkedin.com/company/programmers-city" style="color: #0b83de; text-decoration: none; margin: 0 6px;">LinkedIn</a> &bull;
                                            <a href="https://www.youtube.com/@programmerscity" style="color: #0b83de; text-decoration: none; margin: 0 6px;">YouTube</a> &bull;
                                            <a href="https://www.instagram.com/programmers.city/" style="color: #0b83de; text-decoration: none; margin: 0 6px;">Instagram</a> &bull;
                                            <a href="https://www.facebook.com/programmerscityhub/" style="color: #0b83de; text-decoration: none; margin: 0 6px;">Facebook</a> &bull;
                                            <a href="https://x.com/programmerscity" style="color: #0b83de; text-decoration: none; margin: 0 6px;">X</a>
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
                <!-- End Main Container -->
                
                <!-- Footer Note -->
                <p style="text-align: center; font-size: 12px; color: #475569; margin-top: 24px;">
                    This email was sent from your website contact form.
                </p>
            </td>
        </tr>
    </table>
</body>
</html>';

// =============================================
// 2b. CLIENT ACKNOWLEDGMENT EMAIL (with WhatsApp & Call Buttons)
// =============================================
$client_body = '
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>We received your inquiry - Procity Software Hub</title>
</head>
<body style="margin: 0; padding: 0; font-family: Arial, Helvetica, sans-serif; background-color: #f8fafc; -webkit-text-size-adjust: 100%;">
    <table width="100%" cellpadding="0" cellspacing="0" border="0" align="center" style="background-color: #f8fafc; padding: 40px 0;">
        <tr>
            <td align="center">
                <!-- Main Container -->
                <table width="600" cellpadding="0" cellspacing="0" border="0" style="background-color: #ffffff; border-radius: 16px; box-shadow: 0 4px 24px rgba(0,0,0,0.08); overflow: hidden; max-width: 600px; width: 100%;">
                    
                    <!-- Header -->
                    <tr>
                        <td style="background: linear-gradient(135deg, #0b83de 0%, #004c98 100%); padding: 32px 40px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <img src="https://programmerscity.com/public/assets/images/favicon.png" alt="Procity Software Hub" style="display: block; max-width: 60px; height: auto; margin-bottom: 8px;" />
                                        <h1 style="color: #ffffff; font-size: 24px; font-weight: 700; margin: 0; letter-spacing: -0.5px;">✅ Thank You for Reaching Out!</h1>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Body -->
                    <tr>
                        <td style="padding: 40px 40px 30px;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td style="padding-bottom: 8px;">
                                        <p style="color: #0f172a; font-size: 16px; line-height: 1.6; margin: 0 0 8px 0;">
                                            Hello <strong>' . $fullname . '</strong>,
                                        </p>
                                        <p style="color: #0f172a; font-size: 16px; line-height: 1.6; margin: 0 0 20px 0;">
                                            Thank you for reaching out to <strong>Procity Software Hub</strong>! We have successfully received your inquiry regarding:
                                        </p>
                                        <div style="background-color: #f8fafc; border-radius: 8px; padding: 12px 16px; margin-bottom: 24px; border-left: 3px solid #0b83de;">
                                            <p style="margin: 0; font-size: 16px; color: #0b83de; font-weight: 600;">"' . $subject . '"</p>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Next Steps -->
                                <tr>
                                    <td>
                                        <h3 style="color: #0f172a; font-size: 18px; font-weight: 700; margin: 0 0 16px 0;">📋 What Happens Next?</h3>
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                            <tr>
                                                <td style="padding-bottom: 12px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td width="32" valign="top" style="padding-right: 12px;">
                                                                <span style="display: inline-block; width: 24px; height: 24px; background-color: #0b83de; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700;">1</span>
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Review</strong> – Our team is currently reviewing your message and requirements.</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 12px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td width="32" valign="top" style="padding-right: 12px;">
                                                                <span style="display: inline-block; width: 24px; height: 24px; background-color: #0b83de; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700;">2</span>
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Response</strong> – We will get back to you within <strong>24 hours</strong> via email or phone.</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr>
                                                <td style="padding-bottom: 12px;">
                                                    <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                        <tr>
                                                            <td width="32" valign="top" style="padding-right: 12px;">
                                                                <span style="display: inline-block; width: 24px; height: 24px; background-color: #0b83de; color: #ffffff; border-radius: 50%; text-align: center; line-height: 24px; font-size: 12px; font-weight: 700;">3</span>
                                                            </td>
                                                            <td>
                                                                <p style="margin: 0; font-size: 15px; color: #0f172a;"><strong>Consultation</strong> – We\'ll schedule a consultation to discuss your project in detail.</p>
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                                
                                <!-- Call to Action: WhatsApp & Call Buttons -->
                                <tr>
                                    <td style="padding-top: 24px;">
                                        <div style="background-color: #f8fafc; border-radius: 12px; padding: 20px 24px; border: 1px solid #e2e8f0; text-align: center;">
                                            <p style="margin: 0 0 12px 0; font-size: 15px; color: #0f172a; font-weight: 700;">📞 Need Immediate Assistance?</p>
                                            <p style="margin: 0 0 16px 0; font-size: 14px; color: #475569;">
                                                Get in touch with us right now via phone or WhatsApp.
                                            </p>
                                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                                <tr>
                                                    <td align="center" style="padding: 4px 4px;">
                                                        <a href="tel:+2349019606166" style="display: inline-block; background-color: #0b83de; color: #ffffff; font-weight: 600; font-size: 15px; padding: 14px 28px; border-radius: 50px; text-decoration: none; margin: 4px; min-width: 160px;">
                                                            📞 Call Us Now
                                                        </a>
                                                    </td>
                                                    <td align="center" style="padding: 4px 4px;">
                                                        <a href="https://wa.me/2349019606166" target="_blank" rel="noopener" style="display: inline-block; background-color: #25D366; color: #ffffff; font-weight: 600; font-size: 15px; padding: 14px 28px; border-radius: 50px; text-decoration: none; margin: 4px; min-width: 160px;">
                                                            💬 WhatsApp Us
                                                        </a>
                                                    </td>
                                                </tr>
                                            </table>
                                            <p style="margin: 12px 0 0 0; font-size: 13px; color: #475569;">
                                                <strong>Phone:</strong> +234 9019 606166 &bull; <strong>Hours:</strong> Mon–Sat, 9 AM – 6 PM (WAT)
                                            </p>
                                        </div>
                                    </td>
                                </tr>
                                
                                <!-- Social Links -->
                                <tr>
                                    <td style="padding-top: 24px;">
                                        <table width="100%" cellpadding="0" cellspacing="0" border="0" style="text-align: center;">
                                            <tr>
                                                <td align="center">
                                                    <p style="margin: 0 0 12px 0; font-size: 13px; color: #475569; font-weight: 600;">Connect With Us</p>
                                                    <p style="margin: 0; font-size: 13px; color: #475569;">
                                                        <a href="https://www.linkedin.com/company/programmers-city" target="_blank" rel="noopener" style="color: #0b83de; text-decoration: none; margin: 0 8px;">LinkedIn</a>
                                                        <a href="https://www.youtube.com/@programmerscity" target="_blank" rel="noopener" style="color: #0b83de; text-decoration: none; margin: 0 8px;">YouTube</a>
                                                        <a href="https://www.instagram.com/programmers.city/" target="_blank" rel="noopener" style="color: #0b83de; text-decoration: none; margin: 0 8px;">Instagram</a>
                                                        <a href="https://www.facebook.com/programmerscityhub/" target="_blank" rel="noopener" style="color: #0b83de; text-decoration: none; margin: 0 8px;">Facebook</a>
                                                        <a href="https://x.com/programmerscity" target="_blank" rel="noopener" style="color: #0b83de; text-decoration: none; margin: 0 8px;">X</a>
                                                    </p>
                                                </td>
                                            </tr>
                                        </table>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                    <!-- Footer -->
                    <tr>
                        <td style="background-color: #f8fafc; padding: 20px 40px; border-top: 1px solid #e2e8f0;">
                            <table width="100%" cellpadding="0" cellspacing="0" border="0">
                                <tr>
                                    <td align="center">
                                        <p style="margin: 0 0 4px 0; font-size: 14px; color: #0f172a; font-weight: 700;">Procity Software Hub</p>
                                        <p style="margin: 0 0 4px 0; font-size: 13px; color: #475569;">181 Douglas Road, By Wetheral Junction, Owerri-Aba Road, Owerri, Imo State</p>
                                        <p style="margin: 0 0 8px 0; font-size: 13px; color: #475569;">
                                            <a href="tel:+2349019606166" style="color: #0b83de; text-decoration: none;">+234 9019 606166</a> &bull;
                                            <a href="mailto:info@programmerscity.com" style="color: #0b83de; text-decoration: none;">info@programmerscity.com</a>
                                        </p>
                                        <p style="margin: 0; font-size: 11px; color: #475569;">
                                            <a href="https://programmerscity.com" style="color: #0b83de; text-decoration: none;">programmerscity.com</a>
                                        </p>
                                        <p style="margin: 8px 0 0 0; font-size: 11px; color: #475569; font-style: italic;">
                                            This is an automated confirmation. Please do not reply directly to this email.
                                        </p>
                                    </td>
                                </tr>
                            </table>
                        </td>
                    </tr>
                    
                </table>
                <!-- End Main Container -->
            </td>
        </tr>
    </table>
</body>
</html>';

// =============================================
// 3. Send via SMTP
// =============================================
try {
    $mail = new PHPMailer(true);

    // SMTP Configuration (cPanel)
    $mail->isSMTP();
    $mail->Host       = 'programmerscity.com';
    $mail->SMTPAuth   = true;
    $mail->Username   = 'info@programmerscity.com';
    $mail->Password   = 'Procity2024*';
    $mail->SMTPSecure = 'ssl';
    $mail->Port       = 465;
    $mail->CharSet    = 'UTF-8';

    $mail->setFrom('info@programmerscity.com', 'Procity Software Hub');
    $mail->addReplyTo($email, $fullname);

    // Admin Email
    $mail->addAddress('info@programmerscity.com');
    $mail->Subject = "New Inquiry: " . $subject;
    $mail->Body    = $admin_body;
    $mail->AltBody = "New Inquiry from $fullname\nEmail: $email\nPhone: " . (!empty($phone) ? $phone : 'Not Provided') . "\nSubject: $subject\n\nMessage:\n$message";
    $admin_sent = $mail->send();

    // Client Acknowledgment Email
    $mail->clearAddresses();
    $mail->addAddress($email);
    $mail->Subject = "We received your inquiry, $fullname";
    $mail->Body    = $client_body;
    $mail->AltBody = "Hello $fullname,\n\nThank you for reaching out to Procity Software Hub! We have received your inquiry regarding: \"$subject\".\n\nOur team will get back to you within 24 hours.\n\nFor urgent inquiries, call us at +234 9019 606166 or WhatsApp us at https://wa.me/2349019606166.\n\nWarm regards,\nThe Procity Software Hub Team";
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

?>