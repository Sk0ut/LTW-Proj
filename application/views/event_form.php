<div class="container h-align">
    <!-- Description of the event -->
    <div id="eventDescription">
        <div id="header">
            <?php if($event->getPrivate() == 0) { ?>
                    <h1 class="title"><i class="fa fa-unlock"></i>  <?php echo $event->getName(); ?></h2>
            <?php } else { ?>
                    <h1 class="title"><i class="fa fa-lock"></i>  <?php echo $event->getName(); ?></h2>
            <?php } ?>
            <!-- Status of the user (invited, is going or not) -->
            <div id="status">
            <?php
                if(!$isFinished) {
                        if(!$isOwner) {
                            if($isRegistered) { ?>
                                <i id="regStatus"class="fa fa-check"> Registered</i>
                        <?php } else { ?>
                                <i id="regStatus"class="fa fa-ban"> Unregistered</i>
                <?php       }
                        } else { ?>
                                <i id="editEvent"class="fa fa-pencil"> Edit</i>
                <?php
                        }
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

    <!-- Members -->
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

    <!-- Threads -->
    <div id="threadsComments">
        <h1 class="title">Forum</h1>

        <div id="thread-create-div">
            <h1 class="subTitle">Create Thread</h1>
            <form id="thread-create">
                <div class="input-box">
                    <input type="text" id="titleThread" class="input-text" autocomplete="off" placeholder="Title"/>
                </div>
                <div class="input-box">
                    <textarea type="text" id="description" class="input-text" autocomplete="off" placeholder="Description"></textarea>
                </div>
                <input id="createThread" type="submit" class="fa submit-button" value="&#xf0a9;" title="Create Thread" />
            </form>
        </div>

        <?php
        foreach($forum as $row){ ?>
        <div class="thread">
            <h2 class="thread-title"><?php echo $row->getTitle(); ?> </h2>
            <h3 class="thread-description"><?php echo $row->getDescription(); ?></h3>
            <h4 class="thread-author"><?php echo $row->getUser()->getUsername(); ?></h4>
                <?php
                $comments = $row->getComments();
                foreach($comments as $comment){ ?>
                <div class="thread-comment">
                    <div class="comment-who">
                    <p class="comment-author"><?php echo $comment->getUser()->getUsername(); ?></p>
                    <p class="comment-date"><?php echo $comment->getCommentDate(); ?></p>
                    </div>
                    <p class="comment-text"><?php echo $comment->getComment(); ?></p>
                </div>
                <?php
                }
                ?>
                <form class="commentForm" id="insertComment<?php echo $row->getId(); ?>">
                    <div class="input-box">
                        <textarea class="input-text" placeholder="Write new comment"></textarea>
                    </div>
                    <input id="postComment" type="submit" class="fa submit-button" value="&#xf0a9;" title="Comment" />
                </form>
        </div>
        <?php
        }
        ?>
    </div>
</div>

<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/event.js" type="text/javascript"></script>
