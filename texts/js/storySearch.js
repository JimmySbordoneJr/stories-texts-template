// This code powers the search bar on the index and password protected index pages.
function clearSearch() {
    document.getElementById("storySearch").value = "";
    $("#searchButton").click();
}

function storySearch(published_only) {
    var languageChoice = document.getElementById("languageChoice").value;
    var searchTerm = document.getElementById("storySearch").value;

    // if search box is empty, just reset everything and display all stories
    if (searchTerm.trim() == "") {
        if (published_only === true) {
            resetStories(true);
        } else {
            resetStories();
        }
        return;
    }

    // if searching by author
    if (searchTerm.substring(0, 8) === "Speaker:") {
        searchTerm = searchTerm.replace(/_/g, ' ');
        searchTerm = searchTerm.split("Speaker:")[1];
        var storyContainer = document.getElementById("storyContainer");
        $(storyContainer).fadeOut(600, function () {
            $(this).html('<div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div>').fadeIn();
        });
        setTimeout(function () {
            var xhttp = new XMLHttpRequest();
            xhttp.onreadystatechange = function () {
                if (this.readyState == 4 && this.status == 200) {
                    var storycorpus = this.responseXML;
                    var allStories = storycorpus.getElementsByTagName("story");
                    var stories = [];
                    var storyDescriptions = [];
                    for (var allstory = 0; allstory < allStories.length; allstory++) {
                        // if it's the story we're looking for...
                        var currentAuthors = allStories[allstory].getElementsByTagName("narrator")[0].textContent.toLowerCase();
                        if (currentAuthors.includes(searchTerm.toLowerCase())) {
                            stories.push(allStories[allstory]);
                            storyDescriptions.push(allStories[allstory].getElementsByTagName("description")[0].textContent);
                        }
                    }
                    // Note: the next 70 lines or so are repeated twice in this file, and once in resetstories.js. I could probably 
                    // have put it in its own function to make the code DRY, but this code will probably not be used
                    // beyond these three times, and writing that function is extremely complex. Hence,
                    // I left the code as it was, seeing as it would probably just be simpler to copy and paste code
                    // three times than wrangle the complex parameters said function would require.
                    // If you end up writing that function, I'd love to add it to the Github template!

                    var count = stories.length;
                    var newInnerHTML = "";
                    newInnerHTML += "<div class='row'><div class='col'><h1>" + searchTerm.toTitleCase() + "</h1></div></div>";
                    var openDiv = "<div class='row'><div class='col'><div class='card-deck'>";
                    var closeDiv = "</div></div></div>";
                    var countForInvisibleCards = 3;
                    for (i = 0; i < count; i++) {
                        countForInvisibleCards--;
                        // if this is the fist element, create a new row
                        if (i == 0) {
                            newInnerHTML += openDiv;
                        }
                        var currentStory = stories[i];
                        descriptionToCrop = storyDescriptions[i].split(" ");
                        croppedDescription = "";

                        // okay, so we will crop the descriptions a bit. 128 characters is a common limit. The average word length in English
                        // is 5.1 letters, as of 2018. Hence, 128/5 is around 25 words as a limit. Hence, we will break the description into 
                        // a list of words, and put the first 25 words together. 
                        // Well, I was going to do it like that, but I got to thinking...
                        // ...Just using word length like this neglects the fact that different text passages will have different
                        // average word lengths. 
                        // I decided to be really fancy. This uses the average word length of the description 
                        // in determining how many words to show. This does a better job of ensuring that the text boxes are all the same size (or damn near it)
                        var totalCharacters = 0;
                        for (var word = 0; word < descriptionToCrop.length; word++) {
                            totalCharacters += descriptionToCrop[word].length;
                        }
                        averageWordLength = Math.round((totalCharacters / descriptionToCrop.length));
                        adjustedNumberOfWords = Math.round((128 / averageWordLength));
                        for (word = 0; word < adjustedNumberOfWords; word++) {
                            if (descriptionToCrop[word] == undefined) {
                                break;
                            }
                            croppedDescription += descriptionToCrop[word] + " ";
                        }

                        if (descriptionToCrop.length > adjustedNumberOfWords) {
                            croppedDescription += "..."; // add ... to the end
                        }

                        // add the story 
                        newInnerHTML += "<div class=\"card bg-light border-secondary storyCard\" data-narrator=\"" + currentStory.getElementsByTagName('narrator')[0].textContent + "\"><h5 class=\"card-header text-center\"><a href=\"story.php?story=" + currentStory.getAttribute('id') + "\">" + currentStory.getElementsByTagName("storytitle")[0].textContent + "</a></h5><div class=\"card-body\" style=\"background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4)), url('img/" + currentStory.getElementsByTagName("image")[0].textContent + "'); background-size: cover; background-position: center center;\"><p class=\"card-text\"><a href=\"story.php?story=" + currentStory.getAttribute('id') + "\">" + croppedDescription + "</a></p></div></div>";

                        var endOfRow = (i + 1) % 3 === 0;
                        var endOfStories = (i + 1) === count;
                        if (endOfRow && endOfStories) {
                            newInnerHTML += closeDiv;
                        } else if (endOfRow && !endOfStories) {
                            newInnerHTML += closeDiv;
                            newInnerHTML += openDiv;
                            countForInvisibleCards = 3;
                        } else if (!endOfRow && endOfStories) {
                            // fill in invisible cards so that they are all the same size. 
                            for (c = 0; c < countForInvisibleCards; c++) {
                                newInnerHTML += '<div class="card bg-light border-secondary invisible"><h5 class="card-header text-center"><a href="#" target="_blank"></a></h5><div class="card-body" style="background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4));"></div></div>';
                            }
                            newInnerHTML += closeDiv;
                        }
                    }
                    if (newInnerHTML == "") {
                        newInnerHTML = "<p>Sorry, no published stories containing that were found in " + document.getElementById("languageChoice").value + ". Did you select the correct language?</p>";
                    }
                    $(storyContainer).fadeOut(600, function () {
                        $(this).html(newInnerHTML).fadeIn();
                    });
                    $("#loadingAnimation").remove();
                }
            }
            xhttp.open("GET", "stories.xml", true);
            xhttp.send();
        }, 600);
        return;

    }
    // searching via link from story text
    if (document.getElementById("storySearch").hasAttribute("data-gloss")) {
        var searchGloss = document.getElementById("storySearch").getAttribute("data-gloss");
    }

    // if there is actually a search term that was entered on this page...
    searchTerm = searchTerm.toLowerCase();
    var storyContainer = document.getElementById("storyContainer");
    $(storyContainer).fadeOut(600, function () {
        $(this).html('<div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div>').fadeIn();
    });
    setTimeout(function () {
        var xhttp = new XMLHttpRequest();
        xhttp.onreadystatechange = function () {
            if (this.readyState == 4 && this.status == 200) {
                var storycorpus = this.responseXML;
                var allStories = storycorpus.getElementsByTagName("story");
                var stories = [];
                var storyDescriptions = [];
                for (var allstory = 0; allstory < allStories.length; allstory++) {
                    if (allStories[allstory].getElementsByTagName("storytitle")[0].textContent.toLowerCase().includes(searchTerm) || allStories[allstory].getElementsByTagName("description")[0].textContent.toLowerCase().includes(searchTerm)) {
                        var storyCheck = false;
                        for (var st = 0; st < stories.length; st++) {
                            if (stories[st] == allStories[allstory]) {
                                storyCheck = true;
                                storyDescriptions[st] += "..." + allStories[allstory].getElementsByTagName("description")[0].textContent;
                            }
                        }
                        if (storyCheck == false) {
                            stories.push(allStories[allstory]);
                            storyDescriptions.push(allStories[allstory].getElementsByTagName("description")[0].textContent);
                        }
                    }
                    var storyLines = allStories[allstory].getElementsByTagName("line");
                    for (var line = 0; line < storyLines.length; line++) {
                        var currentStoryLine = storyLines[line];
                        if (languageChoice == "translation") {
                            if (currentStoryLine.getElementsByTagName("translation")[0].textContent.toLowerCase().includes(" " + searchTerm)) {
                                // I add a space to searchTerm so if we're searching for 'his', it won't return stories that contain 'this'
                                var storyCheck = false;
                                for (var st = 0; st < stories.length; st++) {
                                    if (stories[st] == allStories[allstory]) {
                                        storyCheck = true;
                                        storyDescriptions[st] += "..." + currentStoryLine.getElementsByTagName("translation")[0].textContent;
                                    }
                                }
                                if (storyCheck == false) {
                                    stories.push(allStories[allstory]);
                                    storyDescriptions.push(currentStoryLine.getElementsByTagName("translation")[0].textContent);
                                }
                            }
                        }
                        else {
                            if (currentStoryLine.getElementsByTagName("source")[0].textContent.toLowerCase().includes(searchTerm)) {
                                var storyCheck = false;
                                for (var st = 0; st < stories.length; st++) {
                                    if (stories[st] == allStories[allstory]) {
                                        storyCheck = true;
                                        storyDescriptions[st] += "..." + currentStoryLine.getElementsByTagName("source")[0].textContent;
                                    }
                                }
                                if (storyCheck == false) {
                                    stories.push(allStories[allstory]);
                                    storyDescriptions.push(currentStoryLine.getElementsByTagName("source")[0].textContent);
                                }
                            }
                        }
                        var morphemes = currentStoryLine.getElementsByTagName("morpheme");
                        for (var m = 0; m < morphemes.length; m++) {
                            if (languageChoice == "translation") {
                                if (morphemes[m].getElementsByTagName("g")[0].textContent.toLowerCase() == searchTerm) {
                                    var storyCheck = false;
                                    for (var st = 0; st < stories.length; st++) {
                                        if (stories[st] == allStories[allstory]) {
                                            storyCheck = true;
                                            storyDescriptions[st] += "..." + currentStoryLine.getElementsByTagName("source")[0].textContent;
                                        }
                                    }
                                    if (storyCheck == false) {
                                        stories.push(allStories[allstory]);
                                        storyDescriptions.push(currentStoryLine.getElementsByTagName("translation")[0].textContent);
                                    }
                                }
                            }
                            else {
                                if (morphemes[m].getElementsByTagName("m")[0].textContent.toLowerCase() == searchTerm) {
                                    if (typeof searchGloss === 'undefined') {
                                        var storyCheck = false;
                                        for (var st = 0; st < stories.length; st++) {
                                            if (stories[st] == allStories[allstory]) {
                                                storyCheck = true;
                                                storyDescriptions[st] += "..." + currentStoryLine.getElementsByTagName("source")[0].textContent;
                                            }
                                        }
                                        if (storyCheck == false) {
                                            stories.push(allStories[allstory]);
                                            storyDescriptions.push(currentStoryLine.getElementsByTagName("source")[0].textContent);
                                        }
                                    }
                                    else {
                                        if (morphemes[m].getElementsByTagName("g")[0].textContent.toLowerCase() == searchGloss.toLowerCase()) {
                                            var storyCheck = false;
                                            for (var st = 0; st < stories.length; st++) {
                                                if (stories[st] == allStories[allstory]) {
                                                    storyCheck = true;
                                                    storyDescriptions[st] += "..." + currentStoryLine.getElementsByTagName("source")[0].textContent;
                                                }
                                            }
                                            if (storyCheck == false) {
                                                stories.push(allStories[allstory]);
                                                storyDescriptions.push(currentStoryLine.getElementsByTagName("source")[0].textContent);
                                            }
                                        }
                                    }
                                }
                            }
                        }
                    }
                }
                var count = stories.length;
                var newInnerHTML = "";
                var openDiv = "<div class='row'><div class='col'><div class='card-deck'>";
                var closeDiv = "</div></div></div>";
                var countForInvisibleCards = 3;
                for (i = 0; i < count; i++) {
                    countForInvisibleCards--;
                    // if this is the fist element, create a new row
                    if (i == 0) {
                        newInnerHTML += openDiv;
                    }
                    var currentStory = stories[i];
                    descriptionToCrop = storyDescriptions[i].split(" ");
                    croppedDescription = "";

                    // okay, so we will crop the descriptions a bit. 128 characters is a common limit. The average word length in English
                    // is 5.1 letters, as of 2018. Hence, 128/5 is around 25 words as a limit. Hence, we will break the description into 
                    // a list of words, and put the first 25 words together. 
                    // Well, I was going to do it like that, but I got to thinking...
                    // ...Just using word length like this neglects the fact that different text passages will have different
                    // average word lengths. 
                    // I decided to be really fancy. This uses the average word length of the description 
                    // in determining how many words to show. This does a better job of ensuring that the text boxes are all the same size (or damn near it)
                    var totalCharacters = 0;
                    for (var word = 0; word < descriptionToCrop.length; word++) {
                        totalCharacters += descriptionToCrop[word].length;
                    }
                    averageWordLength = Math.round((totalCharacters / descriptionToCrop.length));
                    adjustedNumberOfWords = Math.round((128 / averageWordLength));
                    for (word = 0; word < adjustedNumberOfWords; word++) {
                        if (descriptionToCrop[word] == undefined) {
                            break;
                        }
                        croppedDescription += descriptionToCrop[word] + " ";
                    }

                    if (descriptionToCrop.length > adjustedNumberOfWords) {
                        croppedDescription += "..."; // add ... to the end
                    }

                    // add the story 
                    newInnerHTML += "<div class=\"card bg-light border-secondary storyCard\" data-narrator=\"" + currentStory.getElementsByTagName('narrator')[0].textContent + "\"><h5 class=\"card-header text-center\"><a href=\"story.php?story=" + currentStory.getAttribute('id') + "\">" + currentStory.getElementsByTagName("storytitle")[0].textContent + "</a></h5><div class=\"card-body\" style=\"background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4)), url('img/" + currentStory.getElementsByTagName("image")[0].textContent + "'); background-size: cover; background-position: center center;\"><p class=\"card-text\"><a href=\"story.php?story=" + currentStory.getAttribute('id') + "\">" + croppedDescription + "</a></p></div></div>";

                    var endOfRow = (i + 1) % 3 === 0;
                    var endOfStories = (i + 1) === count;
                    if (endOfRow && endOfStories) {
                        newInnerHTML += closeDiv;
                    } else if (endOfRow && !endOfStories) {
                        newInnerHTML += closeDiv;
                        newInnerHTML += openDiv;
                        countForInvisibleCards = 3;
                    } else if (!endOfRow && endOfStories) {
                        // fill in invisible cards so that they are all the same size. 
                        for (c = 0; c < countForInvisibleCards; c++) {
                            newInnerHTML += '<div class="card bg-light border-secondary invisible"><h5 class="card-header text-center"><a href="#" target="_blank"></a></h5><div class="card-body" style="background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4));"></div></div>';
                        }
                        newInnerHTML += closeDiv;
                    }

                }
                if (newInnerHTML == "") {
                    newInnerHTML = "<p>Sorry, no published stories containing that were found in " + document.getElementById("languageChoice").value + ". Did you select the correct language?</p>";
                }
                $(storyContainer).fadeOut(600, function () {
                    $(this).html(newInnerHTML).fadeIn();
                });
                $("#loadingAnimation").remove();
            }
        }
        xhttp.open("GET", "stories.xml", true);
        xhttp.send();
    }, 600);
    // if we were sent here from a story and then want to continue searching, we want to clear out the data gloss 
    document.getElementById("storySearch").removeAttribute("data-gloss");
}
