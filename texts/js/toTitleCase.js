/* This function takes strings and makes each word lowercase except for the first character. */
String.prototype.toTitleCase = function () {
    var strArr = this.split(" ");
    var returnString = "";
    for (var i = 0; i < strArr.length; i++) {
        returnString += strArr[i].substr(0, 1).toUpperCase() + strArr[i].substr(1).toLowerCase() + " ";
    }
    return returnString;
}