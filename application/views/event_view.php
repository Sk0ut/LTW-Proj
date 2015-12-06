<?php

$event = $data['event'];
$owner = $data['owner'];
$forum = $data['forum'];
$isOwner = $data['isOwner'];
$registeredUsers = $data['registeredUsers'];
$isRegistered = $data['registered'];
$isFinished = $data['finished'];
$eventTypes = $data['eventTypes'];

$imageUrl = str_replace(' ', '%20', $event->getPhoto());
$imageUrl = "img/uploaded/" . $imageUrl;

$PageTitle = $event->getName();
function customPageHeader() { ?>
    <meta name="description" content="<?php echo 'Event page' ?>">
    <meta name="author" content="LTW - MIEIC">

    <link rel="stylesheet" type="text/css" href="css/eventmanager.css" />
    <link rel="stylesheet" type="text/css" href="css/event.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">
    <link rel="stylesheet" href="//cdnjs.cloudflare.com/ajax/libs/jquery-ui-timepicker-addon/1.4.5/jquery-ui-timepicker-addon.min.css">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

require_once('shared/header.php');
require_once('shared/navbar_event.php');
require_once('event_form.php');
require_once('shared/footer.php');
?>
