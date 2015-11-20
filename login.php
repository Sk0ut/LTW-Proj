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
    <!-- Register / Login Form -->
    <div id="login_form">
        <!-- Login Form -->
        <form id="login" method="POST" action="action_login.php">
            <label for="username">Username:</label>
            <input type="text" id="username" /> <br>

            <label for="password">Password:</label>
            <input type="password" id="password" /> <br>

            <input type="checkbox" id="remember" />
            <label for"checkbox">Remember Me.</label> <br>

            <label for="login_existing">Login in my account!</label>
            <input type="radio" id="login_existing" checked="checked" value="login" name="logreg"/> <br>

            <label for="new_account">Register new account!</label>
            <input type="radio" id="new_account" value="register" name="logreg"/> <br>

            <input type="submit" value="Submit" />
        </form>

        <!-- Register Form -->
        <form id="register" method="POST" action="action_register.php">
            <label for="username">Username:</label>
            <input type="text" id="username" /> <br>

            <label for="email">Email:</label>
            <input type="email" id="email" /> <br>

            <label for="password">Password:</label>
            <input type="password" id="password" /> <br>

            <label for="login_existing">Login in my account!</label>
            <input type="radio" id="login_existing" value="login" name="logreg"/> <br>

            <label for="new_account">Register new account!</label>
            <input type="radio" id="new_account" checked="checked" value="register" name="logreg"/> <br>

            <input type="submit" value="Submit" />
        </form>
    </div>

    <!-- Scripts -->
    <script src="js/scripts.js"></script>
</body>
</html>

<?php

// Includes

?>
