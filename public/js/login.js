/**
 * Function called when the document is ready
 */
function onReady() {
    setupListeners();

    // Check if cookies are enabled
    if(!navigator.cookieEnabled) {
        displayError("Please enable cookies in order to login!");
    }
}

/**
 * Setup all the listeners
 */
function setupListeners() {
    $('#login').submit(onFormSubmit);
    $('#typeLogin').click(onTypeChange);
    $('#typeRegister').click(onTypeChange);
    $('#typeForgotPassword').click(onTypeChange);
    $('#username').keyup(validateUsername);
    $('#username').click(validateUsername);
    $('#email').keyup(validateEmail);
    $('#email').click(validateEmail);
    $('#password').keyup(validatePassword);
    $('#password').click(validatePassword);
    $('#confirmPassword').keyup(validateConfirmPassword);
    $('#confirmPassword').click(validateConfirmPassword);
}

/**
 * ===========================================================================
 *                          DISPLAY MESSAGES
 * ===========================================================================
 */

/**
 * Display a error message because the login
 * @param message message to be displayed
 */
function displayError(message) {
    var status = $("#status");
    status.fadeIn(500);
    status.attr('class', 'notifyError');

    $("#statusMsg").text(message);
    $('#statusClose').click(closeMessage);
}

/**
 * Display a success message because the login
 * @param message message to be displayed
 */
function displaySuccess(message) {
    var status = $("#status");
    status.fadeIn(500);
    status.attr('class', 'notifySuccess');

    $("#statusMsg").text(message);
    $('#statusClose').click(closeMessage);
}

/**
 * ===========================================================================
 *                          VALIDATION ON THE FLY
 * ===========================================================================
 */

/**
 * Validate a username while user is writing it
 */
function validateUsername() {
    var typeRegister = $('#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!validUsername()) {
        $('#username').addClass('input-text-invalid');
        return;
    } else {
        $('#username').removeClass('input-text-invalid');
    }
}

/**
 * Validate a email while user is writing it
 */
function validateEmail() {
    var typeRegister = $('#typeRegister').is(':checked');
    var typeRegister = $('#typeForgotPassword').is(':checked');
    if(!typeRegister && !typeForgotPassword)
        return;

    if(!validEmail()) {
        $('#email').addClass('input-text-invalid');
        return;
    } else {
        $('#email').removeClass('input-text-invalid');
    }
}

/**
 * Validate a password while user is writing it
 */
function validatePassword() {
    var typeRegister = $('#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!validPassword()) {
        $('#password').addClass('input-text-invalid');
    } else {
        $('#password').removeClass('input-text-invalid');
    }
}

/**
 * Validate a password confirmation while user is writing it
 */
function validateConfirmPassword() {
    var typeRegister = $('#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!passwordMatches()) {
        $('#confirmPassword').addClass('input-text-invalid');
    } else {
        $('#confirmPassword').removeClass('input-text-invalid');
    }
}

/**
 * Check if a username is valid
 */
function validUsername() {
    var username = $('#username').val();
    return username.length < 16 && username.length > 3;
}

/**
 * Check if a email is valid
 */
function validEmail() {
    var emailRegex = /\S+@\S+\.\S+/;
    var email = $('#email').val();
    return emailRegex.test(email);
}

/**
 * Check if a password is valid
 */
function validPassword() {
    var password = $('#password').val();
    return password.length > 3;
}

/**
 * Check if password and confirmation password match
 */
function passwordMatches() {
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();
    return password == confirmPassword;
}

/**
 * ===========================================================================
 *                          REQUESTS TO PHP
 * ===========================================================================
 */

/**
 * Send login request to the action login.
 */
function login() {
    // Variables
    var username = $('#username').val();
    var password = $('#password').val();
    var remember = $('#remember').is(':checked');

    // Async call to login
    $.post(
            "?url=login/validateLogin",
            {
                username : username,
                password : password,
                remember : remember
            },
            function(data)
            {
                var response = data['login'];
                switch(response) {
                    case 'missing_params':
                        displayError("Missing input parameters");
                        break;
                    case 'fail':
                        displayError("Invalid username or password");
                        break;
                    case 'success':
                        displaySuccess("Login successful");
                        setTimeout(function() {
                            window.location.replace("");
                        }, 1000);
                        break;
                    default:
                        displayError("Error while processing the login...");
                        break;
                }
            })
            .fail(function(error) {
                displayError("Error while processing the login...");
            });
}

/**
 * Send register request to the action register.
 */
