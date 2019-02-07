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

                    <br>
                    <button type="submit" class="btn btn-primary btn-block"><?= $PAGE_TITLE ?></button>
                </form>
            </div>
        </div>
	</div>
</section>

<?php
require_once('footer.php');