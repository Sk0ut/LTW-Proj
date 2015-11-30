<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once(ROOT . DS . 'public' . DS . 'headerSession.php');

// Display user or login page
if($user == NULL) {
    $PageTitle = "Event Manager Login";
    function customPageHeader() { ?>
        <meta name="description" content="Yet another event manager.">
        <meta name="author" content="LTW - MIEIC">

        <link rel="stylesheet" href="css/login.css">

        <!--[if lt IE 9]>
          <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
        <![endif]-->
<?php
    }

    require_once(ROOT . DS . 'public' . DS . 'header.php');
    require_once(ROOT . DS . 'public' . DS . 'login_form.php');
    require_once(ROOT . DS . 'public' . DS . 'footer.php');
} else {
    echo "You are logged in.";
}
?>
