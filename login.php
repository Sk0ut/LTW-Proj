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

    <link rel="stylesheet" href="css/styles.css">

    <!--[if lt IE 9]>
    <script src="http://html5shiv.googlecode.com/svn/trunk/html5.js"></script>
    <![endif]-->
</head>

<body>
    <!-- Login Form -->
    <div id="formDiv">
        <form id="form">
            <label for="username">Username:</label>
            <input type="text" id="username" /> <br>

            <label for="email">Email:</label>
            <input type="text" id="email"/> <br>

            <label for="password">Password:</label>
            <input type="password" id="password" /> <br>

            <input type="checkbox" id="remember" />
            <label for="checkbox">Remember Me</label> <br>

            <label for="typeLogin">Login in my account!</label>
            <input type="radio" id="typeLogin" checked="checked" value="login" name="type"/> <br>

            <label for="typeRegister">Register new account!</label>
            <input type="radio" id="typeRegister" value="register" name="type"/> <br>

            <input type="submit" id="submit" />
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
