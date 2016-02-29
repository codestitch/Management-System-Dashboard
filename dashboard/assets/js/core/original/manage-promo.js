
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

	$scope.onInitTable = function () {
		
		show_loading("#bodyContent");
		var _post = "function=json&table=promotable";
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				//// console.log("Press");
				//// console.log(result);

				var data = result[0].data;

				if (data == null || data.length == 0) {
					$("#dataTable").html('no record found...');
					//toastr['warning']("Password field is empty.", "Login Error");
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


// -------------------- DELETE ------------------------------

var DELETE_CANDIDATE = "";
var DATA_CANDIDATE = "";
function InitDelete (dataid) {
	DELETE_CANDIDATE = dataid;

	$("#delModal").click();
}


function Delete (dataid) {

	if (DELETE_CANDIDATE!="") {

		//// console.log("Data ID: "+dataid);
		var _post = "function=delete_promo&promoID="+DELETE_CANDIDATE;
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				//// console.log("Delete");
				//// console.log(result);

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
	//// console.log("opening..");
	Clear();
	//show_loading("#informationBody");
	$("#serviceBody").html('<center>Loading...</center>');
	$("#selImage").attr({ 'src' : '' });
	$("#editModalBtn").click();
	$("#imagePanel").hide();


	var _post = "function=view_record&table=promotable&recordID="+data;

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

		}
	});
	//hide_loading("#informationBody");

}

function ViewSelected (data) {
	$("#serviceBody").html('');
	$("#imagePanel").show();

	var checkstat = (data.status == "active") ? "checked" : "";

	$("#selImage").attr({ 'src' : data.image });
	$("#imagePanel").css({'display' : 'block'});
	DATA_CANDIDATE = data;

	var str =  "<div class='form-group form-md-line-input  has-info'> " +
	"	<input type='text' class='form-control' id='nameField' value='"+ data.name +"'> " +
	"	<label for='nameField'>Name</label> " +
	"</div>  " +
	"<div class='md-checkbox'> " +
	"	<input type='checkbox' id='statusField' class='md-check' "+checkstat+"/> " +
	"	<label for='statusField'> " +
	"	<span></span> " +
	"	<span class='check'></span> " +
	"	<span class='box'></span> " +
	"	Status </label> " +
	"</div>  <br/>" ;

	$("#serviceBody").append(str);

}


$("#updateBtn").on('click', UpdateSelected);
var clickcount = 0;

function unlock(){
    // console.log("unlocked");
    clickcount = 0;
    $("#updateBtn").on('click', UpdateSelected); 
}

function UpdateSelected (e) {
    e.preventDefault();
	//// console.log("UpdateSelected 123");
    $("#closeBtn").click();
    $("#updateBtn").off('click', UpdateSelected);
    clickcount++;
    
    if (clickcount> 1) return;
    // console.log(clickcount);
    
	if (HasNewImage() == true)
	{
		UploadImage();
	}
	else{
		UpdateRecord("NULL");
	}

        
    setTimeout(unlock, 3000);
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

    $('#upload_press_form').ajaxSubmit({
        url: 'php/upload.php',
        data: { file_name: 'press_image', purpose: 'promo' },
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
            }
            else if (result == "Exceeds"){
                toastr['warning']("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
            }
            else if (result == "Invalid"){
                toastr['warning']("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
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

	var status = ($('#statusField').is(':checked'))? "active" : "inactive";
	 var name = $("#nameField").val();


    if (!name || name == null || name == "") {
        toastr['warning']("Kindly fill promo name", "Invalid Entry");
        hide_loading("#contentBody");
        return;
    }

	var _post = "function=update_promo&promoID="+DATA_CANDIDATE.promoID+"&name="+name+"&status="+status+"&image="+image;
	// console.log(_post);
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			//// console.log("Update");
			//// console.log(result);

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
		}
	});


}

function Clear () {
	//// console.log("clearing...");
	$("#imagePreview").attr({'src':'http://www.placehold.it/200x150/EFEFEF/AAAAAA&amp;text=no+image'});
	$("#imgRemoveButton").click();
	$("#serviceBody").html('');
	$("#selImage").attr({ 'src' : '' });
	$("#nameField").val('');
}