/**
 * Setup the Javascript
 */
function onReady() {
    $("#datepicker").datetimepicker({
        yearRange: "2015:2060",
        dateFormat: "yy-mm-dd",
        timeFormat: "hh:mm",
        changeMonth: true,//this option for allowing user to select month
        changeYear: true, //this option for allowing user to select from year range
        addSliderAccess: true,
        sliderAccessArgs: { touchonly: false  }
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
    $('#createEventForm').submit(onFormSubmit);
}

/**
 * Open the create event modal box
 * @param event event of the click
 */
function openCreateEvent(event) {
    document.getElementById("createEventForm").reset();
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

    // var centerX = tabPosition.left + tabMenu.width() / 2;
    // var left = centerX - subMenu.width() / 2;
    var left = tabPosition.left + tabMenu.width() - subMenu.width();

    subMenu.offset({ top: tabPosition.bottom, left: left });
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
 * On submit the create event form
 */
function onFormSubmit(event) {
    event.preventDefault();
    $("#createEvent").fadeOut(200);

    var formData = new FormData(this);

    $.ajax({
        type:'POST',
        url: "?url=event/create",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            console.log("Success");
        },
        error: function(data){
            console.log("Error");
        }
    });
}

/**
 * On submit the find event form
 */
 function onSearchSubmit(event){
    var formData = new FormData(this);

    $.ajax({
        type:'GET',
        url: "?url=event/search",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
        },
        error: function(data){
        }
    });
 }

/**
 * Called when document is fully loaded in the
 * client browser
 */
$(document).ready(onReady);

