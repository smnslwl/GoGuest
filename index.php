<?php
$PAGE_TITLE = 'Welcome to GoGuest';
require_once('header.php');
?>

<section id="home_banner">
    <div class="container">
        <div class="row">
            <div class="col-md-6 col-md-offset-3">
                <h3><?= $PAGE_TITLE ?></h3>
                <hr>
                <form action="" method="">
					<div class="form-group">
						<label for="destination">Where are you going?</label>
						<input type="text" class="form-control" id="destination" name="destination" value="">

					</div>

					<button type="submit" class="btn btn-primary">Find me a place</button>
				</form>
            </div>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
