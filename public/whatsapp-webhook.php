<?php

/**
 * WhatsApp Business API Webhook Handler
 * This file receives incoming messages and status updates from Meta/WhatsApp
 * 
 * Endpoint URL: https://programmerscity.com/whatsapp-webhook
 * 
 * How it works:
 * 1. GET request: Meta verifies your webhook with a challenge token
 * 2. POST request: Meta sends incoming messages and status updates
 */

// Enable error logging for debugging
error_reporting(E_ALL);
ini_set('display_errors', 0);
ini_set('log_errors', 1);
ini_set('error_log', __DIR__ . '/../logs/whatsapp-webhook.log');

// =============================================
// CONFIGURATION - Set these in your .env file
// =============================================
require __DIR__ . '/../vendor/autoload.php';
$dotenv = Dotenv\Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

$verify_token = $_ENV['WHATSAPP_VERIFY_TOKEN'] ?? 'your_secure_verify_token_here';
$access_token = $_ENV['WHATSAPP_ACCESS_TOKEN'] ?? '';


// echo "Testing: " . $access_token . "\n" . $verify_token;
// exit();

// =============================================
// WEBHOOK VERIFICATION (GET Request)
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
    $mode = $_GET['hub_mode'] ?? '';
    $token = $_GET['hub_verify_token'] ?? '';
    $challenge = $_GET['hub_challenge'] ?? '';

    // Log verification attempt
    error_log("WhatsApp Webhook Verification: mode=$mode, token=$token, challenge=$challenge");

    // Verify the token matches your configured verify_token
    if ($mode === 'subscribe' && $token === $verify_token) {
        // Success! Return the challenge to confirm the webhook
        header('HTTP/1.1 200 OK');
        echo $challenge;
        error_log("WhatsApp Webhook Verified Successfully!");
        exit;
    } else {
        // Verification failed
        header('HTTP/1.1 403 Forbidden');
        error_log("WhatsApp Webhook Verification Failed: token mismatch");
        exit;
    }
}

// =============================================
// INCOMING MESSAGES / STATUS UPDATES (POST Request)
// =============================================
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    // Get the raw POST data
    $payload = file_get_contents('php://input');
    error_log("WhatsApp Webhook Received: " . $payload);

    // Decode the JSON payload
    $data = json_decode($payload, true);

    if (!$data) {
        header('HTTP/1.1 400 Bad Request');
        error_log("WhatsApp Webhook: Invalid JSON payload");
        exit;
    }

    // Verify the webhook signature (recommended for security)
    $signature = $_SERVER['HTTP_X_HUB_SIGNATURE_256'] ?? '';
    if (!empty($signature) && !empty($access_token)) {
        $expected = 'sha256=' . hash_hmac('sha256', $payload, $access_token);
        if (!hash_equals($expected, $signature)) {
            header('HTTP/1.1 403 Forbidden');
            error_log("WhatsApp Webhook: Invalid signature");
            exit;
        }
    }

    // =============================================
    // PROCESS THE WEBHOOK DATA
    // =============================================

    // Check if this is an entry (incoming message/status)
    if (isset($data['entry']) && is_array($data['entry'])) {
        foreach ($data['entry'] as $entry) {
            // Get the WhatsApp Business Account ID
            $waba_id = $entry['id'] ?? '';

            if (isset($entry['changes']) && is_array($entry['changes'])) {
                foreach ($entry['changes'] as $change) {
                    $field = $change['field'] ?? '';
                    $value = $change['value'] ?? [];

                    // =============================================
                    // INCOMING MESSAGES
                    // =============================================
                    if ($field === 'messages' && isset($value['messages'])) {
                        foreach ($value['messages'] as $message) {
                            handleIncomingMessage($message, $value['contacts'] ?? []);
                        }
                    }

                    // =============================================
                    // STATUS UPDATES
                    // =============================================
                    if ($field === 'message_statuses' && isset($value['statuses'])) {
                        foreach ($value['statuses'] as $status) {
                            handleMessageStatus($status);
                        }
                    }
                }
            }
        }
    }

    // Always return 200 OK to acknowledge receipt
    header('HTTP/1.1 200 OK');
    echo json_encode(['status' => 'success']);
    exit;
}

// =============================================
// HANDLER FUNCTIONS
// =============================================

