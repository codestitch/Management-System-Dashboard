
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
		var _post = "function=json&table=devicecodetable";
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				//// console.log("News");
				//// console.log(result);

				var data= result[0].data; 
				

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
				hide_loading("#bodyContent"); 
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




var DELETE_CANDIDATE = "";
var DATA_CANDIDATE = "";

function InitDelete (dataid) {
	DELETE_CANDIDATE = dataid;

	$("#delModal").click();
}

function Delete () {

	if (DELETE_CANDIDATE!="") {

		var _post = "function=delete_tablet&deviceCode="+DELETE_CANDIDATE;
		$.ajax({
			type: 'POST',
			url: 'php/gateway.php',
			data: _post,
			cache: false,
			async: false,
			dataType: 'JSON',
			success: function(result){
				// console.log("Delete");
				// console.log(result);

				if (result[0].response = "Success") {
					$("#bodyTable").html('');
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
	$("#serviceBody").html('<center>Loading...</center>');
	$("#selImage").attr({ 'src' : '' });
	$("#editModalBtn").click();
	$("#imagePanel").hide();


	var _post = "function=view_record&table=devicecodetable&recordID="+data;
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

			if (result[0].response == "Success") {
				ViewSelected(result[0].data[0])
			}
			else
			{
                toastr['warning']("Oops! Something went wrong. Kindly contact the administrator", "Operation Failed");
                return;

			}

		}
	});

}

function ViewSelected (data) {
	$("#serviceBody").html('');
	$("#imagePanel").show();

	var checkstat = (data.status == "active") ? "checked" : "";	
    var deploystat = (data.deploy == "true") ? "checked" : "";

	$("#selImage").attr({ 'src' : data.image });
	$("#imagePanel").css({'display' : 'block'});
	DATA_CANDIDATE = data;
	// console.log(data);

	var str = "<div class='form-group form-md-line-input  has-info'> " +
			"	<input type='text' class='form-control' id='deviceCodeField' value='"+data.deviceCode+"' readonly> " +
			"	<label for='deviceCodeField'>Device Code Field</label> " +
			"</div> " +
			" <div class='form-group form-md-line-input has-info'> " +
			" 	<select name='locField' class='form-control' id='locationField'> " +
			" 		<option id='locoption' value=''>Select Location</option> " +
			" 	</select> " +
			" 	<label for='locationField'>Location</label> " +
			" </div> " +
			"<div class='md-checkbox'> " +
			"	<input type='checkbox' id='statusField' class='md-check' "+checkstat+"/> " +
			"	<label for='statusField'> " +
			"	<span></span> " +
			"	<span class='check'></span> " +
			"	<span class='box'></span> " +
			"	Status </label> " +
			"</div>  <br/>"+
			"<div class='md-checkbox'> " +
			"	<input type='checkbox' id='deployField' class='md-check' "+deploystat+"/> " +
			"	<label for='deployField'> " +
			"	<span></span> " +
			"	<span class='check'></span> " +
			"	<span class='box'></span> " +
			"	Deploy </label> " +
			"</div> ";

	$("#serviceBody").append(str);


	GetLocationData (data.locID); 

}

var LOCATION_DATA;
function GetLocationData (selectedLoc) {
    
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
            LOCATION_DATA = result[0].data;
		    	// console.log(selectedLoc);

            var myOptions = LOCATION_DATA;
		    var mySelect = $('#locationField');
		    $.each(myOptions, function(val, text) {
		        mySelect.append(
		            $("<option></option>").val(text.locID).html(text.locName)
		        );
		    });

		    $('[name=locField]').val(selectedLoc);
        }
    });

    hide_loading("#bodyContent");
}

$("#updateBtn").one('click', UpdateRecord);

function unlock(){
    // console.log("unlock");
    clickcount = 0;
    $("#updateBtn").on('click', UpdateRecord);
}
var clickcount=0;

function UpdateRecord (e) {
    e.preventDefault();
    clickcount++;
    
    $("#closeBtn").click();closeBtn
    $("#updateBtn").off('click', UpdateRecord);
    
    if(clickcount > 1) return;
    // console.log(clickcount);

	var locationID = $("#locationField").val(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive";
    var deploy = ($("#deployField").is(':checked') == true) ? "true" : "false";

    if (!locationID || locationID == null || locationID == "") {
        toastr['warning']("Kindly fill location name", "Invalid Entry");
        setTimeout(unlock, 3000);
        hide_loading("#contentBody");
        return;
    }

	var _post = "function=update_tablet&deviceCode="+DATA_CANDIDATE.deviceCode+"&locID="+locationID
	+"&status="+status+"&deploy="+deploy;

	// console.log(_post);
	$.ajax({
		type: 'POST',
		url: 'php/gateway.php',
		data: _post,
		cache: false,
		async: false,
		dataType: 'JSON',
		success: function(result){
			// console.log("Update");
			// console.log(result);

            
            setTimeout(unlock, 3000);
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


    setTimeout(unlock, 3000);
}


function Clear () {
	
	$("#serviceBody").html('');
	$("#selImage").attr({ 'src' : '' });
}