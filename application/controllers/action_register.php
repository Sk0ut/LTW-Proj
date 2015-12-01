<?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'application' . DS . 'controllers' . DS . 'action_utils.php';
require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

// Need error responses
$key = "register";
$missing_params = "missing_params";
$taken_user = "taken_user";
$taken_email = "taken_email";
$invalid_username = "invalid_username";
$invalid_email = "invalid_email";
$invalid_password = "invalid_password";
$fail_register = "fail";
$success_register = "success";

// Check parameters
$params = ['username' => '', 'email' => '', 'password' => '', 'remember' => ''];
if(!fillParameters($params)) {
    printResponse($key, $missing_params);
    return false;
}

// Validate parameters
if(strlen($params['username']) < 4 || strlen($params['username']) > 15) {
    printResponse($key, $invalid_username);
    return;
}
if(usernameExists($params['username'])) {
    printResponse($key, $taken_user);
    return;
}
if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
    printResponse($key, $invalid_email);
    return;
}
if(emailExists($params['email'])) {
    printResponse($key, $taken_email);
    return;
}
if(strlen($params['password']) < 4) {
    printResponse($key, $invalid_password);
    return;
}

// Create register
$params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);
if(!createNewUser($params['username'], $params['password'], $params['email'])) {
    printResponse($key, $fail_register);
    return;
}

// Update token
$token = regenToken($params['username'], $params['remember']);
if(!$token) {
    printResponse($key, $fail_register);
    return;
}

printResponse($key, $success_register);
?>
