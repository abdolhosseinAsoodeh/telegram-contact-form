<?php

header('Content-Type: application/json; charset=utf-8');

// ====== Telegram bot settings ======
$TELEGRAM_BOT_TOKEN = "YOUR_BOT_TOKEN_HERE";
$TELEGRAM_CHAT_ID   = "YOUR_CHAT_ID_HERE";
// ===================================

// Only POST requests will be accepted
if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
    http_response_code(405);
    echo json_encode(["ok" => false, "error" => "Method not allowed"]);
    exit;
}

// Reading submitted data (JSON or regular form)
$input = json_decode(file_get_contents('php://input'), true);
if (!$input) {
    $input = $_POST;
}

$name    = trim($input['name'] ?? '');
$phone   = trim($input['phone'] ?? '');
$email   = trim($input['email'] ?? '');
$message = trim($input['message'] ?? '');

// Simple validation
if ($name === '' || $phone === '' || $message === '') {
    http_response_code(400);
    echo json_encode(["ok" => false, "error" => "فیلدهای ضروری خالی است"]);
    exit;
}

// Creating message text for Telegram
$text  = "📩 پیام جدید از فرم تماس با ما\n\n";
$text .= "👤 نام: " . $name . "\n";
$text .= "📞 تلفن: " . $phone . "\n";
$text .= "✉️ ایمیل: " . ($email !== '' ? $email : "—") . "\n";
$text .= "📝 پیام:\n" . $message;

// Send to Telegram API
$url = "https://api.telegram.org/bot{$TELEGRAM_BOT_TOKEN}/sendMessage";

$ch = curl_init($url);
curl_setopt($ch, CURLOPT_POST, true);
curl_setopt($ch, CURLOPT_POSTFIELDS, [
    'chat_id' => $TELEGRAM_CHAT_ID,
    'text'    => $text,
]);
curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
curl_setopt($ch, CURLOPT_TIMEOUT, 15);
curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, true);

$response = curl_exec($ch);
$curlError = curl_error($ch);
$httpCode = curl_getinfo($ch, CURLINFO_HTTP_CODE);
curl_close($ch);

if ($curlError) {
    http_response_code(500);
    echo json_encode(["ok" => false, "error" => "Telegram connection error: " . $curlError]);
    exit;
}

$result = json_decode($response, true);

if (isset($result['ok']) && $result['ok'] === true) {
    echo json_encode(["ok" => true]);
} else {
    http_response_code(500);
    echo json_encode([
        "ok" => false,
        "error" => $result['description'] ?? "Unspecified error from Telegram",
        "http_code" => $httpCode
    ]);
}
