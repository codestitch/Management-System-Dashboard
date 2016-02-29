$(function(){

	

	$("#addButton").on("click", function(){
        show_loading("#contentBody");
		ValidateData();
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
                InitSave();
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

function InitSave() {

    var name = $("#nameField").val(),
        address = $( "#addressField").val(),
        latitude = $( "#latField").val(),
        longitude = $( "#longField").val(),
        branch = $( "#branchField").val(),
        phone = $( "#phoneField").val(),
        email = $( "#emailField").val(),
        points = $( "#pointsField").val(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive",
        loyalty = ($("#loyaltyField").is(':checked') == true) ? "active" : "inactive";

    if (!name || name == null || name == "") {
        toastr['warning']("Kindly fill location name", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    if (!address || address == null || address == "") {
        toastr['warning']("Kindly fill location address", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    if (!latitude || latitude == null || latitude == "") {
        toastr['warning']("Kindly fill location latitude", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    if (!longitude || longitude == null || longitude == "") {
        toastr['warning']("Kindly fill location longitude", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    } 
    if (email != "") {
        // console.log(email);
       if (validate_email_address(email) == "Invalid") {
            toastr['warning']("Kindly fill correct email", "Invalid Entry");
            hide_loading("#contentBody");
            return;
        } 
    }
    

    SendData(encodeURIComponent(name), encodeURIComponent(address), latitude, longitude, branch, phone, email, status, loyalty  );
       
}


function SendData (name, address, latitude, longitude, branch, phone, email, status, loyalty ) {

	var _post = "function=add_location&name="+name+"&address="+address+"&latitude="+latitude+"&longitude="+longitude+"&branch="+branch+"&phone="+phone+"&email="+email+"&status="+status+"&loyalty="+loyalty;
    // console.log(_post);
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//console.log("Add Campaign");
			// console.log(result);
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
            }
            else if (result[0].response == "Exceeds"){
                toastr['warning']("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
            }
            else if (result[0].response == "Invalid"){
                toastr['warning']("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
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
    $("#nameField").val('');
    $("#addressField").val('');
    $("#latField").val('');
    $("#longField").val('');
    $("#branchField").val('');
    $("#phoneField").val('');
    $("#emailField").val('');
    $("#statusField").attr("checked", false);
    $("#loyaltyField").attr("checked", false);
    $( "#pointsField").val('');
    $("#imgRemoveButton").click();
}

function validate_email_address(email){
    var reg = /^([A-Za-z0-9_\-\.])+\@([A-Za-z0-9_\-\.])+\.([A-Za-z]{2,4})$/;
    if (reg.test(email) == false) {
        return "Invalid";
    } else {
        return "Valid";
    }
}