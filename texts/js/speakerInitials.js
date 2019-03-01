// In the update page, when users enter something into the narrator and interviewer fields,
// we want them to be able to assign each line to the initials of one of the narrators or speakers.
function fillInSpeakerInitials(edit) {
    if (edit === undefined) {
        var dropDowns = document.getElementsByClassName("speakerDropDown");
        /* I need the .replace() call to change special characters that are not safe for XML */
        var narratorArr = document.getElementById("narrator").value.replace(/[^a-z A-Z0-9_,]/g, '_').split(",").filter(Boolean);
        var interviewerArr = document.getElementById("interviewer").value.replace(/[^a-z A-Z0-9_,]/g, '_').split(",").filter(Boolean);
    }
    else {
        var dropDowns = document.getElementsByClassName("editSpeakerDropDown");
        var narratorArr = document.getElementById("editNarrator").value.replace(/[^a-z A-Z0-9_,]/g, '_').split(",").filter(Boolean);
        var interviewerArr = document.getElementById("editInterviewer").value.replace(/[^a-z A-Z0-9_,]/g, '_').split(",").filter(Boolean);
    }
    if (narratorArr.length > 0 || interviewerArr.length > 0) {
        var speakerArr = narratorArr.concat(interviewerArr);
        var newInnerHTML = "<option value=' '></option>";
        for (var s = 0; s < speakerArr.length; s++) {
            var nameArr = speakerArr[s].trim().split(" ");
            if (nameArr.length > 1) {
                var initials = "";
                for(var name=0; name<nameArr.length; name++){
                    initials += nameArr[name][0];
                }
            }
            else {
                var initials = nameArr[0][0];
            }
            initials = initials.toUpperCase();
            newInnerHTML += "<option value='" + initials + "'>" + initials + "</option>";
        }

        for (var i = 0; i < dropDowns.length; i++) {
            dropDowns[i].innerHTML = newInnerHTML;
        };
    }
}