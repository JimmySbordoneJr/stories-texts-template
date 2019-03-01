// On the stories and texts homepage, this function is called if the user searches for an empty string.
// it simply resets the page and displays all of the stories.

function resetStories(published_only) {
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
                if (published_only === true) {
                    // if resetStories was called from the index page, only show published stories
                    for (var allstory = 0; allstory < allStories.length; allstory++) {
                        if (allStories[allstory].getElementsByTagName("approved")[0].textContent == "True") {
                            stories.push(allStories[allstory]);
                        }
                    }
                }
                else {
                    // if resetStories was called from the password protected index page, show all stories
                    for (var allstory = 0; allstory < allStories.length; allstory++) {
                        stories.push(allStories[allstory]);
                    }
                }

                var count = stories.length;
                var newInnerHTML = "";
                var openDiv = "<div class='row'><div class='col'><div class='card-deck'>";
                var closeDiv = "</div></div></div>";
                var countForInvisibleCards = 3;
                for (i = 0; i < count; i++) {
                    countForInvisibleCards--;
                    // if this is the first element, create a new row
                    if (i == 0) {
                        newInnerHTML += openDiv;
                    }
                    var currentStory = stories[i];
                    descriptionToCrop = currentStory.getElementsByTagName("description")[0].textContent.split(" ");
                    croppedDescription = "";

                    // okay, so we will crop the descriptions a bit. 128 characters is a common limit. The average word length in English
                    // is 5.1 letters, as of 2018. Hence, 128/5 is around 25 words as a limit. Hence, we will break the description into 
                    // a list of words, and put the first 25 words together. 
                    // Well, I was going to do it like that, but I got to thinking...
                    // ...Just using word length like this neglects the fact that different text passages will have different
                    // average word lengths. 
                    // I decided to be really fancy. This uses the average word length of the description 
                    // in determining how many words to show. 
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
                $(storyContainer).fadeOut(600, function () {
                    $(this).html(newInnerHTML).fadeIn();
                });
                $("#loadingAnimation").remove();
            }
        };
        xhttp.open("GET", "stories.xml", true);
        xhttp.send();
    }, 600);
}