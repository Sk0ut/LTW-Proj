<?php
	include_once('database/connection.php');
  	include_once('database/news.php');
  	$resultOwnEvents = getOwnerEvents($_GET['id']);
  	$resultEntered = getRegisteredEvents($_GET['id']);
  	//$resultInvites = getNews(3);
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

			<?php foreach( $resultOwnEvents as $row) {
    		echo '<h2>' . $row['name'] . '</h1>';
 			echo '<p>' . $row['description'] . '</p>';	
 			} ?>
			
		</div>

		<div id="eventsentered">
			<h1> Events I'm in </h1>
			<?php foreach( $resultEntered as $row) {
    		echo '<h2>' . $row['name'] . '</h1>';
 			echo '<p>' . $row['description'] . '</p>';		
 			} ?>
		</div>

		<div id="currentinvites">
			<h1> My current invites </h1>
		</div>

	</body>

</html>