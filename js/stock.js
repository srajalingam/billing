	
var session_value;

	$(window).on("load", function() {
		session_value = readCookie("PHPSESSID");
		// function to get the purchase llist and new purchase id and date
		$.ajax({
			url: "php/request.php?c=stock",
			type: "POST",
			data: {
				mtd: "stockLlist",
				session_id: session_value
			},
			success: function(response) {
				var count_color;
				var result = $.parseJSON(response);
				if(result.status === "success") {
					var stocks = $("#all_stocks_table");
					$.each(result.response.stock, function(key, value) {
						if(value.qty_count < 2) {
							count_color = "red";
						} else if(value.qty_count < 8 && value.qty_count > 2) {
							count_color = "orange";
						} else {
							count_color = "green";
						}
						stocks.append("<tr>");
						stocks.append("<td>"+value.name+"</td>");
						stocks.append("<td>"+value.category+"</td>");
						stocks.append("<td>"+value.product+"</td>");
						stocks.append("<td>"+value.quantity+"</td>");
						stocks.append("<td>"+value.qty_unit+"</td>");
						stocks.append("<td>"+value.rate+"</td>");
						stocks.append("<td style='color: "+count_color+";'>"+value.qty_count+"</td>");
						stocks.append("</tr>");
					});
				} else {
					alert(result.response.message);
				}
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