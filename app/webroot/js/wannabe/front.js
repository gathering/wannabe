$(document).ready(function() {
	document.createElement('header');
    $("#changeevent").bind("click", function (event) {$.ajax({async:true, dataType:"html", success:function (data, textStatus) {$("#modal").modal("show");window.location.hash="#event";$("#modal").html(data);}, url:"\/"+eventREF+"\/Event"});
        return false;
    });
    $("#createuser").bind("click", function (event) {$.ajax({async:true, dataType:"html", success:function (data, textStatus) {$("#modal").modal("show");window.location.hash="#register";$("#modal").html(data);}, url:"\/"+eventREF+"\/User\/Register"});
        return false;
    });
    $("#forgotpassword").bind("click", function (event) {$.ajax({async:true, dataType:"html", success:function (data, textStatus) {$("#modal").modal("show");window.location.hash="#forgot";$("#modal").html(data);}, url:"\/"+eventREF+"\/User\/Forgot"});
        return false;
    });
    $("#modal").bind("hidden", function (event) {window.location.hash="#";
        return false;
    });
	$("#modal").modal({
		closeOnEscape: true,
		backdrop: true,
		keyboard: true
	});
	if (!("autofocus" in document.createElement("input"))) {
		if($('#UserUsername').val().length == 0) $('#UserUsername').focus();
		else $('#UserPassword').focus();
	}
	if(location.hash.substr(1) == "register") {
		$('#createuser').click();
	}
    if(location.hash.substr(1) == "event") {
        $('#changeevent').click();
    }
    if(location.hash.substr(1) == "forgot") {
        $('#forgotpassword').click();
    }
});
