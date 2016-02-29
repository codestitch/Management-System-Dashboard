// Image
$("#updateImgBtn").on("click", UpdateImage);
// Contact info
$("#updateContactBtn").on("click", UpdateContact); 
// Commit Password Change
$("#updatePassButton").on("click", UpdatePass);
// Loyalty
$("#updateLoyaltySettings").on("click", UpdateLoyalty);

function unlockImg(){ 
    clickImg = 0;
    $("#updateImgBtn").on("click", UpdateImage);
}
function unlock(){
    clickContact = 0;
    $("#updateContactBtn").on("click", UpdateContact);
} 
function unlockUpdatePass(){
    clickPass = 0;
    $("#updatePassButton").on("click", UpdatePass); 
}
function unlockLoyalty(){
    clickLoyalty = 0;
    $("#updateLoyaltySettings").on("click", UpdateLoyalty);
}

var clickImg = 0,
    clickContact = 0,
    clickPass = 0,
    clickLoyalty = 0;


// ----------------
// Image Function 
// ----------------
function UpdateImage(e) { 
    $("#updateImgBtn").off("click", UpdateImage);
    
    clickImg++;
    if (clickImg > 1) return;
    
    if (HasNewImage() == true) {
        UploadImage();
    } else {
        UpdateRecord("NULL");
    }
    
    setTimeout(unlockImg, 2500);
}

function HasNewImage() {
    if ($("#imageThumb").html()) {
        return true;
    };
    return false;
}

