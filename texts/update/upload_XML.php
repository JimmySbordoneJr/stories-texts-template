<?php
// This file manages the uploading of a new version of the story corpus. 
// If successful, a banner appears at the top of the update page. If not, an error message appears.
$success = FALSE;

if(isset($_POST['submit'])){
  if ($_FILES["file"]["error"][0] == 0){
  $y = 0;
  $length = count($_FILES['file']['name']);    
    for ($x=0; $x<$length; $x++) {
      if ($_FILES["file"]["name"][$x] != "stories.xml") {
        break;   
      }
      move_uploaded_file($_FILES["file"]["tmp_name"][$x], "../" . $_FILES["file"]["name"][$x]);
      $success = TRUE;
    }   
  }
}

if ($success) {
  echo "<div class=\"jumbotron\" style=\"margin-top: 4rem;\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col text-center\"><br/><h2>XML Upload Success!</h2></div></div></div></div>";   
} 
else {
  echo "<div class=\"jumbotron\" style=\"margin-top: 4rem;\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col text-center\"><br/><h2>XML Upload Failed. Make sure the file name is stories.xml and try again. If this error persists, please contact us.</h2></div></div></div></div>";
}

include("story_update_page.php");
?>




