// In the update page, these functions add a line to the end of the story text section, 
// and then shift values forward accordingly.
function addLine(num) {
	// get the number of the last line and add one to it. The for loop
	// ensures we leave out the edit form lines
	var possibleLines = document.getElementsByTagName("fieldset");
	var lines = [];
	for (var l = 0; l < possibleLines.length; l++) {
		if (!(possibleLines[l].id.includes("edit"))) {
			lines.push(possibleLines[l]);
		}
	}
	var newNumber = parseInt(lines[(lines.length - 1)].id.slice(4));
	newNumber++;
	newLineName = "line" + newNumber;

	// create a new line
	newLine = document.createElement("fieldset");
	newLine.setAttribute('id', newLineName);
	newLine.className = "line";

	// create line heading and add it to the line
	var titleRow = document.createElement("div");
	titleRow.className = "row";
	var titleCol = document.createElement("div");
	titleCol.className = "col";

	lineTitle = document.createElement("h4");
	lineTitle.innerHTML = "Line " + newNumber;

	titleCol.appendChild(lineTitle);
	titleRow.appendChild(titleCol);
	newLine.appendChild(titleRow);

	// create the speaker dropdown
	var speakerRow = document.createElement("div");
	speakerRow.className = "row";
	var speakerCol = document.createElement("div");
	speakerCol.className = "col-2";

	speakerDropdown = document.createElement("input");
	speakerDropdown.id = "line" + newNumber + "_speakerDropDown";
	speakerDropdown.setAttribute("name", "line[" + (newNumber - 1) + "][speaker]");
	speakerDropdown.setAttribute("list", ("list_line" + newNumber + "_speakerDropDown"));
	speakerDropdown.className = "form-control";

	var speakerDatalist = document.createElement("datalist");
	speakerDatalist.id = "list_line" + newNumber + "_speakerDropDown";
	speakerDatalist.className = "speakerDropDown";
	speakerDatalist.innerHTML = "Speaker: " + document.getElementById(("list_line" + (newNumber - 1) + "_speakerDropDown")).innerHTML;
	speakerCol.appendChild(speakerDatalist);

	speakerCol.appendChild(speakerDropdown);
	speakerCol.innerHTML = "Speaker: " + speakerCol.innerHTML;
	speakerRow.appendChild(speakerCol);
	newLine.appendChild(speakerRow);

	// create the source row and add it to the line
	var sourceRow = document.createElement("div");
	sourceRow.className = "row";
	var sourceCol = document.createElement("div");
	sourceCol.className = "col";
	sourceCol.innerHTML = "Source <br/>";

	sourceInput = document.createElement("input");
	sourceInput.setAttribute("type", "text");
	sourceInput.setAttribute("id", (newLineName + "_" + "source"));
	sourceInput.setAttribute("name", "line[" + (newNumber - 1) + "][source]");
	sourceInput.setAttribute("class", "form-control");
	sourceCol.appendChild(sourceInput);

	segmentButton = document.createElement("a");
	segmentButton.setAttribute("id", (newLineName + "_" + "segmentation"));
	segmentButton.className = "btn btn-success";
	segmentButton.setAttribute("onclick", "segment(\"line" + newNumber + "\")");
	segmentButton.innerHTML = "Segment&nbsp;<i class=\"fas fa-bolt\"></i>";
	sourceCol.appendChild(segmentButton);

	sourceRow.appendChild(sourceCol);
	newLine.appendChild(sourceRow);

	// translation row
	var translationRow = document.createElement("div");
	translationRow.className = "row";
	var translationCol = document.createElement("div");
	translationCol.className = "col";
	translationCol.innerHTML = "Translation <br/>";
	translationInput = document.createElement("input");
	translationInput.setAttribute("class", "form-control");
	translationInput.setAttribute("id", (newLineName + "_" + "translation"));
	translationInput.setAttribute("type", "text");
	translationInput.setAttribute("name", ("line[" + (newNumber - 1) + "][translation]"));
	translationCol.appendChild(translationInput);
	translationRow.appendChild(translationCol);
	newLine.appendChild(translationRow);

	// notes row
	var notesRow = document.createElement("div");
	notesRow.className = "row";
	var notesCol = document.createElement("div");
	notesCol.className = "col";
	notesCol.innerHTML = "Hints/Notes <br/>";
	notesInput = document.createElement("input");
	notesInput.setAttribute("id", (newLineName + "_" + "notes"));
	notesInput.setAttribute("type", "text");
	notesInput.setAttribute("class", "form-control");
	notesInput.setAttribute("name", ("line[" + (newNumber - 1) + "][note]"));
	notesCol.appendChild(notesInput);
	notesRow.appendChild(notesCol);
	newLine.appendChild(notesRow);

	// audio file name row
	var audioRow = document.createElement("div");
	audioRow.className = "row";
	var audioCol = document.createElement("div");
	audioCol.className = "col";
	audioCol.innerHTML = "Audio File Name <br/>";
	audioInput = document.createElement("input");
	audioInput.setAttribute("class", "form-control");
	audioInput.setAttribute("id", (newLineName + "_" + "audio"));
	audioInput.setAttribute("type", "text");
	audioInput.setAttribute("name", ("line[" + (newNumber - 1) + "][lineaudio]"));
	audioInput.setAttribute("pattern", "[^&'<>\x22]*");
	audioInput.setAttribute("title", "Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.");
	audioCol.appendChild(audioInput);
	audioRow.appendChild(audioCol);
	newLine.appendChild(audioRow);

	// morpheme title
	morphemeHeader = document.createElement("h5");
	morphemeHeader.innerHTML = "Morphemes";
	newLine.appendChild(morphemeHeader);

	var morphemeContainer = document.createElement("div");
	morphemeContainer.setAttribute("id", ("line" + newNumber + "_morphemeContainer"));

	// create a new mRow and append it to the new line
	var mRow = document.createElement("div");
	mRow.className = "row";
	mRow.setAttribute("id", ("line" + newNumber + "_mRow1"));

	var mCol = document.createElement("div");
	mCol.className = "col-3";

	// add the actual inputs here and 
	var m1 = document.createElement("input");
	m1.setAttribute("id", (newLineName + "_" + "m1"));
	m1.setAttribute("type", "text");
	m1.className = "line" + newNumber + "_morpheme form-control";
	m1.setAttribute("name", "line[" + (newNumber - 1) + "][morpheme][0][m]");
	m1.setAttribute("onkeyup", "suggest(this.value, '" + newLineName + "_" + "g1')");

	// append them to mCol
	mCol.appendChild(m1);
	mRow.appendChild(mCol);
	morphemeContainer.appendChild(mRow);

	// create a new gRow and append it to the new line
	var gRow = document.createElement("div");
	gRow.className = "row";
	gRow.setAttribute("id", ("line" + newNumber + "_gRow1"));
	var gCol = document.createElement("div");
	gCol.className = "col-3";

	var g1 = document.createElement("input");
	g1.setAttribute("id", (newLineName + "_" + "g1"));
	g1.setAttribute("type", "text");
	g1.setAttribute("name", "line[" + (newNumber - 1) + "][morpheme][0][g]");
	g1.setAttribute("list", ("list_" + newLineName + "_g1"));
	g1.className = "line" + newNumber + "_gloss form-control";

	newDatalist = document.createElement("datalist");
	newDatalist.setAttribute("id", ("list_" + newLineName + "_g1"));
	document.getElementById("datalistContainer").appendChild(newDatalist);

	// append them to gCol
	gCol.appendChild(g1);
	gRow.appendChild(gCol);
	morphemeContainer.appendChild(gRow);

	var dRow = document.createElement("div");
	dRow.className = "row";
	dRow.setAttribute("id", ("line" + newNumber + "_dRow1"));
	var dCol = document.createElement("div");
	dCol.className = "col-3";

	var deleteButton = document.createElement("a");
	deleteButton.className = "btn btn-danger " + "line" + newNumber + "_delete";
	deleteButton.innerHTML = "<i class='fas fa-trash-alt fa-lg'></i>&nbsp;Morpheme 1";
	deleteButton.id = "delete_" + newLineName + "_m1";
	deleteButton.setAttribute("onclick", ("deleteMorpheme('" + newLineName + "_m1')"));

	var morphemeButton = document.createElement("a");
	morphemeButton.className = "btn btn-info " + "line" + newNumber + "_add";
	morphemeButton.setAttribute("id", "addMorpheme_line" + newNumber + "_m1");
	morphemeButton.setAttribute("onclick", "addMorpheme('line" + newNumber + "_m2')");
	morphemeButton.innerHTML = "<i class='fas fa-plus'></i>";

	dCol.appendChild(deleteButton);
	dCol.appendChild(morphemeButton);
	dRow.appendChild(dCol);
	morphemeContainer.appendChild(dRow);
	newLine.appendChild(morphemeContainer);

	// row + column for addLine + deleteLine buttons
	var aRow = document.createElement("div");
	aRow.className = "row";
	var aCol = document.createElement("div");
	aCol.className = "col";

	// add line button

	var newAddLineButton = document.createElement("a");
	newAddLineButton.className = "btn btn-info";
	newAddLineButton.setAttribute("id", ("line" + newNumber + "_addLine"));
	newAddLineButton.setAttribute("onclick", ('addLine(' + (newNumber + 1) + ')'));
	newAddLineButton.innerHTML = "+ Add Line";
	aCol.appendChild(newAddLineButton);

	// delete line button
	var newDeleteLineButton = document.createElement("a");
	newDeleteLineButton.className = "btn btn-danger";
	newDeleteLineButton.setAttribute("id", ("line" + newNumber + "_deleteLine"));
	newDeleteLineButton.setAttribute("onclick", ('deleteLine(' + newNumber + ')'));
	newDeleteLineButton.innerHTML = "<i class='fas fa-trash'></i> Delete Line " + newNumber;

	aCol.appendChild(newDeleteLineButton);
	aRow.appendChild(aCol);
	newLine.appendChild(aRow);

	// add the new line to the document
	lineContainer = document.getElementById("lineContainer");
	lineContainer.appendChild(newLine);

	// loop here to adjust move every value from num to the last line up by one. Go from the last one down to num			
	for (var l = (newNumber - 1); l >= num; l--) {
		// we have to go from the last existing line down to num and slide each line's values up to the next line

		// speaker dropdown, 
		document.getElementById(("line" + (l + 1) + "_speakerDropDown")).value = document.getElementById(("line" + l + "_speakerDropDown")).value;
		
		// source,
		document.getElementById(("line" + (l + 1) + "_source")).value = document.getElementById(("line" + l + "_source")).value;
		// translation, 
		document.getElementById(("line" + (l + 1) + "_translation")).value = document.getElementById(("line" + l + "_translation")).value;

		// hint, 
		document.getElementById(("line" + (l + 1) + "_notes")).value = document.getElementById(("line" + l + "_notes")).value;

		// audio,
		document.getElementById(("line" + (l + 1) + "_audio")).value = document.getElementById(("line" + l + "_audio")).value;

		var cm = document.getElementsByClassName(("line" + l + "_morpheme")).length;
		var count = 1;
		while (count <= cm) {
			nextLineMorpheme = document.getElementById(("line" + (l + 1) + "_m" + count));
			if (nextLineMorpheme === null) {
				addMorpheme(("line" + (l + 1) + "_m" + count));
			}

			document.getElementById(("line" + (l + 1) + "_m" + count)).value = document.getElementById(("line" + l + "_m1")).value;
			document.getElementById(("line" + (l + 1) + "_g" + count)).value = document.getElementById(("line" + l + "_g1")).value;
			document.getElementById(("list_" + "line" + (l + 1) + "_g" + count)).innerHTML = document.getElementById(("list_" + "line" + l + "_g1")).innerHTML;

			deleteMorpheme(("line" + l + "_m1"));
			count++;
		}
	}
	// now, we just have to clear out the num-th line
	document.getElementById(("line" + num + "_speakerDropDown")).value = "";	
	document.getElementById(("line" + num + "_source")).value = "";
	document.getElementById(("line" + num + "_translation")).value = "";
	document.getElementById(("line" + num + "_audio")).value = "";
	document.getElementById(("line" + num + "_notes")).value = "";

	// clearing out its morphemes
	var numToClear = document.getElementsByClassName("line" + num + "_morpheme").length;
	for (var h = 1; h <= numToClear; h++) {
		deleteMorpheme(("line" + num + "_m1"));
	}

};

