<?php

// Includes

?>

<!DOCTYPE HTML>
<html lang="en">
<head>
    <meta charset="utf-8">

    <title>Event Manager</title>
    <meta name="description" content="Yet another event manager.">
    <meta name="author" content="LTW - MIEIC">

    <link rel="stylesheet" href="css/login.css">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Login Form -->
    <div id="formDiv" class="form">
        <form id="loginForm">
            <div class="formDiv">
                <label for="username">Username:</label>
                <input type="text" id="username" class="input" />
            </div>

            <div id="emailDiv" class="formDiv">
                <label for="email">Email:</label>
                <input type="text" id="email" class="input"/>
            </div>

            <div class="formDiv">
                <label for="password">Password:</label>
                <input type="password" id="password" class="input"/>
            </div>

            <div class="formDiv">
                <input type="checkbox" id="remember" />
                <label for="checkbox">Remember Me</label>
            </div>

            <div class="formDiv">
                <label for="typeLogin">Login in my account</label>
                <input type="radio" id="typeLogin" checked="checked" value="login" name="type"/>
            </div>

            <div class="formDiv">
                <label for="typeRegister">Register new account</label>
                <input type="radio" id="typeRegister" value="register" name="type"/>
            </div>

            <div class="formDiv">
                <input type="submit" id="submit" class="button" />
            </div>
        </form>

        <div id="status" class="" style="display:none"></div>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
</body>
</html>

<?php

// Includes

?>
