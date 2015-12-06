<!-- Content of the page -->
<div class="container h-align">
    <div id="ownEvents">
        <h1 class="title">My Events</h1>
        <div class="eventActionCard" id="createeventbtn">
            <div class="eventImage eventAction eventAdd"></div>
        </div>
        <?php foreach( $ownedEvents as $row) { ?>
            <div class="eventCard" id="event<?php echo $row->getId()?>">
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
        <?php } ?>
    </div>

    <div id="joinedEvents">
        <h1 class="title"> Events I'm in</h1>
        <div class="eventActionCard" id="searcheventbtn">
            <div class="eventImage eventAction eventSearch"></div>
        </div>
        <?php foreach( $userEvents as $row) { ?>
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
        <?php } ?>
    </div>

    <div id="invites">
        <h1 class="title">My current invites</h1>
        <p>You currently have no invites!</p>
    </div>
</div>

<!-- Create Event -->
<div id="createEvent" class="modal">
    <div class="modal-form v-align h-align">
        <form id="createEventForm">
            <header class="logo">Create Event</header>
            <fieldset>
                <div class="input-box">
                    <input type="text" name="name" id="name" class="input-text" autocomplete="off" placeholder="Name"/>
                </div>

                <div class="input-box">
                    <textarea name="description" rows="5" cols="25" id="description" class="input-text" autocomplete="off" placeholder="Description"></textarea>
                </div>

                <div class="input-box">
                    <input type="text" name="date" id="datepicker" class="input-text" autocomplete="off" placeholder="Date"/>
                </div>

                <div class="input-box">
					<select name="type" id="type" class="input-text" autocomplete="off" placeholder="Type">
						<?php foreach($eventTypes as $eventType) { ?>
							<option value="<?php echo $eventType['id']; ?>"><?php echo $eventType['type']; ?></option>
						<?php }?>
					</select>
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

<!-- Search Event -->
<div id="searchEvent" class="modal">
    <div class="modal-form v-align h-align">
        <div id="searchEventForm">
        <header class="logo">Search Event</header>
            <div class="input-box">
                <input type="text" name="name" id="event" class="input-text" autocomplete="off" placeholder="Event name"/>
            </div>
            <div id="results" class="results-box">
            </div>
            <div class="buttons-box">
                <input id="closeButton" type="button" class="submit-button" value="Close" />
            </div>
        </div>
    </div>
</div>

<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/userpage.js" type="text/javascript"></script>
<script src="//code.jquery.com/ui/1.11.3/jquery-ui.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.js"></script>
<script src="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-sliderAccess.js"></script>
