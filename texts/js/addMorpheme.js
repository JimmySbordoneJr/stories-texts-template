// In the update page, these functions power the 'add morpheme' buttons.
function addMorpheme(id) {
	var fieldsetid = id.split("_")[0];
	var lineNumber = fieldsetid.split("line")[1];
	var morphemeNumber = parseInt(id.split("m")[1]);
	var mRowNumber = Math.ceil((morphemeNumber - 1) / 4);

	// loop through rest of morphemes and adjust the morpheme, gloss, delete button, and addMorpheme button
	var morphemes = document.getElementsByClassName(("line" + lineNumber + "_morpheme"));

	var morphemeCounter = morphemes.length;

	for (var x = morphemeCounter; x >= morphemeNumber; x--) {
		// morpheme id name onkeyup 
		var currentMorpheme = document.getElementById(fieldsetid + "_m" + x);
		currentMorpheme.setAttribute("id", (fieldsetid + "_m" + (x + 1)));
		currentMorpheme.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(4)) - 1) + "][morpheme][" + x + "][m]"));
		currentMorpheme.setAttribute("onkeyup", ("suggest(this.value,'" + fieldsetid + "_g" + (x + 1) + "')"));

		// gloss id name list
		var currentGloss = document.getElementById(fieldsetid + "_g" + x);
		currentGloss.setAttribute("id", (fieldsetid + "_g" + (x + 1)));
		currentGloss.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(4)) - 1) + "][morpheme][" + x + "][g]"));
		currentGloss.setAttribute("list", ("list_" + fieldsetid + "_g" + (x + 1)));

		// datalist id
		var currentDatalist = document.getElementById("list_" + fieldsetid + "_g" + x);
		currentDatalist.setAttribute("id", ("list_" + fieldsetid + "_g" + (x + 1)))

		// delete button id onclick innerHTML
		var currentDeleteButton = document.getElementById("delete_" + fieldsetid + "_m" + x);
		currentDeleteButton.setAttribute("id", ("delete_" + fieldsetid + "_m" + (x + 1)));
		currentDeleteButton.setAttribute("onclick", ("deleteMorpheme('" + (fieldsetid + "_" + "m" + (x + 1)) + "')"));
		currentDeleteButton.innerHTML = "<i class=\"fas fa-trash-alt fa-lg\"></i>&nbsp;Morpheme " + (x + 1);

		// addmorphemebutton id onclick
		var currentAddMorphemeButton = document.getElementById("addMorpheme_" + fieldsetid + "_m" + x);
		currentAddMorphemeButton.setAttribute("id", ("addMorpheme_" + fieldsetid + "_m" + (x + 1)));
		currentAddMorphemeButton.setAttribute("onclick", ("addMorpheme('" + (fieldsetid + "_" + "m" + (x + 2)) + "')"));
	}

	mRow = document.getElementById(("line" + lineNumber + "_mRow" + mRowNumber));
	gRow = document.getElementById(("line" + lineNumber + "_gRow" + mRowNumber));
	dRow = document.getElementById(("line" + lineNumber + "_dRow" + mRowNumber));

	newMInput = document.createElement("input");
	newMInput.setAttribute("id", id);
	newMInput.className = "line" + lineNumber + "_morpheme form-control";
	newMInput.setAttribute("type", "text");
	newMInput.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(4)) - 1) + "][morpheme][" + (morphemeNumber - 1) + "][m]"));
	newMInput.setAttribute("onkeyup", ("suggest(this.value,'" + fieldsetid + "_g" + morphemeNumber + "')"));

	newGInput = document.createElement("input");
	newGInput.className = "line" + lineNumber + "_gloss form-control";
	newGInput.setAttribute("id", id.replace("m", "g"));
	newGInput.setAttribute("type", "text");
	newGInput.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(4)) - 1) + "][morpheme][" + (morphemeNumber - 1) + "][g]"));
	newGInput.setAttribute("list", ("list_" + fieldsetid + "_g" + morphemeNumber));

	newDatalist = document.createElement("datalist");
	newDatalist.setAttribute("id", ("list_" + fieldsetid + "_g" + morphemeNumber));
	document.getElementById("datalistContainer").appendChild(newDatalist);

	newDeleteButton = document.createElement("a");
	newDeleteButton.className = "btn btn-danger " + "line" + lineNumber + "_delete";
	newDeleteButton.id = "delete_" + (fieldsetid + "_" + "m" + morphemeNumber);
	newDeleteButton.setAttribute("onclick", ("deleteMorpheme('" + (fieldsetid + "_" + "m" + morphemeNumber) + "')"));
	newDeleteButton.innerHTML = "<i class=\"fas fa-trash-alt fa-lg\"></i>&nbsp;Morpheme " + morphemeNumber;

	newAddMorphemeButton = document.createElement("a");
	newAddMorphemeButton.className = "btn btn-info " + "line" + lineNumber + "_add";
	newAddMorphemeButton.id = "addMorpheme_" + id;
	newAddMorphemeButton.setAttribute("onclick", ("addMorpheme('" + (fieldsetid + "_" + "m" + (morphemeNumber + 1)) + "')"));
	newAddMorphemeButton.innerHTML = "<i class='fas fa-plus'></i>";

	var nextMorpheme = document.getElementById((fieldsetid + "_" + "m" + (morphemeNumber + 1)));
	if (nextMorpheme) {
		nextMorpheme = nextMorpheme.parentNode;
		if (nextMorpheme.parentNode != mRow) {
			mRow = nextMorpheme.parentNode;
		}
	}
	var nextGloss = document.getElementById((fieldsetid + "_" + "g" + (morphemeNumber + 1)));
	if (nextGloss) {
		nextGloss = nextGloss.parentNode;
		if (nextGloss.parentNode != gRow) {
			gRow = nextGloss.parentNode;
		}
	}
	var nextDeleteButton = document.getElementById(("delete_" + fieldsetid + "_" + "m" + (morphemeNumber + 1)));
	if (nextDeleteButton) {
		nextDeleteButton = nextDeleteButton.parentNode;
		if (nextDeleteButton.parentNode != dRow) {
			dRow = nextDeleteButton.parentNode;
		}
	}

	mRow.insertBefore(newMInput, nextMorpheme);
	gRow.insertBefore(newGInput, nextGloss);
	dRow.insertBefore(newDeleteButton, nextDeleteButton);
	dRow.insertBefore(newAddMorphemeButton, nextDeleteButton);

	organizeMorphemeRows(lineNumber);
}

