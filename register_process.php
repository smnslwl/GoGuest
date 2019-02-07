<?php
require_once('app_init.php');

$username = htmlspecialchars(trim(Request::POST('username')));
$password = Request::POST('password');
$confirm_password = Request::POST('confirm_password');
$tos = Request::POST('tos');

$validator = new Validator('POST', url('register'));
$validator->add_value('username', $username);
$validator->add_value('tos', $tos);

if (empty($username)) {
    $validator->add_error('username', 'This is a required field.');
} else if (strlen($username) < 4) {
    $validator->add_error('username', 'Username must be at least 4 characters long.');
} else if (!filter_var($username, FILTER_VALIDATE_REGEXP, array("options" => array("regexp" => '/^[a-zA-Z0-9]+$/i')))) {
    $validator->add_error('username', 'Username can only contain alphanumeric characters.');
} else {
    $check_user = User::getByUsername($username);
    if (strtolower($check_user->username) === strtolower($username)) {
        $validator->add_error('username', 'That username already exists.');
    }
}

if (empty($password)) {
    $validator->add_error('password', 'This is a required field.');
} else if (strlen($password) < 4) {
    $validator->add_error('password', 'Password must be at least 4 characters long.');
}

if (empty($confirm_password)) {
    $validator->add_error('confirm_password', 'This is a required field.');
} else if ($password !== $confirm_password) {
    $validator->add_error('confirm_password', 'The two passwords do not match.');
}

if ($tos !== 'yes') {
    $validator->add_error('tos', 'You must check this field to proceed.');
}

$validator->validate();

$user = new User();
$user->username = $username;
$user->password = password_hash($password, PASSWORD_BCRYPT);
$user->save();

$PAGE_TITLE = "Registration successful";
require_once('header.php');
?>

<section class="main">
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <p>Please <a href="<?= url('login') ?>">log in</a> to continue.</p>
    </div>
</section>

<?php
require_once('footer.php');
