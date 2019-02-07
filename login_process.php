<?php
require_once('app_init.php');

$username = strtolower(trim(Request::POST('username')));
$password = Request::POST('password');

$validator = new Validator('POST', url('login'));
$validator->add_value('username', $username);

if (empty($username)) {
    $validator->add_error('username', 'This is a required field.');
} else {
    $user = User::getByUsername($username);
    if (strtolower($user->username) !== strtolower($username)) {
        $validator->add_error('username', 'That username does not exist.');
    } else if (!password_verify($password, $user->password)) {
        $validator->add_error('password', 'Wrong password.');
    }
}

$validator->validate();

Session::set('user', $user);

redirect(url('admin'));
