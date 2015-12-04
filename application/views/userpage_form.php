<!-- Content of the page -->
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

<!-- Create Event Modal -->
<div id="createEvent" class="modal">
    <div class="modal-form v-align h-align">
        <form id="createEventForm">
            <header class="logo">Create Event</header>
            <fieldset>
                <div class="input-box">
                    <input type="text" id="name" class="input-text" placeholder="Event Name"/>
                </div>

                <div class="input-box">
                    <input type="text" id="description" class="input-text" placeholder="Description"/>
                </div>

                <div class="input-box">
                    <input type="text" id="datepicker" class="input-text" placeholder="Date"/>
                </div>

                <div class="input-box">
                    <input type="text" id="type" class="input-text" placeholder="Event Type" />
                </div>

                <div class="label-input">
                    <input type="checkbox" id="private" name="private">
                    <label for="private">Private Event</label>
                </div>

                <div class="buttons-box">
                    <input id="createButton" type="submit" class="submit-button" value="Create" />
                    <input id="cancelButton" type="submit" class="submit-button" value="Cancel" />
                </div>
                </form>
            </fieldset>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/userpage.js" type="text/javascript"></script>
<script src="http://code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
