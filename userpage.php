<?php
	include_once('database/connection.php');
  	include_once('database/news.php');
  	$result = getNews($_GET['id']);
  	$resultEntered = getNews(2);
  	$resultInvites = getNews(3);
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

			<?php foreach( $result as $row) {
    		echo '<h2>' . $row['title'] . '</h1>';
 			echo '<p>' . $row['introduction'] . '</p>';
 			echo '<p>' . $row['fulltext'] . '</p>';		
 			} ?>
			
		</div>

		<div id="eventsentered">
			<h1> Events I'm in </h1>
			<?php foreach( $resultEntered as $row) {
    		echo '<h2>' . $row['title'] . '</h1>';
 			echo '<p>' . $row['introduction'] . '</p>';
 			echo '<p>' . $row['fulltext'] . '</p>';		
 			} ?>
		</div>

		<div id="currentinvites">
			<h1> My current invites </h1>
			<?php foreach( $resultInvites as $row) {
    		echo '<h2>' . $row['title'] . '</h1>';
 			echo '<p>' . $row['introduction'] . '</p>';
 			echo '<p>' . $row['fulltext'] . '</p>';		
 			} ?>
		</div>

	</body>

</html>