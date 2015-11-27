<?php
require_once dirname(dirname(__DIR__)) . DIRECTORY_SEPARATOR . 'config' . DIRECTORY_SEPARATOR . 'config.php';

require_once ROOT . DS . 'application' . DS . 'controllers' . DS . 'action_utils.php';
require_once ROOT . DS . 'library' . DS . 'database' . DS . 'users.php';

// Need error responses
$key = "login";
$missing_params = "missing_params";
$fail_login = "fail";
$success_login = "success";

// Check parameters
$params = ['username' => '', 'password' => '', 'remember' => ''];
if(!fillParameters($params)) {
    printResponse($key, $missing_params);
    return false;
}

// Convert email to username
if(filter_var($params['username'], FILTER_VALIDATE_EMAIL)) {
    $user = getUserFromEmail($params['username']);
    if($user == NULL) {
        printResponse($key, $fail_login);
        return;
    }
    $params['username'] = $user->getUsername();
}

// Validate login
if(!isValidLogin($params['username'], $params['password'])) {
    printResponse($key, $fail_login);
    return;
}

// Update token
$token = regenToken($params['username']);
if(!$token) {
    printResponse($key, $fail_login);
    return;
}
updateToken($params['username'], $token, $params['remember']);

printResponse($key, $success_login);
?>
