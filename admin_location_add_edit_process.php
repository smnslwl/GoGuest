<?php
require_once('app_common.php');

if (!Session::has('user')) {
	redirect(url('login'));
}

$form_name = Request::POST('form_name');

if ($form_name === 'add_location') {
    $validator = new Validator('POST', url('admin_location_add_edit'));
} else if ($form_name === 'edit_location') {
    $validator = new Validator('POST', url('admin_location_add_edit'));
} else {
    die('An error occured');
}

$location = new Location;
$location->id = Request::POST('id');
$location->name = Request::POST('name');
$location->latitude = Request::POST('latitude');
$location->longitude = Request::POST('longitude');
$location->user = Session::get('user');

$validator->add_value('id', $location->id);
$validator->add_value('name', $location->name);
$validator->add_value('longitude', $location->longitude);
$validator->add_value('latitude', $location->latitude);
$validator->add_value('user', $location->user);

if (empty($location->name)) {
    $validator->add_error('name', 'This is a required field.');
}

if (empty($location->latitude)) {
    $validator->add_error('latitude', 'This is a required field.');
} else {
    if (!is_numeric($location->latitude)) {
        $validator->add_error('latitude', 'Must be a number.');
    } else if ($location->latitude < 26 or $location->latitude > 30) {
        $validator->add_error('latitude', 'Must be between 26 and 30.');
    }
}

if (empty($location->longitude)) {
    $validator->add_error('longitude', 'This is a required field.');
} else {
    if (!is_numeric($location->longitude)) {
        $validator->add_error('longitude', 'Must be a number.');
    } else if ($location->longitude < 80 or $location->longitude > 89) {
        $validator->add_error('longitude', 'Must be between 80 and 89.');
    }
}

$validator->validate();

if ($form_name === 'add_location') {
    $validator->add_message('Location added.');
} else {
    $location->id = Request::POST('id');
    $validator->add_message('Location edited.');
}

$validator->finish();
$location->save();
redirect(url('admin_dashboard'));
