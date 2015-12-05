<!-- Content of the page -->
<div class="container h-align">
    <div id="ownevents" class="">
        <h1 class="title">My Events</h1>
        <?php
        if(count($ownedEvents) == 0){ ?>
            <p>You currently have no events created!</p>
        <?php
        } else {
            foreach( $ownedEvents as $row) { ?>
                <div class="eventCard">
                    <div class="eventImage" style="background-image: url(img/uploaded/<?php echo str_replace(' ', '%20',$row->getPhoto()); ?>)">
                    </div>
                    <div class="eventContent">
                        <?php if($row->getPrivate() == 0) { ?>
                            <h2 class="subTitle"><i class="fa fa-unlock"></i>  <?php echo $row->getName(); ?></h2>
                        <?php } else { ?>
                            <h2 class="subTitle"><i class="fa fa-lock"></i>  <?php echo $row->getName(); ?></h2>
                        <?php } ?>
                        <p class="date"><i class="fa fa-calendar-check-o"></i>  <?php echo $row->getDate(); ?></p>
                        <p class="description"><i class="fa fa-bars"></i>  <?php echo $row->getDescription(); ?></p>
                    </div>
                </div>
        <?php
            }
        }?>
    </div>

    <div id="button">
        <input type="submit" id="createeventbtn" class="big btn" value="Create an event" />
    </div>

    <div id="joinedEvents" class="">
        <h1 class="title"> Events I'm in</h1>
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
        <h1 class="title">My current invites</h1>
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
                    <input type="text" name="name" id="name" class="input-text" placeholder="Name"/>
                </div>

                <div class="input-box">
                    <textarea name="description" rows="5" cols="25" id="description" class="input-text" placeholder="Description"></textarea>
                </div>

                <div class="input-box">
                    <input type="text" name="date" id="datepicker" class="input-text" placeholder="Date"/>
                </div>

                <div class="input-box">
                    <input type="text" name="type" id="type" class="input-text" placeholder="Type" />
                </div>

                <div class="input-box">
                    <input type="file" name="image" id="image" class="input-file" placeholder="Image">
                </div>

                <div class="label-input">
                    <input type="checkbox" id="private" name="private">
                    <label for="private">Private Event</label>
                </div>

                <div class="buttons-box">
                    <input id="createButton" type="submit" class="submit-button" value="Create" />
                    <input id="cancelButton" type="button" class="submit-button" value="Cancel" />
                </div>
                </form>
            </fieldset>
        </form>
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/userpage.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-sliderAccess.js"></script>
