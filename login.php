<?php
require_once('app_init.php');

if (Session::has('user')) {
	redirect(url('admin'));
}

$PAGE_TITLE = "Login";
require_once('header.php');
$form = new Form('login', 'POST', url('login_process'));
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3><?= $PAGE_TITLE ?></h3>
                <hr>
                <form action="<?= $form->action() ?>" method="<?= $form->method() ?>">
                    <?= $form->get_meta_fields() ?>

                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username" value="<?= $form->value('username') ?>">
                        <?php if ($form->has_errors('username')): ?>
                            <?php foreach($form->errors('username') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                        <?php if ($form->has_errors('password')): ?>
                            <?php foreach($form->errors('password') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary btn-block">Login</button>
                    <br>
                    <p><a href="<?= url('register') ?>">Create a new account</a></p>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
