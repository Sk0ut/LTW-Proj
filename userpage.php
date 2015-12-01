<?php
	require_once("config" . DIRECTORY_SEPARATOR . "config.php");
  	require_once("application/models/user.php");
  	require_once("public/header.php");

  	$user = User::find($_GET['id']);

  	$resultOwnEvents = $user->getOwnerEvents();
  	$resultEntered = $user->getRegisteredEvents();
?>
	<link rel="stylesheet" type="text/css" href="public/css/userpage.css" />
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

	<meta charset="UTF-8">
	</head>

	<body>
		<div id="ownevents" class="ownevents event margin">
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

 			<div id="button">
 				<input type="submit" id="createeventbtn" class="big btn" value="Create an event" />
 			</div>

 			<div id="createEvent">
	 			<fieldset>
	 			 	<strong> Create Event: </strong>
					<div class="nameDiv">
						<input type="text" id="name" class="inputText" placeholder="Event Name"/>	
					</div>

					<div class="descriptionDiv">
						<input type="text" id="description" class="inputText" placeholder="Description"/>	
					</div>

				<input type="text" id="datepicker" class="inputText" placeholder="Date"/>

				<div class="typeDiv">
					<input type="text" id="type" class="inputText" placeholder="Event Type" />	
				</div>

				<div class="privateDiv">
					<input type="checkbox" name="private" class="checkbox"> Private Event
				</div>

				<form action="eventcreated.php" class="inline">
	 				<input type="submit" class="small btn" value="Create Event" />
	 			</form>

			</fieldset>
		</div>
			
	</div>

	<div id="eventsentered" class="eventsentered event margin">
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

			<div id="button">
			<input type="submit" class="big btn" value="Find Events" />
			</div>
	</div>

	<div id="currentinvites" class="currentinvites event">
		<h1> My current invites </h1>
		<p> You currently have no invites! </p>
	</div>

	<?php
	require_once("public/footer.php");
	?>

<!-- Scripts -->
<script src="public/js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="public/js/userpage.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>