function UploadImage() {
    $("#upload_image").ajaxSubmit({
        url: "php/upload.php",
        data: {
            file_name: "currentImage",
            purpose: "profile"
        },
        type: "post",
        beforeSend: function () {},
        uploadProgress: function (_0xcb3fx14, _0xcb3fx15, _0xcb3fx16, _0xcb3fx17) {},
        success: function (result) {
            if (result == "Expired") {
                toastr["warning"]("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({
                    "display": "block"
                });
                window.location.href = "logout.php";
            } else {
                if (result == "Failed") {
                    toastr["warning"]("Oops! Current operation fails. Kindly try again.", "Operation Failed");
                    hide_loading("#contentBody");
                } else {
                    if (result == "Exceeds") {
                        toastr["warning"]("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
                        hide_loading("#contentBody");
                    } else {
                        if (result == "Invalid") {
                            toastr["warning"]("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
                            hide_loading("#contentBody");
                        } else {
                            UpdateRecord(result);
                        }
                    }
                }
            }
        }
        , error: function (result) {
            toastr["error"]("Oops! An error occured. " + result + "Error Encounter");
        }
    })
}

function UpdateRecord(result) {
    show_loading("#contentBody");

    var _post = "function=update_profile_logo&profilePic="+ result;
    $.ajax({
        type: "POST",
        url: "php/gateway.php",
        data: _post,
        cache: false,
        async: false,
        dataType: "JSON",
        success: function (result) {

            if (result[0].response == "Expired") {
                toastr["warning"]("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({
                    "display": "block"
                });
               window.location.href = "logout.php";
            } else if (result[0].response == "Failed") {
                toastr["warning"]("Oops! Current operation fails. Kindly try again.", "Operation Failed");
            } else if (result[0].response == "Exceeds") {
                toastr["warning"]("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
            } else if (result[0].response == "Invalid") {
                toastr["warning"]("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
            } else if (result[0].response == "Success") {
                toastr["success"]("Great! You've successfully updated record information", "Operation Success");
                $("#editInfoBtn")["click"]();
                GetData();
            } else {
                toastr["warning"]("Oops! Something went wrong. Kindly contact the administrator", "Operation Failed");
            }
            hide_loading("#contentBody");
        }

    });
}


// ----------------
// Contact Information 
// ----------------

function UpdateContact(e) {
    // e.preventDefault();
    $("#updateContactBtn").off("click", UpdateContact);

    clickContact++;
    if (clickContact > 1) return;
    
    show_loading("#contentBody");
    var company = encodeURIComponent($("#companyField").val()),
        fname1 = encodeURIComponent($("#fnameField").val()), 
        mname1 = encodeURIComponent($("#mnameField").val()), 
        lname1 = encodeURIComponent($("#lnameField").val()), 
        fname2 = encodeURIComponent($("#fnameField2").val()), 
        mname2 = encodeURIComponent($("#mnameField2").val()), 
        lname2 = encodeURIComponent($("#lnameField2").val()), 
        landline1 = encodeURIComponent($("#phoneField").val()), 
        landline2 = encodeURIComponent($("#phoneField2").val()), 
        mobile1 = encodeURIComponent($("#mobileField").val()), 
        mobile2 = encodeURIComponent($("#mobileField2").val()), 
        fax1 = encodeURIComponent($("#faxField").val()), 
        fax2 = encodeURIComponent($("#faxField2").val()), 
        email = encodeURIComponent($("#emailField").val()), 
        address = encodeURIComponent($("#addField").val()), 
        about = encodeURIComponent($("#aboutField").code()), 
        website = encodeURIComponent($("#webField").val()),
        code = encodeURIComponent($("#codeField").val());
    
    if (company == ""){
        toastr["warning"]("Oops! Kindly fill in company name", "Operation Failed");
        setTimeout(unlock, 2500);
        hide_loading("#contentBody");
        return;
    } 
    else if (email == ""){
        toastr["warning"]("Oops! Kindly fill in primary email", "Operation Failed");
        setTimeout(unlock, 2500);
        hide_loading("#contentBody");
        return; 
    } 
    

    var _post = "function=update_profile_info&company="+ company + "&fname1="+ fname1 + "&mname1="+ mname1 + "&lname1="+ lname1 + "&fname2=" + fname2 +
        "&mname2="+ mname2 +"&lname2=" + lname2 + "&landline1="+ landline1 + "&landline2=" + landline2 + "&mobile1="+ mobile1 + "&mobile2=" +
        mobile2 +"&fax1=" + fax1 + "&fax2=" + fax2 + "&email=" + email + "&address="+ address + "&website="+ website +
        "&about="+ about + "&merchantCode="+ code;

    $.ajax({
        type: "POST",
        url: "php/gateway.php",
        data: _post,
        cache: false,
        async: true,
        dataType: "JSON",
        success: function (result) {
            if (result[0].response == "Expired") {
                toastr["warning"]("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({
                    "display": "block"
                });
                window.location.href = "logout.php";
            } else {
                if (result[0].response == "Failed") {
                    toastr["warning"]("Oops! Current operation fails. Kindly try again.", "Operation Failed");
                    return;
                } else {
                    if (result[0].response == "Exceeds") {
                        toastr["warning"]("Oops! You've exceed file size upload. Kindly check your file.", "Operation Failed");
                        return;
                    } else {
                        if (result[0].response == "Invalid") {
                            toastr["warning"]("Oops! Your file is invalid. Kindly check it again.", "Operation Failed");
                            return;
                        } else {
                            if (result[0].response == "Success") {
                                toastr["success"]("Great! You've successfully updated record information", "Operation Success");
                                $("#cancelBtn")["click"]();
                                GetData();
                                return;
                            } else {
                                toastr["warning"]("Oops! Something went wrong. Kindly contact the administrator", "Operation Failed");
                                return;
                            }
                        }
                    }
                }
            }
        },
        error:  function(result) {  
            toastr['error']("Oops! An error occured. "+result, "Error Encounter");
            hide_loading("#contentBody");
        }
    });

    hide_loading("#contentBody");
   
    setTimeout(unlock, 2500);
    // console.log("click done");
}
 

// ----------------
// Password Information 
// ----------------
$("#initPassButton").on("click", InitPass);

function InitPass(e){
    // e.preventDefault(); 
    
    show_loading("#contentBody");
    if (!$("#newpassField").val() || !$("#repeatpassField").val() || !$("#curpassField").val()) {
        toastr["warning"]("Kindly fill all fields!", "warning");
        hide_loading("#contentBody");
        return;
    };
    if ($("#newpassField").val() != $("#repeatpassField").val()) {
        toastr["warning"]("New password does not match. Please check again.", "Password Mismatch");
        hide_loading("#contentBody");
        return;
    };
    var idiot = $("#newpassField").val();
    var bitch = /((^[0-9]+)|(^[a-z]+))+[0-9a-z]+$/i;
    if (!idiot.match(bitch)) {
        toastr["error"]("Kindly enter letters or numbers only for password. Special characters are not allowed.", "Error Password");
        hide_loading("#contentBody");
        return;
    };
    
    $("#callValidateButton")["click"](); 
}

 
function UpdatePass(e) {
    // e.preventDefault();
    $("#updatePassButton").off("click", UpdatePass);  
    
    clickPass++;
    if (clickPass > 1) return;
    
    var maggot = $("#curpassField").val();
    var mentos = $("#newpassField").val();

    show_loading("#contentBody");

    $("#validateCancelButton").click();
    var _post = "function=password&old_password=" + maggot + "&new_password="+ mentos;
    
    $.ajax({
        type: "POST",
        url: "php/gateway.php",
        data: _post,
        cache: false,
        async: true,
        dataType: "JSON",
        success: function (result) {
           // // console.log(result);
            if (result[0].response == "Incorrect") {
                toastr["error"]("Oops! Kindly check your current password.", "Password Incorrect")
            } else  if (result[0].response == "Failed") {
                toastr["error"]("System Error. Kindly contact your administrator.", "Action Failed")
            } else if (result[0].response == "Expired") {
                toastr["error"]("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({
                    "display": "block"
                });
               window.location.href = "logout.php";
                return;
            } else if (result[0].response == "Success") {
                toastr["success"]("Great! You successfully updated your password", "Update Complete");
                $("#curpassField").val('');
                $("#newpassField").val('');
                $("#repeatpassField").val('');
                $("#stackCancelButton").click();
            } 
            else {
                toastr["error"]("Oops! An error occured. Kindly contact the administrator", "Error");
            }

            hide_loading("#contentBody");
        }
        
    });

    setTimeout(unlockUpdatePass, 2500);
}


