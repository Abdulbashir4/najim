<?php
// auth.php
require_once __DIR__ . '/session_config.php'; // adjust path if needed

// Timeout (seconds) — 30 minutes
define('SESSION_TIMEOUT', 1800);

function require_login($required_role = null) {
    // 1) logged in check
    if (!isset($_SESSION['employee_id'])) {
        // not logged in -> redirect to login
        header('Location: index.php');
        exit;
    }

    // 2) inactivity timeout
    if (isset($_SESSION['LAST_ACTIVITY']) && (time() - $_SESSION['LAST_ACTIVITY'] > SESSION_TIMEOUT)) {
        // session expired
        session_unset();
        session_destroy();
        header('Location: login.php');
        exit;
    }
    // update last activity
    $_SESSION['LAST_ACTIVITY'] = time();

    // 3) role-based check (if required)
    if ($required_role !== null) {
        if (!isset($_SESSION['role']) || $_SESSION['role'] !== $required_role) {
            header('HTTP/1.1 403 Forbidden');
            echo 'Access denied.';
            exit;
        }
    }

    // optional: refresh session id occasionally to prevent fixation
    if (!isset($_SESSION['CREATED'])) {
        $_SESSION['CREATED'] = time();
    } elseif (time() - $_SESSION['CREATED'] > 300) { // regenerate every 5 minutes
        session_regenerate_id(true);
        $_SESSION['CREATED'] = time();
    }
}
