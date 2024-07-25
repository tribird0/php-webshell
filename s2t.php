<?php

function sendMessageToTelegram($message)
{
    $url = "https://api.telegram.org/bot[token]/sendMessage";
    $data = ['chat_id' => '[ChatID]', 'text' => $message];
    $options = [
        'http' => [
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ],
    ];
    file_get_contents($url, false, stream_context_create($options));
}

$currentUrl = (isset($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off' ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
sendMessageToTelegram("File was launched. Current URL: $currentUrl");
