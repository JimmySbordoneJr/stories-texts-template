// This script is the mechanism behind the button that allows you to toggle all of the glosses at once.
// We need it to take an optional input that is the carousel slide number in cases of more than one story,
// so that we don't try to open all glosses in all story versions at once.

// email Jimmy Sbordone Jr. at jsbordone96@gmail.com with any questions or suggestions!


//if buttonPresses is even, we open all of the glosses. If it is odd, we close them all. 
var buttonPresses = 1;

function toggleAllGlosses(idAddOn) {
	// build some IDs to getElementsBy
	//var toggleAllButtonId = "toggleAllButton";
	var glossId = "gloss";
	var translationId = "translation";
	// check to see if it is the main story, in which case we don't do anything. If idAddOn is not blank, this
	// must be one of the other story versions, and we must add idAddOn to these three variables
	if (idAddOn !== undefined) {
		//toggleAllButtonId += idAddOn;
		glossId += idAddOn;
		translationId += idAddOn;
	}

	// get the button 
	//var toggleAllButton = document.getElementById(toggleAllButtonId);

	// get all of the glosses
	var glosses = document.getElementsByClassName(glossId);
	var translations = document.getElementsByClassName(translationId);

	// how the toggle all button actually works

	// increase buttonPresses by one
	buttonPresses++;
	// if buttonPresses is even...
	if (buttonPresses % 2 === 0) {
		// show each gloss and hide each translation.
		for (var i = 0; i < glosses.length; i++) {
			$(glosses[i]).collapse("show");
			$(translations[i]).collapse("hide");
		}
	}

	// if buttonPresses is odd...
	else {
		// hide each gloss and show each translation.
		for (var j = 0; j < glosses.length; j++) {
			$(glosses[j]).collapse("hide");
			$(translations[j]).collapse("show");
		};
	};
};
