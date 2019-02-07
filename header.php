<?php
require_once('app_init.php');
?>

<!doctype html>
<html lang="en">
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <title><?= $PAGE_TITLE . ' - ' . $APP_TITLE ?></title>
    <link href="css/bootstrap.min.css" rel="stylesheet">
    <link href="css/style.css" rel="stylesheet">
    <script src="js/jquery.min.js"></script>
    <script src="js/bootstrap.min.js"></script>
    <script src="js/script.js"></script>
</head>
<body>
<nav class="navbar navbar-inverse navbar-fixed-top">
    <div class="container">
        <div class="navbar-header">
            <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#navbar" aria-expanded="false" aria-controls="navbar">
            <span class="sr-only">Toggle navigation</span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            <span class="icon-bar"></span>
            </button>
            <a class="navbar-brand" href="#"><?= $APP_TITLE ?></a>
        </div>
        <div id="navbar" class="navbar-collapse collapse">
            <ul class="nav navbar-nav">
                <li><a href="<?= url('') ?>">Home</a></li>
                <li><a href="<?= url('about') ?>">About</a></li>
            </ul>
            <ul class="nav navbar-nav navbar-right">
                <?php if (Session::has('user')): ?>
                <li class="dropdown">
                    <a href="#" class="dropdown-toggle" data-toggle="dropdown" role="button" aria-haspopup="true" aria-expanded="false"><?= Session::get('user')->username ?> <span class="caret"></span></a>
                    <ul class="dropdown-menu">
                        <li><a href="<?= url('admin') ?>">Admin</a></li>
                        <li role="separator" class="divider"></li>
                        <li class="dropdown-header">Account</li>
                        <li><a href="<?= url('logout') ?>">Logout</a></li>
                    </ul>
                </li>
                <?php else: ?>
                <li><a href="<?= url('login') ?>">Login</a></li>
                <li><a href="<?= url('register') ?>">Register</a></li>
                <?php endif ?>
            </ul>
        </div>
    </div>
</nav>
