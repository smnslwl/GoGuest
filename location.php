<?php
require_once('app_init.php');

$location_id = Request::GET('location', 0);
$location = Location::getById($location_id);
if ($location->id == 0) {
    redirect(url('404'));
}

$PAGE_TITLE = $location->description;
require_once('header.php');
?>

<section>
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <hr>
        <br>
        <br>
        <?= $location->description ?>
        <br>
        <br>
    </div>
</section>

<?php
require_once('footer.php');