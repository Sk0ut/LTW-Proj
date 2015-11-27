<?php
require_once '../inc/utilities.php';

/**
 * Print a response
 * @param value value of the login response
 */
function printResponse($value) {
    $data = ["login" => $value];
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
        $expireTimeCookie = time() + 30 * 60; // Expire in 30 minutes
    setcookie('username', $username, $expireTimeCookie, "/", false);
    setcookie('token', $token, $expireTimeCookie, "/", false);
}

// Need error responses
$missing_params = "missing_params";
$fail_login = "fail";
$success_login = "success";

// Check parameters
$params = ['username' => '', 'password' => '', 'remember' => ''];
if(!fillParameters($params)) {
    printResponse($missing_params);
    return false;
}

// Convert email to username
if(filter_var($params['username'], FILTER_VALIDATE_EMAIL)) {
    $user = getUserFromEmail($params['username']);
    if($user == NULL) {
        printResponse($fail_login);
        return;
    }
    $params['username'] = $user->getUsername();
}

// Validate login
if(!isValidLogin($params['username'], $params['password'])) {
    printResponse($fail_login);
    return;
}

// Update token
$token = regenToken($params['username']);
if(!$token) {
    printResponse($fail_login);
    return;
}
updateToken($params['username'], $token, $params['remember']);

printResponse($success_login);
?>
