<?php
// In the update page, this file handles the suggesting of translations for morphemes.

// load morpheme database
$xmlDoc = new DOMDocument();
$xmlDoc->load("../../morphemes/morphemes.xml");
$xpath = new DOMXPath($xmlDoc);

$returnString = "";
$txt = $_GET['txt'];
$originalWords = explode(" ", $txt); // the morpheme database does not have any hyphens. So, when comparing
$words = explode(" ", $txt); // our input with the morpheme database entries, we will keep one array $words with the hyphens removed,
														// and another array $originalWords with the hyphens intact for sending the translation back with a hyphen.
$txt = "<s1> <s2> " . $txt . " </s1> </s2>";

for ($counter = 0; $counter < sizeof($words); $counter++) {

$morpheme = trim($words[$counter], "-");
$num = $counter + 1;

if ($morpheme == "") {  // if blank, return blank
    echo "";    
}
	
$result = $xpath->query("//source[text()=\"$morpheme\"]/..");

if ($result->length == 0) {    
	$returnString .= "? ";
} else { 
	$gloss = "";
	for($g = 0; $g < $result->length; $g++){
		$currentGloss = $result->item($g)->getElementsByTagName("gloss")->item(0)->nodeValue;
		$currentGloss = str_replace(" ", "_", $currentGloss);
		if($currentGloss !== ""){
			if(substr($originalWords[$counter], 0, 1) === "-"){
				$gloss .= "-" . $currentGloss . "~";
			} 
			elseif(substr($originalWords[$counter], -1) === "-"){
				$gloss .= $currentGloss . "-~";
			}
			else{
				$gloss .= $currentGloss . "~";
			}
		}
	}
	$returnString .= $gloss . " ";
  }   
}
echo $returnString;
?>

