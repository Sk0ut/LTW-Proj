<!-- Login Form -->
<div class="h-align v-align">
    <form id="login">
        <header class="logo">Event Manager</header>

        <fieldset>
            <input type="text" id="username" class="input-box input-text" autocomplete="off" placeholder="Username"/>
            <input type="text" id="email" class="input-box input-text" autocomplete="off" placeholder="Email"/>
            <input type="password" id="password" class="input-box input-text" placeholder = "Password"/>
            <input type="password" id="confirmPassword" class="input-box input-text" placeholder="Confirm Password"/>

            <div class="label-input">
                <input type="checkbox" id="remember" placeholder="Remember me!" />
                <label for="remember">Remember me</label>
            </div>

            <div class="label-input">
                <input type="radio" id="typeLogin" checked="checked" name="type"/>
                <label for="typeLogin">Login in account</label>
            </div>
            <div class="label-input">
                <input type="radio" id="typeRegister" name="type"/>
                <label for="typeRegister">Register new account</label>
            </div>
            <input id="submit" type="submit" class="submit-button arrow-icon" value="" title="Login" />
        </fieldset>

    </form>

    <!-- Status of the form -->
    <div id="status" class="" style="display:none">
        <div id="statusMsg" class="notify-message h-align"></div>
        <div id="statusClose" class="close-notify">✖</div>
    </div>
</div>
<!-- Scripts -->
<script src="js/jquery-1.11.3.min.js" type="text/javascript"></script>
<script src="js/login.js" type="text/javascript"></script>
