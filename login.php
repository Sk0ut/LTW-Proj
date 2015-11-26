<?php

require_once 'templates/header.php';

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
            <div class="logo">
                Event Manager
            </div>

            <fieldset class="formFields">
                <div class="inputDiv">
                    <label for="username">Username:</label>
                    <input type="text" id="username" class="inputText" />
                </div>

                <div id="emailDiv" class="inputDiv">
                    <label for="email">Email:</label>
                    <input type="text" id="email" class="inputText"/>
                </div>

                <div class="inputDiv">
                    <label for="password">Password:</label>
                    <input type="password" id="password" class="inputText"/>
                </div>

                <div id="confirmPasswordDiv" class="inputDiv">
                    <label for="confirmPassword">Confirm Password:</label>
                    <input type="password" id="confirmPassword" class="inputText"/>
                </div>

                <div class="inputDiv">
                    <input type="checkbox" id="remember" />
                    <label for="checkbox">Remember Me</label>
                </div>

                <div class="inputDiv">
                    <label for="typeLogin">Login in my account</label>
                    <input type="radio" id="typeLogin" checked="checked" value="login" name="type"/>
                </div>

                <div class="inputDiv">
                    <label for="typeRegister">Register new account</label>
                    <input type="radio" id="typeRegister" value="register" name="type"/>
                </div>
            </fieldset>

            <div>
                <input type="submit" id="submit" class="submitButton" />
            </div>

            <div id="status" class="" style="display:none"></div>
        </form>
    </div>

    <!-- Scripts -->
    <script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
    <script src="js/login.js" type="text/javascript"></script>
</body>
</html>

<?php

// Includes

?>
