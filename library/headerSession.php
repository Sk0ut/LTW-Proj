<?php
require_once __DIR__ . "/../application/models/userDAO.php";

// Get current user and validate session
$user = UserDAO::getCurrentUser();
if($user == NULL)
    $user = NULL;
else {
    // Regenerate token
    $remember = "false";
    if(isset($_COOKIE['em_remember']) && $_COOKIE['em_remember'] == "true")
            $remember = "true";
    UserDAO::regenToken($user->getUsername(), $remember);
}
?>
