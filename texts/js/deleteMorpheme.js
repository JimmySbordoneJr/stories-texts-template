// In the update page, these functions power the 'delete morpheme' buttons.
function deleteMorpheme(id) {
	// delete a morpheme from the "Create Story" section
	var num = id.split("_")[1].split("m")[1];
	var glossId = id.replace("m", "g");
	var lineNumber = id.split("_")[0].split("line")[1];
	var morphemes = document.getElementsByClassName(("line" + lineNumber + "_morpheme"));
	var morphemeCounter = morphemes.length;
	var deleteButtonId = "delete_" + id;
	if (num == "1") {
		// if you want to delete the first morpheme, we will just clear its text, and not delete the element
		document.getElementById(id).value = "";
		document.getElementById(glossId).value = "";
		document.getElementById(("list_" + glossId)).innerHTML = "";
		// note, this is how all cases should work, and not just the case where the first morpheme is deleted. 
		// hindsight is 20/20... 

		// slide all of the values to left by one
		for (var n = 1; n < morphemeCounter; n++) {
			document.getElementById(("line" + lineNumber + "_m" + n)).value = document.getElementById(("line" + lineNumber + "_m" + (n + 1))).value;
			document.getElementById(("line" + lineNumber + "_g" + n)).value = document.getElementById(("line" + lineNumber + "_g" + (n + 1))).value;
			document.getElementById(("list_line" + lineNumber + "_g" + n)).innerHTML = document.getElementById(("list_line" + lineNumber + "_g" + (n + 1))).innerHTML
		}
		if (morphemeCounter > 1) {
			// now, delete the remaining empty input at the end
			var morphemeToDelete = document.getElementById(("line" + lineNumber + "_m" + n));
			morphemeToDelete.parentNode.removeChild(morphemeToDelete);

			// delete the gloss
			var glossToDelete = document.getElementById(("line" + lineNumber + "_g" + n));
			glossToDelete.parentNode.removeChild(glossToDelete);

			// delete the delete button
			var deleteButton = document.getElementById(("delete_line" + lineNumber + "_m" + n));
			deleteButton.parentNode.removeChild(deleteButton);

			// delete the addMorpheme button
			var addMorphemeButton = document.getElementById(("addMorpheme_line" + lineNumber + "_m" + n));
			addMorphemeButton.parentNode.removeChild(addMorphemeButton);

			// delete the autosuggestions
			var suggestions = document.getElementById(("list_line" + lineNumber + "_g" + n));
			suggestions.parentNode.removeChild(suggestions);
		}
	}
	else {
		// delete the source language morpheme			
		var morphemeToDelete = document.getElementById(id)
		morphemeToDelete.parentNode.removeChild(morphemeToDelete);

		// delete the gloss
		var glossToDelete = document.getElementById(glossId);
		glossToDelete.parentNode.removeChild(glossToDelete);

		// delete the autosuggestions
		var suggestions = document.getElementById(("list_" + glossId));
		suggestions.parentNode.removeChild(suggestions);

		// delete the delete button
		var deleteButton = document.getElementById(deleteButtonId);
		deleteButton.parentNode.removeChild(deleteButton);

		// delete the addMorpheme button
		var addMorphemeButton = document.getElementById(("addMorpheme_" + id));
		addMorphemeButton.parentNode.removeChild(addMorphemeButton);

		// adjust the rest of the morphemes after the one that was deleted
		for (var n = (parseInt(num) + 1); n <= morphemeCounter; n++) {
			// adjust morpheme by 1: id name onkeyup
			var idWithoutNumber = id.split("_")[0] + "_m";
			var idWithNumber = idWithoutNumber + (n - 1);
			var currentMorpheme = document.getElementById((idWithoutNumber + n));
			currentMorpheme.id = idWithNumber;
			currentMorpheme.name = currentMorpheme.name.split("morpheme")[0] + "morpheme][" + (n - 2) + "][m]";
			currentMorpheme.setAttribute("onkeyup", ("suggest(this.value, 'line" + lineNumber + "_g" + (n - 1) + "')"));

			// adjust gloss id name
			var glossIdWithoutNumber = glossId.split("_")[0] + "_g";
			var glossIdWithNumber = glossIdWithoutNumber + (n - 1);
			var currentGloss = document.getElementById((glossIdWithoutNumber + n));
			currentGloss.id = glossIdWithNumber;
			currentGloss.name = currentMorpheme.name.split("morpheme")[0] + "morpheme][" + (n - 2) + "][g]";
			currentGloss.setAttribute("list", ("list_" + glossIdWithNumber));

			// adjust delete button id onclick
			var currentDeleteButton = document.getElementById(("delete_" + (idWithoutNumber + n)));
			currentDeleteButton.id = "delete_" + idWithNumber;
			currentDeleteButton.setAttribute("onclick", ("deleteMorpheme('" + idWithNumber + "')"));
			currentDeleteButton.innerHTML = "<i class='fas fa-trash-alt fa-lg'></i>&nbsp;Morpheme " + (n - 1);

			// adjust addMorpheme button id onclick
			var currentAddMorphemeButton = document.getElementById(("addMorpheme_" + (idWithoutNumber + n)));
			currentAddMorphemeButton.id = "addMorpheme_" + idWithNumber;
			currentAddMorphemeButton.setAttribute("onclick", ("addMorpheme('" + (idWithoutNumber + n) + "')"));

			// adjust suggestions				
			var suggestions = document.getElementById(("list_" + (glossIdWithoutNumber + n)));
			suggestions.setAttribute("id", ("list_" + glossIdWithNumber));
		}
	}
	organizeMorphemeRows(lineNumber);
}

