<div class="container h-align">
    <div id="event_header">
        <?php if($event->getPrivate() == 0) { ?>
                <h1 class="title"><i class="fa fa-unlock"></i>  <?php echo $event->getName(); ?></h2>
        <?php } else { ?>
                <h1 class="title"><i class="fa fa-lock"></i>  <?php echo $event->getName(); ?></h2>
        <?php } ?>

        <h3 id="event_type">
            <?php echo $event->getType(); ?>
        </h3>
        <h3 class="event_date">
            <?php echo $event->getDate(); ?>
        </h3>
        <h4 id="event_owner">
            Created by: <?php echo $owner->getUsername(); ?>
        </h4>
        <img id="event_picture" src="<?php echo $imageUrl ?>">
        <p id="event_description">
            <?php echo $event->getDescription(); ?>
        </p>
    </div>
</div>
