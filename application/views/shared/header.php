<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="utf-8">
    <meta http-equiv="content-type" content="text/html">
    <title><?= isset($PageTitle) ? $PageTitle : "EventManager"?></title>
    <?php
      if (function_exists('customPageHeader')){
        customPageHeader();
      }
    ?>
  </head>
  <body>
