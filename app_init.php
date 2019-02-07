<?php
require_once('app_config.php');

spl_autoload_register(function ($class_name) {
	$filename = 'classes/' . $class_name . '.php';
	if (is_readable($filename)) {
		require_once($filename);
	}
});

function url($name)
{
    global $APP_URL;
    return empty($name) ? $APP_URL : $APP_URL . $name. '.php';
}

function redirect($location)
{
    header('Location: '. $location);
    die();
}

function location_url($id)
{
    return url('location') . '?location=' . $id;
}

Session::start();
