// In the update page, the code in this file will take a line in the source language field and attempt to break
// it into its constituent morphemes. This happens when the 'segment' button is clicked. Lines 1 through 79 
// are helper functions, and the code beginning at line 80 is the actual function called when the 'segment'
// button is clicked.

function endsWithMorpheme(str, morpheme) {
	return ((morpheme === str.slice((-1 * morpheme.length))) && (str.length !== str.slice((-1 * morpheme.length)).length));
}

function beginsWithMorpheme(str, morpheme) {
	return ((morpheme === str.slice(0, morpheme.length)) && (morpheme.length < str.length));
}
var morphemesArr;
var morphemes = [];
$(document).ready(function () {
	if (window.XMLHttpRequest) {
		// code for IE7+, Firefox, Chrome, Opera, Safari
		xmlhttp = new XMLHttpRequest();
	} else { // code for IE6, IE5
		xmlhttp = new ActiveXObject("Microsoft.XMLHTTP");
	}

	xmlhttp.onreadystatechange = function () {
		if (xmlhttp.readyState == 4 && xmlhttp.status == 200) {
			var xmlDoc = this.responseXML;
			morphemesArr = xmlDoc.getElementsByTagName("source");
			for (var m = 0; m < morphemesArr.length; m++) {
				morphemes.push(morphemesArr[m].textContent);
			}
			// we sort the morphemes from longest to shortest, because when segmenting, we want to match the largest
			// morpheme we can first.
			morphemes.sort(function (a, b) {
				// ascending  -> a.length - b.length
				// descending -> b.length - a.length
				return b.length - a.length;
			});
		}
	}
	xmlhttp.open("GET", "../../morphemes/morphemes.xml", true);
	xmlhttp.send();
});

function analyzeWord(str) {
	if (str === "") {
		// base case for recursion
		return "";
	} else {
		if (str.substring(0, 1) === "-") {
			var newstr = str.substring(1, str.length);
		}
		else {
			var newstr = str;
		}
		for (var morph = 0; morph < morphemes.length; morph++) {
			var currentMorpheme = morphemes[morph];
			if (currentMorpheme !== "" && currentMorpheme !== "-") {
				// pull off any hyphens from beginning and end of string
				if (currentMorpheme[0] === "-") {
					currentMorpheme = currentMorpheme.slice(1);
				} else if (currentMorpheme.slice(-1) === "-") {
					currentMorpheme = currentMorpheme.slice(0, -1);
				};

				if (endsWithMorpheme(newstr.toLowerCase(), currentMorpheme.toLowerCase()) === true) {
					return analyzeWord(newstr.slice(0, (-1 * currentMorpheme.length))) + " -" + currentMorpheme;
				}
				else if (beginsWithMorpheme(newstr.toLowerCase(), currentMorpheme.toLowerCase()) === true) {
					if (morphemesArr[morph].parentNode.getElementsByTagName("affix")[0].textContent !== "prefix") {
						return currentMorpheme + " -" + analyzeWord((newstr.slice(currentMorpheme.length)));
					}
					else {
						return currentMorpheme + "- " + analyzeWord((newstr.slice(currentMorpheme.length)));
					}
				}
				else if (newstr.toLowerCase() === currentMorpheme.toLowerCase()) {
					return str;
				}
			}
		}
		// if we did not find any kind of match, just return the input string
		return str;
	}
}

function segment(line, editSection) {
	// this code segments the source text in the "create story" section
	if (edit === undefined) {
		var lineNumber = line.split("line")[1];
		var edit = "l";
	} else {
		var lineNumber = line.split("Line")[1];
		var edit = "editL";
	}
	var lineSource = document.getElementById((line + "_source")).value;
	var morphemes = document.getElementsByClassName((edit + "ine" + lineNumber + "_morpheme"));
	var morphemeCounter = morphemes.length;
	// if source is blank, fill in all the morphemes with blanks
	for (var i = 1; i <= morphemeCounter; i++) {
		document.getElementById(line + "_m" + i).value = "";
		document.getElementById(line + "_g" + i).value = "";
	}
	lineSource = lineSource.split(" ");
	var returnString = "";

	// analyze the lineSource here
	for (var i = 0; i < lineSource.length; i++) {
		returnString += analyzeWord(lineSource[i]) + " ";
	}

	returnString = returnString.split(" ").filter(Boolean);
	for (j = 0; j < returnString.length; j++) {
		// if there aren't any remaining morpheme spaces to segment the text...
		if (document.getElementById(line + '_m' + (j + 1)) === null) {
			// ... add one.
			if (editSection === undefined) {
				addMorpheme((line + "_m" + (j + 1)));
			} else {
				addEditMorpheme((line + "_m" + (j + 1)));
			}
		}
		document.getElementById(line + '_m' + (j + 1)).value = returnString[j];
	}
	// deleting any extra morphemes
	while (document.getElementById((line + '_m' + (j + 1))) !== null) {
		if (editSection === undefined) {
			deleteMorpheme((line + "_m" + (j + 1)));
		} else {
			deleteEditMorpheme((line + "_m" + (j + 1)));
		}
	}
	suggest(returnString[j], (line + "_g" + j), segment);
}