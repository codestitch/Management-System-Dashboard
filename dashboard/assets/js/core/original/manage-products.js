
var myApp = angular.module('myApp', ['angularUtils.directives.dirPagination']);

$(function(){

	$("#reloadIcon").on("click", function(){
		  angular.element($("#MyController")).scope().reloadTable();
	});

});

var VariantString;
var variantCount = 1;

$('#serviceBody').on("click", "#AddVariant", function (event) {
   AddVariant();
});


function MyController ($scope) {

	$scope.reloadTable = function(){
		$scope.onInitTable ();
		$scope.$apply();
	}

    $scope.currentPage = 1;
    $scope.pageSize = 10;

    $scope.onInitTable = function(){

        // console.log(123);
        show_loading("#bodyContent");
        var _post = "function=json&table=producttable";

        $.ajax({
          type: 'POST',
          url: 'php/gateway.php',
          data: _post,
          cache: false,
          async: false,
          dataType: 'JSON',
          success: function(result){
              // console.log(result[0].response);

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
                $scope.products = result[0].data;
              } 
          },
          error: function(result){
            toastr['error']("Oops! An error occured while performing the operation. " + result, "Operation Error");
          }
        });
        hide_loading("#bodyContent");

    }// end initData


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

		var _post = "function=delete_product&itemID="+DELETE_CANDIDATE;
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


	var _post = "function=view_record&table=producttable&recordID="+data;
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

	// console.log(data);


	var checkstat = (data.status == "active") ? "checked" : "";
	$("#selImage").attr({ 'src' : data.image });
	$("#imagePanel").css({'display' : 'block'});
	DATA_CANDIDATE = data;

	var str = "<div class='form-group form-md-line-input  has-info'> " +
	"	<input type='text' class='form-control' id='titleField' > " +
	"	<label for='titleField'>Name Field</label> " +
	"</div> " +
	" <div class='form-group form-md-line-input has-info'> " +
	" 	<select name='locField' class='form-control' id='categoryField'> " +
	" 		<option id='locoption' value=''>Select Location</option> " +
	" 	</select> " +
	" 	<label for='categoryField'>Category</label> " +
	" </div> " +
	"<div class='form-group form-md-line-input  has-info'> " +
	"	<input type='text' class='form-control' id='priceField' value='0'> " +
	"	<label for='priceField'>Price:</label> " +
	"	<span class='help-block'>Enter price here...</span> " +
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
	"<div name='summernote' id='editserviceDescField'></div> ";


	$("#serviceBody").append(str);
	GetDropDownData(data.categoryID);

    $('#titleField').val(data.name);
    $('#priceField').val(data.price);
    $('#editserviceDescField').summernote({
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
    $('#editserviceDescField').code(decodeURIComponent(data.description));
    // $('#editserviceDescField').code(decodeURIComponent(data.description));
}

function GetDropDownData (selectedValue) {
    
    show_loading("#bodyContent");
    var _post = "function=json&table=categoryTable";
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
		    var mySelect = $('#categoryField');
		    $.each(myOptions, function(val, text) {
		        mySelect.append(
		            $("<option></option>").val(text.categoryID).html(text.name)
		        );
		    });

		    $('[name=locField]').val(selectedValue);
        }
    });

    hide_loading("#bodyContent");
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

	//// console.log("UPLOAD IMAGE");

    $('#upload_press_form').ajaxSubmit({
        url: 'php/upload.php',
        data: { file_name: 'press_image', purpose: 'product' },
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
				//// console.log(result);

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

	var title = $("#titleField").val(),
        description = $( "#editserviceDescField").code(),
        status = ($("#statusField").is(':checked') == true) ? "active" : "inactive",
        price = $("#priceField").val(),
        category = $("#categoryField").val();
 
 	// console.log(description);

    if (!title || title == null || title == "") {
        toastr['warning']("Kindly fill service title", "Invalid Entry");
        return;
    }
    else if (!description || description == null || description == "" || description == "<p><br></p>" || description == "<br>" ) {
        toastr['warning']("Kindly fill service description", "Invalid Entry");
        return;
    }
    else if (!category || category == null || category == "" || category == "<p><br></p>") {
        toastr['warning']("Kindly fill service category", "Invalid Entry");
        return;
    }
    else if (isNaN(price)){
        toastr['warning']("Kindly fill in number format", "Invalid Entry");
        return;
    }



	var _post = "function=update_product&name="+encodeURIComponent(title)+"&prodID="+DATA_CANDIDATE.prodID+"&price="+price+"&category="+category+"&description="+encodeURIComponent(description)+"&status="+status+"&image="+image;
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
	
	$("#serviceBody").html('');
	$("#selImage").attr({ 'src' : '' });
}