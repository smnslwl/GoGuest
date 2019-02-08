<?php
require_once('app_init.php');

$booking = new Booking();
$booking->email = htmlspecialchars(trim(Request::POST('email')));
$booking->location = Location::getById(Request::POST('location'));
$booking->from = htmlspecialchars(Request::POST('date_from'));
$booking->to = htmlspecialchars(Request::POST('date_to'));
$booking->adults = htmlspecialchars(Request::POST('adults'));
$booking->children = htmlspecialchars(Request::POST('children'));
$booking->status = Request::POST('status');
$booking->id = Request::POST('id');

$validator = new Validator('POST', url('booking'));
$validator->add_value('id', $booking->id);
$validator->add_value('location', $booking->location->id);
$validator->add_value('email', $booking->email);
$validator->add_value('from', $booking->from);
$validator->add_value('to', $booking->to);
$validator->add_value('adults', $booking->adults);
$validator->add_value('children', $booking->children);
$validator->add_value('status', $booking->status);

if (empty($booking->email)) {
    $validator->add_error('email', 'This is a required field.');
} else if (!filter_var($booking->email, FILTER_VALIDATE_EMAIL)) {
    $validator->add_error('email', 'Please enter a valid email address.');
}

$d1 = new DateTime($booking->from);
if (!($d1 && $d1->format('Y/m/d') == $booking->from)) {
    $validator->add_error('date_from', 'Invalid date' . var_dump($d1));
}

$d2 = new DateTime($booking->to);
if (!($d2 && $d2->format('Y/m/d') == $booking->to)) {
    $validator->add_error('date_to', 'Invalid date' . var_dump($d2));
}

if ($d2 < $d1) {
    $validator->add_error('date_to', 'Cannot be earlier than check in date.');
}

if (empty($booking->adults)) {
    $validator->add_error('adults', 'This is a required field.');
} else {
    if (!is_numeric($booking->adults)) {
        $validator->add_error('adults', 'Must be a number.');
    } else if ($booking->adults < 1 or $booking->adults > 20) {
        $validator->add_error('adults', 'Must have at least one and at most 20 adults.');
    }
}

if (!is_numeric($booking->children)) {
    $validator->add_error('children', 'Must be a number.');
} else if ($booking->children < 0 or $booking->children > 20) {
    $validator->add_error('children', 'Can bring at most 20 children.');
}

$validator->validate();
$booking->save();

$PAGE_TITLE = "Booking successful";
require_once('header.php');
?>

<section class="main">
    <div class="container">
        <h3><?= $PAGE_TITLE ?></h3>
        <p>You will soon receive a confirmation email from the owners of <?= $booking->location->name ?>. Thank you for using <?= $APP_TITLE ?> for your travel needs.</p>
        <p>Please be aware that in the case of unforseen circumstances, your booking might get canceled. You will receive an cancellation message if that happens.</p>
    </div>
</section>

<?php
require_once('footer.php');
