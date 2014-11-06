// get the new purchase id and current date to insert the new purchase

var purchase_item = [];
var session_value;
var item_rate;


	$(window).on("load", function() {
		session_value = readCookie("PHPSESSID");
		// function to get the purchase llist and new purchase id and date
		$.ajax({
			url: "php/request.php?c=purchase",
			type: "POST",
			data: {
				mtd: "loadPurchase",
				session_id: session_value
			},
			success: function(response) {
				var result = $.parseJSON(response);
				if(result.status === "success") {
					$("#purchase_id").val(result.response.purchase_id);
					$("#purchase_date").val(result.response.purchase_date);
					// console.log(result.response.items);
					// auto suggest for items comes here
					$("#item").autocomplete({
						source: result.response.items
					});
					purchaseListTable(result.response.purchase_list);
				} else {
					alert(result.response.message);
				}
			},
			error: function() {
				alert("Request not send try again");
				window.location("dashboard.php");
			}
		});
		
		// table purchase list on page load 
		var purchaseListTable = function(arr_purchase) {
			var purchase = $("#all_purchase_table");
			$.each(arr_purchase, function(key, value) {
				purchase.append("<tr>");
				purchase.append("<td>"+value.purchase_id+"</td>");
				purchase.append("<td>"+value.purchase_date+"</td>");
				purchase.append("<td>"+value.purchase_from+"</td>");
				purchase.append("<td>"+value.items_purchased+"</td>");
				purchase.append("<td>view</td>");
				purchase.append("</tr>");
			});
		}
		
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
		
		// add purchase items into an array to insert the total purchase items in DB
		$("#add_item").on("click", function() {
			var item_details = {
				item_id: $("#item_id").val(),
				item: $("#item").val(),
				qty_value: $("#qty_value").val(),
				qty_unit: $("#qty_unit").val(),
				rate: $("#rate").val()
			}
			purchase_item.push(item_details);
			console.log(purchase_item);
			$(".items").val("");
			$(".items").attr("placeholder", "");
			// append the old item list to table
			$("#items_added").append("<tr id='"+item_details.item_id+"'><td>"+item_details.item+"</td><td>"+item_details.qty_value+"</td><td>"+item_details.qty_unit+"</td><td>"+item_details.rate+"</td><td><input type='button' name='remove_item' id='remove_item' value='Remove'></td></tr>");
		});
		
		// remove the items from the table list 
		// TODO : remove the list from the array
		$("#items_added").on("click", "#remove_item", function() {
			var this_item = $(this).parent().parent();
			var item_details = {
				item_id: this_item.attr('id'),
				item: this_item.find('td:eq(0)').html(),
				qty_value: this_item.find('td:eq(1)').html(),
				qty_unit: this_item.find('td:eq(2)').html(),
				rate: this_item.find('td:eq(3)').html(),
			}
			console.log(item_details);
			if($.inArray(item_details, purchase_item)) {
				purchase_item.pull(item_details);
			}
			console.log(purchase_item);
			// var remove_item = find('td:eq(0)').html()
			this_item.remove();
		})
		
		// validate and insert the items purchase submit
		$("#item_submit").on("click", function(e) {
			// e.preventDefault();
			validatePurchase();
		});
		
		// calculate the amount from qty and rate
		$("#qty_value").on("keyup", function() {
			var qty = $("#qty_value").val();
			var rate = qty * item_rate;
			$("#rate").val(rate);
		});
		
	});
	
	$("#create_purchase").on("click", function() {
		$("#all_purchase").hide();
		$("#new_purchase").show();
	});
	
	$("#back_purchase_list").on("click", function() {
		$("#all_purchase").show();
		$("#new_purchase").hide();
	});
	
	var validatePurchase = function() {
		$("#purchase_form").validate({
			rules: {
				purchase_id: {
					required: true
				},
				purchase_date: {
					required: true
				},
				purchase_from: {
					required: true
				},
				remarks: {
					required: true
				},
				purchase_by: {
					required: true
				}
			},
			messages: {
				purchase_id: {
					required: "Purchase id is a required field"
				},
				purchase_date: {
					required: "Purchase date is a required field"
				},
				purchase_from: {
					required: "Purchase from is a required field"
				},
				remarks: {
					required: "Purchase remarks is a required field"
				},
				purchase_by: {
					required: "Purchase by is a required field"
				}
			},
			errorPlacement: function(error, element) {
				error.appendTo(element.parent());
			},
			submitHandler: function(form) {
				insertPurchase();
			}
		});
	}
	
	var insertPurchase = function() {
		console.log(purchase_item);
		var purchase_data = {
			mtd: "newPurchase",
			session_id: session_value,
			purchase_id: $("#purchase_id").val(),
			purchase_date: $("#purchase_date").val(),
			purchase_from: $("#purchase_from").val(),
			remarks: $("#remarks").val(),
			purchase_by: $("#purchase_by").val(),
			items: purchase_item
		}
		
		$.ajax({
			url: "php/request.php?c=purchase",
			type: "POST",
			data: purchase_data,
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
		