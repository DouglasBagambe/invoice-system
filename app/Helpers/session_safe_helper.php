<?php

if (!function_exists('safe_session')) {
    function safe_session() {
        try {
            // Suppress session handler warnings
            error_reporting(E_ALL & ~E_DEPRECATED & ~E_STRICT & ~E_WARNING);
            return session();
        } catch (\Exception $e) {
            // Fallback to PHP sessions
            if (!isset($_SESSION)) {
                session_start();
            }
            return (object) $_SESSION;
        }
    }
}

if (!function_exists('safe_session_get')) {
    function safe_session_get($key, $default = null) {
        try {
            if (isset($_SESSION[$key])) {
                return $_SESSION[$key];
            }
            $session = safe_session();
            return $session->get($key) ?? $default;
        } catch (\Exception $e) {
            return $default;
        }
    }
}

if (!function_exists('safe_esc')) {
    function safe_esc($data, $context = 'html') {
        if (function_exists('esc')) {
            return esc($data, $context);
        }
        return htmlspecialchars($data, ENT_QUOTES, 'UTF-8');
    }
}
