<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

$user = getCurrentUser();
if($user == NULL || !isValidToken($user->getUsername(), $user->getToken()))
    $user = NULL;
else {
    $remember = "false";
    if(isset($_COOKIE['em_remember']) && $_COOKIE['em_remember'] == "true")
            $remember = "true";
    $token = regenToken($user->getUsername(), $remember);
    $user->setToken($token);
}
?>
