<?php
// Check parameters
$params = ['username', 'password', 'remember'];
foreach ($params as $param) {
    // Create variables
    if(isset($_POST[$param])) {
        $params[$param] = $_POST[$param];
        continue;
    }

    // Error message
    $data = [ "login" => "fail" ];
    header('Content-Type: application/json');
    echo json_encode($data);
    return;
}

// Validate login
$validLogin = validLogin($params['username'], $params['password']);
if(!validLogin) {
    $data = [ "login" => "fail" ];
    header('Content-Type: application/json');
    echo json_encode($data);
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
$data = [ "login" => "success" ];
header('Content-Type: application/json');
echo json_encode($data);
?>
