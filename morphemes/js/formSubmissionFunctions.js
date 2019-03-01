// This code handles the form submissions for deleting a morpheme and regenerating the morpheme database from
// an existing dictionary, phrasicon, or story corpus. It passes data along to inject.php, which modifies the
// database. 

$(document).ready(function () {
    $('.delete').on('submit', function (e) {
        var confirmed = confirm("Are you sure you want to delete this morpheme? \n" + this.parentNode.parentNode.childNodes[1].textContent + "     " + this.parentNode.parentNode.childNodes[2].textContent);
        if (confirmed == true) {
            $.ajax({
                url: './inject.php',
                data: $(this).serialize(),
                type: 'POST',
                success: function (data) {
                    alert("Morpheme Successfully Deleted"); //=== Show Success Message==
                    location.reload(true);
                },
                error: function (data) {
                    alert("Error."); //===Show Error Message====
                }
            });
            e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click"===
        } else {
            return false;
        }
    });

    $('#morphemeDBPhrasicon').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#morphemeDBPhrasicon').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Query submitted. The Morpheme Database has been regenerated (Phrasicon)."); //=== Show Success Message==
                });
                $("#loadingAnimation").remove();
            },
            error: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click" ===
    });
    $('#morphemeDBDictionary').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#morphemeDBDictionary').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Query submitted. The Morpheme Database has been regenerated (Dictionary)."); //=== Show Success Message==
                });
                $("#loadingAnimation").remove();
            },
            error: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click" ===
    });
    $('#morphemeDBStorycorpus').on('submit', function (e) {
        $(document.body).append('<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>');

        $.ajax({
            url: './inject.php',
            data: $('#morphemeDBStorycorpus').serialize(),
            type: 'POST',
            success: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Query submitted. The Morpheme Database has been regenerated (Story Corpus)."); //=== Show Success Message==
                });
                $("#loadingAnimation").remove();
            },
            error: function (data) {
                $("#loadingAnimation").fadeOut("slow", function () {
                    alert("Error."); //===Show Error Message====
                });
                $("#loadingAnimation").remove();
            }
        });
        e.preventDefault(); //=== To Avoid Page Refresh and Fire the Event "Click" ===
    });
});

function clear(id) {
    document.getElementById(id).reset();
}