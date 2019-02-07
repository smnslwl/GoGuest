<?php
$PAGE_TITLE = 'Register';
require_once('header.php');
?>

<section>
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3><?= $PAGE_TITLE ?></h3>
                <hr>
                <form>
                    <div class="form-group">
                        <label for="username">Username</label>
                        <input type="text" class="form-control" id="username" name="username">
                    </div>
                    <div class="form-group">
                        <label for="password">Password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <div class="form-group">
                        <label for="password">Confirm password</label>
                        <input type="password" class="form-control" id="password" name="password">
                    </div>
                    <br>
                    <button type="submit" class="btn btn-default btn-primary btn-block"><?= $PAGE_TITLE ?></button>
                </form>
            </div>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
