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
if((include_once('../database/connection.php')) == -1) {
    printResponse($fail_login);
    return;
}
include_once('../database/users.php');


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
if(!validLogin($params['username'], $params['password'])) {
    printResponse($fail_login);
    return;
}

// Update session
// $sessionId = generateSessionId();
// updateSessionId($params['username'], $sessionId);
// $_SESSION['username'] = $params['username'];
// $_SESSION['sessionId'] = $sessionId;
//
// // Cookies
// $expireTimeCookie = 0;
// if($params['remember'])
//     $expireTimeCookie = 2147483647;
// else
//     $expireTimeCookie = 30 * 60; // Expire in 30 minutes
// setcookie('username', $params['username'], $expireTimeCookie);
// setcookie('session', $sessionId, $expireTimeCookie);
//
// // Response
printResponse($success_login);
?>