// -------------------
// Loyalty Information 
// -------------------

$("#initLoyaltyBtn").on("click", function () {
    // console.log("click");
    var base = $("#baseField").val(),
        points = $("#pointearnField").val(),
        regpoints  = $("#regField").val(),
        raffleEntry = $("#raffleEntryField").val(),
        raffleValue = $("#raffleValueField").val(),
        mulkey =  "0",
        mulamount =  "0",
        mulentry =  "0";

    var rafflestat = ($("#raffleStatField").is(':checked') == true) ? "active" : "inactive";


    // General Condition
    // Values Must not be empty 
    if ( base == "" || points == "" ||  regpoints == "" ||  
        raffleEntry == "" || raffleValue == "" || 
        mulkey == "" || mulamount == "" || mulentry == "") {

        toastr["warning"]("Kindly fill all fields!", "warning");
        hide_loading("#contentBody"); 
        return;
    }
    else if ( isNaN(base) || isNaN(points) ||  isNaN(regpoints) ||
        isNaN(raffleEntry ) || isNaN(raffleValue ) ||
        isNaN(mulkey ) || isNaN(mulamount ) || isNaN(mulentry) ) 
    {
        toastr["warning"]("Kindly input numbers only", "warning");
        hide_loading("#contentBody"); 
        return;
    }
    
    // Raffle Condition
    if (rafflestat == "active"){ 

        if (raffleEntry == 0 || raffleValue == 0){ 
            toastr["warning"]("You have activated raffle feature. Kindly fill in right values.", "warning");
            hide_loading("#contentBody"); 
            return;
        } 
    } 

    if (!MERCHANT_CODE) {
        toastr["warning"]("Oops! Some data were not fetch properly. Kindly check your internet and reload the page.", "warning");
        return;
    };

    $("#callLoyalValidateButton").click();
});


function UpdateLoyalty(e) {
    // e.preventDefault();
    $("#updateLoyaltySettings").off("click", UpdateLoyalty);
    
    clickLoyalty++;
    if (clickLoyalty > 1) return;
    
    show_loading("#contentBody");
    $("#passValidationCancelButton").click(); 
    var rafflestatus = ($("#raffleStatField").is(":checked") == true) ? "active" : "inactive";

    var _post = "function=update_profile_loyalty&merchantCode=" + MERCHANT_CODE 
    + "&baseValue="+ $("#baseField").val() + "&basePoint="+ $("#pointearnField").val() + "&regPoint="+ $("#regField").val() 
    + "&raffleValue=" + $("#raffleValueField").val() +"&raffleEntry="+ $("#raffleEntryField").val() +
        "&raffleStatus="+ rafflestatus 
    + "&nonCash_status=inactive&nonCash_key=0&baseValue_nonCash=0&basePoint_nonCash=0";
    // console.log(_post);
    $.ajax({
        type: "POST",
        url: "php/gateway.php",
        data: _post,
        cache: false,
        async: true,
        dataType: "JSON",
        success: function (result) {

            hide_loading("#contentBody");

            if (result[0].response == "Incorrect") {
                toastr["error"]("Oops! Kindly check your current password.", "Password Incorrect");
            } else if (result[0].response == "Failed") {
                toastr["error"]("System Error. Kindly contact your administrator.", "Action Failed");
            } else if (result[0].response == "Expired") {
                toastr["error"]("Oops! Your account has expired. Kindly login again.", "Session Expired");
                $(".preloader-wrapper").css({
                    "display": "block"
                });
               window.location.href = "logout.php";
                return;
            } else if (result[0].response == "Success") {
                toastr["success"]("Great! You successfully updated loyalty settings", "Update Complete");
                $("#curpassField").val();
                $("#newpassField").val();
                $("#repeatpassField").val();
                $("#stackCancelButton")["click"]();
            } 
            else {
                toastr["error"]("Oops! An error occured. Kindly contact the administrator", "Error");
            }

        }
     
    });

    setTimeout(unlockLoyalty, 2500);
}