/**
 * Handle Incoming Messages
 */
function handleIncomingMessage($message, $contacts)
{
    error_log("WhatsApp Message Received: " . json_encode($message));

    // Extract customer information
    $from = $message['from'] ?? '';
    $message_id = $message['id'] ?? '';
    $timestamp = $message['timestamp'] ?? '';

    // Get the customer's phone number
    $customer_phone = $from;

    // Get customer name if available
    $customer_name = '';
    if (!empty($contacts)) {
        foreach ($contacts as $contact) {
            if (($contact['wa_id'] ?? '') === $from) {
                $customer_name = $contact['profile']['name'] ?? '';
                break;
            }
        }
    }

    // Process different message types
    $message_type = $message['type'] ?? '';
    $message_text = '';

    switch ($message_type) {
        case 'text':
            $message_text = $message['text']['body'] ?? '';
            break;
        case 'image':
            $message_text = "[Image] " . ($message['image']['caption'] ?? '');
            break;
        case 'audio':
            $message_text = "[Audio Message]";
            break;
        case 'video':
            $message_text = "[Video] " . ($message['video']['caption'] ?? '');
            break;
        case 'document':
            $message_text = "[Document] " . ($message['document']['filename'] ?? '');
            break;
        case 'sticker':
            $message_text = "[Sticker]";
            break;
        case 'location':
            $message_text = "[Location] " . ($message['location']['name'] ?? '');
            break;
        case 'contacts':
            $message_text = "[Contact Shared]";
            break;
        case 'interactive':
            $message_text = "[Interactive Message]";
            break;
        default:
            $message_text = "[Unsupported Message Type: $message_type]";
            break;
    }

    // =============================================
    // DO SOMETHING WITH THE MESSAGE
    // =============================================

    // Option 1: Save to database
    // saveMessageToDatabase($from, $customer_name, $message_text, $message_type, $timestamp);

    // Option 2: Send email notification to admin
    $admin_email = $_ENV['ADMIN_EMAIL'] ?? 'info@programmerscity.com';
    $subject = "New WhatsApp Message from $customer_name";
    $body = "You received a new WhatsApp message:\n\n";
    $body .= "From: $customer_name ($from)\n";
    $body .= "Type: $message_type\n";
    $body .= "Message: $message_text\n";
    $body .= "Time: " . date('Y-m-d H:i:s', $timestamp) . "\n";

    // Uncomment to send email notification
    // mail($admin_email, $subject, $body, "From: webhook@programmerscity.com\r\n");

    // Option 3: Auto-reply (optional)
    // sendAutoReply($from, "Thank you for your message! A member of our team will get back to you shortly.");
}

/**
 * Handle Message Status Updates
 */
function handleMessageStatus($status)
{
    error_log("WhatsApp Status Update: " . json_encode($status));

    $message_id = $status['id'] ?? '';
    $status_type = $status['status'] ?? '';
    $recipient = $status['recipient_id'] ?? '';
    $timestamp = $status['timestamp'] ?? '';

    // Log the status for monitoring
    // Possible statuses: sent, delivered, read, failed
    if ($status_type === 'failed') {
        $error_code = $status['errors'][0]['code'] ?? '';
        $error_title = $status['errors'][0]['title'] ?? '';
        error_log("WhatsApp Message Failed: $message_id - $error_title ($error_code)");
    }
}

/**
 * Send an auto-reply to the customer (optional)
 */
function sendAutoReply($to, $message)
{
    $phone_number_id = $_ENV['WHATSAPP_PHONE_NUMBER_ID'] ?? '';
    $access_token = $_ENV['WHATSAPP_ACCESS_TOKEN'] ?? '';

    if (empty($phone_number_id) || empty($access_token)) {
        return false;
    }

    $url = "https://graph.facebook.com/v18.0/{$phone_number_id}/messages";

    $payload = [
        "messaging_product" => "whatsapp",
        "to" => $to,
        "type" => "text",
        "text" => ["body" => $message]
    ];

    $ch = curl_init($url);
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

    if ($err) {
        error_log("Auto-reply failed: " . $err);
        return false;
    }

    return true;
}

// If the request method is neither GET nor POST
header('HTTP/1.1 405 Method Not Allowed');
exit;
