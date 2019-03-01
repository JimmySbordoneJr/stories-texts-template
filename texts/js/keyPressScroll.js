// In the story display page, if there is more than one version
// of a story, you can click to cycle through the versions. This
// function lets you use the arrow keys to cycle through the version.
document.onkeyup = function (e) {
  if (e.which == 37) {
    $(".carousel-control-prev").click();
  } else if (e.which == 39) {
    $(".carousel-control-next").click();
  }
};