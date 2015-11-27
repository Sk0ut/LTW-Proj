<?php

//require_once 'templates/header.php';

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
	<meta charset="utf-8">
	<title> Create an event </title>
	<meta name="description" content="Yet another event manager.">
    <meta name="author" content="LTW - MIEIC">
</head>

<body>
	<fieldset class="fromFields">
		<div class="nameDiv">
			<label for="name">Event Name:</label>
			<input type="text" id="name" class="inputText" />	
		</div>

		<div class="descriptionDiv">
			<label for="description">Description:</label>
			<input type="text" id="description" class="inputText" />	
		</div>

		<div class="datelocalDiv">
			Date:
			<br>
			<label for="year"> Year: </label>
			<select id="year" name="year">
			<?php for($i = 2015; $i<=2020; $i++) { ?>
			<option value="<?php echo $i ?>"><?php echo $i ?></option>
			<?php } ?>			
			</option>
			</select>

			<label for="month"> Month: </label>
			<select id="month" name="month">
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

			<label for="day"> Day: </label>
			<select id="day" name="day">
			<?php
				for($i = 1; $i <= 31; $i++) { ?>
				<option value="<?php echo $i ?>"><?php echo $i ?></option>
				<?php } ?>
			</select>
		</div>

		<div class="typeDiv">
			<label for="type">Type:</label>
			<input type="text" id="type" class="inputText" />	
		</div>

		<div class="privateDiv">
			<input type="checkbox" name="vehicle" value="Bike">Private Event
		</div>

		<form action="eventcreated.php">
 				<input type="submit" value="Create Event" />
 			</form>

	</fieldset>
</body>
</html>