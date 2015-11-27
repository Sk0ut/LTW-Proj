<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

$user = getCurrentUser();
if($user == NULL || !isValidToken($user->getUsername(), $user->getToken()))
    $user = NULL;
?>
