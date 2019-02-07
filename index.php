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
				<h3>Let's find you a place!</h3>
				<form action="<?= $search_form->action() ?>" method="<?= $search_form->method() ?>">
					<div class="form-group">
						<label for="destination">Where are you going?</label>
						<input type="text" class="form-control" id="destination" name="destination" value="">
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
				<h3>Guests</h3>
				<p>Find the best places to stay around your destination. Search for places, book the one you like the most!</p>
			</div>
		</div>
	</div>
</section>

<section>
	<div class="container">
		<div class="row">
			<div class="col-md-6">
				<h3>Hosts</h3>
				<p>
					All you need to do is sign up a new account and add your places.
					Once guests book your place, simply confirm the booking and you're ready to go.
					GoGuest will charge you a small convienence fee for every succesful booking.
				</p>
			</div>
            <div class="col-md-6">
				<h3>Let's get started!</h3>
				<p>
					Registering for a new account is a simple, hassle free process.
					It will take less than a minute to get everything set up.
				</p>
				<a href="<?= url('register') ?>">
					<button type="button" class="btn btn-primary">Start earning money now!</button>
				</a>
			</div>
		</div>
	</div>
</section>

<?php
require_once('footer.php');
