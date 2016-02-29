$(function() {

    GetData();

	$("#addButton").click(function() {
        show_loading("#contentBody");
		ValidateData();
	});

    $("#clearButton").click(function() {
        Clear();
    });


});	

function GetData () {
    
    show_loading("#bodyContent");
    var _post = "function=json&table=loctable";
    $.ajax({
        type: 'POST',
        url: 'php/gateway.php',
        data: _post,
        cache: false,
        async: true,
        dataType: 'JSON',
        success: function(result){
            // console.log(result);
            var data = result[0].data;

            var myOptions = data;
            var mySelect = $('#locationField');
            $.each(myOptions, function(val, text) {
                mySelect.append(
                    $("<option></option>").val(text.locID).html(text.locName)
                );
            });
        },
        error:  function(result) { 
            //// console.log('Error: '+result); 
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
            hide_loading("#contentBody");
        }
    });

    hide_loading("#bodyContent");
}

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

    var locationID = $("#locationField").val(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive";

    if (!locationID || locationID == null || locationID == "") {
        toastr['warning']("Kindly fill location name", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }

    // upload image
    SendData(locationID, status);

}


function SendData (locID,  status) {

	var _post = "function=add_tablet&locID="+locID+"&status="+status;
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//// console.log("Add Campaign");
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
        error:  function(result) { 
            //// console.log('Error: '+result); 
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
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