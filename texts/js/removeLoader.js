// This code removes the loading animation once the page has loaded.

$(window).on("load", function () {
	setTimeout(function () { $("#loadingAnimation").fadeOut("slow") }, 1000);
	$("#loadingAnimation").remove();
});