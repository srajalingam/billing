// get the new bill id and current date to insert the new bill

var bill_item = [];
var session_value;
var item_rate;


	$(window).on("load", function() {
		session_value = readCookie("PHPSESSID");
		// function to get the bill llist and new bill id and date
		$.ajax({
			url: "php/request.php?c=billing",
			type: "POST",
			data: {
				mtd: "loadBill",
				session_id: session_value
			},
			success: function(response) {
				var result = $.parseJSON(response);
				if(result.status === "success") {
					$("#bill_id").val(result.response.bill_id);
					$("#bill_date").val(result.response.bill_date);
					// console.log(result.response.items);
					// auto suggest for items comes here
					$("#item").autocomplete({
						source: result.response.items
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
	
	// get the amount of item after item
		$("#item").focusout(function() {
			var item = $(this).val();
			if(item) {
				$.ajax({
					url: "php/request.php?c=items",
					type: "POST",
					data: {
						mtd: "itemDetails",
						item_name: item
					},
					success: function(response) {
						var result = $.parseJSON(response);
						
						item_rate = result.response.item_details.rate;
						$("#item_id").val(result.response.item_details.item_id);
						$("#item").val(result.response.item_details.name);
						$("#qty_value").attr("placeholder", result.response.item_details.quantity);
						$("#qty_unit").val(result.response.item_details.qty_unit).sel;
						$("#rate").attr("placeholder", item_rate);
					},
					error: function() {
						alert("Invalid request");
					}
				});
			} else {
				console.log("No item");
			}
		});
		
		// calculate the amount from qty and rate
		$("#qty_value").on("keyup", function() {
			var qty = $("#qty_value").val();
			var rate = qty * item_rate;
			$("#rate").val(rate);
		});
		
		// add bill items into an array to insert the total bill items in DB
		$("#add_item").on("click", function() {
			var item_details = {
				item_id: $("#item_id").val(),
				item: $("#item").val(),
				qty_value: $("#qty_value").val(),
				qty_unit: $("#qty_unit").val(),
				rate: $("#rate").val()
			}
			bill_item.push(item_details);

			$(".items").val("");
			$(".items").attr("placeholder", "");
			// append the old item list to table
			$("#items_added").append("<tr><td>"+item_details.item+"</td><td>"+item_details.qty_value+"</td><td>"+item_details.qty_unit+"</td><td>"+item_details.rate+"</td><td><input type='button' name='remove_item' id='remove_item' value='Remove'></td></tr>");
		});
		
		// remove the items from the table list 
		// TODO : remove the list from the array
		$("#items_added").on("click", "#remove_item", function() {
			var this_item = $(this).parent().parent();
			this_item.remove();
		});
		
		// validate and insert the items bill submit
		$("#bill_submit").on("click", function(e) {
			// e.preventDefault();
			validateBilling();
		});
		
		var validateBilling = function() {
		$("#bill_form").validate({
			rules: {
				bill_id: {
					required: true
				},
				bill_date: {
					required: true
				},
				bill_name: {
					required: true
				},
				remarks: {
					required: true
				},
				bill_by: {
					required: true
				}
			},
			messages: {
				bill_id: {
					required: "Bill id is a required field"
				},
				bill_date: {
					required: "Bill date is a required field"
				},
				bill_name: {
					required: "Bill name is a required field"
				},
				remarks: {
					required: "Bill remarks is a required field"
				},
				bill_by: {
					required: "Bill by is a required field"
				}
			},
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},
			submitHandler: function(form) {
				insertBilling();
			}
		});
	}
	
	var insertBilling = function() {
		console.log(bill_item);
		var bill_data = {
			mtd: "newBilling",
			session_id: session_value,
			bill_id: $("#bill_id").val(),
			bill_date: $("#bill_date").val(),
			bill_name: $("#bill_name").val(),
			remarks: $("#remarks").val(),
			bill_by: $("#bill_by").val(),
			items: bill_item
		}
		
		$.ajax({
			url: "php/request.php?c=billing",
			type: "POST",
			data: bill_data,
			success: function(response) {
				var result = $.parseJSON(response);
				if(result.status === "success") {
					alert(result.response.msg);
					window.location = "";
				} else {
					alert(result.response.msg);
				}
			}
		});
	}
	
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