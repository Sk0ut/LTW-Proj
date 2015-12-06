/**
 * Setup the Javascript
 */
function onReady() {
    $("#datepicker").datetimepicker({
        yearRange: "2015:2060",
        dateFormat: "yy-mm-dd",
        timeFormat: "HH:mm",
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
    $('a[href^="#"]').click(scrollToTag);
    $('.navbar-item').mouseover(openDropdownMenu);
    $('#createEventForm').submit(onFormSubmit);
    $('.eventCard').click(onEventClick);
    $("#createeventbtn").click(openCreateEvent);
    $("#configButton").click(openConfig);
    $("#searcheventbtn").click(openSearchEvent);
    $("#event").keyup(onSearchKeyPress);
}

/**
 *
 */
function openConfig() {
    document.getElementById("createEventForm").reset();
    $("#config").fadeIn(300);

    $("#cancelButtonForm").click(function() {
        $("#config").fadeOut(200);
    });
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
 * Open the search event modal box
 * @param event event of the click
 */
function openSearchEvent(event) {
    // Clear inputs
    $("#event").val("");
    $("#results").empty();

    // Show modal
    $("#searchEvent").fadeIn(300);

    $("#closeButton").click(function() {
        $("#searchEvent").fadeOut(200);
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
            window.location.replace("");
        },
        error: function(data){
        }
    });
}

/**
 * On key press on the find event form
 * @param event key press event
 */
 function onSearchKeyPress(event){
    event.preventDefault();
    var name = $(this).val();
    var resultBox = $("#results");
    resultBox.empty();
    if(name.length < 1)
        return;


    $.ajax({
        type:'GET',
        url: "?url=event/search",
        data: {name : name},
        success:function(data){
            resultBox.empty();
            for (var i = 0; i < data['search_events'].length; ++i) {
                event = data['search_events'][i];
                var div = generateResult(event);
                resultBox.append(div);
            }
        },
        error: function(data){
            console.log("error: " + data);
        }
    });
}

/**
 * Generate a event result
 * @param event user event to generate a result
 * @return generated HTML block
 */
function generateResult(event) {
    var $div = $("<div>");
    $div.addClass("result-box");
    $div.attr("id", "event" + event._id);

    var $image = $("<img>");
    $image.addClass("result-image");
    $image.attr("src", "img/uploaded/" + event._photo);

    var $desc = $("<h3>");
    $desc.addClass("result-description");
    $desc.text(event._name);

    $div.append($image);
    $div.append($desc);

    $div.click(onEventClick);

    return $div;
}

 /**
  * Event when clicking an event card.
  * Redirects to event page.
  * @param event event of the click
  */
 function onEventClick(event) {
    var eventId = this.id.substr("event".length);

    window.location.href ="?url=event/index&id=" + eventId;
 }
 
/**
 * Called when document is fully loaded in the
 * client browser
 */
$(document).ready(onReady);
