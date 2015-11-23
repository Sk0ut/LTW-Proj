<?php
function printResponse($value) {
    $data = ["login" => $value];
    header('Content-Type: application/json');
    echo json_encode($data);
}

// Check parameters
$params = ['username', 'password', 'remember'];
foreach ($params as $param) {
    // Create variables
    if(isset($_POST[$param])) {
        $params[$param] = $_POST[$param];
        continue;
    }

    // Error message
    printResponse("fail");
    return;
}
printResponse("fail");
return;

// Validate login
$validLogin = validLogin($params['username'], $params['password']);
if(!validLogin) {
    printResponse("fail");
    return;
}

// Update session
$sessionId = generateSessionId();
updateSessionId($params['username'], $sessionId);
$_SESSION['username'] = $params['username'];
$_SESSION['sessionId'] = $sessionId;

// Cookies
$expireTimeCookie = 0;
if($remember)
    $expireTimeCookie = 2147483647;
else
    $expireTimeCookie = 30 * 60; // Expire in 30 seconds
setcookie('username', $params['username'], $expireTimeCookie);
setcookie('session', $sessionId, $expireTimeCookie);

// Response
printResponse("success");
?>
