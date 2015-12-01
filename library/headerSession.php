<?php
require_once __DIR__ . "/database/users.php";

// Get current user and validate session
$user = getCurrentUser();
if($user == NULL || !isValidToken($user->getUsername(), $user->getToken()))
    $user = NULL;
else {
    // Regenerate token
    $remember = "false";
    if(isset($_COOKIE['em_remember']) && $_COOKIE['em_remember'] == "true")
            $remember = "true";
    $token = regenToken($user->getUsername(), $remember);
    $user->setToken($token);
}
?>
