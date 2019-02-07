<?php

require_once('app_init.php');

if (!Session::has('user')) {
	redirect(url('login'));
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $form_name = Request::POST('form_name');
    $validator = new Validator('POST', url('admin'));
    $validator->validate();
} else {
    $form_name = Session::get('form_name', 'add_location');
    Session::remove('form_name');
}

$form = new Form($form_name, 'POST', url('admin_location_add_edit_process'));
if ($form_name === 'add_location') {
    $location = new Location();
    $location->user = Session::get('user');
    $PAGE_TITLE = "Add a new location";
} else if ($form_name === 'edit_location') {
    $location = Location::getById(Request::POST('id'));
    $PAGE_TITLE = "Edit location";
} else {
    die('An error occured.');
}

if ($form->has_errors_any())
{
    $location->id = $form->value('id');
    $location->name = $form->value('name');
    $location->latitude = $form->value('latitude');
    $location->longitude = $form->value('longitude');
    $location->user = $form->value('user');
}

require_once('header.php');
?>

<section>
	<div class="container">
        <div class="row">
            <h3><?= $PAGE_TITLE ?></h3>
            <hr>
        </div>
        <div class="row">
            <div class="col-md-6">
                <div id="map_canvas" style="height: 400px; width: 100%"></div>
            </div>
            <div class="col-md-6">
                <form action="<?= $form->action() ?>" method="<?= $form->method() ?>">
                    <?= $form->get_meta_fields() ?>
                    <input type="hidden" name="form_name" value="<?= $form_name ?>">
                    <input type="hidden" name="id" value="<?= $location->id ?>">
                    <input type="hidden" name="user" value="<?= $location->user->id ?>">

                    <div class="form-group">
                        <label for="name">Name</label>
                        <input type="text" class="form-control" id="name" name="name" value="<?= $location->name ?>">
                        <?php if ($form->has_errors('name')): ?>
                            <?php foreach($form->errors('name') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="latitude">Latitude</label>
                        <input type="text" class="form-control" id="latitude" name="latitude" value="<?= $location->latitude ?>">
                        <?php if ($form->has_errors('latitude')): ?>
                            <?php foreach($form->errors('latitude') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="longitude">Longitude</label>
                        <input type="text" class="form-control" id="longitude" name="longitude" value="<?= $location->longitude ?>">
                        <?php if ($form->has_errors('longitude')): ?>
                            <?php foreach($form->errors('longitude') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="price">Price</label>
                        <input type="text" class="form-control" id="price" name="price" value="<?= $location->price ?>">
                        <?php if ($form->has_errors('price')): ?>
                            <?php foreach($form->errors('price') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <div class="form-group">
                        <label for="description">Description</label>
                        <textarea class="form-control" rows="5" id="description" name="description" value="<?= $location->description ?>"></textarea>
                        <?php if ($form->has_errors('description')): ?>
                            <?php foreach($form->errors('description') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
                    </div>

                    <br>
                    <button type="submit" class="btn btn-primary btn-block"><?= $PAGE_TITLE ?></button>
                </form>
            </div>
        </div>
	</div>
</section>

<script src="js/leaflet.js"></script>
<script type="text/javascript">
var mymap = L.map('map_canvas').setView([27.7296302,84.3584355], 8);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
    maxZoom: 18,
    attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
        '<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
        'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
    id: 'mapbox.streets'
}).addTo(mymap);

var latlng = L.latLng(<?= $location->latitude ?>, <?= $location->longitude ?>);
var popup = L.popup();
popup.setLatLng(latlng).setContent(latlng.toString()).openOn(mymap);

function onMapClick(e) {
    popup.setLatLng(e.latlng).setContent(e.latlng.toString()).openOn(mymap);
    document.getElementById('latitude').value = e.latlng.lat;
    document.getElementById('longitude').value = e.latlng.lng;
}

mymap.on('click', onMapClick);
</script>

<?php
require_once('footer.php');
