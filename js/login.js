/**
 * Function called when the document is ready
 */
function onReady() {
    setupListeners();
    onTypeChange();
    loadImages();
}

/**
 * Setup all the listeners
 */
function setupListeners() {
    $('#loginForm').submit(onFormSubmit);
    $('input#typeLogin').click(onTypeChange);
    $('input#typeRegister').click(onTypeChange);
    $('input#username').keyup(validateUsername);
    $('input#username').click(validateUsername);
    $('input#email').keyup(validateEmail);
    $('input#email').click(validateEmail);
    $('input#password').keyup(validatePassword);
    $('input#password').click(validatePassword);
    $('input#confirmPassword').keyup(validateConfirmPassword);
    $('input#confirmPassword').click(validateConfirmPassword);
}

/**
 * Load all the images of the website
 */
function loadImages() {
    $('.form').css('background', 'url(assets/bluePaperPattern.png)');
    $('body').css('background-image', 'url(assets/meeting.jpg)');
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
    status.fadeIn(200);
    status.text('');
    status.append('<div class="errorDiv">' + message + "</div>");
    status.append('<div id="close" class="closeButton">&#x274c;</div>');
    status.attr('class', 'notifyError');

    // Add listener
    $('div#close').click(closeMessage);
}

/**
 * Display a success message because the login
 * @param message message to be displayed
 */
function displaySuccess(message) {
    var status = $("#status");
    status.fadeIn(200);
    status.text('');
    status.append('<div class="errorDiv">' + message + "</div>");
    status.append('<div id="close" class="closeButton">&#x274c;</div>');
    status.attr('class', 'notifySuccess');

    // Add listener
    $('div#close').click(closeMessage);
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
    var typeRegister = $('input#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!validUsername()) {
        $('input#username').addClass('inputText-Invalid');
        return;
    } else {
        $('input#username').removeClass('inputText-Invalid');
    }
}

/**
 * Validate a email while user is writing it
 */
function validateEmail() {
    var typeRegister = $('input#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!validEmail()) {
        $('input#email').addClass('inputText-Invalid');
        return;
    } else {
        $('input#email').removeClass('inputText-Invalid');
    }
}

/**
 * Validate a password while user is writing it
 */
function validatePassword() {
    var typeRegister = $('input#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!validPassword()) {
        $('input#password').addClass('inputText-Invalid');
    } else {
        $('input#password').removeClass('inputText-Invalid');
    }
}

/**
 * Validate a password confirmation while user is writing it
 */
function validateConfirmPassword() {
    var typeRegister = $('input#typeRegister').is(':checked');
    if(!typeRegister)
        return;

    if(!passwordMatches()) {
        $('input#confirmPassword').addClass('inputText-Invalid');
    } else {
        $('input#confirmPassword').removeClass('inputText-Invalid');
    }
}

/**
 * Check if a username is valid
 */
function validUsername() {
    var username = $('input#username').val();
    return username.length < 16 && username.length > 3;
}

/**
 * Check if a email is valid
 */
function validEmail() {
    var emailRegex = /\S+@\S+\.\S+/;
    var email = $('input#email').val();
    return emailRegex.test(email);
}

/**
 * Check if a password is valid
 */
function validPassword() {
    var password = $('input#password').val();
    return password.length > 3;
}

/**
 * Check if password and confirmation password match
 */
function passwordMatches() {
    var password = $('input#password').val();
    var confirmPassword = $('input#confirmPassword').val();
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
    var username = $('input#username').val();
    var password = $('input#password').val();
    var remember = $('input#remember').is(':checked');

    // Async call to login
    $.post(
            'actions/action_login.php',
            {
                'username' : username,
                'password' : password,
                'remember' : remember
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
    var username = $('input#username').val();
    var email = $('input#email').val();
    var password = $('input#password').val();
    var confirmPassword = $('input#confirmPassword').val();
    var remember = $('input#remember').is(':checked');

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
            'actions/action_register.php',
            {
                'username' : username,
                'email' : email,
                'password' : password,
                'remember' : remember
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
                        displaySuccess("Register was successful");
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
    var typeLogin = $('input#typeLogin').is(':checked');
    var typeRegister = $('input#typeRegister').is(':checked');
    if(typeLogin)
        login();
    else if(typeRegister)
        register();
}

/**
 * Called when a user changes from login to register or vice-versa
 * Will update the ID of the form and add / remove inputs.
 * @param event click event
 */
function onTypeChange(event) {
    var typeLogin = $('input#typeLogin').is(':checked');
    var typeRegister = $('input#typeRegister').is(':checked');
    if(typeLogin) {
        $('input#submit').val('Login');
        $('input#username').prev().text('Username / Email:');
        $('div#emailDiv').hide();
        $('div#confirmPasswordDiv').hide();

        // Remove red borders if needed
        $('input#username').removeClass('inputText-Invalid');
        $('input#password').removeClass('inputText-Invalid');
    } else if(typeRegister) {
        $('input#submit').val('Register');
        $('input#username').prev().text('Username:');
        $('div#emailDiv').show();
        $('div#confirmPasswordDiv').show();
    }
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
