<?php
require_once('app_init.php');

$location_id = Request::GET('location', 0);
$location = Location::getById($location_id);
if ($location->id == 0) {
    redirect(url('404'));
}

$booking_form = new Form('booking_start', 'POST', url('booking'));

$PAGE_TITLE = $location->name;
require_once('header.php');
?>

<section>
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <hr>
        <?= $location->description ?>
        <br>
        <br>
        <form class="inline_form" action="<?= $booking_form->action() ?>" method="<?= $booking_form->method() ?>">
            <?= $booking_form->get_meta_fields() ?>
            <input type="hidden" name="location" value="<?= $location->id ?>">
            <button type="submit" class="btn btn-primary">Book this location</button>
        </form>
    </div>
</section>

<?php
require_once('footer.php');