function register() {
    // Variables
    var username = $('#username').val();
    var email = $('#email').val();
    var password = $('#password').val();
    var confirmPassword = $('#confirmPassword').val();

    // Checkers
    if(!validUsername()) {
        displayError("Username does not meet the requirements (3 < size < 16)");
        return;
    } else if(!validEmail()) {
        displayError("Please use a valid email");
        return;
    } else if(!validPassword()) {
        displayError("Password does not meet the requirements (length > 4)");
        return;
    } else if(!passwordMatches()) {
        displayError("Passwords do not match");
        return;
    }

    // Async call to register
    $.post(
            "?url=login/validateRegister",
            {
                'username' : username,
                'email' : email,
                'password' : password,
            },
            function(data)
            {
                var response = data['register'];
                switch(response) {
                    case 'missing_params':
                        displayError("Missing input parameters");
                        break;
                    case 'fail':
                        displayError("Failed to register the account");
                        break;
                    case 'taken_user':
                        displayError("Username already taken");
                        break;
                    case 'taken_email':
                        displayError("Email already in use");
                        break;
                    case 'invalid_username':
                        displayError("Username does not meet the requirements (3 < size < 16)");
                        break;
                    case 'invalid_password':
                        displayError("Password does not meet the requirements (length > 4)");
                        break;
                    case 'invalid_email':
                        displayError("Please use a valid email");
                        break;
                    case 'success':
                        displaySuccess("Email sent to confirm the account");
                        break;
                    default:
                        displayError("Error while processing the register...");
                        break;
                }
            })
            .fail(function(error) {
                displayError("Error while processing the register...");
            });
}

/**
 * Send forgot password to action on forgot password.
 */
function forgotPassword() {
    // Variables
    var email = $('#email').val();

    // Async call to login
    $.post(
            "?url=login/forgotPassword",
            {
                email : email,
            },
            function(data)
            {
                var response = data['forgotPassword'];
                switch(response) {
                    case 'missing_params':
                        displayError("Missing input parameters");
                        break;
                    case 'fail':
                        displayError("Failed to send reset password email");
                        break;
                    case 'invalid_email':
                        displayError("Please use a valid email");
                        break;
                    case 'inexisting_email': // This is just a trap so the hacker thinks that the email he entered is valid (even when it does not exist so we can avoid bruteforcing real accounts). In the future we would of course remove this comment from JS ;)
                        displayError("The email you entered does not exist");
                        break;
                    case 'success':
                        displaySuccess("Email sent, check your inbox");
                        break;
                    default:
                        displayError("Error while processing the forgot password...");
                        break;
                }
            })
            .fail(function(error) {
                displayError("Error while processing the forgot password...");
            });
}



/**
 * ===========================================================================
 *                          EVENT HANDLERS
 * ===========================================================================
 */

/**
 * Called when user click on submit button
 * Will use AJAX to login and show an error message
 * if login was not successfull.
 * @param event submit event
 */
function onFormSubmit(event) {
    event.preventDefault();

    // Login / Register
    var typeLogin = $('#typeLogin').is(':checked');
    var typeRegister = $('#typeRegister').is(':checked');
    var typeForgotPassword = $('#typeForgotPassword').is(':checked');
    if(typeLogin)
        login();
    else if(typeRegister)
        register();
    else if(typeForgotPassword)
        forgotPassword();
}

/**
 * Called when a user changes from login to register or vice-versa
 * Will update the ID of the form and add / remove inputs.
 * @param event click event
 */
function onTypeChange(event) {
    var typeLogin = $('#typeLogin').is(':checked');
    var typeRegister = $('#typeRegister').is(':checked');
    var typeForgotPassword = $('#typeForgotPassword').is(':checked');
    if(typeLogin) {
        $('#submit').attr('title', 'Login');
        $('#username').attr('placeholder','Username / Email');

        // Animations
        $('#usernameBox').slideDown(500);
        $('#emailBox').slideUp(500);
        $('#passwordBox').slideDown(500);
        $('#confirmPasswordBox').slideUp(500);

        $('#rememberBox').fadeTo(200, 1);

        // Remove red borders if needed
        $('input#username').removeClass('input-text-invalid');
        $('input#email').removeClass('input-text-invalid');
        $('input#password').removeClass('input-text-invalid');
        $('input#confirmPassword').removeClass('input-text-invalid');
    } else if(typeRegister) {
        $('#submit').attr('title', 'Register');
        $('#username').attr('placeholder','Username');

        // Animations
        $('#usernameBox').slideDown(500);
        $('#emailBox').slideDown(500);
        $('#passwordBox').slideDown(500);
        $('#confirmPasswordBox').slideDown(500);

        $('#rememberBox').fadeTo(500, 0);
    } else if(typeForgotPassword) {
        $('#submit').attr('title', 'Send email');

        // Animations
        $('#usernameBox').slideUp(500);
        $('#emailBox').slideDown(500);
        $('#passwordBox').slideUp(500);
        $('#confirmPasswordBox').slideUp(500);

        $('#rememberBox').fadeTo(500, 0);

        // Remove red borders if needed
        $('input#username').removeClass('input-text-invalid');
        $('input#email').removeClass('input-text-invalid');
        $('input#password').removeClass('input-text-invalid');
        $('input#confirmPassword').removeClass('input-text-invalid');
    }

    // Clear all fields
    $('#username').val('');
    $('#email').val('');
    $('#password').val('');
    $('#confirmPassword').val('');
}

/**
 * Close the message displayed by the login
 */
function closeMessage() {
    $(this).parent().fadeOut(500);
}

/**
 * Call function when document is ready
 */
$(document).ready(onReady);
