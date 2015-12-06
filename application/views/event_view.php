<?php

$event = $data['event'];
$owner = $data['owner'];

$imageUrl = str_replace(' ', '%20', $event->getPhoto());
$imageUrl = "img/uploaded/" . $imageUrl;

$PageTitle = $event->getName();
function customPageHeader() { ?>
    <meta name="description" content="<?php echo 'Event page' ?>">
    <meta name="author" content="LTW - MIEIC">

    <link rel="stylesheet" type="text/css" href="css/eventmanager.css" />
    <link rel="stylesheet" type="text/css" href="css/event.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">

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
