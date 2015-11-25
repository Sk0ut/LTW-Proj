<?php
/**
 * Print a response
 * @param value value of the login response
 */
function printResponse($value) {
    $data = ["login" => $value];
    header('Content-Type: application/json');
    echo json_encode($data);
}

// Need error responses
$missing_params = "missing_params";
$fail_login = "fail";
$success_login = "success";

// Includes
if((require_once('../database/connection.php')) == -1) {
    printResponse($fail_login);
    return;
}
require_once('../database/users.php');


// Check parameters
$params = ['username', 'password', 'remember'];
foreach ($params as $param) {
    // Create variables
    if(isset($_POST[$param])) {
        $params[$param] = $_POST[$param];
        continue;
    }

    // Error message
    printResponse($missing_params);
    return;
}

// Validate login
if(!isValidLogin($params['username'], $params['password'])) {
    printResponse($fail_login);
    return;
}

// Update session
$token = generateToken(256);
if(!updateToken($params['username'], $token)) {
    printResponse($fail_login);
    return;
}
$_SESSION['username'] = $params['username'];
$_SESSION['token'] = $token;

// Cookies
$expireTimeCookie = 0;
if($params['remember'])
    $expireTimeCookie = 2147483647;
else
    $expireTimeCookie = 30 * 60; // Expire in 30 minutes
setcookie('username', $params['username'], $expireTimeCookie);
setcookie('token', $token, $expireTimeCookie);

// Response
printResponse($success_login);
?>
