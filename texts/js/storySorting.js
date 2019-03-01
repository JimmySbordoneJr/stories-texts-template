/* This file handles the sorting by author and sorting by title in the Index and secretIndex files.  */
function sortByTitle() {
    var storyContainer = document.getElementById("storyContainer");
    var stories = document.getElementsByClassName("storyCard");
    var newInnerHTML = "";
    var storiesArr = [].slice.call(stories).sort(function (a, b) {
        return a.getElementsByClassName("card-header")[0].textContent > b.getElementsByClassName("card-header")[0].textContent ? 1 : -1;
    });

    // rebuild it
    var count = stories.length;
    var openDiv = "<div class='row'><div class='col'><div class='card-deck'>";
    var closeDiv = "</div></div></div>";
    var countForInvisibleCards = 3;
    for (i = 0; i < count; i++) {
        countForInvisibleCards--;
        // if this is the fist element, create a new row
        if (i === 0) {
            newInnerHTML += openDiv;
        }
        var currentStory = storiesArr[i].outerHTML;

        // add the story 
        newInnerHTML += currentStory;

        // if this is the third element in the row, close this row and open a new one
        if ((i + 1) % 3 === 0) {
            newInnerHTML += closeDiv;
            newInnerHTML += openDiv;
            countForInvisibleCards = 3;

            if ((i + 1) === count) {
                break; // this keeps us from closing the div twice
            }
            else {
                continue;
            }
        }
        // if the current item is the last one, close the row 
        if ((i + 1) === count) {
            // fill in invisible cards so that they are all the same size. 
            for (c = 0; c < countForInvisibleCards; c++) {
                newInnerHTML += '<div class="card bg-light border-secondary invisible"><h5 class="card-header text-center"><a href="#" target="_blank"></a></h5><div class="card-body"></div></div>';
            }
            newInnerHTML += closeDiv;
        }
    }

    $(storyContainer).fadeOut(600, function () {
        $(this).html(newInnerHTML).fadeIn();
    });
}


function sortByAuthor() {
    var storyContainer = document.getElementById("storyContainer");
    var stories = document.getElementsByClassName("storyCard");
    var newInnerHTML = "";

    if (stories.length > 0) {
        var storiesArr = [].slice.call(stories).sort(function (a, b) {
            return a.getAttribute("data-narrator") > b.getAttribute("data-narrator") ? 1 : -1;
        });

        // rebuild it
        var count = stories.length;
        var openDiv = "<div class='row'><div class='col'><div class='card-deck'>";
        var closeDiv = "</div></div></div>";
        var countForInvisibleCards = 3;
        newInnerHTML += "<div class=\"row\"><div class=\"col\"><h1 id=\"" + storiesArr[0].getAttribute("data-narrator").replace(" ", "_") + "\">" + storiesArr[0].getAttribute("data-narrator") + "</h1></div></div>";
        for (i = 0; i < count; i++) {
            countForInvisibleCards--;
            // if this is the fist element, create a new row
            if (i == 0) {
                newInnerHTML += openDiv;
            }
            var currentStory = storiesArr[i].outerHTML;

            // add the story 
            newInnerHTML += currentStory;

            // if the next story is told by a different author, close the row, add the new author's <h1>, open that row, and continue to the next iteration of the loop
            if (((i + 1) !== count) && (storiesArr[(i + 1)].getAttribute("data-narrator") !== storiesArr[i].getAttribute("data-narrator"))) {
                for (c = 0; c < countForInvisibleCards; c++) {
                    newInnerHTML += '<div class="card bg-light border-secondary invisible"><h5 class="card-header text-center"><a href="#" target="_blank"></a></h5><div class="card-body" style="background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4));"></div></div>';
                }
                newInnerHTML += closeDiv;
                newInnerHTML += "<div class=\"row\"><div class=\"col\"><h1 id=\"" + storiesArr[0].getAttribute("data-narrator").replace(" ", "_") + "\">" + storiesArr[(i + 1)].getAttribute("data-narrator") + "</h1></div></div>";
                newInnerHTML += openDiv;
                countForInvisibleCards = 3;
                continue;
            }

            // if this is the third element in the row, close this row and open a new one
            if (countForInvisibleCards === 0) {
                newInnerHTML += closeDiv;
                newInnerHTML += openDiv;
                countForInvisibleCards = 3;
                continue; // this break keeps us from closing the div twice
            }
            // if the current item is the last one, close the row 
            if ((i + 1) === count) {
                // fill in invisible cards so that they are all the same size. 
                for (c = 0; c < countForInvisibleCards; c++) {
                    newInnerHTML += '<div class="card bg-light border-secondary invisible"><h5 class="card-header text-center"><a href="#" target="_blank"></a></h5><div class="card-body" style="background: linear-gradient(to right bottom, rgba(256, 256, 256, 0.4), rgba(256, 256, 256, 0.4));"></div></div>';
                }
                newInnerHTML += closeDiv;
            }
        }
    }
    $(storyContainer).fadeOut(600, function () {
        $(this).html(newInnerHTML).fadeIn();
    });
}