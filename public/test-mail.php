<?php
require __DIR__ . '/../vendor/autoload.php';

use Dotenv\Dotenv;

$dotenv = Dotenv::createImmutable(__DIR__ . '/../');
$dotenv->load();

mail($_ENV['ADMIN_EMAIL'] ?? 'info@programmerscity.com', 'Test Email', 'This is a test message', 'From: test@programmerscity.com');
echo 'Mail sent? Check your inbox/spam.';
exit;