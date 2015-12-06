<?php
$user = $data['user'];
$ownedEvents = $data['ownedEvents'];
$userEvents = $data['userEvents'];

$PageTitle = "Event Manager";
function customPageHeader() { ?>
    <meta name="description" content="Yet another event manager.">
    <meta name="author" content="LTW - MIEIC">

    <link rel="stylesheet" type="text/css" href="css/eventmanager.css" />
    <link rel="stylesheet" type="text/css" href="css/userpage.css" />
    <link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/font-awesome/4.5.0/css/font-awesome.min.css">
    <link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

require_once('shared/header.php');
require_once('shared/navbar_user.php');
require_once('userpage_form.php');
require_once('shared/footer.php');
?>
