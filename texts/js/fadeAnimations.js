// when the page loads, fade in its content, which is stored in a div with the class hidden
$(document).ready(function () {
  $(".hidden").fadeIn(1000);
});

// when the user leaves a page, fade out its content
window.addEventListener("beforeunload", function (event) {
  $(document.body).fadeOut(600);
});