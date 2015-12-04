/**
 * Setup the Javascript
 */
function onReady() {
    $("#datepicker").datepicker({
      yearRange: "2015:2060",
      dateFormat: "dd-mm-yy",
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });

    setupListeners();
}

/**
 * Setup the listeners of the userpage
 */
function setupListeners() {
    $("#createeventbtn").click(openCreateEvent);
    $('a[href^="#"]').click(scrollToTag);
    $('.navbar-item').mouseover(openDropdownMenu);
}

/**
 * Open the create event modal box
 * @param event event of the click
 */
function openCreateEvent(event) {
    $("#createEvent").fadeIn(300);

    $("#cancelButton").click(function() {
        $("#createEvent").fadeOut(200);
    });
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

    var centerX = tabPosition.left + tabMenu.width() / 2;
    var left = centerX - subMenu.width() / 2;

    subMenu.offset({ top: tabMenu.bottom, left: left });
}

/**
 * Scroll to a html tag
 * @param event event of the click
 */
function scrollToTag(event) {
    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: -40 + target.offset().top
        }, 500);
    }
}

/**
 * Called when document is fully loaded in the
 * client browser
 */
$(document).ready(onReady);
