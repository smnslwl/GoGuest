<?php
require_once('app_init.php');

$remove_location_validator = new Validator('POST', url('admin'));
$remove_location_validator->validate();
$location_id = Request::POST('id');
$location = Location::getById($location_id);
$location->remove();
$remove_location_validator->add_message('Location removed.');
$remove_location_validator->finish();
redirect($remove_location_validator->source());
