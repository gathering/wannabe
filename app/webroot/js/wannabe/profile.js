$(document).ready(function() {
	$('#UserPostcode').bind('focusout', function() {
		var country = $('#UserCountrycode').val();	
		var valid = {'NO':'','SE':'','DK':'','FI':'','NL':'','DE':'','US':'','BE':''};
		if(country in valid) {
			var pnr = $(this).val();
			$.get("http://infosystems.gathering.org/bring-api/postcode.php", {pnr : pnr, country : country},
				function(data) {
					var res = $.parseJSON(data);
					$('#UserTown').val(res.result);
			});
		}
	});
});
