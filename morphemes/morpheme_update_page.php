<?php
// There are 8 things for you to edit in this file. There is also a note on line 95.

	// This code opens the database and gets all of the morphemes. We will print them to the HTML later on in this document.
	$file = 'morphemes.xml';
	$xmlDoc = new DOMDocument(); 
	$xmlDoc->load($file); 
	$xpath = new DOMXPath($xmlDoc);
	$morphemes = $xpath->query("//morpheme");
?>

<!DOCTYPE html>
<html lang="en">

<head>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- 1. You can enter your name below or delete the line. Having the line is totally optional. -->
	<meta name="author" content="You">

	<!-- 2. You can enter your name or the website name below or delete the line. Having the line is totally optional. -->
	<meta name="copyright" content="You" />
	
	<!-- 3. Replace with the name of your language. -->
	<title>Your Language Morphemes</title>  
		
	<!-- CSS: This page is powered by Bootstrap 4 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- CSS file with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="css/morphemes.css">
	
	<!-- fonts and icons -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
</head>

<body>
<div class="hidden">
<!-- loading animation -->
<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>


<!-- 4. This is the bar at the top of the page. Feel free to add or remove nav-items to suit your website's pages. Feel free also to add or remove special character buttons. -->

<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
  <a class="navbar-brand" href="../">Home</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
  <ul class="navbar-nav mr-auto">
			<li class="nav-item specialCharacter"><a class="nav-link">ʔ</a></li>
				
			<li class="nav-item specialCharacter"><a class="nav-link">kʰ</a></li>
				
			<li class="nav-item specialCharacter"><a class="nav-link">pʰ</a></li>
		
			<li class="nav-item specialCharacter"><a class="nav-link">tʰ</a></li>
				
			<li class="nav-item specialCharacter"><a class="nav-link">t̪</a></li>
				
			<li class="nav-item specialCharacter"><a class="nav-link">t̪'</a></li>
				
			<li class="nav-item specialCharacter"><a class="nav-link">t̪ʰ</a></li>
		</ul>

  		<ul class="navbar-nav ml-auto">
			<li class="nav-item"><a class="nav-link" href="#displayRecordsJumbotron">Find</a></li>
			<li class="nav-item"><a class="nav-link" href="#editJumbotron">Edit</a></li>
		</ul>
  </div>
</nav>
	
<div class="jumbotron jumbotron-fluid">
	<div class="black-box black-box--full">
		<h1 class="text-center">Morphemes Database</h1>
	</div>
</div>

<div class="jumbotron jumbotron-fluid" id="editJumbotron">
	<div class="black-box black-box--full">
		<h1 class="text-center">Regenerating the Morpheme Database</h1>
	</div>
</div>
	
<div class="container-fluid bodyContainer">
	<div class="row">
		<div class="col">
			<p>Note: If you click on one of the buttons below, the morpheme database will look through that part of the website (either the phrasicon, dictionary, or story corpus) and see if that part of the website contains any morphemes that are not currently in the morpheme database.</p>
		</div>
	</div>
	<div class="row">
	<!-- If you are not using Edwin Ko's Web Template, which came with a Phrasicon and Dictionary, You can delete 
	the morphemeDBPhrasicon, lines 97-102, and the morphemeDBDictionary, lines 104-109. If you are a programmer,
	you could also go into the inject.php file and modify the code behind these buttons to suit the structure of 
	your dictionary. -->
	<form id="morphemeDBPhrasicon" method="POST" name="morphemeDBPhrasicon">
		<input type="hidden" name="type" value="morphemeDBPhrasicon">
		<div class="col">
			<button class="btn btn-success" type="submit" value="morphemeDBPhrasicon">Look through the Phrasicon&nbsp; <i class="fas fa-plane"></i></button>
		</div>
	</form>

	<form id="morphemeDBDictionary" method="POST" name="morphemeDBDictionary">
		<input type="hidden" name="type" value="morphemeDBDictionary">
		<div class="col">
			<button class="btn btn-info" type="submit" value="morphemeDBDictionary">Look through the Dictionary&nbsp; <i class="fas fa-car"></i></button>
		</div>
	</form>

	<form id="morphemeDBStorycorpus" method="POST" name="morphemeDBStorycorpus">
		<input type="hidden" name="type" value="morphemeDBStorycorpus">
		<div class="col">
			<button class="btn btn-warning" type="submit" value="morphemeDBStorycorpus">Look through Story Corpus&nbsp; <i class="fas fa-taxi"></i></button>
		</div>
	</form>
	</div>
