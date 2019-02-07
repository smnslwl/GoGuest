<?php
require_once('app_init.php');

$search_form = new Form('search', 'GET', url('locations'));

$PAGE_TITLE = "Home";
require_once('header.php');
?>

<section id="home_banner">
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<img src="images/house.jpg" class="img-responsive img-rounded" alt="House in Nepal">
			</div>
            <div class="col-md-6">
				<h3>Stay with a family in Nepal</h3>
				<hr>
				<p>Discover the best places to stay around your destination in Nepal.</p>
				<p>Stay with a welcoming family and enjoy delicious food and an amazing experience.</p>
				<p>Let's find you the perfect place!</p>
				<br>
				<br>
				<form action="<?= $search_form->action() ?>" method="<?= $search_form->method() ?>">
					<div class="form-group">
						<input type="text" class="form-control" id="destination" name="destination" placeholder="Where are you going?" value="">
                        <?php if ($search_form->has_errors('destination')): ?>
                            <?php foreach($search_form->errors('destination') as $error): ?>
                            <small class="text-danger"><?= $error ?></small><br>
                            <?php endforeach ?>
                        <?php endif; ?>
					</div>

					<button type="submit" class="btn btn-primary">Find me a place</button>
				</form>
			</div>
            <div class="col-md-6">
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<?php if (!Session::has('user')): ?>
				<h3>Become a host</h3>
				<hr>
				<p>
					All you need to do is sign up a new account and add your places.
					Once guests book your place, simply confirm the booking and you're ready to go.
					GoGuest will charge you a small convienence fee for every succesful booking.
				</p>
				<p>
					Registering for a new account is a simple, hassle free process.
					It will take less than a minute to get everything set up.
					Let's get started!
				</p>
				<a href="<?= url('register') ?>">
					<button type="button" class="btn btn-primary">Start earning money now!</button>
				</a>
				<?php else: ?>
				<h3>Manage your account</h3>
				<hr>
				<p>
					Manage all your locations and bookings in the admin area.
				</p>
				<a href="<?= url('admin') ?>">
					<button type="button" class="btn btn-primary">Go to Dashboard</button>
				</a>
				<?php endif ?>
			</div>
			<div class="col-md-6">
				<img src="images/house2.jpg" class="img-responsive img-rounded" alt="House in Nepal">
			</div>
		</div>
	</div>
</section>

<?php
require_once('footer.php');
