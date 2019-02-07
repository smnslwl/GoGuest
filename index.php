<?php
$PAGE_TITLE = 'Welcome to GoGuest';
require_once('header.php');
?>

<section id="home_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3><?= $PAGE_TITLE ?></h3>
                <hr>
                <?php
                $stmt = DB::instance()->query('SELECT * from USERS');
                var_dump($stmt);
                ?>
            </div>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
