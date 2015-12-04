<?php
  define('DS', DIRECTORY_SEPARATOR);
  define('ROOT', dirname(dirname(__FILE__)));
?>

<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html">
    <title><?= isset($PageTitle) ? $PageTitle : "Event Manager"?></title>
    <?php
      if (function_exists('customPageHeader')){
        customPageHeader();
      }
    ?>
  </head>
  <body>
