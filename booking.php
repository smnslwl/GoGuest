<?php

require_once('app_init.php');

$form = new Form('booking', 'POST', url('booking_process'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator('POST', url('home'));
    $validator->validate();
    $booking = new Booking();
    $booking->location = Location::getById(Request::POST('location'));
} else if ($form->has_errors_any()) {
    $booking = new Booking();
    $booking->id = $form->value('id');
    $booking->email = $form->value('email');
    $booking->status = $form->value('status');
    $booking->location = Location::getById($form->value('location'));
} else {
    redirect(url('home'));
}

$PAGE_TITLE = 'Book "' . $booking->location->name . '" now';
require_once('header.php');
?>

<section>
	<div class="container">
        <div class="row">
            <div class="col-md-6">
                <h3><?= $PAGE_TITLE ?></h3>
	        	<hr>
                <form action="<?= $form->action() ?>" method="<?= $form->method() ?>">
                    <?= $form->get_meta_fields() ?>
                    <input type="hidden" name="id" value="<?= $booking->id ?>">
                    <input type="hidden" name="location" value="<?= $booking->location->id ?>">

                    <div class="form-group">
                        <label for="email">Email</label>
                        <input type="text" class="form-control" id="email" name="email" value="<?= $booking->email ?>">
                        <?php if ($form->has_errors('email')): ?>
                            <?php foreach($form->errors('email') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary btn-block">Book this place</button>
                </form>
            </div>
        </div>
	</div>
</section>

<?php
require_once('footer.php');
