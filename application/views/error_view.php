<?php
$PageTitle = "404 Page Not Found";
function customPageHeader() { ?>
    <meta name="description" content="404 page was not found">
    <meta name="author" content="LTW - MIEIC">

    <!--[if lt IE 9]>
      <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
<?php
}

require_once('shared/header.php');
?>

<p>Page was not found in the server... ;(</p>

<?php
require_once('shared/footer.php');
?>
