<?php

require_once('app_init.php');

$form = new Form('booking', 'POST', url('booking_process'));

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $validator = new Validator('POST', url(''));
    $validator->validate();
    $booking = new Booking();
    $booking->location = Location::getById(Request::POST('location'));
} else if ($form->has_errors_any()) {
    $booking = new Booking();
    $booking->id = $form->value('id');
    $booking->email = $form->value('email');
    $booking->from = $form->value('date_from');
    $booking->to = $form->value('date_to');
    $booking->adults = $form->value('adults');
    $booking->children = $form->value('children');
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
            <div class="col-md-6 col-md-offset-3">
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

                    <div class="form-group">
                        <label for="date_from">Check in</label>
                        <div class='input-group date' id='datetimepicker_from'>
                            <input type='text' class="form-control" id="date_from" name="date_from">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <?php if ($form->has_errors('date_from')): ?>
                            <?php foreach($form->errors('date_from') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="date_from">Check out</label>
                        <div class='input-group date' id='datetimepicker_to'>
                            <input type='text' class="form-control" id="date_to" name="date_to">
                            <span class="input-group-addon">
                                <span class="glyphicon glyphicon-calendar"></span>
                            </span>
                        </div>
                        <?php if ($form->has_errors('date_to')): ?>
                            <?php foreach($form->errors('date_to') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="adults">Adults</label>
                        <input type="text" class="form-control" id="adults" name="adults" value="<?= $booking->adults ?>">
                        <?php if ($form->has_errors('adults')): ?>
                            <?php foreach($form->errors('adults') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="children">Children</label>
                        <input type="text" class="form-control" id="children" name="children" value="<?= $booking->children ?>">
                        <?php if ($form->has_errors('children')): ?>
                            <?php foreach($form->errors('children') as $error): ?>
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

<script type="text/javascript">
$(function () {
    $('#datetimepicker_from').datetimepicker({format: 'YYYY/MM/DD', showTodayButton: true, showClear: true, minDate: moment()});
});

$(function () {
    $('#datetimepicker_to').datetimepicker({format: 'YYYY/MM/DD', showTodayButton: true, showClear: true, minDate: moment()});
});
</script>

<?php
require_once('footer.php');
