$(function() {

	$("#addButton").click(function() {
        show_loading("#contentBody");
		ValidateData();
//                ValidateFields();
	});

    $("#clearButton").click(function() {
        Clear();
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

    var campaign = $("#campaignField").val(),
        points = $("#pointsField").val(),
        terms = $( "#termsField").code(),
        promo = $("#categoryField").val(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive",
        description = $( "#descriptionField").code();

    if (!campaign || campaign == null || campaign == "") {
        toastr['warning']("Kindly fill campaign title", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    else if (!points || points == null || points == "" ) {
        toastr['warning']("Kindly fill campaign points", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    } 
    else if(isNaN(points)){
         toastr['warning']("Campaign points must be a number", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    else if (!description || description == null || description == "" || description == "<p><br></p>" || description == "<br>") {
        toastr['warning']("Kindly fill campaign description", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }

    // upload image
    SendData(encodeURIComponent(campaign), points, encodeURIComponent(terms), encodeURIComponent(description), status, promo);

}


function SendData (name, points, terms, description, status, promotype) {

	var _post = "function=add_loyalty&name="+name+"&points="+points+"&terms="+terms+"&description="+description+"&status="+status+"&promo="+promotype;
//	console.log(_post);
    $.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//console.log("Add Campaign");
			//console.log(result);

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
                toastr['warning']("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
                return;
            }
            grecaptcha.reset();
		},
        error:  function(result) { 
            //console.log('Error: '+result); 
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
            hide_loading("#contentBody");
        }
	});

}

function Clear () {
    $("#campaignField").val('');
    $("#pointsField").val('');
    $("#termsField").code('');
    $("#descriptionField").code('');
    $("#statusField").attr("checked", false);

}