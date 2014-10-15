// get the new purchase id and current date to insert the new purchase
$(window).on("load", function() {
	var session_value = readCookie("PHPSESSID")
	$.ajax({
		url: "php/request.php?c=purchase",
		type: "POST",
		data: {
			session_id: session_value,
			mtd: "loadPurchase"
		},
		success: function(result_data) {
			
		},
		error: function() {
			alert("Request not send try again");
			window.location("dashboard.php");
		}
	});
});

	function readCookie(name) {
		var nameEQ = escape(name) + "=";
		var ca = document.cookie.split(';');
		for (var i = 0; i < ca.length; i++) {
			var c = ca[i];
			while (c.charAt(0) === ' ') c = c.substring(1, c.length);
			if (c.indexOf(nameEQ) === 0) return unescape(c.substring(nameEQ.length, c.length));
		}
		return null;
	}