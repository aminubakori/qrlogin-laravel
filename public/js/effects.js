
$(document).ready(function() {

	// for webcam support
	$('#example').photobooth().on("image", function(event, dataUrl) {
		$("#hiddenImg").html('<img src="' + dataUrl + '" >');
		$('#button').disabled;
		$('.lloader').html('<img src="images/loader.gif" width="16"/> Please Wait...');
		qrCodeDecoder(dataUrl);
		/*console.log(event);
		console.log(dataUrl);
		console.log($('#example').data( "photobooth" ));*/
	});

	$('#button').click(function() {
		$('.trigger').trigger('click');
	});
	
	qrcode.callback = login;

});

// decode the img
function qrCodeDecoder(dataUrl) {
	qrcode.decode(dataUrl);
}

// show info from qr code
function showInfo(data) {
	$("#qrContent p").text(data);
}

//send data for login
function login(qrdata) {
	console.log(qrdata);
	jQuery.ajax({
        type: "POST",
        url: "/login", //Where form data is sent on submission
        dataType:"HTML", // Data type, HTML, json etc.
        data:{ qrdata: qrdata }, //Form variables
        success:function(data){
            /*$('.loginform').html('');
*/            $('.loginerror').html(data);
            $('.lloader').html('');

        },
        error:function (xhr, ajaxOptions, thrownError){
            $('.loginerror').html('<div class="alert alert-danger alert-dismissible" role="alert"> <button type="button" class="close" data-dismiss="alert"><span aria-hidden="true">&times;</span><span class="sr-only">Close</span></button><strong>Error: </strong>'+ thrownError +'</div>');
        	$('.lloader').html('');
        	return false;
        }
    });
}