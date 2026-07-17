<?php
// test-email.php
$to = 'info@programmerscity.com';
$subject = 'Test Email from Procity';
$message = 'This is a test email to verify the mail() function works.';
$headers = 'From: test@programmerscity.com';

if (mail($to, $subject, $message, $headers)) {
    echo '✅ Email sent successfully! Check your inbox/spam.';
} else {
    echo '❌ Email failed. Check server logs.';
}
?>