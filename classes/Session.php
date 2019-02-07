<?php

// Wrapper around the $_SESSION superglobal
class Session {

    public static function start()
	{
        if (session_status() == PHP_SESSION_NONE) {
            session_start();
        }

        if (!isset($_SESSION['csrf_token']) || empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = base64_encode(openssl_random_pseudo_bytes(32));
        }
	}

    public static function end()
	{
        session_destroy();
        unset($_SESSION);
    }

    public static function has($key)
    {
        return array_key_exists($key, $_SESSION) ? true : false;
    }

    public static function get($key, $default = '')
    {
        return array_key_exists($key, $_SESSION) ? $_SESSION[$key] : $default;
    }

    public static function set($key, $value)
    {
        $_SESSION[$key] = $value;
    }

    public static function remove($key)
    {
        unset($_SESSION[$key]);
    }

    public static function get_csrf_token()
    {
        return $_SESSION['csrf_token'];
    }

    public static function verify_csrf_token($token)
    {
        return $_SESSION['csrf_token'] === $token;
    }

}
