// In the update page, when loading sound files, users need to choose which story
// they are uploading sound files for. To get a list of existing stories, they click a button
// that calls this function. 
var updateStoryVersions = function () {
	storyDropdown = document.getElementById("storyDropdown");
	storyDropdown.innerHTML = "";
	var xhttp = new XMLHttpRequest();
	xhttp.onreadystatechange = function () {
		if (this.readyState == 4 && this.status == 200) {
			getStoryVersions(this);
		}
	};
	xhttp.open("GET", "../stories.xml", true);
	xhttp.send();

	function getStoryVersions(xml) {
		var xmlDoc = xml.responseXML;
		var stories = xmlDoc.getElementsByTagName("story");
		stories = [].slice.call(stories).sort(function (a, b) {
			return parseInt(a.getAttribute("id")) < parseInt(b.getAttribute("id")) ? 1 : -1;
		});
		for (var s = 0; s < stories.length; s++) {
			option = document.createElement("option");
			option.value = stories[s].getElementsByTagName("storytitle")[0].textContent.replace(/\s/g, '') + stories[s].getAttribute('id');
			option.innerHTML = stories[s].getElementsByTagName("storytitle")[0].textContent + " " + stories[s].getElementsByTagName("narrator")[0].textContent + " " + stories[s].getAttribute('id');
			storyDropdown.appendChild(option);
		}
	}
}
// When users are trying to edit a story, they need its ID number. If they don't know it, they can search
// for a story using a text field that calls this function when a value is inputted. Most of the work
// is handled by showRecords.php
function showRecords(str) {
	// this is the code that powers the "display records" section. 
	$("#display").fadeOut(600, function () {
		$(this).html('<div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div>').fadeIn();
	});

	if (str == "") {
		$("#display").fadeOut(600, function () {
			$(this).html('').fadeIn();
		});
		$("#loadingAnimation1").remove();
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
			$("#display").fadeOut(600, function () {
				$(this).html(xmlhttp.responseText).fadeIn();
			});
			$("#loadingAnimation1").remove();
		}
	}
	xmlhttp.open("GET", "showRecords.php?title=" + str, true);
	xmlhttp.send();
}