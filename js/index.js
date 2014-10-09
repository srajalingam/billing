/**
 *  Index page javascript functionalities goes here	
 */
 
	// get all registered shop details on page load
	$(window).on("load", function() {
		if((typeof($.cookie("alert")) !== "undefined")) {
			var alert = $.cookie("alert");
			$("#alert_msg").html(alert);
		}
		/* $.ajax({
			url : "php/request.php?msg=allShops",
			type : "POST",
			success : function(result) {
				var obj_result = $.parseJSON(result);
				if(obj_result.status === "success") {
					$.each(obj_result.message, function(key, value) {
						var shop = $("#shop_details");
						$(shop).append("a").attr
						var shop_name = $(shop).find("h3").html(value.name);
						var owner = $(shop).find("label").append(value.owner);
						var shop_address = $(shop).find("p").html(value.address);
					});
				} else {
					if(obj_result.errors != "") {
						$("#error_message").html(obj_result.errors);
					}
					$("#status_message").html(obj_result.message);
				}
			},
			error : function() {
				alert("request not send");
			}
		}); */
	});
	
	// shop registration details validation and ajax to insert the shop details	
	$("#shop_submit").on("click", function(e) {
		e.preventDefault();
		shopValidation();
		shopRegistration();
	});
	
	var shopValidation = function() {
		$("#shop_registration").validate({
			rules:{
				"shop":{
					required:true
				},
				"owner":{
					required:true
				},
				"address":{
					required:true
				},
				"email":{
					required:true,
					email:true
				},
				"phone":{
					required:true,
					number:true
				},
				"mobile":{
					required:true,
					number:true,
					maxlength:10
				}
			}, 
			messages:{
				"shop":{
					required:"Please enter the shop name"
				},
				"owner":{
					required:"Please enter the owner name"
				},
				"address":{
					required:"Please enter the shop address"
				},
				"email":{
					required:"Please enter the email id",
					email:"Please enter the valid email id"
				},
				"phone":{
					required:"Please enter the phone number",
					number:"Please enter the valid phone number"
				},
				"mobile":{
					required:"Please enter the mobile number",
					number:"Please enter the valid mobile number",
					maxlength:"Please enter the 10 digit mobile number"
				}
			},
			debug:true
		});
	}

	var shopRegistration = function() {
		$.ajax({
			url : "php/request.php?msg=addShop",
			data : {
				'shop' : $("#shop").val(),
				'owner' : $("#owner").val(),
				'address' : $("#address").val(),
				'email' : $("#email").val(),
				'phone' : $("#phone").val(),
				'mobile' : $("#mobile").val()
			},
			type : "POST",
			success : function(result) {
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
			error : function() {
				alert("Invalid request..!");
			}
		});
	}