function deleteEditMorpheme(id) {
	// delete a morpheme from the "Edit Story" section. 
	var num = id.split("_")[1].split("m")[1];
	var glossId = id.replace("m", "g");
	var lineNumber = id.split("_")[0].split("Line")[1];
	var morphemes = document.getElementsByClassName(("editLine" + lineNumber + "_editMorpheme"));
	var morphemeCounter = morphemes.length;
	var deleteButtonId = "delete_" + id;

	if (num == "1") {
		// if you want to delete the first morpheme, we will just clear its text, and not delete the element
		document.getElementById(id).value = "";
		document.getElementById(glossId).value = "";
		document.getElementById(("list_" + glossId)).innerHTML = "";
		// note, this is how all cases should work, and not just the case where the first morpheme is deleted. 
		// hindsight is 20/20... 

		// slide all of the values to left by one
		for (var n = 1; n < morphemeCounter; n++) {
			document.getElementById(("editLine" + lineNumber + "_m" + n)).value = document.getElementById(("editLine" + lineNumber + "_m" + (n + 1))).value;
			document.getElementById(("editLine" + lineNumber + "_g" + n)).value = document.getElementById(("editLine" + lineNumber + "_g" + (n + 1))).value;
			document.getElementById(("list_editLine" + lineNumber + "_g" + n)).innerHTML = document.getElementById(("list_editLine" + lineNumber + "_g" + (n + 1))).innerHTML
		}
		if (morphemeCounter > 1) {
			// now, delete the remaining empty input at the end
			var morphemeToDelete = document.getElementById(("editLine" + lineNumber + "_m" + n));
			morphemeToDelete.parentNode.removeChild(morphemeToDelete);

			// delete the gloss
			var glossToDelete = document.getElementById(("editLine" + lineNumber + "_g" + n));
			glossToDelete.parentNode.removeChild(glossToDelete);

			// delete the delete button
			var deleteButton = document.getElementById(("delete_editLine" + lineNumber + "_m" + n));
			deleteButton.parentNode.removeChild(deleteButton);

			// delete the addMorpheme button
			var addMorphemeButton = document.getElementById(("addEditMorpheme_editLine" + lineNumber + "_m" + n));
			addMorphemeButton.parentNode.removeChild(addMorphemeButton);

			// delete the autosuggestions
			var suggestions = document.getElementById(("list_editLine" + lineNumber + "_g" + n));
			suggestions.parentNode.removeChild(suggestions);
		}
	}
	else {
		// delete the source language morpheme			
		var morphemeToDelete = document.getElementById(id)
		morphemeToDelete.parentNode.removeChild(morphemeToDelete);

		// delete the gloss
		var glossToDelete = document.getElementById(glossId);
		glossToDelete.parentNode.removeChild(glossToDelete);

		// delete the delete button
		var deleteButton = document.getElementById(deleteButtonId);
		deleteButton.parentNode.removeChild(deleteButton);

		// delete the addMorpheme button
		var addMorphemeButton = document.getElementById(("addEditMorpheme_" + id));
		addMorphemeButton.parentNode.removeChild(addMorphemeButton);

		// delete the autosuggestions
		var suggestions = document.getElementById(("list_" + glossId));
		suggestions.parentNode.removeChild(suggestions);

		// adjust the rest of the morphemes after the one that was deleted
		for (var n = (parseInt(num) + 1); n <= morphemeCounter; n++) {
			// adjust morpheme by 1: id name onkeyup
			var idWithoutNumber = id.split("_")[0] + "_m";
			var idWithNumber = idWithoutNumber + (n - 1);
			var currentMorpheme = document.getElementById((idWithoutNumber + n));
			currentMorpheme.id = idWithNumber;
			currentMorpheme.name = currentMorpheme.name.split("morpheme")[0] + "morpheme][" + (n - 2) + "][m]";
			currentMorpheme.setAttribute("onkeyup", ("suggest(this.value, 'editLine" + lineNumber + "_g" + (n - 1) + "')"));

			// adjust gloss id name
			var glossIdWithoutNumber = glossId.split("_")[0] + "_g";
			var glossIdWithNumber = glossIdWithoutNumber + (n - 1);
			var currentGloss = document.getElementById((glossIdWithoutNumber + n));
			currentGloss.id = glossIdWithNumber;
			currentGloss.name = currentMorpheme.name.split("morpheme")[0] + "morpheme][" + (n - 2) + "][g]";
			currentGloss.setAttribute("list", ("list_" + glossIdWithNumber));

			// adjust delete button id onclick
			var currentDeleteButton = document.getElementById(("delete_" + (idWithoutNumber + n)));
			currentDeleteButton.id = "delete_" + idWithNumber;
			currentDeleteButton.setAttribute("onclick", ("deleteEditMorpheme('" + idWithNumber + "')"));
			currentDeleteButton.innerHTML = "<i class='fas fa-trash-alt fa-lg'></i>&nbsp;Morpheme " + (n - 1);

			// adjust addMorpheme button id onclick
			var currentAddMorphemeButton = document.getElementById(("addEditMorpheme_" + (idWithoutNumber + n)));
			currentAddMorphemeButton.id = "addEditMorpheme_" + idWithNumber;
			currentAddMorphemeButton.setAttribute("onclick", ("addEditMorpheme('" + (idWithoutNumber + n) + "')"));

			// adjust suggestions
			var suggestions = document.getElementById(("list_" + (glossIdWithoutNumber + n)));
			suggestions.setAttribute("id", ("list_" + glossIdWithNumber));
		}
	}
	organizeMorphemeRows(lineNumber, "edit");
}