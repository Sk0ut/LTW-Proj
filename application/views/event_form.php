<div class="container h-align">
    <!-- Description of the event -->
    <div id="description">
        <div id="header">
            <?php if($event->getPrivate() == 0) { ?>
                    <h1 class="title"><i class="fa fa-unlock"></i>  <?php echo $event->getName(); ?></h2>
            <?php } else { ?>
                    <h1 class="title"><i class="fa fa-lock"></i>  <?php echo $event->getName(); ?></h2>
            <?php } ?>
            <!-- Status of the user (invited, is going or not) -->
            <div id="status">
                <i class="fa fa-check"> Registered</i>
                <i class="fa fa-ban"> Unregistered</i>
            </div>
        </div>

        <img id="eventImage" src="<?php echo $imageUrl ?>">
        <div class="description">
            <h3 id="event_type">
                <i class="fa fa-hashtag"></i>
                <?php echo $event->getType(); ?>
            </h3>
            <h3 class="event_date">
                <i class="fa fa-calendar-check-o"></i>
                <?php echo $event->getDate(); ?>
            </h3>
            <h4 id="event_owner">
                <i class="fa fa-user"></i>
                Created by: <?php echo $owner->getUsername(); ?>
            </h4>
            <p id="event_description">
                <i class="fa fa-bars"></i>
                <?php echo $event->getDescription(); ?>
            </p>
        </div>
    </div>

    <div id="members">
        <h1 class="title">Members</h1>
    </div>

    <div id="threadsComments">
        <?php
            foreach($forum as $row){
                echo '<h2> $row->getTitle() </h2>';
                echo '<h3> $row->getDescription</h3>';
                foreach($comments as $comment){
                    echo '<p> $comment->getComment()</p>';
                }
            }
        ?>
    </div>
</div>

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/event.js" type="text/javascript"></script>
