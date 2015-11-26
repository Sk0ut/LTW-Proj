<?php
	include_once('database/connection.php');
  	include_once('database/event.php');
  	$resultOwnEvents = getOwnerEvents($_GET['id']);
  	$resultEntered = getRegisteredEvents($_GET['id']);
?>

<!DOCTYPE html>
<html>
	<head>
		<title> sceptross's page </title>
		<meta charset="UTF-8">
	</head>

	<body>
		<div id="ownevents">
			<h1> My events </h1> 
			<?php
			if(count($resultOwnEvents) == 0){
				echo '<p> You currently have no events created! </p>'; 
			}
			else { 
				foreach( $resultOwnEvents as $row) {
    			echo '<h2>' . $row['name'] . '</h1>';
 				echo '<p>' . $row['description'] . '</p>';	
 				} 
 			}?>
			
		</div>

		<div id="eventsentered">
			<h1> Events I'm in </h1>
			<?php
			if(count($resultEntered) == 0){
				echo '<p> You are currently not participating on any events! </p>';
			}
			else {
				foreach( $resultEntered as $row) {
    				echo '<h2>' . $row['name'] . '</h1>';
 					echo '<p>' . $row['description'] . '</p>';
 				}	
 			} ?>
		</div>

		<div id="currentinvites">
			<h1> My current invites </h1>
			<p> You currently have no invites! </p>
		</div>

	</body>

</html>