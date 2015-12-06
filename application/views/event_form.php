<div class="container h-align">
    <?php if($event->getPrivate() == 0) { ?>
            <h1 class="title"><i class="fa fa-unlock"></i>  <?php echo $event->getName(); ?></h2>
    <?php } else { ?>
            <h1 class="title"><i class="fa fa-lock"></i>  <?php echo $event->getName(); ?></h2>
    <?php } ?>

    <img id="eventImage" src="<?php echo $imageUrl ?>">
    <div class="description">
        <h3 id="event_type">
            <i class="fa fa-calendar-check-o"></i>
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
            <?php echo $event->getDescription(); ?>
        </p>
    </div>
</div>
