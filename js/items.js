/**
 *  Items page functionalities goes here
 */
 
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
	
 // get all the inserted item details on page load
	$(window).on("load", function() {
		var session_value = readCookie("PHPSESSID");
		$.ajax({
			url: "php/request.php?c=items",
			type: "POST",
			data: {
				mtd: "allItems",
				session_id: session_value
			},
			success: function(result) {
				var obj_result = $.parseJSON(result);
				console.log(obj_result);
				if(obj_result.status === "success") {
					var items = $("#all_items_table");
					$.each(obj_result.message, function(key, value) {
						items.append("<tr>");
						items.append("<td>"+value.name+"</td>");
						items.append("<td>"+value.category+"</td>");
						// items.append("<td>"+value.sub_category+"</td>");
						items.append("<td>"+value.product+"</td>");
						items.append("<td>"+value.quantity+"</td>");
						items.append("<td>"+value.qty_unit+"</td>");
						items.append("<td>"+value.rate+"</td>");
						items.append("</tr>");
					});
				} else {
					if(obj_result.errors != "") {
						$("#error_message").html(obj_result.errors);
					}
					$("#status_message").html(obj_result.message);
				}
			},
			error: function() {
				alert("request not send");
			}
		});
	});
	
	$("#create_item").on("click", function() {
		$("#all_items").hide();
		$("#new_item").show();
	});
	
	$("#back_item_list").on("click", function() {
		$("#all_items").show();
		$("#new_item").hide();
	});
	
// validate and insert the new item
	$("#item_submit").on("click", function(e) {
		e.preventDefault();
		// itemValidation();
		itemInsertion();
	});
	
	var itemValidation = function() {
		$("#item_form").validate({
			rules:{
				"name":{
					required:true
				},
				"category":{
					required:true
				},
				// "sub_category":{
					// required:true
				// },
				"product":{
					required:true
				},
				"quantity":{
					required:true,
					number:true
				},
				"qty_unit":{
					required:true
				},
				"rate":{
					required:true,
					number:true
				}
			},
			messages:{
				"name":{
					required:"Please enter the item name"
				},
				"category":{
					required:"Please enter the category of item"
				},
				// "sub_category":{
					// required:"Please enter the sub-category of item"
				// },
				"product":{
					required:"Please enter the product of item"
				},
				"quantity":{
					required:"Please enter the quantity of item",
					number:"Please enter the valid quantity"
				},
				"qty_unit":{
					required:"Please select the unit for quantity"
				},
				"rate":{
					required:"Please enter the rate for item",
					number:"Please enter the valid number"
				}
			},
			debug:true
		});
	}
	
	var itemInsertion = function() {
		var session_value = readCookie("PHPSESSID");
		itemData = {
			mtd: "addItem",
			session_id: session_value,
			name: $("#name").val(),
			category: $("#category").val(),
			// sub_category: $("#sub_category").val(),
			product: $("#product").val(),
			quantity: $("#quantity").val(),
			qty_unit: $("#qty_unit").val(),
			rate: $("#rate").val()
		}
		
		$.ajax({
			url: "php/request.php?c=items",
			type: "POST",
			data: itemData,
			success: function(result) {
				var obj_result = $.parseJSON(result);
				if(obj_result.status === "success") {
					alert(obj_result.message);
					window.location = "";
				} else {
					if(obj_result.errors != "") {
						$("#error_message").html(obj_result.errors);
					}
					$("#status_message").html(obj_result.message);
				}
			},
			error: function() {
				alert("Invalid request..!");
			}
		});
		
	}