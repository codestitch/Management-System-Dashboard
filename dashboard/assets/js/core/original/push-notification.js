//// Loyalty
//$("#updateLoyaltySettings").on("click", UpdateLoyalty);
//
//// unlock
//function unlockLoyalty(){
//    $("#updateLoyaltySettings").on("click", UpdateLoyalty);
//}

$(function() {
	
	$("#initButton").on("click", function(){ 
        
	    show_loading("#contentBody");
		if ($("#g-recaptcha-response").val()) {
	        $.ajax({
	            type: 'POST',
	            url: "php/captcha.php", // The file we're making the request to
	            dataType: 'html',
	            async: true,
	            data: {
	                captchaResponse: $("#g-recaptcha-response").val() // The generated response from the widget sent as a POST parameter
	            },
	            success: function (data) {
                    hide_loading("#contentBody");
	            	$("#modalClick").click();
	            },
	            error: function (XMLHttpRequest, textStatus, errorThrown) {
                    hide_loading("#contentBody");
					toastr['warning']("You're a bot", "Invalid Entry");
	            }
	        });
	    } else {
            hide_loading("#contentBody");
	    	toastr['warning']("Please fill the captcha!", "Missing Captcha");
	    }

	});


	$("#sendButton").on("click", Push);
	
	$("#clearButton").on("click", function(){
		$("#notificationMessageField").val('');
	});

});

function unlock(){ 
    $("#sendButton").on("click", Push);
    clickcount = 0;
}

var clickcount = 0;

function Push (e) {
    e.preventDefault(); 
    $("#sendButton").off("click", Push);
	clickcount++;
    
    if (clickcount > 1) return;
    // console.log(clickcount);
    
    show_loading("#contentBody");
	var message = $("#notificationMessageField").val();
	// // console.log("message: " + message);

	if (!message) {
		toastr['warning']("There's no message in push notification. Kindly supply one.", "Missing Message");
		return;
	};

    grecaptcha.reset();
	var _post = "function=send_push&message="+message+"&type=normal";
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			// // console.log("pusch");
			// // console.log(result);
			$("#notificationMessageField").val('');
			toastr['success']("Great! You've successfully send the message to all devices.", "Message Sent"); 

		}
	});
    hide_loading("#contentBody");	 

    setTimeout(unlock, 2000);
}