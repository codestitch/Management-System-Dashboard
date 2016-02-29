
var myApp = angular.module('myApp', ['angularUtils.directives.dirPagination']);

$(function(){

	$("#reloadIcon").on("click", function(){
  		angular.element($("#MyController")).scope().reloadTable();
	});

});

function MyController ($scope) {

	$scope.reloadTable = function(){
		$scope.onInitTable ();
		$scope.$apply();
	}

	
	$scope.onInitTable = function(){

		show_loading("#bodyContent");
		var _post = "function=json&table=loctable";
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				//// console.log(result);

				// console.log(result);

				var data = result[0].data; 

				if (data == null || data.length == 0) {
					$("#dataTable").html('no record found...');
					return;
				}
				else if (data[0].result == "Incorrect") {
					toastr['error']("Oops! Kindly check your current password.", "Password Incorrect");

				}
				else if (data[0].result == "Failed"){
					toastr['error']("System Error. Kindly contact your administrator.", "Action Failed");

				}
				else if (data[0].result == "Expired"){
					toastr['error']("Oops! Your account has expired. Kindly login again.", "Session Expired");
					$(".preloader-wrapper").css({'display' : 'block'});
					window.location.href = "logout.php";
					return;
				}
				else
				{
				    $scope.currentPage = 1;
				    $scope.pageSize = 10;
               		$scope.items = data; 
				} 

			},
			error: function(result){
				toastr['error']("Oops! An error occured while performing the operation. " + result, "Operation Error");
			}
		});
		hide_loading("#bodyContent");

	}

	 $scope.pageChangeHandler = function(num) {
        // console.log('meals page changed to ' + num);
    };

    $scope.editObject = function (item) {
       GetSelectedRow(item);
    }
  
}



function OtherController($scope) {
    $scope.pageChangeHandler = function(num) {
      // console.log('going to page ' + num);
    };
}

myApp.controller('MyController', MyController);
myApp.controller('OtherController', OtherController);


// ---------------------- START COPY HERE -------------------------

var DELETE_CANDIDATE = "";
var DATA_CANDIDATE = "";
function InitDelete (dataid) {
	DELETE_CANDIDATE = dataid;

	$("#delModal").click();

}

function Delete () {

	// ////// console.log("DELETE_CANDIDATE:"+DELETE_CANDIDATE);
	if (DELETE_CANDIDATE!="") {

		var _post = "function=delete_location&locID="+DELETE_CANDIDATE;
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				////// console.log("Delete");
				////// console.log(result);

				if (result[0].response = "Success") {
					$("#bodyTable").html('');
					DELETE_CANDIDATE = "";
					GetData();
					return;
				}
				else
				{
					toastr['warning']("Oops! An error occured", "System Error");
				};
			},
			error: function(result){
				toastr['error']("Oops! An error occured while performing the operation. " + result, "Operation Error");
			}
		});

	}
	else{
		$("#alertModal").click();
		$("#alertTitle").val("Something Went Wrong...");
		$("#alertBody").val("Kindly check your internet connection and try to reload the page.");
	}

}

//  --------------------- EDIT MODULE -----------------------------

function GetSelectedRow (data) {

//	// console.log(data);
	//show_loading("#informationBody");
	$("#serviceBody").html('<center>Loading...</center>');
	$("#selImage").attr({ 'src' : '' });
	$("#editModalBtn").click();
	$("#imagePanel").hide();


	var _post = "function=view_record&table=loctable&recordID="+data;
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//// console.log("Edit");
			//// console.log(result);

			if (result[0].response == "Success" || result[0].data.length != 0) {
				ViewSelected(result[0].data[0])
			};

		},
		error: function(result){
			toastr['error']("Oops! An error occured while performing the operation. " + result, "Operation Error");
		}
	});
	//hide_loading("#informationBody");

}


function ViewSelected (data) {
	$("#serviceBody").html('');
	$("#imagePanel").show();

	// console.log(data);


	var checkstat = (data.status == "active") ? "checked" : "";
	var checkloyalty = (data.locFlag == "active") ? "checked" : "";
	$("#selImage").attr({ 'src' : data.image });
	$("#imagePanel").css({'display' : 'block'});
	
	DATA_CANDIDATE = data;

	var str = "<div class='form-group form-md-line-input  has-info'> " +
	"	<input type='text' class='form-control' id='nameField' > " +
	"	<label for='nameField'>Location Name</label> " +
	"</div> " +
	"<div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='addressField' > " +
	"	<label for='addressField'>Address</label> " +
	"</div> " +
	"<div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='latField' value='"+data.latitude+"'> " +
	"	<label for='latField'>Latitude</label> " +
	"</div> " +
	"<div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='longField' value='"+data.longitude+"'> " +
	"	<label for='longField'>Longitude</label> " +
	"</div> " +
	"<div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='branchField' value='"+data.branchCode+"'> " +
	"	<label for='branchField'>Branch Code</label> " +
	"</div> " +
	"<div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='phoneField' value='"+data.phone+"'> " +
	"	<label for='phoneField'>Primary Phone</label> " +
	" </div> " +
	" <div class='form-group form-md-line-input has-info'> " +
	"	<input type='text' class='form-control' id='emailField' value='"+data.email+"'> " +
	"	<label for='emailField'>Email</label> " +
	" </div> " +
	" <div class='md-checkbox'> " +
	"	<input type='checkbox' id='statusField' class='md-check' "+checkstat+"/> " +
	"	<label for='statusField'> " +
	"	<span></span> " +
	"	<span class='check'></span> " +
	"	<span class='box'></span> " +
	"	Status </label> " +
	" </div>  <br/>" +
	" <div class='md-checkbox'> " +
	"	<input type='checkbox' id='locFlagField' class='md-check' "+checkloyalty+"/> " +
	"	<label for='locFlagField'> " +
	"	<span></span> " +
	"	<span class='check'></span> " +
	"	<span class='box'></span> " +
	"	Enable Loyalty </label> " +
	" </div> <br/><br/> " +
	"  <br/> ";


	$("#serviceBody").append(str);

	$("#nameField").val(data.locName);
	$("#addressField").val(data.address);

}

