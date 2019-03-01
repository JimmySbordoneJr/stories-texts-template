/* This function works in the update page. It takes the content of each morpheme box, searches the morpheme
database, and returns possible translations for that morpheme. It takes the text of the morpheme and passes 
it off to the maxent.php file, which handles the bulk of the work of finding translations. */

function suggest(str, id, segment) {
	// The function works differently depending on whether the morpheme was typed in or filled in by the segmenter
	if (segment === undefined) {
		var lineArray = id.split("_");// [line1, g1]
		var lineNumber = lineArray[0]; // [line1]
		var mNumber = lineArray[1].split("g")[1]; // 1
		if (str == "") {
			document.getElementById(id).value = "";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				response = xmlhttp.responseText.trim().split(" ");
				if (response[0] == "?") {
					document.getElementById(id).value = "";
					var currentDatalist = document.getElementById(("list_" + id));
					currentDatalist.innerHTML = "";
				} else {
					var options = response[0].split("~");
					var currentDatalist = document.getElementById(("list_" + id));
					currentDatalist.innerHTML = "";
					for (var o = 0; o < options.length; o++) {
						var currentOption = options[o].replace(/_/g, " ");
						var newOption = document.createElement("option");
						newOption.setAttribute("value", currentOption);
						currentDatalist.appendChild(newOption);
					}
				}

			}
		}
		if (str !== "") {
			xmlhttp.open("GET", "maxent.php?txt=" + str.trim(), true);
			xmlhttp.send();
		}
	} else {
		// this function suggests english translations for each morpheme
		var lineArray = id.split("_");// [line1, g1]
		var lineNumber = lineArray[0]; // [line1]
		var mNumber = lineArray[1].split("g")[1]; // 1
		if (str == "") {
			document.getElementById(id).value = "";
			return;
		}
		if (window.XMLHttpRequest) {
			// code for IE7+, Firefox, Chrome, Opera, Safari
			xmlhttp = new XMLHttpRequest();
		} else { // code for IE6, IE5
			xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
		}
		xmlhttp.onreadystatechange = function () {
			if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
				response = xmlhttp.responseText.trim().split(" ");

				for (var i = 0; i < response.length; i++) {
					if (response[i] == "?") {
						document.getElementById(lineNumber + "_g" + (i + 1)).value = "";
						var currentDatalist = document.getElementById(("list_" + lineNumber + "_g" + (i + 1)));
						currentDatalist.innerHTML = "";
					} else {
						var options = response[i].split("~");
						var currentDatalist = document.getElementById(("list_" + lineNumber + "_g" + (i + 1)));
						currentDatalist.innerHTML = "";
						for (var o = 0; o < options.length; o++) {
							var currentOption = options[o].replace(/_/g, " ");
							var newOption = document.createElement("option");
							newOption.setAttribute("value", currentOption);
							currentDatalist.appendChild(newOption);
						}
					}
				}
			}
		}
		text = "";
		for (i = 1; i <= mNumber; i++) {
			if (document.getElementById(lineNumber + "_m" + i).value == " "
				| document.getElementById(lineNumber + "_m" + i).value == "") {
				text = text + "? ";
			} else {
				text = text + document.getElementById(lineNumber + "_m" + i).value + " ";
			}
		}
		text = text.trim().toLowerCase();
		xmlhttp.open("GET", "maxent.php?txt=" + text, true);
		xmlhttp.send();
	}
}