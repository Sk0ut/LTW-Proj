<?php
  $user = $data['user'];
	$ownedEvents = $data['ownedEvents'];
	$userEvents = $data['userEvents'];

$PageTitle = $user->getUsername() . "'s page";
function customPageHeader() { ?>
    <meta name="description" content="Yet another event manager.">
    <meta name="author" content="LTW - MIEIC">

	<link rel="stylesheet" type="text/css" href="css/userpage.css" />
  	<link rel="stylesheet" href="//code.jquery.com/ui/1.11.4/themes/smoothness/jquery-ui.css">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

require_once('shared/header.php');
require_once('userpage_form.php');
require_once('shared/footer.php');
?>