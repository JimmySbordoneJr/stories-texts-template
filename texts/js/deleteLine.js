// In the update page, these functions power the 'delete line' buttons.
function deleteLine(num) {
	// ask the user if they really want to delete this line
	var confirmation = confirm("Are you sure you want to delete this line? \n " + document.getElementById(("line" + num + "_source")).value);
	// if they do not want to delete this line, do nothing and exit
	if (confirmation === false) {
		return;
	}

	var lines = document.getElementsByClassName("line").length;
	// if the line to be deleted is line 1, and it is the only line, just clear its inputs and do not delete it
	if ((num === 1) && (lines === 1)) {
		$("#line1 input").val(" ");
		return;
	}

	// we will loop over all of the lines from num to the end and replace each line's content with that of the next line.
	// after the loop runs, there will be one remaining empty line, which we will then delete from the DOM
	for (var i = num; i < lines; i++) {
		// speaker & datalist
		document.getElementById(("list_line" + i + "_speakerDropDown")).innerHTML = document.getElementById(("list_line" + (i + 1) + "_speakerDropDown")).innerHTML;
		document.getElementById(("line" + i + "_speakerDropDown")).value = document.getElementById(("line" + (i + 1) + "_speakerDropDown")).value;

		// source	
		document.getElementById(("line" + i + "_source")).value = document.getElementById(("line" + (i + 1) + "_source")).value;


		// translation
		document.getElementById(("line" + i + "_translation")).value = document.getElementById(("line" + (i + 1) + "_translation")).value;

		// hint/notes
		document.getElementById(("line" + i + "_notes")).value = document.getElementById(("line" + (i + 1) + "_notes")).value;

		// audio file name
		document.getElementById(("line" + i + "_audio")).value = document.getElementById(("line" + (i + 1) + "_audio")).value;

		// morphemes -- m, g, datalist
		var currentLineMorphemes = document.getElementsByClassName(("line" + i + "_morpheme")).length;
		var nextLineMorphemes = document.getElementsByClassName(("line" + (i + 1) + "_morpheme")).length;
		for (var m = 1; m <= nextLineMorphemes; m++) {
			// if necessary, add morpheme
			if (document.getElementById(("line" + i + "_m" + m)) === null) {
				addMorpheme(("line" + i + "_m" + m))
			}

			// move m
			document.getElementById(("line" + i + "_m" + m)).value = document.getElementById(("line" + (i + 1) + "_m" + m)).value;

			// move g
			document.getElementById(("line" + i + "_g" + m)).value = document.getElementById(("line" + (i + 1) + "_g" + m)).value;

			// move datalist
			document.getElementById(("list_line" + i + "_g" + m)).innerHTML = document.getElementById(("list_line" + (i + 1) + "_g" + m)).innerHTML;
		}

		// loop to delete extra morphemes from current line, if necessary
		if (currentLineMorphemes > nextLineMorphemes) {
			for (var c = (nextLineMorphemes + 1); c <= currentLineMorphemes; c++) {
				deleteMorpheme(("line" + i + "_m" + (nextLineMorphemes + 1)));
			}
		}

	}

	// delete empty line remaining at the end
	$(("#line" + lines)).remove();
}

function deleteEditLine(num) {
	var confirmation = confirm("Are you sure you want to delete this line? \n " + document.getElementById(("editLine" + num + "_source")).value);

	if (confirmation === false) {
		return;
	}

	var lines = document.getElementsByClassName("editLine").length;

	// if the line to be deleted is line 1, and it is the only line, just clear its inputs and do not delete it
	if ((num === 1) && (lines === 1)) {
		$("#editLine1 input").val(" ");
		return;
	}

	// we will loop over all of the lines from num to the end and replace each line's content with that of the next line.
	// after the loop runs, there will be one remaining empty line, which we will then delete from the DOM
	for (var i = num; i < lines; i++) {
		// speaker & datalist
		document.getElementById(("list_editLine" + i + "_editSpeakerDropDown")).innerHTML = document.getElementById(("list_editLine" + (i + 1) + "_editSpeakerDropDown")).innerHTML;
		document.getElementById(("editLine" + i + "_editSpeakerDropDown")).value = document.getElementById(("editLine" + (i + 1) + "_editSpeakerDropDown")).value;

		// source	
		document.getElementById(("editLine" + i + "_source")).value = document.getElementById(("editLine" + (i + 1) + "_source")).value;


		// translation
		document.getElementById(("editLine" + i + "_translation")).value = document.getElementById(("editLine" + (i + 1) + "_translation")).value;

		// hint/notes
		document.getElementById(("editLine" + i + "_notes")).value = document.getElementById(("editLine" + (i + 1) + "_notes")).value;

		// audio file name
		document.getElementById(("editLine" + i + "_audio")).value = document.getElementById(("editLine" + (i + 1) + "_audio")).value;

		// morphemes -- m, g, datalist
		var currentLineMorphemes = document.getElementsByClassName(("editLine" + i + "_editMorpheme")).length;
		var nextLineMorphemes = document.getElementsByClassName(("editLine" + (i + 1) + "_editMorpheme")).length;
		for (var m = 1; m <= nextLineMorphemes; m++) {
			// if necessary, add morpheme
			if (document.getElementById(("editLine" + i + "_m" + m)) === null) {
				addEditMorpheme(("editLine" + i + "_m" + m))
			}

			// move m
			document.getElementById(("editLine" + i + "_m" + m)).value = document.getElementById(("editLine" + (i + 1) + "_m" + m)).value;

			// move g
			document.getElementById(("editLine" + i + "_g" + m)).value = document.getElementById(("editLine" + (i + 1) + "_g" + m)).value;

			// move datalist
			document.getElementById(("list_editLine" + i + "_g" + m)).innerHTML = document.getElementById(("list_editLine" + (i + 1) + "_g" + m)).innerHTML;
		}

		// loop to delete extra morphemes from current line, if necessary
		if (currentLineMorphemes > nextLineMorphemes) {
			for (var c = (nextLineMorphemes + 1); c <= currentLineMorphemes; c++) {
				deleteEditMorpheme(("editLine" + i + "_m" + (nextLineMorphemes + 1)));
			}
		}

	}

	// delete empty line remaining at the end
	$(("#editLine" + lines)).remove();
}