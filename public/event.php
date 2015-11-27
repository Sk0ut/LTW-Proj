<?php
	require_once(".." . DIRECTORY_SEPARATOR . "config" . DIRECTORY_SEPARATOR . "config.php");
	
	require_once(ROOT . DS . "application" . DS . "models" . DS . "event.class.php");
	
	$event = new Event("Event name", "Event Owner", "Event Type", "Event description", "10/12/2015 19:30", "not_available");
	
	$PageTitle=$event->getName();
	require_once("header.php");
?>

	<div id="event_header">
		<h1 class="event_name">
			<?php echo $event->getName(); ?>
		</h1>
		<h3 class="event_date">
			<?php echo $event->getDate(); ?>
		</h3>
		<h4 class="event_owner">
			Created by: <?php echo $event->getOwner(); ?>
		</h4>
		<img class="event_picture" src=<?php echo $event->getPicture(); ?> >
		<p class="event_description">
			<?php echo $event->getDescription(); ?>
		</p>
	</div>
	
	<div id="registered_users">
	</div>

	<div id="albums">
	</div>
	
	<div id="forum">
	</div>
<?php
	require_once("footer.php");
?>