/**
 * Function called when the document is ready
 */
function docReady() {
    $('#form').submit(formSubmit);
    $('input#typeLogin').click(updateLoginRegister);
    $('input#typeRegister').click(updateLoginRegister);
}

/**
 * Called when user click on submit button
 * Will use AJAX to login and show an error message
 * if login was not successfull.
 * @param event submit event
 */
function formSubmit(event) {
    event.preventDefault();

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
                } else {
                    displayError("Login successfull!");
                }
            })
            .fail(function(error) {
                displayError("Error while processing the login...");
            });
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
        $('input#username').next().after('<label for="email">Email:</label>' +
                '<input type="text" id="email"/><br>');
    }
}

/**
 * Return if a given element exists or not
 */
jQuery.fn.exists = function(){ return this.length>0; }

/**
 * Call function when document is ready
 */
$(document).ready(docReady);
