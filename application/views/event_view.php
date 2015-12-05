<?php

$event = $data['event'];
$owner = $data['owner'];

$imageUrl = str_replace(' ', '%20', $event->getPhoto());
$imageUrl = "img/uploaded/" . $imageUrl;

$PageTitle = $event->getName();
function customPageHeader() { ?>
    <meta name="description" content="<?php echo 'Event page' ?>">
    <meta name="author" content="LTW - MIEIC">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

require_once('shared/header.php');
?>

<div id="event_header">
	<h1 id="event_name">
		<?php echo $event->getName(); ?>
	</h1>
	<h3 id="event_type">
		<?php echo $event->getType(); ?>
	</h3>
	<h3 class="event_date">
		<?php echo $event->getDate(); ?>
	</h3>
	<h4 id="event_owner">
		Created by: <?php echo $owner->getUsername(); ?>
	</h4>
	<img id="event_picture" src="<?php echo $imageUrl ?>">
	<p id="event_description">
		<?php echo $event->getDescription(); ?>
	</p>
</div>

<?php
require_once('shared/footer.php');
?>
