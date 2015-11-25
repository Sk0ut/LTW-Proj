<?php
/**
 * Print a response
 * @param value value of the login response
 */
function printResponse($value) {
    $data = ["register" => $value];
    header('Content-Type: application/json');
    echo json_encode($data);
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
$params = ['username', 'email', 'password', 'remember'];
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

// Validate parameters
if(strlen($params['username']) < 4 || strlen($params['username']) > 15) {
    printResponse($invalid_username);
    return;
}
if(userExists($params['username'])) {
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

// Validate register
$registerSuccess = createRegister($params['username'], $params['password'], $params['email']);
if(!registerSuccess) {
    printResponse($fail_register);
    return;
}

// Update session
$sessionId = generateSessionId();
updateSessionId($params['username'], $sessionId);
$_SESSION['username'] = $params['username'];
$_SESSION['sessionId'] = $sessionId;

// Cookies
$expireTimeCookie = 0;
if($params['remember'])
    $expireTimeCookie = 2147483647;
else
    $expireTimeCookie = 30 * 60; // Expire in 30 minutes
setcookie('username', $params['username'], $expireTimeCookie);
setcookie('session', $sessionId, $expireTimeCookie);

// Response
printResponse($success_register);
?>
