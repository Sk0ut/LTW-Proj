<?php
require_once dirname(__DIR__) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

$user = getCurrentUser();
if($user == NULL) {
    echo "NO USER";
} else {
    if(isValidToken($user->getUsername(), $user->getToken())) {
        echo "VALID TOKEN";
    } else {
        echo "INVALID TOKEN";
    }
}
?>
