<div class="navbar-fixed">
    <nav class="navbar-content">
        <header class="navbar-title"><a href="#">Event Manager</a></header>
        <ul class="navbar-items">
            <li class="navbar-item"><a href="#ownedEvents">Owned</a></li>
            <li class="navbar-item"><a href="#joinedEvents">Joined</a>
            <li class="navbar-item"><a href="#invites">Invites</a></li>
            <li class="navbar-item"><a href="#invites">Profile</a>
                <ul class="navbar-subitems">
                    <li class="navbar-subitem"><a href="#">Photo</a></li>
                    <li class="navbar-subitem"><a href="?url=login/validateLogout">Logout</a></li>
                </ul>
            </li>
        </ul>
    </nav>
</div>

<div class="container h-align">
    <div id="ownEvents" class="">
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

    <div id="joinedEvents" class="">
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

    <div id="invites" class="">
        <h1>My current invites</h1>
        <p>You currently have no invites!</p>
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/userpage.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
