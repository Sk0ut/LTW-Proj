/**
 * Function called when the document is ready
 */
function onReady() {
    $('#loginForm').submit(onFormSubmit);
    $('input#typeLogin').click(onTypeChange);
    $('input#typeRegister').click(onTypeChange);
    onTypeChange();
}

/**
 * Display a error message because the login
 * @param message message to be displayed
 */
function displayError(message) {
    var status = $("#status");
    status.show();
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
    status.show();
    status.text('');
    status.append('<div class="errorDiv">' + message + "</div>");
    status.append('<div id="close" class="closeButton">&#x274c;</div>');
    status.attr('class', 'notifySuccess');

    // Add listener
    $('div#close').click(closeMessage);
}

/**
 * Close the message displayed by the login
 */
function closeMessage() {
    $(this).parent().fadeOut(500);
}

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
                    case 'fail':
                        displayError("Invalid username or password");
                        break;
                    case 'success':
                        displaySuccess("Login successfull");
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

    // Check if password matches password confirmation
    if(password !== confirmPassword) {
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
                        displaySuccess("Register was successfull");
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
 * Called when a user changes from login to register or vice-versa
 * Will update the ID of the form and add / remove inputs.
 * @param event click event
 */
function onTypeChange(event) {
    var typeLogin = $('input#typeLogin').is(':checked');
    var typeRegister = $('input#typeRegister').is(':checked');
    if(typeLogin) {
        $('input#submit').val('Login');
        $('div#emailDiv').hide();
        $('div#confirmPasswordDiv').hide();
    } else if(typeRegister) {
        $('input#submit').val('Register');
        $('div#emailDiv').show();
        $('div#confirmPasswordDiv').show();
    }
}

/**
 * Return if a given element exists or not
 */
jQuery.fn.exists = function(){ return this.length > 0; }

/**
 * Call function when document is ready
 */
$(document).ready(onReady);
