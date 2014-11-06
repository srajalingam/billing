// function to check the user is logged in or not
$(window).on("load", function() {
	$.ajax({
		url: "php/request.php?c=shop",
		type: "POST",
		data: {
			mtd: "checkLogIN"
		},
		success: function(response) {
			var result = $.parseJSON(response);
			if(result.status !== "success") {
				// alert(result.msg);
				window.location = "index.php";
			}
		}
	});
});

$(".navigation").on("click", "li", function() {
	var file = $(this).attr("id");
	if(file === "logout") {
		$.post("php/request.php?c=shop", {"mtd": "logout"}, function(response) {
			var result = $.parseJSON(response);
			if(result.status === "success") {
				window.location = "index.php";
			}
		})
	} else {
		window.location = file+".php";
	}
});

/* $("body").click(function() {
	$("#menu_list").slideUp();
}); */

$("#menu").on("click", function() {
	$("#menu_list").toggle("slide");
});

