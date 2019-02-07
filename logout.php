<?php
require_once('app_init.php');

Session::end();
Session::start();

$PAGE_TITLE = "Logout successful";
require_once('header.php');
?>

<section class="main">
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <p>You have successfully logged out your account.</p>
    </div>
</section>

<?php
require_once('footer.php');
