$(".dashboard").on("click", function() {
	var id = $(this).attr("id");
	window.location = id+".php";
});