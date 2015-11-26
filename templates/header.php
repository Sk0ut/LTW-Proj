<?php

require_once 'inc/utilities.php';

$user = getCurrentUser();
if($user == NULL) echo "NO USER";
else {
    if(isValidToken($user->getUsername(), $user->getToken()))
        echo "VALID TOKEN";
    else
        echo "INVALID TOKEN";
}

?>
