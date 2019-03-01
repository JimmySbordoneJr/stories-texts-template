// This is one of the few files you will have to edit. I have numbered the instructions for you to complete.
// There are only four things for you to do, if you are using our language tools template. 
// You simply have to change the URL that the links send users to. You simply replace "yourwebsite" with
// the actual address of your website.
// The first one to change is at line 80. 

// if you are not using our language tools template for your dictionary or phrases pages, email me at
// jsbordone96@gmail.com
// I would be glad to help you set this up for your website!

// On a story display page, the code in this file powers the linking to the dictionary, phrasicon, and story corpus.
// It goes through the middle two rows of the four line morphogloss and sees if their contents match
// anything in our morphemes database. If it does, the code links the morphogloss item to the dictionary, if possible.
// If the item is not in the dictionary, the code checks to see if it is in the phrasicon. If it is not in the phrasicon,
// the code links to other stories and texts that use this morpheme. After these checks are complete, there is another
// function that links morphogloss items to the grammar section.

var storyIdNumber = parseInt(document.getElementById("storyIdNumber").getAttribute("data-story"));
var xhttp = new XMLHttpRequest();
xhttp.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {
		linkToDictionaryEntries(this);
	}
};
xhttp.open("GET", "../../../morphemes/morphemes.xml", true);
xhttp.send();

async function linkToDictionaryEntries(xml) {
	var xmlDoc = xml.responseXML;
	var dictionaryEntries = xmlDoc.getElementsByTagName("morpheme");
	var rowTwoItems = document.getElementsByTagName("dt");
	var rowThreeItems = document.getElementsByTagName("dd");
	if (rowTwoItems.length > 0 && rowThreeItems.length > 0) {
		for (var j = 0; j < rowTwoItems.length; j++) {
			var sourceMorpheme = rowTwoItems[j].textContent.trim();
			if (sourceMorpheme.slice(0, 1) === "(") {
				sourceMorpheme = sourceMorpheme.slice(1);
			}
			if (sourceMorpheme.slice(-1) === ")") {
				sourceMorpheme = sourceMorpheme.slice(0, -1);
			}

			var sourceMorphemeDict = sourceMorpheme.slice(0, sourceMorpheme.length);
			if (sourceMorphemeDict.slice(0, 1) === "-") {
				sourceMorphemeDict = sourceMorphemeDict.slice(1);
			}
			if (sourceMorphemeDict.slice(-1) === "-") {
				sourceMorphemeDict = sourceMorphemeDict.slice(0, -1);
			}


			var translationMorpheme = rowThreeItems[j].textContent.trim();
			if (translationMorpheme.slice(0, 1) === "(") {
				translationMorpheme = translationMorpheme.slice(1);
			}
			if (translationMorpheme.slice(-1) === ")") {
				translationMorpheme = translationMorpheme.slice(0, -1);
			}

			var newHTML = rowTwoItems[j].innerHTML;
			for (var k = 0; k < dictionaryEntries.length; k++) {
				entry = dictionaryEntries[k];

				entrySource = entry.getElementsByTagName("source")[0].textContent;
				if (entrySource.slice(0, 1) === "(") {
					entrySource = entrySource.slice(1);
				}
				if (entrySource.slice(-1) === ")") {
					entrySource = entrySource.slice(0, -1);
				}

				var entryRoot = entry.getElementsByTagName("root")[0].textContent;
				if (entryRoot.slice(0, 1) === "(") {
					entryRoot = entryRoot.slice(1);
				}
				if (entryRoot.slice(-1) === ")") {
					entryRoot = entryRoot.slice(0, -1);
				}

				var entryGloss = entry.getElementsByTagName("gloss")[0].textContent;
				if (entryGloss.slice(0, 1) === "(") {
					entryGloss = entryGloss.slice(1);
				}
				if (entryGloss.slice(-1) === ")") {
					entryGloss = entryGloss.slice(0, -1);
				}

				// the or statement below checks if sourceMorpheme matches the given morpheme from our database or the root of the given morpheme
				if (((entrySource === sourceMorpheme) || (entryRoot === sourceMorpheme)) && entryGloss === translationMorpheme) {
					// if it's in the dictionary, link to the dictionary
					if (entry.getElementsByTagName("dictionary")[0].textContent != "") {
						var dictionaryLinks = entry.getElementsByTagName("dictionary")[0].textContent.split(",");
						var linkId = dictionaryLinks[0];
						// 1. Change the URL in the line below to match your website 
						newHTML = "<a class=\"foundInDictionary\" href=\"http://yourwebsite.com/dictionary/word.php?word=" + sourceMorphemeDict + "&lang=source#" + linkId + "\" target=\"_blank\">" + rowTwoItems[j].innerHTML + "</a>";
					} else if (entry.getElementsByTagName("phrasicon")[0].textContent != "") {
						var phrasiconLinks = entry.getElementsByTagName("phrasicon")[0].textContent.split(",");
						var linkId = phrasiconLinks[0];
						// 2. Change the URL in the line below to match your website 
						newHTML = "<a class=\"foundInPhrasicon\" href=\"http://yourwebsite.com/phrasicon/word.php?word=" + sourceMorpheme + "&lang=source#" + linkId + "\" target=\"_blank\">" + rowTwoItems[j].innerHTML + "</a>";
					} else {
						var storyCorpusLinks = entry.getElementsByTagName("storycorpus")[0].textContent.split(",");
						for (var linkVar = 0; linkVar < storyCorpusLinks.length; linkVar++) {
							linkId = parseInt(storyCorpusLinks[linkVar]);
							if ((linkId != storyIdNumber) && (!isNaN(linkId))) {
								// 3. Change the URL in the line below to match your website 
								newHTML = "<a class=\"foundInStoryCorpus\" href=\"http://yourwebsite.com/texts/index.php?lang=source&searchTerm=" + sourceMorpheme + "&searchGloss=" + translationMorpheme + "&authorLink=false\" target=\"_blank\">" + rowTwoItems[j].innerHTML + "</a>";
								break;
							}
						}
					}
					rowTwoItems[j].innerHTML = newHTML;
					break;
				};
			};
		};
	}

}


// links to grammar page
var xhttp2 = new XMLHttpRequest();
xhttp2.onreadystatechange = function () {
	if (this.readyState == 4 && this.status == 200) {
		linkToGrammarTopics(this);
	}
};
xhttp2.open("GET", "../../../grammar/grammar_topics.xml", true);
xhttp2.send();

async function linkToGrammarTopics(xml) {
	var xmlDoc = xml.responseXML;
	var grammarTopics = xmlDoc.getElementsByTagName("topic");
	var rowThreeItems = document.getElementsByTagName("dd");
	for (var l = 0; l < rowThreeItems.length; l++) {
		var translationMorpheme = rowThreeItems[l].textContent;
		if (translationMorpheme[0] === "-") {
			var cleanedtranslationMorpheme = translationMorpheme.substring(1);
		}
		else {
			var cleanedtranslationMorpheme = translationMorpheme;
		};
		for (var m = 0; m < grammarTopics.length; m++) {
			topic = grammarTopics[m];
			if (topic.getElementsByTagName("abbreviation")[0].textContent === cleanedtranslationMorpheme) {
				// 4. Change the URL in the line below to match your website 
				var newHTML = "<a class=\"foundInGrammarPage\" href=\"http://yourwebsite.com/grammar/topic.php?topic=" + topic.getAttribute("id") + "\" target=_blank>" + translationMorpheme + "</a>";
				rowThreeItems[l].innerHTML = newHTML
			};
		};
	};
};