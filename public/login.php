<?php
  $PageTitle = "Event Manager Login";
  function customPageHeader() {
?>
    <meta name="description" content="Yet another event manager.">
    <meta name="author" content="LTW - MIEIC">

    <link rel="stylesheet" href="css/login.css">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
  }
  
  include_once("header.php");
  include_once("login_form.php");
  include_once("footer.php");
?>
