<?php
require_once('app_init.php');

if (!Session::has('user')) {
	redirect(url('login'));
}

$locations = Location::getAllByUser(Session::get('user'));

$add_location_form = new Form('add_location', 'POST', url('admin_location_add_edit'));
$edit_location_form = new Form('edit_location', 'POST', url('admin_location_add_edit'));
$remove_location_form = new Form('remove_location', 'POST', url('admin_location_remove'));

$PAGE_TITLE = 'Admin';
require_once('header.php');
?>

<section>
    <div class="container">
        <div class="row">
            <h3><?= $PAGE_TITLE ?></h3>
            <hr>
            <p>Manage your locations here.</p>
			<?php if ($add_location_form->has_messages()): ?>
				<?php foreach($add_location_form->messages() as $message): ?>
				<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $message ?></div>
				<?php endforeach ?>
			<?php endif; ?>

			<?php if ($edit_location_form->has_messages()): ?>
				<?php foreach($edit_location_form->messages() as $message): ?>
				<div class="alert alert-warning alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $message ?></div>
				<?php endforeach ?>
			<?php endif; ?>

			<?php if ($remove_location_form->has_messages()): ?>
				<?php foreach($remove_location_form->messages() as $message): ?>
				<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $message ?></div>
				<?php endforeach ?>
			<?php endif; ?>
        </div>
    </div>
</section>

<section>
	<div class="container">
		<div class="row">
			<h4>Locations</h4>
			<div class="col-md-6">
				<?php if (count($locations) > 0): ?>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Name</th>
						<th>Latitude</th>
						<th>Longitude</th>
						<th>Actions</th>
					</tr>
					<?php foreach ($locations as $location): ?>
					<tr>
						<td><?= $location->name ?></td>
						<td><?= $location->latitude ?></td>
						<td><?= $location->longitude ?></td>
						<td>
							<form class="inline_form" action="<?= $edit_location_form->action() ?>" method="<?= $edit_location_form->method() ?>">
								<?= $edit_location_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $location->id ?>">
								<button type="submit" class="btn btn-warning">&#9986</button>
						    </form>
							<form class="inline_form" action="<?= $remove_location_form->action() ?>" method="<?= $remove_location_form->method() ?>">
								<?= $remove_location_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $location->id ?>">
								<button type="submit" class="btn btn-danger">&#10006</button>
							</form>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
				<?php else: ?>
				<p>No locations found.</p>
				<?php endif ?>
				<form action="<?= $add_location_form->action() ?>" method="<?= $remove_location_form->method() ?>">
					<?= $add_location_form->get_meta_fields() ?>
					<button type="submit" class="btn btn-success">Add a new location</button>
				</form>
			</div>
			<div class="col-md-6">
				<div id="map_canvas" style="height: 400px; width: 100%"></div>
			</div>
		</div>
	</div>
</section>


<?php
require_once('footer.php');
