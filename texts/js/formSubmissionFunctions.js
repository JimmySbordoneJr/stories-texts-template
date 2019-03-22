// In the update page, some of the form submissions are handled by JS. When they are submitting, the 
// page gets a grey overlay with the loading animation showing

$(document).ready(function () {
    $('#create').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation1"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#create').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Query submitted. Entry created."); //=== Show Success Message==
                    clear('create');
                    document.getElementById("datalistContainer").innerHTML = "<datalist id=\"list_line1_g1\"></datalist>";
                });
                $("#loadingAnimation1").remove();
                location.reload(true);
            },
            error: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation1").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
});

$(document).ready(function () {
    $('#modify').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation1"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#modify').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Query submitted. Entry edited."); //=== Show Success Message==
                    // clear out the edit form
                    clear('modify');
                    // clear out the old English suggestions
                    document.getElementById("datalistEditContainer").innerHTML = "<datalist id=\"list_editLine1_g1\"></datalist>";
                    // get rid of excess edit rows and excess morphemes by reloading page
                    location.reload(true);
                })
                $("#loadingAnimation1").remove();

            },
            error: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                })
                $("#loadingAnimation1").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
});

$(document).ready(function () {
    $('#mass_edit').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation1"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#mass_edit').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Query submitted. Mass edit complete."); //=== Show Success Message==
                    clear('mass_edit');
                });
                $("#loadingAnimation1").remove();
            },
            error: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation1").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
});

$(document).ready(function () {
    $('#delete').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation1"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#delete').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Query submitted. Make sure to remove videos from Youtube, and ask the web developer to remove the image, audio, and handout from the web server."); //=== Show Success Message==
                    clear('delete');
                });
                $("#loadingAnimation1").remove();
            },
            error: function (data) {
                $("#loadingAnimation1").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation1").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
    });
});

function clear(id) {
    document.getElementById(id).reset();
}
