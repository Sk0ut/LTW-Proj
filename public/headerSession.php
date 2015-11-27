<?php
  require_once ('../config/config.php');

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
