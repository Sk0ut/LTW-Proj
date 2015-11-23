/**
 * Function called when the document is ready
 */
function docReady() {
    $('#form').submit(formSubmit);
    $('input#typeLogin').click(updateLoginRegister);
    $('input#typeRegister').click(updateLoginRegister);
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
function formSubmit(event) {
    event.preventDefault();

    // Login / Register
    var typeLogin = $('input#typeLogin').is(':checked');
    if(typeLogin)
        login();
    else
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
                if(data['login'] == 'fail') {
                    displayError("Invalid username or password!");
                } else if(data['login'] == 'success') {
                    displaySuccess("Login successfull!");
                } else {
                    displayError("Error while processing the login...");
                }
            })
            .fail(function(error) {
                displayError("Error while processing the login...");
            });
}

/**
 * Send register request to the action login.
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
                if(data['register'] == 'taken_user') {
                    displayError("Username already taken!");
                } else if(data['register'] == 'invalid_username') {
                    displayError("Username does not meet the requirements!");
                } else if(data['register'] == 'invalid_password') {
                    displayError("Password does not meet the requirements!");
                } else if(data['register'] == 'success') {
                    displaySuccess("Register was successfull!");
                } else {
                    displayError("Error while processing the register...");
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
function updateLoginRegister(event) {
    if(!$('input#typeLogin').exists())
        return;

    var login = $('input#typeLogin').is(':checked');
    if(login) {
        if(!$('input#email').exists())
            return;
        $('input#email').next().remove(); // <br>
        $('input#email').prev().remove(); // <label>
        $('input#email').remove(); // <input>
    } else {
        $('input#username').next().after(
                '<label for="email">Email:</label>' +
                '<input type="text" id="email"/>' +
                '<br>');
    }
}

/**
 * Return if a given element exists or not
 */
jQuery.fn.exists = function(){ return this.length > 0; }

/**
 * Call function when document is ready
 */
$(document).ready(docReady);
