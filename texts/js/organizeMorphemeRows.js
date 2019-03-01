// In the update page, this function organizes the morphemes, translations, and add/delete buttons into rows
// and columns.
function organizeMorphemeRows(lineNumber, edit) {
	if (edit == undefined) {
		var morphemeClassName = "line" + lineNumber + "_morpheme";
		var glossClassName = "line" + lineNumber + "_gloss";
		var deleteButtonClassName = "line" + lineNumber + "_delete";
		var addButtonClassName = "line" + lineNumber + "_add";
		var morphemeContainer = document.getElementById(("line" + lineNumber + "_morphemeContainer"));
		var morphemeHTML = '<div class="row" id="line' + lineNumber + '_mRow1' + '">';
		var glossHTML = '<div class="row" id="line' + lineNumber + '_gRow1' + '">';
		var buttonsHTML = '<div class="row" id="line' + lineNumber + '_dRow1' + '">';
	}
	else {
		var morphemeClassName = "editLine" + lineNumber + "_editMorpheme";
		var glossClassName = "editLine" + lineNumber + "_editGloss";
		var deleteButtonClassName = "editLine" + lineNumber + "_editDelete";
		var addButtonClassName = "editLine" + lineNumber + "_editAdd";
		var morphemeContainer = document.getElementById(("editLine" + lineNumber + "_editMorphemeContainer"));
		var morphemeHTML = '<div class="row" id="editLine' + lineNumber + '_editMRow1' + '">';
		var glossHTML = '<div class="row" id="editLine' + lineNumber + '_editGRow1' + '">';
		var buttonsHTML = '<div class="row" id="editLine' + lineNumber + '_editDRow1' + '">';
	}
	var morphemes = document.getElementsByClassName(morphemeClassName);
	var glosses = document.getElementsByClassName(glossClassName);
	var deleteButtons = document.getElementsByClassName(deleteButtonClassName);
	var addButtons = document.getElementsByClassName(addButtonClassName);
	// build organized rows, where each row has five morphemes. Before I can uncomment these  lines, I need to add 
	// the morpheme container div to the HTML and adjust the add/delete morphemes and add line functions accordingly
	var newInnerHTML = '';
	var sourceValues = [];
	var translationValues = [];
	for (var m = 0; m < morphemes.length; m++) {
		sourceValues.push(morphemes[m].value);
		translationValues.push(glosses[m].value);
		morphemeHTML = morphemeHTML + '<div class="col-3">' + morphemes[m].outerHTML + '</div>';
		glossHTML = glossHTML + '<div class="col-3">' + glosses[m].outerHTML + '</div>';
		buttonsHTML = buttonsHTML + '<div class="col-3">' + deleteButtons[m].outerHTML + addButtons[m].outerHTML + '</div>';
		if (((m + 1) % 4 == 0) || (m + 1) >= morphemes.length) {
			// close the rows if we are at 5 morphemes for this row or we don't have any more morphemes to handle after the current one
			morphemeHTML = morphemeHTML + '</div>';
			glossHTML = glossHTML + '</div>';
			buttonsHTML = buttonsHTML + '</div>';
			// add them to the new innerHTML, and then clear them out
			newInnerHTML = newInnerHTML + morphemeHTML + glossHTML + buttonsHTML;

			morphemeHTML = '';
			glossHTML = '';
			buttonsHTML = '';

			if ((m + 1) < morphemes.length) {
				// if we have more morphemes to organize, open a new row
				var newMNumber = Math.floor((m + 1) / 4) + 1;
				if (edit == undefined) {
					morphemeHTML = '<div class="row" id="line' + lineNumber + '_mRow' + newMNumber + '">';
					glossHTML = '<div class="row" id="line' + lineNumber + '_gRow' + newMNumber + '">';
					buttonsHTML = '<div class="row" id="line' + lineNumber + '_dRow' + newMNumber + '">';
				} else {
					morphemeHTML = '<div class="row" id="editLine' + lineNumber + '_editMRow' + newMNumber + '">';
					glossHTML = '<div class="row" id="editLine' + lineNumber + '_editGRow' + newMNumber + '">';
					buttonsHTML = '<div class="row" id="editLine' + lineNumber + '_editDRow' + newMNumber + '">';
				}
			}
		}
	}
	morphemeContainer.innerHTML = newInnerHTML;
	if (edit == undefined) {
		for (var m = 0; m < morphemes.length; m++) {
			document.getElementById(("line" + lineNumber + "_m" + (m + 1))).value = sourceValues[m];
			document.getElementById(("line" + lineNumber + "_g" + (m + 1))).value = translationValues[m];
		}
	} else {
		for (var m = 0; m < morphemes.length; m++) {
			document.getElementById(("editLine" + lineNumber + "_m" + (m + 1))).value = sourceValues[m];
			document.getElementById(("editLine" + lineNumber + "_g" + (m + 1))).value = translationValues[m];
		}
	}
};