function addEditMorpheme(id) {
	var fieldsetid = id.split("_")[0];
	var lineNumber = fieldsetid.split("Line")[1];
	var morphemeNumber = parseInt(id.split("m")[1]);
	var mRowNumber = Math.ceil((morphemeNumber - 1) / 4);
	var morphemes = document.getElementsByClassName(("editLine" + lineNumber + "_editMorpheme"));
	var morphemeCounter = morphemes.length;

	for (var x = morphemeCounter; x >= morphemeNumber; x--) {
		// morpheme id name onkeyup 
		var currentMorpheme = document.getElementById(fieldsetid + "_m" + x);
		currentMorpheme.setAttribute("id", (fieldsetid + "_m" + (x + 1)));
		currentMorpheme.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(8)) - 1) + "][morpheme][" + x + "][m]"));
		currentMorpheme.setAttribute("onkeyup", ("suggest(this.value,'" + fieldsetid + "_g" + (x + 1) + "')"));

		// gloss id name list
		var currentGloss = document.getElementById(fieldsetid + "_g" + x);
		currentGloss.setAttribute("id", (fieldsetid + "_g" + (x + 1)));
		currentGloss.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(8)) - 1) + "][morpheme][" + x + "][g]"));
		currentGloss.setAttribute("list", ("list_" + fieldsetid + "_g" + (x + 1)));

		// datalist id
		var currentDatalist = document.getElementById("list_" + fieldsetid + "_g" + x);
		currentDatalist.setAttribute("id", ("list_" + fieldsetid + "_g" + (x + 1)))

		// delete button id onclick innerHTML
		var currentDeleteButton = document.getElementById("delete_" + fieldsetid + "_m" + x);
		currentDeleteButton.setAttribute("id", ("delete_" + fieldsetid + "_m" + (x + 1)));
		currentDeleteButton.setAttribute("onclick", ("deleteEditMorpheme('" + (fieldsetid + "_" + "m" + (x + 1)) + "')"));
		currentDeleteButton.innerHTML = "<i class=\"fas fa-trash-alt fa-lg\"></i>&nbsp;Morpheme " + (x + 1);

		// addmorphemebutton id onclick
		var currentAddMorphemeButton = document.getElementById("addEditMorpheme_" + fieldsetid + "_m" + x);
		currentAddMorphemeButton.setAttribute("id", ("addEditMorpheme_" + fieldsetid + "_m" + (x + 1)));
		currentAddMorphemeButton.setAttribute("onclick", ("addEditMorpheme('" + (fieldsetid + "_" + "m" + (x + 2)) + "')"));
	}

	mRow = document.getElementById(("editLine" + lineNumber + "_editMRow" + mRowNumber));
	gRow = document.getElementById(("editLine" + lineNumber + "_editGRow" + mRowNumber));
	dRow = document.getElementById(("editLine" + lineNumber + "_editDRow" + mRowNumber));

	newMInput = document.createElement("input");
	newMInput.setAttribute("id", id);
	newMInput.className = "editLine" + lineNumber + "_editMorpheme form-control";
	newMInput.setAttribute("type", "text");
	newMInput.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(8)) - 1) + "][morpheme][" + (morphemeNumber - 1) + "][m]"));
	newMInput.setAttribute("onkeyup", ("suggest(this.value,'" + fieldsetid + "_g" + morphemeNumber + "')"));

	newGInput = document.createElement("input");
	newGInput.className = "editLine" + lineNumber + "_editGloss form-control";
	newGInput.setAttribute("id", id.replace('m', 'g'));
	newGInput.setAttribute("type", "text");
	newGInput.setAttribute("name", ("line[" + (parseInt(fieldsetid.slice(8)) - 1) + "][morpheme][" + (morphemeNumber - 1) + "][g]"));
	newGInput.setAttribute("list", ("list_" + fieldsetid + "_g" + morphemeNumber));

	newDatalist = document.createElement("datalist");
	newDatalist.setAttribute("id", ("list_" + fieldsetid + "_g" + morphemeNumber));
	document.getElementById("datalistEditContainer").appendChild(newDatalist);

	newDeleteButton = document.createElement('a');
	newDeleteButton.className = "btn btn-danger " + "editLine" + lineNumber + "_editDelete";
	newDeleteButton.id = "delete_" + (fieldsetid + "_" + "m" + morphemeNumber);
	newDeleteButton.setAttribute("onclick", ("deleteEditMorpheme('" + (fieldsetid + "_" + "m" + morphemeNumber) + "')"));
	newDeleteButton.innerHTML = "<i class='fas fa-trash-alt fa-lg'></i>&nbsp;Morpheme " + morphemeNumber;

	newAddMorphemeButton = document.createElement("a");
	newAddMorphemeButton.className = "btn btn-info " + "editLine" + lineNumber + "_editAdd";
	newAddMorphemeButton.id = "addEditMorpheme_" + id;
	newAddMorphemeButton.setAttribute("onclick", ("addEditMorpheme('" + (fieldsetid + "_" + "m" + (morphemeNumber + 1)) + "')"));
	newAddMorphemeButton.innerHTML = "<i class='fas fa-plus'></i>";

	var nextMorpheme = document.getElementById((fieldsetid + "_" + "m" + (morphemeNumber + 1)));
	if (nextMorpheme) {
		nextMorpheme = nextMorpheme.parentNode;
		if (nextMorpheme.parentNode != mRow) {
			mRow = nextMorpheme.parentNode;
		}
	}
	var nextGloss = document.getElementById((fieldsetid + "_" + "g" + (morphemeNumber + 1)));
	if (nextGloss) {
		nextGloss = nextGloss.parentNode;
		if (nextGloss.parentNode != gRow) {
			gRow = nextGloss.parentNode;
		}
	}
	var nextDeleteButton = document.getElementById(("delete_" + fieldsetid + "_" + "m" + (morphemeNumber + 1)));
	if (nextDeleteButton) {
		nextDeleteButton = nextDeleteButton.parentNode;
		if (nextDeleteButton.parentNode != dRow) {
			dRow = nextDeleteButton.parentNode;
		}
	}

	mRow.insertBefore(newMInput, nextMorpheme);
	gRow.insertBefore(newGInput, nextGloss);
	dRow.insertBefore(newDeleteButton, nextDeleteButton);
	dRow.insertBefore(newAddMorphemeButton, nextDeleteButton);

	organizeMorphemeRows(lineNumber, "edit");
}