<?php
require_once '../inc/utilities.php';

/**
 * Print a response
 * @param value value of the login response
 */
function printResponse($value) {
    $data = ["register" => $value];
    header('Content-Type: application/json');
    echo json_encode($data);
}

/**
 * Fill the params needed to check and process login
 * @param params array with expected parameters name
 * @return true if successfull, false otherwise
 */
function fillParameters(&$params) {
    foreach ($params as $param => $value)
        if(isset($_POST[$param])) $params[$param] = $_POST[$param];
        else return false;
    return true;
}

/**
 * Update the token id of the username
 * @param username username to be updated
 * @param token new token value
 * @param remember true if cookie never expires, false otherwise
 */
function updateToken($username, $token, $remember) {
    $_SESSION['username'] = $username;
    $_SESSION['token'] = $token;

    // Cookies
    $expireTimeCookie = 0;
    if($remember == "true")
        $expireTimeCookie = 2147483647;
    else
        $expireTimeCookie = 30 * 60; // Expire in 30 minutes
    setcookie('username', $username, $expireTimeCookie);
    setcookie('token', $token, $expireTimeCookie);
}

// Need error responses
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
    printResponse($missing_params);
    return false;
}

// Validate parameters
if(strlen($params['username']) < 4 || strlen($params['username']) > 15) {
    printResponse($invalid_username);
    return;
}
if(usernameExists($params['username'])) {
    printResponse($taken_user);
    return;
}
if(!filter_var($params['email'], FILTER_VALIDATE_EMAIL)) {
    printResponse($invalid_email);
    return;
}
if(emailExists($params['email'])) {
    printResponse($taken_email);
    return;
}
if(strlen($params['password']) < 4) {
    printResponse($invalid_password);
    return;
}

// Create register
$params['password'] = password_hash($params['password'], PASSWORD_BCRYPT);
if(!createNewUser($params['username'], $params['password'], $params['email'])) {
    printResponse($fail_register);
    return;
}

// Update token
$token = regenToken($params['username']);
if(!$token) {
    printResponse($fail_register);
    return;
}
updateToken($params['username'], $token, $params['remember']);

printResponse($success_register);
?>
