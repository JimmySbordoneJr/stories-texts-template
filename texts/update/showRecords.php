<?php
$title = strtolower($_GET['title']);
$xmlDoc = new DOMDocument();
$xmlDoc->load("../stories.xml");
$xpath = new DOMXPath($xmlDoc);
$result = $xpath->query("(//story[contains(translate(storytitle, 'ABCDEFGHIJKLMNOPQRSTUVWXYZ', 'abcdefghijklmnopqrstuvwxyz'), '$title')])");

if($title==" "){
	$result = $xpath->query("(//story)");
}

echo "<table class=\"table\">
<tr>
	<th>ID</th>
	<th>Title</th>
	<th>Narrator</th>
	<th>Interviewer</th>
	<th>Published</th>
</tr>";


foreach($result as $entry) {
	echo "<tr class=\"even\">";
    
	$id = $entry->getAttribute('id');
	echo "<td>" . $id . "</td>";
      
	$storytitle = $entry->getElementsByTagName("storytitle")->item(0)->nodeValue;
	echo "<td>" . $storytitle . "</td>";

	$narrator = $entry->getElementsByTagName("narrator")->item(0)->nodeValue;
	echo "<td>" . $narrator . "</td>";

	$interviewer = $entry->getElementsByTagName("interviewer")->item(0)->nodeValue;
	echo "<td>" . $interviewer . "</td>";

	$published = $entry->getElementsByTagName("approved")->item(0)->nodeValue;
	if($published == "True"){
		echo "<td>Y</td>";
	} else{
		echo "<td>N</td>"; 
	}

	echo "</tr>";
}

echo "</table>";
?> 