<div class="header-cont">
    <div id="userpageheader" class="header">
        <!--<h2> <?php echo $_GET['id'] . '\'s page' ?> </h2>-->
        <ul class="onepage-pagination">
            <li><a href="#ownevents"> My Events </a> </li>
            <li><a href="#eventsentered"> Events I'm in </a></li>
            <li><a href="#currentinvites"> My current Invites </a></li>
        </ul>
    </div>
</div>

<div id="ownevents" class="ownevents event margin">
    <h1> My events </h1>
    <?php
    if(count($ownedEvents) == 0){
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

	<form id="createEventForm">
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

            <div class="imageDiv">
            	<input type="file" name="image">
            	<input type="submit" value="Upload">
            </div>

            <input type="submit" class="small btn" value="Create Event">
  
        </fieldset>
    </form>
</div>

<div id="eventsentered" class="eventsentered event margin">
    <h1> Events I'm in </h1>
    <?php
    if(count($userEvents) == 0){
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

<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/userpage.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
