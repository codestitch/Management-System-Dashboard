$(function() {

	$("#addButton").click(function() {
        show_loading("#contentBody");
		ValidateData();
	});


});	

function ValidateData () {
    
    if ($("#g-recaptcha-response").val()) {
        $.ajax({
            type: 'POST',
            url: "php/captcha.php", // The file we're making the request to
            dataType: 'html',
            async: false,
            data: {
                captchaResponse: $("#g-recaptcha-response").val() // The generated response from the widget sent as a POST parameter
            },
            success: function (data) {
                ValidateFields();
                
            },
            error: function (XMLHttpRequest, textStatus, errorThrown) {
                toastr['warning']("You're a bot", "Invalid Entry");
                hide_loading("#contentBody");
                return;
            }
        });
    } else {
        toastr['warning']("Please fill the captcha!", "Missing Captcha");
                hide_loading("#contentBody");
    }


}



function ValidateFields () {

    var card = $("#cardField").val();

    if (!card || card == null || card == "") {
        toastr['warning']("Kindly fill card series limit", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }

    // upload image
    SendData();

}


function SendData () {

	var _post = "function=card_series";
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//console.log("Add Campaign");
//			console.log(result);

            hide_loading("#contentBody");

            if(result[0].response == "Success"){
                toastr['success']("Great! You successfully added a new press", "Success");
                Clear();
            }
            else if (result[0].response == "Expired"){
                toastr['warning']("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({'display' : 'block'});
                window.location.href = "logout.php";
            }
            else if (result[0].response == "Failed"){
                toastr['warning']("Oops! Current operation fails. Kindly try again.", "Operation Failed");
                return;
            }
            else if (result[0].response == "Exceeds"){
                toastr['warning']("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
                return;
            }
            else if (result[0].response == "Invalid"){
                toastr['warning']("Oops! Something went wrong. SKU Code and Promo Type already Exist.", "Operation Failed");
                return;
            }
            grecaptcha.reset();
		},
		error: function(){
            hide_loading("#contentBody");

		}
	});

}

function Clear () {
	$("#nameField").val('');
	$("#skuField").val('');
	$("#priceField").val('');
	$("#groupField").val('');
	$("#descriptionField").val('');
	$("#statusField").attr("checked", false);
}