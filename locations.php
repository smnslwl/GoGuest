<?php
require_once('app_init.php');

$destination = 'Kathmandu';
if ($_SERVER['REQUEST_METHOD'] === 'GET') {
	$validator = new Validator('GET', url(''));
	$destination = trim(Request::GET('destination'));
	if (empty($destination)) {
		$validator->add_error('destination', 'This field is required.');
	}
	$validator->validate();
	$PAGE_TITLE = "Locations near " . $destination;
}

$saved_location = SavedLocation::getByName($destination);
$all_locations = Location::getAll();
$near_locations = [];
if ($saved_location->id != 0) {
	foreach ($all_locations as $location) {
		$lat_difference = abs($location->latitude - $saved_location->latitude);
		$lng_difference = abs($location->longitude - $saved_location->longitude);
		if ($lat_difference < 0.5 and $lng_difference < 0.5) {
			$near_locations[] = $location;
		}
	}
}

if (empty($near_locations)) {
	$locations = $all_locations;
} else {
	$locations = $near_locations;
}

$booking_form = new Form('booking_start', 'POST', url('booking'));

require_once('header.php');
?>

<section>
	<div class="container">
		<div class="row">
			<h3><?= $PAGE_TITLE ?></h3>
			<hr>
			<?php if (empty($near_locations)): ?>
			<p>Sorry, we could not find any locations near your destination.</p>
				<?php if (empty($locations)): ?>
				<p>Sorry, we could not find any locations at all.</p>
				<?php else: ?>
				<p>However, here are some other locations that you may like.</p>
				<?php endif ?>
			<?php endif ?>
		</div>
		<div class="row">
			<div class="col-md-6">
				<?php if (count($locations) > 0): ?>

				<table class="table table-bordered table-condensed">
					<tr>
						<th>Name</th>
						<th>Price</th>
						<th>Host</th>
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
							<?= $location->user->username ?>
						</td>
						<td>
							<form class="inline_form" action="<?= $booking_form->action() ?>" method="<?= $booking_form->method() ?>">
								<?= $booking_form->get_meta_fields() ?>
								<input type="hidden" name="location" value="<?= $location->id ?>">
								<button type="submit" class="btn btn-primary">Book</button>
							</form>
						</td>
					</tr>
					<?php endforeach ?>
				</table>
				<?php else: ?>
				<p>No locations found.</p>
				<?php endif ?>
			</div>
			<div class="col-md-6">
				<div id="map_canvas" style="height: 400px; width: 100%"></div>
			</div>
		</div>
	</div>
</section>

<script src="js/leaflet.js"></script>
<script type="text/javascript">
<?php if ($saved_location->id != 0): ?>
var mymap = L.map('map_canvas').setView([<?= $saved_location->latitude ?>, <?= $saved_location->longitude ?>], 8);
<?php else: ?>
var mymap = L.map('map_canvas').setView([27.7296302, 84.3584355], 8);
<?php endif ?>

L.tileLayer('https://api.tiles.mapbox.com/v4/{id}/{z}/{x}/{y}.png?access_token=pk.eyJ1IjoibWFwYm94IiwiYSI6ImNpejY4NXVycTA2emYycXBndHRqcmZ3N3gifQ.rJcFIG214AriISLbB6B5aw', {
	maxZoom: 18,
	attribution: 'Map data &copy; <a href="https://www.openstreetmap.org/">OpenStreetMap</a> contributors, ' +
		'<a href="https://creativecommons.org/licenses/by-sa/2.0/">CC-BY-SA</a>, ' +
		'Imagery © <a href="https://www.mapbox.com/">Mapbox</a>',
	id: 'mapbox.streets'
}).addTo(mymap);

<?php foreach($locations as $location): ?>
L.marker([<?= $location->latitude ?>, <?= $location->longitude ?>]).addTo(mymap).bindPopup("<a href='<?= location_url($location->id) ?>'><strong><?= $location->name ?></strong></a><br><em><?= $location->user->username ?></em><br><strong>Rs. <?= $location->price ?></strong>").openPopup();
<?php endforeach ?>
</script>

<?php
require_once('footer.php');
