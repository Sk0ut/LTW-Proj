/**
 * Function called when the document is ready
 */
function onReady() {
    $('#form').submit(onFormSubmit);
    $('input#typeLogin').click(onTypeChange);
    $('input#typeRegister').click(onTypeChange);
    onTypeChange();
}

/**
 * Display a error message because the login
 * @param message message to be displayed
 */
function displayError(message) {
    $('#formDiv').after('<span class="errorMessage">' + message + '</span>');
    $('span.errorMessage').fadeOut(5 * 1000, function() { $(this).remove(); });
}

/**
 * Display a success message because the login
 * @param message message to be displayed
 */
function displaySuccess(message) {
    $('#formDiv').after('<span class="successfulMessage">' + message + '</span>');
    $('span.successfulMessage').fadeOut(5 * 1000, function() { $(this).remove(); });
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
                        displayError("Invalid username or password!");
                        break;
                    case 'success':
                        displaySuccess("Login successfull!");
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
    var remember = $('input#remember').is(':checked');

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
                        displayError("Failed to register the account!");
                        break;
                    case 'taken_user':
                        displayError("Username already taken!");
                        break;
                    case 'invalid_username':
                        displayError("Username does not meet the requirements!");
                        break;
                    case 'invalid_password':
                        displayError("Password does not meet the requirements!");
                        break;
                    case 'invalid_email':
                        displayError("Please use a valid email!");
                        break;
                    case 'success':
                        displaySuccess("Register was successfull!");
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
    if(!$('input#typeLogin').exists())
        return;

    var typeLogin = $('input#typeLogin').is(':checked');
    var typeRegister = $('input#typeRegister').is(':checked');
    if(typeLogin) {
        $('input#submit').val('Login');
        $('input#email').prev().hide();
        $('input#email').hide();
        $('input#email').next().hide();
    } else if(typeRegister) {
        $('input#submit').val('Register');
        $('input#email').prev().show();
        $('input#email').show();
        $('input#email').next().show();
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
