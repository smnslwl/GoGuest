<?php

require_once('app_init.php');

if (!Session::has('user')) {
	redirect(url('login'));
}

$bookings = Booking::getAllByUser(Session::get('user'));
$locations = Location::getAllByUser(Session::get('user'));

$confirm_booking_form = new Form('confirm_booking', 'POST', url('admin_booking_process'));
$cancel_booking_form = new Form('cancel_booking', 'POST', url('admin_booking_process'));
$add_location_form = new Form('add_location', 'POST', url('admin_location_add_edit'));
$edit_location_form = new Form('edit_location', 'POST', url('admin_location_add_edit'));
$remove_location_form = new Form('remove_location', 'POST', url('admin_location_remove'));

$PAGE_TITLE = "Admin";
require_once('header.php');
?>

<section>
	<div class="container">
		<div class="row">
			<h3><?= $PAGE_TITLE ?></h3>
			<hr>
			<p>Manage bookings and locations here.</p>
			<?php if ($confirm_booking_form->has_messages()): ?>
				<?php foreach($confirm_booking_form->messages() as $message): ?>
				<div class="alert alert-success alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $message ?></div>
				<?php endforeach ?>
			<?php endif; ?>

			<?php if ($cancel_booking_form->has_messages()): ?>
				<?php foreach($cancel_booking_form->messages() as $message): ?>
				<div class="alert alert-danger alert-dismissible fade in"><a href="#" class="close" data-dismiss="alert" aria-label="close">&times;</a><?= $message ?></div>
				<?php endforeach ?>
			<?php endif; ?>

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
			<h4>Bookings</h4>
			<div class="col-md-12">
				<?php if (count($bookings) > 0): ?>
				<table class="table table-bordered table-condensed">
					<tr>
						<th>Location</th>
						<th>Guest Email</th>
						<th>Check in</th>
						<th>Check out</th>
						<th>Adults</th>
						<th>Children</th>
						<th>Status</th>
						<th>Actions</th>
					</tr>
					<?php foreach ($bookings as $booking): ?>
					<tr>
						<td><?= $booking->location->name ?></td>
						<td><?= $booking->email ?></td>
						<td><?= $booking->from ?></td>
						<td><?= $booking->to ?></td>
						<td><?= $booking->adults ?></td>
						<td><?= $booking->children ?></td>
						<td><?= $booking->status_text() ?></td>
						<td>
							<?php if ($booking->status != BOOKING::CONFIRMED): ?>
							<form class="inline_form" action="<?= $confirm_booking_form->action() ?>" method="<?= $confirm_booking_form->method() ?>">
								<?= $confirm_booking_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $booking->id ?>">
								<button type="submit" class="btn btn-success">Confirm</button>
							</form>
							<?php endif ?>
							<?php if ($booking->status != BOOKING::CANCELED): ?>
							<form class="inline_form" action="<?= $cancel_booking_form->action() ?>" method="<?= $cancel_booking_form->method() ?>">
								<?= $cancel_booking_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $booking->id ?>">
								<button type="submit" class="btn btn-danger">Cancel</button>
							</form>
							<?php endif ?>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
				<?php else: ?>
				<p>No bookings found.</p>
				<?php endif ?>
			</div>
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
						<th>Price</th>
						<th>Actions</th>
					</tr>
					<?php foreach ($locations as $location): ?>
					<tr>
						<td>
							<a href="<?= location_url($location->id) ?>"><?= $location->name ?></a>
						</td>
						<td>
							Rs. <?= $location->price ?></a>
						</td>
						<td>
							<form class="inline_form" action="<?= $edit_location_form->action() ?>" method="<?= $edit_location_form->method() ?>">
								<?= $edit_location_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $location->id ?>">
								<button type="submit" class="btn btn-warning">&#9986; Edit</button>
							</form>
							<form class="inline_form" action="<?= $remove_location_form->action() ?>" method="<?= $remove_location_form->method() ?>">
								<?= $remove_location_form->get_meta_fields() ?>
								<input type="hidden" name="id" value="<?= $location->id ?>">
								<button type="submit" class="btn btn-danger">&#10006; Delete</button>
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

<script src="js/leaflet.js"></script>
<script type="text/javascript">
var mymap = L.map('map_canvas').setView([27.7296302, 84.3584355], 8);

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	id: 'mapbox.streets'
}).addTo(mymap);



<?php foreach($locations as $location): ?>
L.marker([<?= $location->latitude ?>, <?= $location->longitude ?>]).addTo(mymap).bindPopup("<a href='<?= location_url($location->id) ?>'><strong><?= $location->name ?></strong></a><br><br>Rs. <?= $location->price ?>").openPopup();
<?php endforeach ?>
</script>

<?php
require_once('footer.php');
