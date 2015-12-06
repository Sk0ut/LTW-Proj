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
	var id = getParameterByName('id');
	
    if(regStatus.hasClass("fa-check")) {
		 $.ajax({
			type:'POST',
			url: "?url=event/unregister",
			data: {eventId : id},
			success:function(data){
				if (data['unregister event'] == "unregistered") {
					regStatus.removeClass();
					regStatus.addClass("fa");
					regStatus.addClass("fa-ban");
					regStatus.text(" Unregistered");
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
					regStatus.removeClass();
					regStatus.addClass("fa");
					regStatus.addClass("fa-check");
					regStatus.text(" Registered");
				}
			}
		});
    }
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
 * Called when document is fully loaded in the
 * client browser
 */
$(document).ready(onReady);
