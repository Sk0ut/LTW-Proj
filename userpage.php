<?php
	require_once("config" . DIRECTORY_SEPARATOR . "config.php");
  	require_once("application/models/user.php");
  	require_once("public/header.php");

  	$user = User::find($_GET['id']);

  	$resultOwnEvents = $user->getOwnerEvents();
  	$resultEntered = $user->getRegisteredEvents();
?>
	<link rel="stylesheet" type="text/css" href="public/css/userpage.css" />
	<meta charset="UTF-8">
	</head>

	<body>
		<div id="ownevents" class="ownevents event">
			<h1> My events </h1> 
			<?php
			if(count($resultOwnEvents) == 0){
				echo '<p> You currently have no events created! </p>'; 
			}
			else { 
				foreach( $resultOwnEvents as $row) {
    			echo '<h2>' . $row['name'] . '</h2>';
 				echo '<p>' . $row['description'] . '</p>';	
 				} 
 			}?>

 			<form action="createevent.php" >
 				<input type="submit" class="btn" value="Create an event" />
 			</form>
			
		</div>

		<div id="eventsentered" class="eventsentered event">
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
 			<form action="createevent.php" >
 				<input type="submit" class="btn" value="Find Events" />
 			</form>
		</div>

		<div id="currentinvites" class="currentinvites event">
			<h1> My current invites </h1>
			<p> You currently have no invites! </p>
		</div>

		<footer> . </footer>

	<?php
	require_once("public/footer.php");
	?>