<?php
	function getEventName() {
		return "Event name";
	}
	
	function getEventDate() {
		return "10/12/2015 19:30";
	}
	
	function getEventOwner() {
		return "Event Owner";
	}
	
	function getEventPicture() {
		return ""
	}
	
	function getEventDescription() {
		return "Event description";
	}
	
?>


<!DOCTYPE html>

<html>
  <head>
    <title><?php getEventName() ?></title>
  </head>
  <body>
	<div id="event_header">
		<h1 class="event_name">
			<?php echo getEventName() ?>
		</h1>
		<h3 class="event_date">
			<?php echo getEventDate() ?>
		</h3>
		<h4 class="event_owner">
			Created by: <?php echo getEventOwner() ?>
		</h4>
		<img class="event_picture" src=<?php echo getEventPicture() ?> >
		<p class="event_description">
			<?php echo getEventDescription() ?>
		</p>
	</div>
	
	<div id="registered_users">
	</div>

	<div id="albums">
	</div>
	
	<div id="forum">
	</div>
  </body>
</html>