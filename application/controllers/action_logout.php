<?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'application' . DS . 'controllers' . DS . 'action_utils.php';
require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

// Check if is logged in
$user = getCurrentUser();
if($user == NULL) {
    printResponse("logout", "not_logged");
    return;
}

// Delete token
deleteToken($user->getUsername());

printResponse("logout", "success");
?>
