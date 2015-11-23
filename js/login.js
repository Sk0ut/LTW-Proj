function docReady(jQuery) {
    $('#form').submit(formSubmit);
    $('input#typeLogin').click(updateLoginRegister);
    $('input#typeRegister').click(updateLoginRegister);
}

/**
 * Called when user click on submit button
 * Will use AJAX to login and show an error message
 * if login was not successfull
 */
function formSubmit(event) {
    event.preventDefault();

    var username = $('input#username').val();
    var password = $('input#password').val();
    var remember = $('input#remember').is(':checked');

    $("#message").text("Login successful");
}

/**
 * Called when a user changes from login to register or vice-versa
 * Will update the ID of the form and add / remove inputs.
 */
function updateLoginRegister(event) {
    var login = $('input#typeLogin').is(':checked');
    if(login) {
        $('input#email').prev().remove(); // <label>
        $('input#email').after().remove(); // <br>
        $('input#email').remove(); // <input>
    } else {
        $('input#username').next().after('<label for="email">Email:</label>' +
                '<input type="text" id="email"/><br>');
    }
}

$(document).ready(docReady);
