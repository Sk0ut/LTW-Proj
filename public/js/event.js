/**
 * Setup the Javascript
 */
function onReady() {
    setupListeners();
}

/**
 * Setup the listeners of the userpage
 */
function setupListeners() {
    $('.navbar-item').mouseover(openDropdownMenu);
    $('#regStatus').click(changeRegisterStatus);
}

/**
 * Open a drop down menu centered
 * in its parent
 * @param event event of the mouse over
 */
function openDropdownMenu(event) {
    var tabMenu = $(this);
    if(!tabMenu.has("ul").length > 0)
        return;

    var subMenu = $(this).children("ul");
    var tabPosition = tabMenu.offset();

    var left = tabPosition.left + tabMenu.width() - subMenu.width();

    subMenu.offset({ top: tabPosition.bottom, left: left });
}

/**
 * Change the register status of the user
 * @event event click event
 */
function changeRegisterStatus(event) {
    var regStatus = $(this);
    if(regStatus.hasClass("fa-check")) {
        regStatus.removeClass();
        regStatus.addClass("fa");
        regStatus.addClass("fa-ban");
        regStatus.text(" Unregistered");
    } else {
        regStatus.removeClass();
        regStatus.addClass("fa");
        regStatus.addClass("fa-check");
        regStatus.text(" Registered");
    }
}

/**
 * Called when document is fully loaded in the
 * client browser
 */
$(document).ready(onReady);
