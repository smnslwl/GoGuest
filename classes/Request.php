<?php

class Request {

    public static function method()
    {
        return $_SERVER['REQUEST_METHOD'];
    }

    public static function GET($key, $default = '')
    {
        return array_key_exists($key, $_GET) ? $_GET[$key] : $default;
    }

    public static function POST($key, $default = '')
    {
        return array_key_exists($key, $_POST) ? $_POST[$key] : $default;
    }

};
