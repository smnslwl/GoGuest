<?php

// Wrapper around the $_SESSION superglobal
class Session {

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

}