$("#updateBtn").on('click', UpdateSelected);

function unlock(){
    // console.log("unlock");
    clickcount = 0;
    $("#updateBtn").on('click', UpdateSelected);
}

var clickcount = 0;

function UpdateSelected (e) {
    e.preventDefault();

    $("#closeBtn").click();
    $("#updateBtn").off('click', UpdateSelected);
    clickcount++;


	if (HasNewImage() == true)
	{
		UploadImage();
	}
	else{
		UpdateRecord("NULL");
	}

    
    if (clickcount > 1) return;
    // console.log(clickcount)


    setTimeout(unlock, 2500);
}

// Check kng naa bay new image
function HasNewImage () {
	////// console.log($("#imagePreview").html());
	// kung naay sulod
	if ($("#imagePreview").html()){
		//// console.log($("#imagePreview").html());
		return true;
	}
	return false;
}


function UploadImage() {

	//// console.log("UPLOAD IMAGE");
    // console.log("during click: "+click);
	// console.log("UploadImage");

    $('#upload_press_form').ajaxSubmit({
        url: 'php/upload.php',
        data: { file_name: 'upload_img', purpose: 'location' },
        type: 'post',
        beforeSend: function() { /* Add Function if NEEDED */ },
        uploadProgress: function(event, position, total, percentComplete) { /* Add Function if NEEDED */ },
        success: function(result) { 
            //// console.log("UploadImage");
            //// console.log(result);

            if (result == "Expired"){
                toastr['warning']("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({'display' : 'block'});
                window.location.href = "logout.php";
            }
            else if (result == "Failed"){
                toastr['warning']("Oops! Current operation fails. Kindly try again.", "Operation Failed");
            	 return;
            }
            else if (result == "Exceeds"){
                toastr['warning']("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
            	 return;
            }
            else if (result == "Invalid"){
                toastr['warning']("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
            	 return;
            }
            else{ 

				UpdateRecord(result);
            }
        },
        error:  function(result) { 
            //// console.log('Error: '+result); 
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
        }

    });

}

function UpdateRecord (image) { 
	// console.log("UpdateRecord");

	var name = $("#nameField").val(),
	    address = $( "#addressField").val(),
	    latitude = $( "#latField").val(),
	    longitude = $( "#longField").val(),
	    branch = $( "#branchField").val(),
	    phone = $( "#phoneField").val(),
	    email = $( "#emailField").val(),
	    status = ($("#statusField").is(':checked') == true) ? "active" : "inactive",
	    loyalty = ($("#locFlagField").is(':checked') == true) ? "active" : "inactive";

		if (name == "") {
			// console.log("123");
	        toastr['warning']("Kindly fill location name", "Invalid Entry");
	        hide_loading("#contentBody");
            setTimeout(unlock, 2500);
	        return;
	    }
	    if (!address || address == null || address == "") {
	        toastr['warning']("Kindly fill location address", "Invalid Entry");
	        hide_loading("#contentBody");
            setTimeout(unlock, 2500);
	        return;
	    }
	    if (!latitude || latitude == null || latitude == "") {
	        toastr['warning']("Kindly fill location latitude", "Invalid Entry");
	        hide_loading("#contentBody");
            setTimeout(unlock, 2500);
	        return;
	    }
	    if (!longitude || longitude == null || longitude == "") {
	        toastr['warning']("Kindly fill location longitude", "Invalid Entry");
	        hide_loading("#contentBody");
            setTimeout(unlock, 2500);
	        return;
		}
	    if (!branch || branch == null || branch == "") {
	        toastr['warning']("Kindly fill location branch", "Invalid Entry");
	        hide_loading("#contentBody");
            setTimeout(unlock, 2500);
	        return;
		}
	    if (email != ""){
	        if (validate_email_address(email) == "Invalid") {
	            toastr['warning']("Kindly fill correct email", "Invalid Entry");
	            hide_loading("#contentBody");
                setTimeout(unlock, 2500);
	            return;
	        }
	    }

	    SendData(encodeURIComponent(name), encodeURIComponent(address), latitude, longitude, branch, phone, email, status, loyalty, image);


}

function SendData (name, address, latitude, longitude, branch, phone, email, status, loyalty, image) {
	
	var _post = "function=update_location&locID="+DATA_CANDIDATE.locID+"&name="+name+"&address="+address+"&latitude="+latitude+"&longitude="+longitude+"&branch="+branch+"&phone="+phone+"&email="+email+"&status="+status+"&loyalty="+loyalty+"&image="+image;
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){


			if (result[0].response == "Expired"){
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
            else if (result[0].response == "Success") {
                toastr['success']("Great! You've successfully updated record information", "Operation Success");
                $("#editInfoBtn").click();
                Clear();
		  		angular.element($("#MyController")).scope().reloadTable();
                return;
            }
            else
            {
                toastr['warning']("Oops! Something went wrong. Kindly contact the administrator", "Operation Failed");
                return;
            }
		},
		error: function(result){
			toastr['error']("Oops! An error occured while performing the operation. " + result, "Operation Error");
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
}