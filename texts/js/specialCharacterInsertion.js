// prime with empty jQuery object
window.prevFocus = $();

// Catch any bubbling focusin events (focus does not bubble)
$(document).on('focusin', ':input', function () {

	// Test: Show the previous value/text so we know it works!
	$("#prev").html(prevFocus.val() || prevFocus.text());

	// Save the previously clicked value for later
	window.prevFocus = $(this);
});

// if a special character is clicked on, add it to the previously focused element and return focus to that element
var specialCharacters = document.getElementsByClassName("specialCharacter");
for (var c = 0; c < specialCharacters.length; c++) {
	specialCharacters[c].addEventListener('click', function () {
		window.prevFocus[0].value = window.prevFocus[0].value + this.innerText;
		window.prevFocus.keyup();
		window.prevFocus.focus();
	});

}
	// this occasionally throws errors. It seems to not like the navbar links sending the user to different parts of the page.
	// it still works and inserts special characters, so I will ignore these errors for now. IT seems to throw an error 
	// if prevFocus has not been changed