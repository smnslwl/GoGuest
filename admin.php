<?php
$PAGE_TITLE = 'Admin';
require_once('header.php');
?>

<section>
    <div class="container">
        <div class="row">
            <h3><?= $PAGE_TITLE ?></h3>
            <hr>
            <p>This is a super secret page that can only be viewed by logged in users.</p>
        </div>
    </div>
</section>

<?php
require_once('footer.php');
