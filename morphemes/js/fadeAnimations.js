// This code fades the page in when the user opens the page, and 
// fades the page out when the user leaves the page. 
$(document).ready(function () {
  $(".hidden").fadeIn(1000);
});

window.addEventListener("beforeunload", function (event) {
  $(document.body).fadeOut(600);
});