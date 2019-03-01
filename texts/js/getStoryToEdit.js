// In the update page, when a user is editing a story, they input the ID of a story and click a button which
// calls this function to get the story and load its values into the update page form.
function getStorytoEdit() {
	$(document.body).append('<div class="fadeMe" id="loadingAnimation1"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');
	var saveChangesButton = document.getElementById("saveChangesButton");
	// clear out the form
	var id = document.getElementById('editID').value.trim();
	document.getElementById("modify").reset();
	document.getElementById('editID').value = id;
	document.getElementById('checkSubmission').value = id;
	// get story from corpus, insert current values into form. If nothing was entered in the id box, do nothing.
	if ((id != "") && (id != " ")) {
		var xhttp = new XMLHttpRequest();
		xhttp.onreadystatechange = function () {
			if (this.readyState == 4 && this.status == 200) {
				var xmlDoc = this.responseXML;
				var stories = xmlDoc.getElementsByTagName("story");
				var story;
				for (var s = 0; s < stories.length; s++) {
					if (stories[s].getAttribute("id") == id) {
						story = stories[s];
						break;
					}
				}
				if (story == null) {
					alert("Sorry, no story with that ID number exists.");
					return;
				}
				document.getElementById("editTitle").value = story.getElementsByTagName("storytitle")[0].textContent;
				document.getElementById("editNarrator").value = story.getElementsByTagName("narrator")[0].textContent;
				document.getElementById("editInterviewer").value = story.getElementsByTagName("interviewer")[0].textContent;

				if (story.getElementsByTagName("approved")[0].textContent === "True") {
					document.getElementById("approvedTrue").setAttribute("checked", "checked");
				}
				else {
					document.getElementById("approvedFalse").setAttribute("checked", "checked");
				}

				// this triggers a function that fills in the dropdowns
				$("#editNarrator").blur();

				document.getElementById("editDescription").value = story.getElementsByTagName("description")[0].textContent;
				document.getElementById("editSocialMedia").value = story.getElementsByTagName("socialmediabuttontext")[0].textContent;
				document.getElementById("editYoutubeSourceLang").value = story.getElementsByTagName("youtubelinksourcelang")[0].textContent;
				document.getElementById("editYoutubeBoth").value = story.getElementsByTagName("youtubelinkboth")[0].textContent;
				document.getElementById("editYoutubeTranslationLang").value = story.getElementsByTagName("youtubelinktranslationlang")[0].textContent;
				document.getElementById("editWholeAudio").value = story.getElementsByTagName("wholestoryaudio")[0].textContent;
				document.getElementById("editImage").value = story.getElementsByTagName("image")[0].textContent;
				document.getElementById("editHandout").value = story.getElementsByTagName("handout")[0].textContent;

				var morphoglossLines = story.getElementsByTagName("line");
				for (var l = 0; l < morphoglossLines.length; l++) {
					document.getElementById(("editLine" + (l + 1) + "_source")).value = morphoglossLines[l].getElementsByTagName("source")[0].textContent;
					document.getElementById(("editLine" + (l + 1) + "_translation")).value = morphoglossLines[l].getElementsByTagName("translation")[0].textContent;
					document.getElementById(("editLine" + (l + 1) + "_notes")).value = morphoglossLines[l].getElementsByTagName("note")[0].textContent;
					document.getElementById(("editLine" + (l + 1) + "_audio")).value = morphoglossLines[l].getElementsByTagName("lineaudio")[0].textContent;

					// set dropdown

					// if the story corpus line has a speaker...
					if (morphoglossLines[l].getElementsByTagName("speaker").length > 0) {

						currentLineSpeaker = morphoglossLines[l].getElementsByTagName("speaker")[0].textContent;

						// if that attribute value is not in the dropdown options (in other words, if someone wrote a custom value for it)
						// we'll add it to the dropdown options... this is only relevant if people can define their own initials for a speaker 

						document.getElementById(("editLine" + (l + 1) + "_editSpeakerDropDown")).value = currentLineSpeaker.trim();
					}

					// loop for morphemes
					currentLineMorphemes = morphoglossLines[l].getElementsByTagName("morpheme");
					for (var m = 0; m < currentLineMorphemes.length; m++) {
						document.getElementById(("editLine" + (l + 1) + "_m" + (m + 1))).value = currentLineMorphemes[m].getElementsByTagName("m")[0].textContent;
						document.getElementById(("editLine" + (l + 1) + "_g" + (m + 1))).value = currentLineMorphemes[m].getElementsByTagName("g")[0].textContent;

						// check to see if we need another morpheme
						if ((currentLineMorphemes[(m + 1)] !== null) && (document.getElementById(("editLine" + (l + 1) + "_m" + (m + 2))) === null)) {
							addEditMorpheme(("editLine" + (l + 1) + "_m" + (m + 2)));
						}
					}

					// check to see if we need to add another line to the HTML: if there is another morphogloss line we need to display AND
					// if there is no available line in the document
					if ((morphoglossLines[(l + 1)] !== null) && (document.getElementById(("editLine" + (l + 2))) === null)) {
						addEditLine((l + 2));
					}
				}

				// we keep the save changes button disabled until the entire story has loaded
				// in case people click save changes before all of the lines have been loaded. 
				saveChangesButton.removeAttribute("disabled");
				$("#loadingAnimation1").fadeOut("slow");
				$("#loadingAnimation1").remove();
			}
		};

		xhttp.open("GET", "../stories.xml", true);
		xhttp.send();
	}
}