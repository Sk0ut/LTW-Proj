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
	 			<fieldset id="formFields">
	 			 	<strong> Create Event: </strong>
					<div class="nameDiv">
						<input type="text" id="name" class="inputText" placeholder="Event Name"/>	
					</div>

					<div class="descriptionDiv">
						<input type="text" id="description" class="inputText" placeholder="Description"/>	
					</div>

					<div class="datelocalDiv">
						Date:
						<select id="year" name="year" class="year">
						<?php for($i = 2015; $i<=2020; $i++) { ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
						<?php } ?>			
						</option>
						</select>

						<select id="month" name="month" class="month">
							<option value="1">January</option>
							<option value="2">February</option>
							<option value="3">March</option>
							<option value="4">April</option>
							<option value="5">May</option>
							<option value="6">June</option>
							<option value="7">July</option>
							<option value="8">August</option>
							<option value="9">September</option>
							<option value="10">October</option>
							<option value="11">November</option>
							<option value="12">December</option>
						</select>

					<select id="day" name="day" class="day">
					<?php
						for($i = 1; $i <= 31; $i++) { ?>
						<option value="<?php echo $i ?>"><?php echo $i ?></option>
					<?php } ?>
					</select>
				</div>

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