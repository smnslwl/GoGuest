<?php
require_once('app_init.php');

if (!Session::has('user')) {
	redirect(url('login'));
}

$form_name = Request::POST('form_name');

if ($form_name === 'confirm_booking') {
    $validator = new Validator('POST', url('admin'));
} else if ($form_name === 'cancel_booking') {
    $validator = new Validator('POST', url('admin'));
} else {
    die('An error occured');
}

$booking = Booking::getById(Request::POST('id'));
$validator->validate();

if ($form_name === 'confirm_booking') {
    $booking->status = Booking::CONFIRMED;
    $validator->add_message('Booking confirmed.');
} else {
    $booking->status = Booking::CANCELED;
    $validator->add_message('Booking canceled.');
}

$validator->finish();
$booking->save();
redirect($validator->source());
