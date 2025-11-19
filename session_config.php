<?php
// session_config.php
// Call THIS BEFORE any output and before session_start elsewhere

// secure flag only if using HTTPS
$secure = (!empty($_SERVER['HTTPS']) && $_SERVER['HTTPS'] !== 'off');

// recommended cookie params
session_set_cookie_params([
    'lifetime' => 0,            // session cookie (until browser close)
    'path' => '/',
    'domain' => $_SERVER['HTTP_HOST'],
    'secure' => $secure,        // only send cookie over HTTPS if available
    'httponly' => true,         // JS can't access cookie
    'samesite' => 'Lax'         // change to 'Strict' or 'None' if needed
]);

if (session_status() === PHP_SESSION_NONE) {
    session_start();
}

// optional inactivity timeout (seconds)
if (!isset($_SESSION['LAST_ACTIVITY'])) {
    $_SESSION['LAST_ACTIVITY'] = time();
}
