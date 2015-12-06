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
    $('#regStatus').click(changeRegisterStatus);
    $('#thread-create').submit(threadCreate);
    $("#editBtnEvent").click(openEditEvent);
    $('.commentForm').submit(postComment);
    $('#editEventForm').submit(onFormSubmit);
    $('#deleteButton').click(deleteEvent);
}

/**
 * Open the edit event modal box
 * @param event event of the click
 */
function openEditEvent(event) {
    $("#editEvent").fadeIn(300);

    $("#cancelButton").click(function() {
        $("#editEvent").fadeOut(200);
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
 * Change the register status of the user
 * @event event click event
 */
function changeRegisterStatus(event) {
    var regStatus = $(this);
    var id = getParameterByName('id');

    if(regStatus.hasClass("fa-check")) {
         $.ajax({
            type:'POST',
            url: "?url=event/unregister",
            data: {eventId : id},
            success:function(data){
                if (data['unregister event'] == "unregistered") {
                    location.reload();
                }
            }
        });
    } else {
        $.ajax({
            type:'POST',
            url: "?url=event/register",
            data: {eventId : id},
            success:function(data){
                if (data['register event'] == "registered") {
                    location.reload();
                }
            }
        });
    }
}

/**
 * Post a comment in a thread
 * @param event submit event
 */
function postComment(event) {
    event.preventDefault();
    var eventId = getParameterByName('id');
    var threadId = this.id.substr("insertComment".length);

    var comment = $(this).find("textarea").val();
    $(this).find("textarea").val("");

    $.post(
            "?url=event/addComment",
            {
                eventId: eventId,
                threadId: threadId,
                comment: comment
            },
            function(data) {
                location.reload();
            })
            .fail(function(error) {
                console.log("Error on posting comment");
            });
}

/**
 * Create a new thread in a event
 * @param event submit event
 */
function threadCreate(event) {
    event.preventDefault();
    var id = getParameterByName('id');
    var title = $(this).find("#titleThread").val();
    var description = $(this).find("textarea").val();

    $.post(
            "?url=event/createThread",
            {
                eventId: id,
                title: title,
                description: description
            },
            function(data) {
                location.reload();
            })
            .fail(function(error) {
            });
}

/**
 * On submit the edit event form
 */
function onFormSubmit(event) {
    event.preventDefault();
    $("#editEvent").fadeOut(200);

    var formData = new FormData(this);
    formData.append("id", getParameterByName('id'));

    $.ajax({
        type:'POST',
        url: "?url=event/edit",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            window.location.reload();
        },
        error: function(data){
            console.log("Error on edit event");
        }
    });
}

/**
 * Delete a event
 * @param event submit event
 */
function deleteEvent(event) {
    event.preventDefault();
    var eventId = getParameterByName('id');

    $.post(
            "?url=event/delete",
            {
                id: eventId
            },
            function(data) {
                window.location.href = "";
            })
            .fail(function(error) {
                console.log("Error on delete event");
            });
}

/**
 * Search name in get params.
 * @param name name to search
 * @return value associated with name
 */
function getParameterByName(name) {
    name = name.replace(/[\[]/, "\\[").replace(/[\]]/, "\\]");
    var regex = new RegExp("[\\?&]" + name + "=([^&#]*)"),
        results = regex.exec(location.search);
    return results === null ? "" : decodeURIComponent(results[1].replace(/\+/g, " "));
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
