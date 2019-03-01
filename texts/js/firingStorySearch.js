// if we were sent here by the glossLinking, we need to fire this when the page loads to run the search of 
// the story corpus
$(document).ready(function () {
    $("#searchButton").click();
});

// fire a search when a user hits the 'enter' key
document.getElementById("storySearch").addEventListener("keypress", function (e) {
    if (e.keyCode === 13 || e.which === 13) {
        $("#searchButton").click();
    }
});