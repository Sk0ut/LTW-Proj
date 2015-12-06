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
                <?php if(!$isOwner) {
                        if($isRegistered) { ?>
                            <i id="regStatus"class="fa fa-check"> Registered</i>
                    <?php } else { ?>
                            <i id="regStatus"class="fa fa-ban"> Unregistered</i>
                <?php     }
                    }
                ?>
            </div>
        </div>

        <div class="eventImage" style="background-image: url(<?php echo $imageUrl; ?>)"></div>
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
                Hosted by: <?php echo $owner->getUsername(); ?>
            </h4>
            <p id="event_description">
                <i class="fa fa-bars"></i>
                <?php echo $event->getDescription(); ?>
            </p>
        </div>
    </div>

    <div id="members">
        <h1 class="title">Members</h1>
        <?php
        foreach($registeredUsers as $user) {
        ?>
            <div class="userCard" id="user<?php echo $user->getId(); ?>">
                <div class="userImage" style="background-image: url(img/uploaded/lock.png)"></div>
                <div class="userContent">
                    <h2 class="subTitle"><i class="fa fa-user"></i> <?php echo $user->getUsername(); ?></h2>
                </div>
            </div>
        <?php
        }
        ?>
    </div>

    <div id="threadsComments">
        <h1 class="title">Forum</h1>
        <div class="thread">
            <h2 class="thread-title">Bebidas que vão haver para a party</h2>
            <h3 class="thread-description">Bem pessoal, alguém tem que comprar as bebidas se não não vai haver party! Disponibilizem-se ai nos comentários.... BTW estava a pensar em algumas Vodkas e Gin :33</h3>
            <div class="thread-comment">
                <div class="comment-who">
                    <p class="comment-author">joao</p>
                    <p class="comment-date">2015-04-03 20:08</p>
                </div>
                <p class="comment-text">Eu quero comprar <3</p>
            </div>
            <form id="insertComment">
                <div class="input-box">
                    <textarea class="input-text" placeholder="Write new comment"></textarea>
                </div>
                <input id="submit" type="submit" class="fa submit-button" value="&#xf0a9;" title="Comment" />
            </form>
        </div>
        <?php
        foreach($forum as $row){ ?>
            <h2 class="thread-title"><?php echo $row->getTitle(); ?> </h2>
            <h3 class="thread-description"><?php echo $row->getDescription; ?></h3>
            <?php
            foreach($comments as $comment){ ?>
                <p class="thread-comment"> <?php echo $comment->getComment() ; ?></p>
            <?php
            }
        }
        ?>
    </div>
</div>

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/event.js" type="text/javascript"></script>
