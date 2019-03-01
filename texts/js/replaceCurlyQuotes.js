// When users enter things in the update page, we want to make sure we use the same characters, so that
// the search engine gets things right. Hence, when users type curly single or double quotes, we want to replace
// them with straight ones, so that all quotes are the same. This matters for our language, because we use a single
// quote to mark ejectives. Hence, without this code, our search engine might miss examples written with different 
// quote types. 
String.prototype.replaceAll = function (search, replacement) {
    var target = this;
    return target.replace(new RegExp(search, 'g'), replacement);
};

/* replacing curly quotes and apostrophes with straight ones automatically as a user types */
$(document).on("input", "input:text", function () {
    $(this).val($(this).val().replaceAll("‘", "'"));
    $(this).val($(this).val().replaceAll("’", "'"));
    $(this).val($(this).val().replaceAll('“', '"'));
    $(this).val($(this).val().replaceAll('”', '"'));
    $(this).val($(this).val().replaceAll('ṱ', 't̪'));
});

$(document).on("input", "textarea", function () {
    $(this).val($(this).val().replaceAll("‘", "'"));
    $(this).val($(this).val().replaceAll("’", "'"));
    $(this).val($(this).val().replaceAll('“', '"'));
    $(this).val($(this).val().replaceAll('”', '"'));
    $(this).val($(this).val().replaceAll('ṱ', 't̪'));
});

/* replacing special characters in speaker initials box */
$(document).on("input", "input[name*='speaker']", function () {
    $(this).val($(this).val().replace(/[^a-z A-Z0-9_?]/g, '_'));
});