function addEditLine(num) {
	// get the number of the last line and add one to it. The for loop
	// makes sure we look at only the lines of the edit form
	var possibleLines = document.getElementsByTagName("fieldset");
	var lines = [];
	for (var l = 0; l < possibleLines.length; l++) {
		if (possibleLines[l].id.includes("edit")) {
			lines.push(possibleLines[l]);
		}
	}
	var newNumber = parseInt(lines[(lines.length - 1)].id.slice(8));
	newNumber++;
	newLineName = "editLine" + newNumber;

	// create a new line
	newLine = document.createElement("fieldset");
	newLine.setAttribute('id', newLineName);
	newLine.className = "editLine";

	// create line heading and add it to the line
	var titleRow = document.createElement("div");
	titleRow.className = "row";
	var titleCol = document.createElement("div");
	titleCol.className = "col";

	lineTitle = document.createElement("h4");
	lineTitle.innerHTML = "Line " + newNumber;

	titleCol.appendChild(lineTitle);
	titleRow.appendChild(titleCol);
	newLine.appendChild(titleRow);

	// create the speaker dropdown
	var speakerRow = document.createElement("div");
	speakerRow.className = "row";
	var speakerCol = document.createElement("div");
	speakerCol.className = "col-2";

	speakerDropdown = document.createElement("input");
	speakerDropdown.id = "editLine" + newNumber + "_editSpeakerDropDown";
	speakerDropdown.setAttribute("name", "line[" + (newNumber - 1) + "][speaker]");
	speakerDropdown.setAttribute("list", "list_editLine" + newNumber + "_editSpeakerDropDown");
	speakerDropdown.className = "form-control";

	var speakerDatalist = document.createElement("datalist");
	speakerDatalist.id = "list_editLine" + newNumber + "_editSpeakerDropDown";
	speakerDatalist.className = "editSpeakerDropDown";
	speakerDatalist.innerHTML = "Speaker: " + document.getElementById(("list_editLine" + (newNumber - 1) + "_editSpeakerDropDown")).innerHTML;
	speakerCol.appendChild(speakerDatalist);

	speakerCol.appendChild(speakerDropdown);
	speakerCol.innerHTML = "Speaker: " + speakerCol.innerHTML;
	speakerRow.appendChild(speakerCol);
	newLine.appendChild(speakerRow);

	// create the source row and add it to the line
	var sourceRow = document.createElement("div");
	sourceRow.className = "row";
	var sourceCol = document.createElement("div");
	sourceCol.className = "col";
	sourceCol.innerHTML = "Source <br/>";

	sourceInput = document.createElement("input");
	sourceInput.setAttribute("type", "text");
	sourceInput.setAttribute("class", "form-control");
	sourceInput.setAttribute("id", (newLineName + "_" + "source"));
	sourceInput.setAttribute("name", "line[" + (newNumber - 1) + "][source]");
	sourceCol.appendChild(sourceInput);

	segmentButton = document.createElement("a");
	segmentButton.setAttribute("id", (newLineName + "_" + "segmentation"));
	segmentButton.className = "btn btn-success";
	segmentButton.setAttribute("onclick", "segment(\"editLine" + newNumber + "\", \"edit\")");
	segmentButton.innerHTML = "Segment&nbsp;<i class=\"fas fa-bolt\"></i>";
	sourceCol.appendChild(segmentButton);

	sourceRow.appendChild(sourceCol);
	newLine.appendChild(sourceRow);

	// translation row
	var translationRow = document.createElement("div");
	translationRow.className = "row";
	var translationCol = document.createElement("div");
	translationCol.className = "col";
	translationCol.innerHTML = "Translation <br/>";
	translationInput = document.createElement("input");
	translationInput.setAttribute("class", "form-control");
	translationInput.setAttribute("id", (newLineName + "_" + "translation"));
	translationInput.setAttribute("type", "text");
	translationInput.setAttribute("name", ("line[" + (newNumber - 1) + "][translation]"));
	translationCol.appendChild(translationInput);
	translationRow.appendChild(translationCol);
	newLine.appendChild(translationRow);

	// notes row
	var notesRow = document.createElement("div");
	notesRow.className = "row";
	var notesCol = document.createElement("div");
	notesCol.className = "col";
	notesCol.innerHTML = "Hints/Notes <br/>";
	notesInput = document.createElement("input");
	notesInput.setAttribute("class", "form-control");
	notesInput.setAttribute("id", (newLineName + "_" + "notes"));
	notesInput.setAttribute("type", "text");
	notesInput.setAttribute("name", ("line[" + (newNumber - 1) + "][note]"));
	notesCol.appendChild(notesInput);
	notesRow.appendChild(notesCol);
	newLine.appendChild(notesRow);

	// audio file name row
	var audioRow = document.createElement("div");
	audioRow.className = "row";
	var audioCol = document.createElement("div");
	audioCol.className = "col";
	audioCol.innerHTML = "Audio File Name <br/>";
	audioInput = document.createElement("input");
	audioInput.setAttribute("id", (newLineName + "_" + "audio"));
	audioInput.setAttribute("class", "form-control");
	audioInput.setAttribute("type", "text");
	audioInput.setAttribute("name", ("line[" + (newNumber - 1) + "][lineaudio]"));
	audioInput.setAttribute("pattern", "[^&'<>\x22]*");
	audioInput.setAttribute("title", "Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.");
	audioCol.appendChild(audioInput);
	audioRow.appendChild(audioCol);
	newLine.appendChild(audioRow);

	// morpheme title
	morphemeHeader = document.createElement("h5");
	morphemeHeader.innerHTML = "Edit Morphemes";
	newLine.appendChild(morphemeHeader);

	var morphemeContainer = document.createElement("div");
	morphemeContainer.setAttribute("id", ("editLine" + newNumber + "_editMorphemeContainer"));

	// create a new mRow and append it to the new line
	var mRow = document.createElement("div");
	mRow.className = "row";
	mRow.setAttribute("id", ("editLine" + newNumber + "_editMRow1"));

	var mCol = document.createElement("div");
	mCol.className = "col-3";

	// add the actual inputs here and 
	var m1 = document.createElement("input");
	m1.setAttribute("id", (newLineName + "_" + "m1"));
	m1.setAttribute("type", "text");
	m1.className = "editLine" + newNumber + "_editMorpheme form-control";
	m1.setAttribute("name", "line[" + (newNumber - 1) + "][morpheme][0][m]");
	m1.setAttribute("onkeyup", "suggest(this.value, '" + newLineName + "_" + "g1')");

	// append them to mCol
	mCol.appendChild(m1);
	mRow.appendChild(mCol);
	morphemeContainer.appendChild(mRow);

	// create a new gRow and append it to the new line
	var gRow = document.createElement("div");
	gRow.className = "row";
	gRow.setAttribute("id", ("editLine" + newNumber + "_editGRow1"));

	var gCol = document.createElement("div");
	gCol.className = "col-3";

	var g1 = document.createElement("input");
	g1.setAttribute("id", (newLineName + "_" + "g1"));
	g1.setAttribute("type", "text");
	g1.setAttribute("name", "line[" + (newNumber - 1) + "][morpheme][0][g]");
	g1.setAttribute("list", ("list_" + newLineName + "_g1"));
	g1.className = "editLine" + newNumber + "_editGloss form-control";

	newDatalist = document.createElement("datalist");
	newDatalist.setAttribute("id", ("list_" + newLineName + "_g1"));
	document.getElementById("datalistEditContainer").appendChild(newDatalist);

	// append them to gCol
	gCol.appendChild(g1);
	gRow.appendChild(gCol);
	morphemeContainer.appendChild(gRow);

	var dRow = document.createElement("div");
	dRow.className = "row";
	dRow.setAttribute("id", ("editLine" + newNumber + "_editDRow1"));

	var dCol = document.createElement("div");
	dCol.className = "col-3";

	var deleteButton = document.createElement("a");
	deleteButton.className = "btn btn-danger " + "editLine" + newNumber + "_editDelete";
	deleteButton.innerHTML = "<i class='fas fa-trash-alt fa-lg'></i>&nbsp;Morpheme 1";
	deleteButton.id = "delete_" + newLineName + "_m1";
	deleteButton.setAttribute("onclick", ("deleteMorpheme('" + newLineName + "_m1')"));

	var morphemeButton = document.createElement("a");
	morphemeButton.className = "btn btn-info " + "editLine" + newNumber + "_editAdd";
	morphemeButton.setAttribute("onclick", "addEditMorpheme('editLine" + newNumber + "_m2')");
	morphemeButton.innerHTML = "<i class='fas fa-plus'></i>";

	dCol.appendChild(deleteButton);
	dCol.appendChild(morphemeButton);
	dRow.appendChild(dCol);
	morphemeContainer.appendChild(dRow);
	newLine.appendChild(morphemeContainer);
	// add addRow button
	var aRow = document.createElement("div");
	aRow.className = "row";
	var aCol = document.createElement("div");
	aCol.className = "col";

	var newAddLineButton = document.createElement("a");
	newAddLineButton.className = "btn btn-info";
	newAddLineButton.setAttribute("id", ("editLine" + newNumber + "_addEditLine"));
	newAddLineButton.setAttribute("onclick", ('addEditLine(' + (newNumber + 1) + ')'));
	newAddLineButton.innerHTML = "+ Add Line";
	aCol.appendChild(newAddLineButton);

	var newDeleteLineButton = document.createElement("a");
	newDeleteLineButton.className = "btn btn-danger";
	newDeleteLineButton.setAttribute("id", ("editLine" + newNumber + "_deleteEditLine"));
	newDeleteLineButton.setAttribute("onclick", ('deleteEditLine(' + newNumber + ')'));
	newDeleteLineButton.innerHTML = "<i class='fas fa-trash'></i> Delete Line " + newNumber;
	aCol.appendChild(newDeleteLineButton);

	aRow.appendChild(aCol);
	newLine.appendChild(aRow);

	// add the new line to the document
	lineContainer = document.getElementById("editLineContainer");
	lineContainer.appendChild(newLine);

	// loop here to adjust move every value from num to the last line up by one. Go from the last one down to num			
	for (var l = (newNumber - 1); l >= num; l--) {
		// we have to go from the last existing line down to num and slide each line's values up to the next line
		
		// speaker dropdown,
		document.getElementById(("editLine" + (l + 1) + "_editSpeakerDropDown")).value = document.getElementById(("editLine" + l + "_editSpeakerDropDown")).value;

		// source,
		document.getElementById(("editLine" + (l + 1) + "_source")).value = document.getElementById(("editLine" + l + "_source")).value;

		// translation, 
		document.getElementById(("editLine" + (l + 1) + "_translation")).value = document.getElementById(("editLine" + l + "_translation")).value;

		// hint, 
		document.getElementById(("editLine" + (l + 1) + "_notes")).value = document.getElementById(("editLine" + l + "_notes")).value;

		// audio,
		document.getElementById(("editLine" + (l + 1) + "_audio")).value = document.getElementById(("editLine" + l + "_audio")).value;

		var cm = document.getElementsByClassName(("editLine" + l + "_editMorpheme")).length;
		var count = 1;
		while (count <= cm) {
			nextLineMorpheme = document.getElementById(("editLine" + (l + 1) + "_m" + count));
			if (nextLineMorpheme === null) {
				addEditMorpheme(("editLine" + (l + 1) + "_m" + count));
			}

			document.getElementById(("editLine" + (l + 1) + "_m" + count)).value = document.getElementById(("editLine" + l + "_m1")).value;
			document.getElementById(("editLine" + (l + 1) + "_g" + count)).value = document.getElementById(("editLine" + l + "_g1")).value;
			document.getElementById(("list_" + "editLine" + (l + 1) + "_g" + count)).innerHTML = document.getElementById(("list_" + "editLine" + l + "_g1")).innerHTML;

			deleteEditMorpheme(("editLine" + l + "_m1"));
			count++;
		}
	}
	// now, we just have to clear out the num-th line
	document.getElementById(("editLine" + num + "_editSpeakerDropDown")).value = "";	
	document.getElementById(("editLine" + num + "_source")).value = "";
	document.getElementById(("editLine" + num + "_translation")).value = "";
	document.getElementById(("editLine" + num + "_audio")).value = "";
	document.getElementById(("editLine" + num + "_notes")).value = "";

	// clearing out its morphemes
	var numToClear = document.getElementsByClassName("editLine" + num + "_editMorpheme").length;
	for (var h = 1; h <= numToClear; h++) {
		deleteEditMorpheme(("editLine" + num + "_m1"));
	}
};
