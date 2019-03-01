<?php
// This file manages the uploading of handouts to the server. 
// If successful, a banner appears at the top of the update page. If not, an error message appears.

$success = FALSE;
if(isset($_POST['submit'])){
   if($_FILES["file"]["error"][0] > 0){
      echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Invalid Handout File.</h4></div></div></div></div>";
      include("story_update_page.php");
   }
   else{
		$dirname = "../handouts"; 	
		$length = count($_FILES['file']['name']);
       
	   for ($x=0; $x<$length; $x++) {
			move_uploaded_file($_FILES["file"]["tmp_name"][$x], $dirname . "/" . $_FILES["file"]["name"][$x]);
			$success = TRUE;
		}	
   }
}

if ($success) {
   echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Handout Successfully Uploaded!</h4><p>Make sure the handout filename in the story matches this file's name.</p></div></div></div></div>";
   include("story_update_page.php");   
}
?>




