var qrcode = new QRCode(document.getElementById("qrcode"), {
    width: 150
    , height: 150
});

$(function () {
    GetData();
    PopulateContactInfo();

    $("#overviewTab").on("click", function () {
        GetData();
    });
    $("#accountTab").on("click", function () {
        PopulateContactInfo();
    });

});
var MERCHANT_CODE = "";

function GetData() {
    show_loading("#contentBody");

    var _post = "function=json&table=settings";
    $.ajax({
        type: "POST", 
        url: "php/gateway.php", 
        data: _post, 
        cache: false, 
        async: true, 
        dataType: "JSON", 
        success: function (result) {

            var data = result[0].data;
            if (data[0].result == "Incorrect") {
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
            
            //// console.log(result);
            $("#prof_image").attr("src", result[0].data[0].profilePic);
            $("#prof_company").text(result[0].data[0].company);
            $("#prof_website").html("<a href=" + result[0].data[0].website + " target='_blank'"> + result[0].data[0].website + "</a>");
            $("#prof_about").html(decodeURIComponent(result[0].data[0].about));
            $("#prof_email").html("<i></i> <a href='mailto:" + result[0].data[0].email + "> "+ result[0].data[0].email +" </a></i>");
            $("#prof_address").text(result[0].data[0].address);

            var contact = result[0].data[0].fname1 +  " " + result[0].data[0].mname1 + " "  +result[0].data[0].lname1;
            var contact2 = result[0].data[0].fname2 + " "  + result[0].data[0].mname2 +  " " + result[0].data[0].lname2;
            // console.log(contact2);
            var cute = "";
            if (contact) {
                cute += "<i></i> " + contact +" </i> ";
            };
            if (contact2 != null) {
                cute += "<br/><br/><i></i>  "+ contact2 +" </i>";
            };
            $("#prof_contact").html(cute);

            var igit = "";
            if (result[0].data[0].mobile1) {
                igit += "<i></i> " + result[0].data[0].mobile1 + "</i>";
            };
            if (result[0].data[0].mobile2) {
                igit += "<br/><i></i> " + result[0].data[0].mobile2 + "</i>";
            };
            $("#prof_mobile").html(igit);

            var taenimo = "";
            if (result[0].data[0].landline1) {
                taenimo += "<i></i> " + result[0].data[0].landline1 + "</i>";
            };
            if (result[0].data[0].landline2) {
                taenimo += "<br/><i></i>  "+ result[0].data[0].landline2 + "</i>";
            };
            $("#prof_landline").html(taenimo);

            var maggot = "";
            if (result[0].data[0].fax1) {
                maggot += "<i></i>"  + result[0].data[0].fax1 +" </i>";
            };
            if (result[0].data[0].fax2) {
                maggot += "<br/><i></i>"  + result[0].data[0].fax2 +" </i>";
            };
            $("#prof_fax").html(maggot);            
            $("#prof_code").html(result[0].data[0].merchantCode);


            $("#prof_baseValue").text(result[0].data[0].baseValue);
            $("#prof_basePoint").text(result[0].data[0].basePoint);
            $("#prof_regPoint").text(result[0].data[0].regPoint);

            // console.log(result[0].data[0].raffleStatus);
            if (result[0].data[0].raffleStatus == "inactive") {
                $("#prof_raffleStatus").removeClass("label-primary");
                $("#prof_raffleStatus").addClass("label-danger");
                $("#prof_raffleStatus").text("INACTIVE");
            } else {
                $("#prof_raffleStatus").removeClass("label-danger");
                $("#prof_raffleStatus").addClass("label-primary");
                $("#prof_raffleStatus").text("ACTIVE");
            };
            $("#prof_raffleValue").text(result[0].data[0].raffleValue);
            $("#prof_raffleEntry").text(result[0].data[0].raffleEntry);

            qrcode.makeCode(decodeURIComponent(result[0].data[0].merchantCode));
            MERCHANT_CODE = result[0].data[0].merchantCode;
        }
    });
    hide_loading("#contentBody");
}

function PopulateContactInfo() {
    show_loading("#contentBody");

    var _post = "function=json&table=settings";
    $.ajax({
        type: "POST",
        url: "php/gateway.php",
        data: _post,
        cache: false,
        async: true,
        dataType: "JSON",
        success: function (result) {
            var data = result[0].data[0];
            $("#companyField").val(data.company);
            $("#fnameField").val(data.fname1);
            $("#mnameField").val(data.mname1);
            $("#lnameField").val(data.lname1);
            $("#fnameField2").val(data.fname2);
            $("#mnameField2").val(data.mname2);
            $("#lnameField2").val(data.lname2);
            $("#phoneField").val(data.landline1);
            $("#phoneField2").val(data.landline2);
            $("#mobileField").val(data.mobile1);
            $("#mobileField2").val(data.mobile2);
            $("#faxField").val(data.fax1);
            $("#faxField2").val(data.fax2);
            $("#emailField").val(data.email);   
            $("#addField").val(data.address);
            $("#aboutField").code(decodeURIComponent(data.about));
            $("#webField").val(data.website);
            $("#baseField").val(data.baseValue);
            $("#pointearnField").val(data.basePoint);
            $("#regField").val(data.regPoint);           
            $("#codeField").val(data.merchantCode);

            if (data.multiplierStatus == "active") {
                $("#mulmodeField").attr({
                    "checked": true
                });
            } else {
                $("#mulmodeField").attr({
                    "checked": false
                });
            };
            $("#mulCountField").val(data.multiplierCount);
            $("#attemptField").val(data.attemptLimit);
            $("#mulKeyField").val(data.attemptLimit);
            if (data.raffleStatus == "active") {
                $("#raffleStatField").attr({
                    "checked": true
                });
            } else {
                $("#raffleStatField").attr({
                    "checked": false
                });
            };
            $("#raffleEntryField").val(data.raffleEntry);
            $("#raffleValueField").val(data.raffleValue);
            $("#imgPreview").attr({
                "src": data.profilePic
            });
            MERCHANT_CODE = data.merchantCode;
        }
    });
    hide_loading("#contentBody");
}
