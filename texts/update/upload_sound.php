<?php
// This file manages the uploading of sound files to the server. 
// If successful, a banner appears at the top of the update page. If not, an error message appears.
$success = FALSE;
$story = str_replace("/", "_", $_POST['storyDropdown']);

if(isset($_POST['submit'])){
	if ($_FILES["file"]["error"][0] > 0){
		echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Invalid File.</h4></div></div></div></div>";
		include("story_update_page.php");
  	}
  	else{
		$dirname = "../sounds/" . $story; 
		if(is_dir($dirname)){	
			//Note, we are limited to 25 files at once. 
			// If you do not have this limit, replace the number 26 in line 23 with $length, and uncomment line 21. 
			//$length = count($_FILES['file']['name']);  
			for ($x=0; $x<26; $x++) {
				move_uploaded_file($_FILES["file"]["tmp_name"][$x], $dirname . "/" . $_FILES["file"]["name"][$x]);
				$success = TRUE;
			}
		}
  	}
}

if ($success) {
	echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Files Successfully Uploaded!</h4><p>Make sure the file names match the ones listed in the story database.</p></div></div></div></div>";
	include("story_update_page.php");   
}
?>




