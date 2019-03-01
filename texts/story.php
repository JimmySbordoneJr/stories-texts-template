<?php
// When users try to view a story, this file directs them to the correct page.
// If the story number they requested is not valid, they receive an error message.
// If the story exists, but is password protected, they are directed to draft.php, a login page.
// If the story is published, they are directed to valid_story.php to view it.
$id = $_GET["story"];
$file = 'stories.xml';
$xmlDoc = new DOMDocument(); 
$xmlDoc->load($file); 
$xpath = new DOMXPath($xmlDoc); 

if(isset($id) && !is_null($id)){
	$story = $xpath->query("/storycorpus/story[@id='$id']");

	if($story->length > 0){
		$story = $story->item(0);
		if($story->getElementsByTagName("approved")->item(0)->nodeValue === "True"){
			include("valid_story.php");
		}
		else{
			include("draft.php");
		}
	} else{
		include("error_message.php");
	}
}
?>