</div>

<hr>

<div class="jumbotron jumbotron-fluid" id="displayRecordsJumbotron">
	<div class="black-box black-box--full">
		<h1 class="text-center">Morphemes</h1>
	</div>
</div>

<div class="container-fluid">
<?php
$count = 0;
echo "<table class=\"table\">
<tr>
	<th>ID</th>
	<th>Morpheme</th>
	<th>Gloss</th>
	<th>Root</th>
	<th>Hypernym</th>
	<th>Links</th>
	<th>Affix</th>
	<th>Delete?</th>
</tr>";
foreach($morphemes as $morpheme){
	echo "<tr class=\"even\">";
	echo "<td>" . $morpheme->getAttribute("id") . "</td>";
	echo "<td>" . $morpheme->getElementsByTagName("source")->item(0)->nodeValue . "</td>";
	echo "<td>" . $morpheme->getElementsByTagName("gloss")->item(0)->nodeValue . "</td>";
	echo "<td>" . $morpheme->getElementsByTagName("root")->item(0)->nodeValue . "</td>";
	echo "<td>" . $morpheme->getElementsByTagName("hypernym")->item(0)->nodeValue . "</td>";
	
	echo "<td>";
	if($morpheme->getElementsByTagName("dictionary")->item(0)->nodeValue != ""){
		// 5. Replace with the name of your website
		echo "<a target='_blank' class='foundInDictionary' href=\"http://yourwebsite.com/dictionary/word.php?word=" . $morpheme->getElementsByTagName("source")->item(0)->nodeValue . "&lang=pomo\">D</a> &nbsp;";
	} 
	if($morpheme->getElementsByTagName("phrasicon")->item(0)->nodeValue != ""){
		// 6. Replace with the name of your website
		echo "<a target='_blank' class='foundInPhrasicon' href=\"http://yourwebsite.com/phrasicon/word.php?word=" . $morpheme->getElementsByTagName("source")->item(0)->nodeValue . "&lang=pomo\">P</a> &nbsp;";
	} 
	if($morpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue != ""){
		// 7. Replace with the name of your website
		echo "<a target='_blank' class='foundInStoryCorpus' href=\"http://yourwebsite.com/texts/secretIndex.php?lang=pomo&searchTerm=" . $morpheme->getElementsByTagName("source")->item(0)->nodeValue . "&searchGloss=" . $morpheme->getElementsByTagName("gloss")->item(0)->nodeValue . "&authorLink=false\">S</a> &nbsp;";
	}
	echo "</td>";
	
	echo "<td>" . $morpheme->getElementsByTagName("affix")->item(0)->nodeValue . "</td>";
	echo "<td><form class=\"delete\" id=\"delete" . $morpheme->getAttribute("id") . "\" method=\"POST\" name=\"delete" . $morpheme->getAttribute("id") . "\"><input type=\"hidden\" name=\"type\" value=\"delete\"><input type=\"hidden\" name=\"id\" value=\"" . $morpheme->getAttribute("id") . "\"><button disabled class=\"btn btn-danger\" type=\"submit\" value=\"Delete\">Delete&nbsp;<i class=\"fas fa-eraser\"></i></button></form></td>";
	echo "</tr>";
	$count++;
}

echo "</table>";

echo "<p>There are roughly " . $count . " morphemes between the story corpus, the dictionary, and the phrasicon. Wow!</p>";
?>
</div>

	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
				<!-- 8. Replace with the name of your website -->
				<p> &copy; Your Website Name <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>	
</div>
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script>
		// When the page has completely loaded, this removes the disabled attribute from the delete morpheme buttons.
		$(document).ready(function(){
			$('.btn-danger').removeAttr("disabled");
		});
	</script>

	<!-- This script handles form data. -->
	<script src="js/formSubmissionFunctions.js"></script>

	<!-- This script fades the page in when the page is opened and fades it out when the user leaves the page. -->
	<script src="js/fadeAnimations.js"></script>

	<!-- This script removes the loading animation once the page has loaded. -->
	<script src="js/removeLoader.js"></script>
</body>
</html>