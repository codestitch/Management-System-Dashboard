$(function(){
	
	$("#addButton").on("click", function(){
        show_loading("#contentBody");
		ValidateData();
        // UploadImage();
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
                UploadImage();
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

function UploadImage() {

    $('#upload_img_form').ajaxSubmit({
        url: 'php/upload.php',
        data: { file_name: 'form_image', purpose: 'product' },
        type: 'post',
        beforeSend: function() { /* Add Function if NEEDED */ },
        uploadProgress: function(event, position, total, percentComplete) { /* Add Function if NEEDED */ },
        success: function(result) { 
             // console.log(result);

            if (result == "Expired"){
                toastr['warning']("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({'display' : 'block'});
                // console.log("Expired");
                window.location.href = "logout.php";
            }
            else if (result == "Failed"){
                toastr['warning']("Oops! Current operation fails. Kindly try again.", "Operation Failed");
                hide_loading("#contentBody");
                return;
            }
            else if (result == "Exceeds"){
                toastr['warning']("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
                hide_loading("#contentBody");
                return;
            }
            else if (result == "Invalid"){
                toastr['warning']("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
                hide_loading("#contentBody");
                return;
            }
            else{
                var name = encodeURIComponent($("#nameField").val()),
                    status = ($("#statusField").is(':checked') == true) ? "active" : "inactive";

                    // console.log(name);
                if (!name || name == null || name == "") {
                    toastr['warning']("Kindly fill category title", "Invalid Entry");
                    hide_loading("#contentBody");
                    return;
                } 
               
                SendData(name, status, result, "");
            }
        },
        error:  function(result) { 
            //console.log('Error: '+result); 
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
            hide_loading("#contentBody");
        }
    });
    hide_loading("#contentBody");
}


function SendData (name, status, image, icon) {

	var _post = "function=add_category&name="+name+"&status="+status+"&image="+image+"&icon="+icon;
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
    $("#iconField").val('');
    $("#statusField").attr("checked", false);
 $("#imgRemoveButton").click();


}