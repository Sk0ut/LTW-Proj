var creatingEvent = false;

$( document ).ready(function() {
    $('#createEvent').toggle();
});

$( "#createeventbtn" ).click(function() {
    $( "#createEvent" ).toggle();
    if(creatingEvent){
    	creatingEvent = false;
    	$(".inputText").val("");
    	$(".checkbox").attr("checked", false);
    	$("select.year").val("2015");
    	$("select.month").val("1");
    	$("select.day").val("1");
		$("#createeventbtn").attr("value", "Create an event");
    }
    else {
    	creatingEvent = true;
		$("#createeventbtn").attr("value", "Cancel creation");
    }

    /* Em ambos os casos...*/
    console.log("O JOAO È MERDA");
});