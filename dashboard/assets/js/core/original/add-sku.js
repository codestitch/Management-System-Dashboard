$(function() {

	$("#addButton").click(function() {
        show_loading("#contentBody");
		ValidateData();
//        ValidateFields();
	});

    $("#clearButton").click(function() {
        Clear();
    });
    
});	



$( "#categoryField" )
  .change(function () {
    
        var str = $( "#categoryField" ).val(); 
    
        if(str == "frequency"){
            $("#frequencypanel").show();    
            $("#snappanel").hide();     
            // console.log("frequency: " );
            GetData();
        }
        else if(str == "snap") {
            $("#frequencypanel").hide();    
            $("#snappanel").show();  
            // console.log("litse na snap: ");
        }

  })
  .change();
 

function GetData () {
    
    show_loading("#contentBody");
    var _post = "function=json&table=loyaltytable";
    $.ajax({
        type: 'POST',
        url: 'php/gateway.php',
        data: _post,
        cache: false,
        async: true,
        dataType: 'JSON',
        success: function(result){
            //// console.log("News");
            // console.log(result);

            var data = result[0].data;

            if (data == null || data.length == 0) {
                toastr['warning']("Oops! No Category found. Kindly add first a category.", "No Data Found");
                return;
            } 

            var myOptions = data;
            var mySelect = $('#campaignField');
            $.each(myOptions, function(val, text) {
//                    // console.log(text);
                mySelect.append(
                    $("<option></option>").val(text.loyaltyID).html(text.name)
                );
            });

        }
    });

    hide_loading("#contentBody");
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

    var title = $("#nameField").val(),
        skuCode = $("#skuField").val(),
        price = $("#priceField").val(),
        promoType = $("#categoryField").val(),
        snaps = $("#pointsField").val(),
        loyaltyID = ( $("#campaignField").val() == "") ? "" : $("#campaignField").val(),
        group = ( $("#groupField").val() == "") ? "" : $("#groupField").val(),
        description = $("#descriptionField").val(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive";

    if (!title || title == null || title == "") {
        toastr['warning']("Kindly fill SKU name", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    else if (!skuCode || skuCode == null || skuCode == "") {
        toastr['warning']("Kindly fill SKU skuCode", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    else if (!price || price == null || price == "") {
        toastr['warning']("Kindly fill SKU price", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }
    else if (isNaN(price)) {
        toastr['warning']("Kindly fill SKU price", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    } 
    else if (!description || description == null || description == "") {
        toastr['warning']("Kindly fill SKU description", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }

    var str = $( "#categoryField" ).val(); 
    if(str == "bonus"){
        
        if (!snaps || snaps == null || snaps == "") {
            toastr['warning']("Kindly fill SKU snap points", "Invalid Entry");
            hide_loading("#contentBody");
            return;
        }
        else if (isNaN(snaps)){
            toastr['warning']("Kindly fill snaps", "Invalid Entry");
            hide_loading("#contentBody");
            return 
        }
    }
    // frequency
    else{ 
        
        if (!group || group == null || group == "") {
            toastr['warning']("Kindly fill group", "Invalid Entry");
            hide_loading("#contentBody");
            return;
        }
        else if (!loyaltyID || loyaltyID == null || loyaltyID == "") {
            toastr['warning']("Kindly select campaign", "Invalid Entry");
            hide_loading("#contentBody");
            return 
        }
    }
      
    
    SendData(title, skuCode, price, promoType, snaps, description, status, group, loyaltyID);

}


function SendData (title, skuCode, price, promoType, points, description, status, group, loyaltyID) {

        $( "#addButton").unbind("click");
	var _post = "function=add_sku&name="+encodeURIComponent(title)+"&skuCode="+encodeURIComponent(skuCode)+"&price="+price+"&promoType="+encodeURIComponent(promoType)+"&points="+points+"&description="+encodeURIComponent(description)+"&status="+status+"&group="+encodeURIComponent(group)+"&loyaltyID="+loyaltyID;
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//// console.log("Add Campaign");
			//// console.log(result);

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

    $( "#addButton").bind("click");

}

function Clear () {
	$("#nameField").val('');
	$("#skuField").val('');
	$("#priceField").val('');
	$("#groupField").val('');
	$("#descriptionField").val('');
    $("#pointsField").val('');
	$("#statusField").attr("checked", false);
    $("#campaignField").val('');
    $("#groupField").val('');
}