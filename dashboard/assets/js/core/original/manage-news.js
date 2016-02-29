
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
		var _post = "function=json&table=posttable";
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

function Delete (dataid) {

	if (DELETE_CANDIDATE!="") {

		//// console.log("Data ID: "+dataid);
		var _post = "function=delete_post&postID="+DELETE_CANDIDATE;
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
	Clear();
	$("#serviceBody").html('<center>Loading...</center>');
	$("#selImage").attr({ 'src' : '' });
	$("#editModalBtn").click();
	$("#imagePanel").hide();


	var _post = "function=view_record&table=posttable&recordID="+data;
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
	$("#selImage").attr({ 'src' : data.image });
	$("#imagePanel").css({'display' : 'block'});
	$("#imgRemoveButton").click();
	DATA_CANDIDATE = data;

	//// console.log(data);

	var str = "<div class='form-group form-md-line-input  has-info'> " +
	"	<input type='text' class='form-control' id='titleField' > " +
	"	<label for='titleField'>Name Field</label> " +
	"</div> " +
	"<div class='md-checkbox'> " +
	"	<input type='checkbox' id='statusField' class='md-check' "+checkstat+"/> " +
	"	<label for='statusField'> " +
	"	<span></span> " +
	"	<span class='check'></span> " +
	"	<span class='box'></span> " +
	"	Status </label> " +
	"</div>  <br/>" +
	"<label>Description</label> " +
	"<div name='summernote' id='descField'></div> ";


	$("#serviceBody").append(str);

    $('#titleField').val(data.title);
    $('#descField').summernote({
            height: 180,
            disableDragAndDrop: false,
            fontNames: ['Opens Sans'],
            defaultFontName: 'Opens Sans',
            onpaste: function(e) {
                var thisNote = $(this);
                var updatePastedText = function(someNote){
                    var original = someNote.code();
                    var cleaned = CleanPastedHTML(original); //this is where to call whatever clean function you want. I have mine in a different file, called CleanPastedHTML.
                    someNote.code('').html(cleaned); //this sets the displayed content editor to the cleaned pasted code.
                };
                setTimeout(function () {
                    //this kinda sucks, but if you don't do a setTimeout, 
                    //the function is called before the text is really pasted.
                    updatePastedText(thisNote);
                }, 10);
            }
        });
    $('#descField').code(decodeURIComponent(data.description));

}

$("#updateBtn").on('click', UpdateSelected);

var clickcount = 0;

function unlock(){
    // console.log("unlock");
    clickcount = 0;
    $("#updateBtn").on('click', UpdateSelected);
}
// Kung gi update na ang selected Record
function UpdateSelected (e) {
    e.preventDefault();
    $("#closeBtn").click();
    $("#updateBtn").off('click', UpdateSelected);
    clickcount++;
    
    if (clickcount > 1) return;
    // console.log(clickcount)

	if (HasNewImage() == true)
	{
		UploadImage();
	}
	else
		UpdateRecord("NULL");

    setTimeout(unlock, 2500);
}

// Check kng naa bay new image
function HasNewImage () {
	////// console.log($("#imagePreview").html());
	// kung naay sulod
	//// console.log("Has image?");
	if ($("#imagePreview").html()){
		//// console.log($("#imagePreview").html());
		return true;
	}
	return false;
}


function UploadImage() {

    $('#upload_press_form').ajaxSubmit({
        url: 'php/upload.php',
        data: { file_name: 'press_image', purpose: 'post' },
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
	//// console.log("IMAGE: " + image);
	var name = $("#titleField").val(),
        description = $("#descField").code(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive";

        // console.log(description); 

    if (!name || name == null || name == "") {
        toastr['warning']("Kindly fill post name", "Invalid Entry");
        return;
    }
   else if (!description || description == null || description == "" || description == "<p><br></p>" || description == "<br>" ) {
        toastr['warning']("Kindly fill post description", "Invalid Entry");
        return;
    }

	var _post = "function=update_post&postID="+DATA_CANDIDATE.postID+"&title="+encodeURIComponent(name)+"&description="+encodeURIComponent(description)+"&status="+status+"&image="+image;
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
                $("#editModalBtn").click();
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
	$("#imgRemoveButton").click();
	$("#serviceBody").html('');
	$("#selImage").attr({ 'src' : '' });
}