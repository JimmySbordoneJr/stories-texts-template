<?php
// In the update page, this file handles the suggesting of translations for morphemes.

$returnString = "";
$txt = $_GET['txt'];
$words = explode(" ", $txt);
$txt = "<s1> <s2> " . $txt . " </s1> </s2>";

for ($counter = 0; $counter < sizeof($words); $counter++) {

$morpheme = $words[$counter];
$num = $counter + 1;

if ($morpheme == "") {  // if blank, return blank
    echo "";    
}

// load morpheme database
$xmlDoc = new DOMDocument();
$xmlDoc->load("../../morphemes/morphemes.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("//source[text()=\"$morpheme\"]/..");

if ($result->length == 0) {    
	$returnString .= "? ";
} else { 
	$gloss = "";
	for($g = 0; $g < $result->length; $g++){
		$currentGloss = $result->item($g)->getElementsByTagName("gloss")->item(0)->nodeValue;
		$currentGloss = str_replace(" ", "_", $currentGloss);
		$gloss .= $currentGloss . "~";
	}
	$returnString .= $gloss . " ";
  }   
}
echo $returnString;
?>

