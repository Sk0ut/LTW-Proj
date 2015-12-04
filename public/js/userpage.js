var creatingEvent = false;

$( document ).ready(
	function() {
    $( "#datepicker" ).datepicker({
      yearRange: "2015:2060",
      dateFormat: "dd-mm-yy",
      changeMonth: true,//this option for allowing user to select month
      changeYear: true //this option for allowing user to select from year range
    });

    $("#createEventForm").submit(onFormSubmit);
});

$( "#createeventbtn" ).click(function() {
    if(creatingEvent){
    	creatingEvent = false;
    	$("#createEvent").slideUp(500);
    	$(".inputText").val("");
    	$(".checkbox").attr("checked", false);
    	$("select.year").val("2015");
    	$("select.month").val("1");
    	$("select.day").val("1");
		$("#createeventbtn").attr("value", "Create an event");
    }
    else {
    	creatingEvent = true;
    	$("#createEvent").slideDown(500);
		$("#createeventbtn").attr("value", "Cancel creation");
    }
});

$('a[href^="#"]').on('click', function(event) {

    var target = $( $(this).attr('href') );

    if( target.length ) {
        event.preventDefault();
        $('html, body').animate({
            scrollTop: -40 + target.offset().top
        }, 500);
    }

});

function onFormSubmit(event) {
    event.preventDefault();
    var formData = new FormData(this);

    $.ajax({
        type:'POST',
        url: "?url=event/create",
        data:formData,
        cache:false,
        contentType: false,
        processData: false,
        success:function(data){
            console.log("success");
            console.log(data);
        },
        error: function(data){
            console.log("error");
            console.log(data);
        }
    });
}