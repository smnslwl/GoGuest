<?php
require_once('app_init.php');

$booking = new Booking();
$booking->email = trim(Request::POST('email'));
$booking->location = Location::getById(Request::POST('location'));
$booking->status = Request::POST('status');
$booking->id = Request::POST('id');

$validator = new Validator('POST', url('booking'));
$validator->add_value('id', $booking->id);
$validator->add_value('location', $booking->location->id);
$validator->add_value('email', $booking->email);
$validator->add_value('status', $booking->status);

if (empty($booking->email)) {
    $validator->add_error('email', 'This is a required field.');
} else if (!filter_var($booking->email, FILTER_VALIDATE_EMAIL)) {
    $validator->add_error('email', 'Please enter a valid email address.');
}

$validator->validate();
$booking->save();

$PAGE_TITLE = "Booking successful";
require_once('header.php');
?>

<section class="main">
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <p>You will soon receive a confirmation email from the owners of <?= $booking->location->name ?>. Thank you for using <? $APP_TITLE ?> for your travel needs.</p>
        <p>Please be aware that in the case of unforseen circumstances, your booking might get canceled. You will receive an cancellation message if that happens.</p>
    </div>
</section>

<?php
require_once('footer.php');
