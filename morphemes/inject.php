<?php
// There are five things for you to replace in this file. Skip down to line 370 to see the first one.


// okay, I am leaving a note here for future reference. With the regenerate morpheme database buttons, we would get an error
// if we tried to have it parse the dictionary, phrasicon, and story corpus all at once. I suspect this is because of an upper
// limit Bluehost set on how much data a form can handle at once. I split the one regenerate button into three (dictionary, phrasicon, stories).
// and it works. For now. As the story corpus grows, it may well start triggering that error. When that day comes (if it ever does),
// we can reach out to bluehost and see if we can increase that limit, though previous efforts have gone nowhere. 
// It should never be a problem though, because these buttons should only be used to get the morpheme database
// up and running. From then on, each section of the website should be reconfigured to add to the database on
// its own. New versions Edwin Ko's dictionary and phrasicon that have that capability are coming soon.  

// load story corpus
$storycorpusFile = '../texts/stories.xml';
$storycorpusXmlDoc = new DOMDocument();
$storycorpusXmlDoc->load($storycorpusFile);
$storycorpusXPath = new DOMXPath($storycorpusXmlDoc);

// load phrasicon
$phrasiconFile = '../phrasicon/phrasicon.xml';
$phrasiconXmlDoc = new DOMDocument();
$phrasiconXmlDoc->load($phrasiconFile);
$phrasiconXPath = new DOMXPath($phrasiconXmlDoc);

// load dictionary
$dictFile = '../dictionary/dictionary.xml';
$dictXmlDoc = new DOMDocument();
$dictXmlDoc->load($dictFile);
$dictXPath = new DOMXPath($dictXmlDoc);

// load morpheme database
$morphemeFile = 'morphemes.xml';
$morphemeXmlDoc = new DOMDocument();
$morphemeXmlDoc->preserveWhiteSpace = false;
$morphemeXmlDoc->formatOutput = true;
$morphemeXmlDoc->load($morphemeFile);
$morphemeXpath = new DOMXPath($morphemeXmlDoc);
$morphemeRootNode = $morphemeXmlDoc->getElementsByTagName("morphemedatabase")->item(0);

// If they want to delete a morpheme...
if ($_POST['type'] == 'delete') {
	$id = (int)$_POST['id'];  
	if($id!=""){// ...and it is a valid morpheme, delete it.
		$result = $morphemeXpath->query("/morphemedatabase/morpheme[@id='$id']");
		$result->item(0)->parentNode->removeChild($result->item(0));
		$morphemeXmlDoc->save($morphemeFile);	
	}	
}

// this is just here to get the morpheme db up and running
// eventually, each part of the website will update the morpheme database when an entry is added or edited
// that check should probably be a function that the dictionary, phrasicon, and storycorpus can call
// it would take in the english and pomo and check to see if this was in the morpheme database

elseif ($_POST['type'] == 'morphemeDBPhrasicon') {
	$phrasiconEntries = $phrasiconXPath->query("//m");
	foreach($phrasiconEntries as $entry){
		$morphemeEntries = $morphemeXpath->query("//morpheme");
		$lastEntry = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
		if($lastEntry->item(0)){
			$newId = ($lastEntry->item(0)->getAttribute('id')) + 1;
		} else{
			$newId = 1;
		}
		// We will check to see if the current phrasicon entry is in morpheme database. 
		// First, we have to replace any curly quotes with straight ones.
		$phraseSource = trim($entry->nodeValue);
		$phraseSource = str_replace("‘", "'", $phraseSource);
		$phraseSource = str_replace("’", "'", $phraseSource);

		$phraseGlossId = $entry->getAttribute("id");
		$phraseGloss = trim($phrasiconXPath->query("//g[@id =\"$phraseGlossId\"]")->item(0)->nodeValue);
		$phraseGloss = str_replace("‘", "'", $phraseGloss);
		$phraseGloss = str_replace("’", "'", $phraseGloss);
		// We set a variable equal to false, and it is set to true if a match is found.
		$foundInDB = false; 

		// We will loop through the morpheme database looking for a match. 	
		foreach($morphemeEntries as $existingMorpheme){
			$source = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
			$source = str_replace("‘", "'", $source);
			$source = str_replace("’", "'", $source);

			$gloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);
			$gloss = str_replace("‘", "'", $gloss);
			$gloss = str_replace("’", "'", $gloss);

			// if we find a match, we will set our variable to be true and break out of the morpheme DB loop.
			if(($source == $phraseSource) && ($gloss == $phraseGloss)){
				$foundInDB = true;
				// Here, we mark the existing morpheme database entry to note that it occurs in the Phrasicon
				$inPhrasicon = $existingMorpheme->getElementsByTagName("phrasicon")->item(0);
				$inPhrasicon->nodeValue .= $entry->parentNode->parentNode->getAttribute("id") . ",";
				break;
			}
		}
		// After the morpheme database loop, we will check to see if the variable is set to true. 
		if($foundInDB == true){
			// If it is true, we don't need to enter anything and can 
			// go to the next entry
			continue;
		} else{
			// if we didn't find a match, we will create a new morpheme entry.
			$newMorphemeEntry = $morphemeXmlDoc->createElement("morpheme");
			$newMorphemeEntry->setAttribute("id", $newId);

			$newMorphemeSource = $morphemeXmlDoc->createElement("source");
			$newMorphemeSourceText = $morphemeXmlDoc->createTextNode($phraseSource);
			$newMorphemeSource->appendChild($newMorphemeSourceText);
			$newMorphemeEntry->appendChild($newMorphemeSource);
			
			$newMorphemeGloss = $morphemeXmlDoc->createElement("gloss");
			$newMorphemeGlossText = $morphemeXmlDoc->createTextNode($phraseGloss);
			$newMorphemeGloss->appendChild($newMorphemeGlossText);
			$newMorphemeEntry->appendChild($newMorphemeGloss);

			$newMorphemeRoot = $morphemeXmlDoc->createElement("root");
			$newMorphemeRootText = $morphemeXmlDoc->createTextNode($phraseSource);
			$newMorphemeRoot->appendChild($newMorphemeRootText);
			$newMorphemeEntry->appendChild($newMorphemeRoot);

			$newMorphemeHypernym = $morphemeXmlDoc->createElement("hypernym");
			$newMorphemeHypernymText = $morphemeXmlDoc->createTextNode($phraseGloss);
			$newMorphemeHypernym->appendChild($newMorphemeHypernymText);
			$newMorphemeEntry->appendChild($newMorphemeHypernym);
							
			$newMorphemeP = $morphemeXmlDoc->createElement("phrasicon");
			$newMorphemeP->nodeValue = $entry->parentNode->parentNode->getAttribute("id") . ",";
			$newMorphemeEntry->appendChild($newMorphemeP);
			
			$newMorphemeD = $morphemeXmlDoc->createElement("dictionary");
			$newMorphemeEntry->appendChild($newMorphemeD);
			
			$newMorphemeS = $morphemeXmlDoc->createElement("storycorpus");
			$newMorphemeEntry->appendChild($newMorphemeS);
			
			$newMorphemeAffix = $morphemeXmlDoc->createElement("affix");
			
			if(substr($phraseSource, 0, 1) == "-"){
				$newMorphemeAffix->nodeValue = "suffix";
			} elseif(substr($phraseSource, -1, 1) == "-"){
				$newMorphemeAffix->nodeValue = "prefix";
			} else{
				$newMorphemeAffix->nodeValue = "root";
			}
			$newMorphemeEntry->appendChild($newMorphemeAffix);
			
			$morphemeRootNode->appendChild($newMorphemeEntry);
		}
	}	
	// alphabetizing the morpheme database? Is it worth it? We might gain a tiny bit in terms of performance in querying the morpheme database, but we also lose the time it takes to sort.


	// Next, we save changes 
	$metaTag = $morphemeXpath->query("/morphemedatabase/metadata"); 
	$metaTag->item(0)->getElementsByTagName('modified')->item(0)->nodeValue = date("Y-m-d");
	$morphemeXmlDoc->save($morphemeFile);	

// If people wanted to regenerate the morpheme database from the dictionary...
}elseif($_POST['type'] == 'morphemeDBDictionary'){
	$dictEntries = $dictXPath->query("//entry");
	foreach($dictEntries as $entry){
		$morphemeEntries = $morphemeXpath->query("//morpheme");
		$lastEntry = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
		if($lastEntry->item(0)){
			$newId = ($lastEntry->item(0)->getAttribute('id')) + 1;
		} else{
			$newId = 1;
		}
		// We will check to see if in morpheme database. we will match the Pomo and the English, hence, if either is not a match,
		// we will add a new morpheme. We first convert any curly quote marks to straight ones. Our language has ejectives, so making sure the quote marks are all the same was critical.
		$dictSource = trim($entry->getElementsByTagName("orth")->item(0)->nodeValue);
		$dictSource = str_replace("‘", "'", $dictSource);
		$dictSource = str_replace("’", "'", $dictSource);

		$dictGloss = trim($entry->getElementsByTagName("quote")->item(0)->nodeValue);
		$dictGloss = str_replace("‘", "'", $dictGloss);
		$dictGloss = str_replace("’", "'", $dictGloss);

		// We set a variable equal to false.
		$foundInDB = false; 

		// We will loop through the database looking for a match. 	
		foreach($morphemeEntries as $existingMorpheme){
			$source = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
			$source = str_replace("‘", "'", $source);
			$source = str_replace("’", "'", $source);

			$gloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);
			$gloss = str_replace("‘", "'", $gloss);
			$gloss = str_replace("’", "'", $gloss);
			// if we find a match, we will set our variable to be true and break out of the morpheme database loop.
			if(($source == $dictSource) && ($gloss == $dictGloss)){
				$foundInDB = true; 
				$inDictionary = $existingMorpheme->getElementsByTagName("dictionary")->item(0);
				$inDictionary->nodeValue .= $entry->getAttribute("id");
				break;
			}
		}
		// After the morpheme database loop, we will check to see if the variable is true. 
		if($foundInDB == true){
			// If it is true, we don't need to enter anything and can 
			// go to the next entry.
			continue;
		} else{
			// if we didn't find a match, we will create a new morpheme.
			$newMorphemeEntry = $morphemeXmlDoc->createElement("morpheme");
			$newMorphemeEntry->setAttribute("id", $newId);

			$newMorphemeSource = $morphemeXmlDoc->createElement("source");
			$newMorphemeSourceText = $morphemeXmlDoc->createTextNode($dictSource);
			$newMorphemeSource->appendChild($newMorphemeSourceText);
			$newMorphemeEntry->appendChild($newMorphemeSource);
			
			$newMorphemeGloss = $morphemeXmlDoc->createElement("gloss");
			$newMorphemeGlossText = $morphemeXmlDoc->createTextNode($dictGloss);
			$newMorphemeGloss->appendChild($newMorphemeGlossText);
			$newMorphemeEntry->appendChild($newMorphemeGloss);

			$newMorphemeRoot = $morphemeXmlDoc->createElement("root");
			$newMorphemeRootText = $morphemeXmlDoc->createTextNode($dictSource);
			$newMorphemeRoot->appendChild($newMorphemeRootText);
			$newMorphemeEntry->appendChild($newMorphemeRoot);

			$newMorphemeHypernym = $morphemeXmlDoc->createElement("hypernym");
			$newMorphemeHypernymText = $morphemeXmlDoc->createTextNode($dictGloss);
			$newMorphemeHypernym->appendChild($newMorphemeHypernymText);
			$newMorphemeEntry->appendChild($newMorphemeHypernym);
			
			$newMorphemeP = $morphemeXmlDoc->createElement("phrasicon");
			$newMorphemeEntry->appendChild($newMorphemeP);
			
			$newMorphemeD = $morphemeXmlDoc->createElement("dictionary");
			$newMorphemeD->nodeValue = $entry->getAttribute("id") . ",";
			$newMorphemeEntry->appendChild($newMorphemeD);
			
			$newMorphemeS = $morphemeXmlDoc->createElement("storycorpus");
			$newMorphemeEntry->appendChild($newMorphemeS);
			
			$newMorphemeAffix = $morphemeXmlDoc->createElement("affix");
			
			if(substr($dictSource, 0, 1) == "-"){
				$newMorphemeAffix->nodeValue = "suffix";
			} elseif(substr($dictSource, -1, 1) == "-"){
				$newMorphemeAffix->nodeValue = "prefix";
			} else{
				$newMorphemeAffix->nodeValue = "root";
			}
			$newMorphemeEntry->appendChild($newMorphemeAffix);
			
			$morphemeRootNode->appendChild($newMorphemeEntry);
		}
	}

// If they want to regenerate the morpheme database from the story corpus...
} elseif($_POST['type'] == 'morphemeDBStorycorpus'){
	$storyEntries = $storycorpusXPath->query("//morpheme");
	foreach($storyEntries as $entry){
		$morphemeEntries = $morphemeXpath->query("//morpheme");
		$lastEntry = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
		if($lastEntry->item(0)){
			$newId = ($lastEntry->item(0)->getAttribute('id')) + 1;
		} else{
			$newId = 1;
		}
		// We will check to see if the morpheme is in morpheme database. We will match the Pomo and the English, hence, if either is not a match,
		// we will add a new morpheme
		$storySource = trim($entry->getElementsByTagName("m")->item(0)->nodeValue);
		$storySource = str_replace("‘", "'", $storySource);
		$storySource = str_replace("’", "'", $storySource);

		$storyGloss = trim($entry->getElementsByTagName("g")->item(0)->nodeValue);
		$storyGloss = str_replace("‘", "'", $storyGloss);
		$storyGloss = str_replace("’", "'", $storyGloss);
		// We will set a variable equal to false.
		$foundInDB = false; 

		// We will loop through the database looking for a match. 	
		foreach($morphemeEntries as $existingMorpheme){
			$source = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
			$source = str_replace("‘", "'", $source);
			$source = str_replace("’", "'", $source);

			$gloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);
			$gloss = str_replace("‘", "'", $gloss);
			$gloss = str_replace("’", "'", $gloss);

			// if we find a match, we will set our variable to be true and break out of the morpheme database loop.
			if(($source == $storySource) && ($gloss == $storyGloss)){
				$foundInDB = true; 
				$inStoryCorpus = $existingMorpheme->getElementsByTagName("storycorpus")->item(0);
				$inStoryCorpus->nodeValue .= $entry->parentNode->parentNode->parentNode->getAttribute("id") . ",";
				break;
			}
		}
		// After the morpheme database loop, we will check to see if the var is true. 
		if($foundInDB == true){
			// If it is true, we don't need to enter anything and can 
			// go to the next entry.
			continue;
		} else{
			// if we didn't find a match, we will create a new morpheme.
			$newMorphemeEntry = $morphemeXmlDoc->createElement("morpheme");
			$newMorphemeEntry->setAttribute("id", $newId);

			$newMorphemeSource = $morphemeXmlDoc->createElement("source");
			$newMorphemeSourceText = $morphemeXmlDoc->createTextNode($storySource);
			$newMorphemeSource->appendChild($newMorphemeSourceText);
			$newMorphemeEntry->appendChild($newMorphemeSource);
			
			$newMorphemeGloss = $morphemeXmlDoc->createElement("gloss");
			$newMorphemeGlossText = $morphemeXmlDoc->createTextNode($storyGloss);
			$newMorphemeGloss->appendChild($newMorphemeGlossText);
			$newMorphemeEntry->appendChild($newMorphemeGloss);

			$newMorphemeRoot = $morphemeXmlDoc->createElement("root");
			$newMorphemeRootText = $morphemeXmlDoc->createTextNode($storySource);
			$newMorphemeRoot->appendChild($newMorphemeRootText);
			$newMorphemeEntry->appendChild($newMorphemeRoot);

			$newMorphemeHypernym = $morphemeXmlDoc->createElement("hypernym");
			$newMorphemeHypernymText = $morphemeXmlDoc->createTextNode($storyGloss);
			$newMorphemeHypernym->appendChild($newMorphemeHypernymText);
			$newMorphemeEntry->appendChild($newMorphemeHypernym);

			$newMorphemeP = $morphemeXmlDoc->createElement("phrasicon");
			$newMorphemeEntry->appendChild($newMorphemeP);
			
			$newMorphemeD = $morphemeXmlDoc->createElement("dictionary");
			$newMorphemeEntry->appendChild($newMorphemeD);
			
			$newMorphemeS = $morphemeXmlDoc->createElement("storycorpus");
			$newMorphemeS->nodeValue = $entry->parentNode->parentNode->parentNode->getAttribute("id") . ",";
			$newMorphemeEntry->appendChild($newMorphemeS);
			
			$newMorphemeAffix = $morphemeXmlDoc->createElement("affix");
			
			if(substr($storySource, 0, 1) == "-"){
				$newMorphemeAffix->nodeValue = "suffix";
			} elseif(substr($storySource, -1, 1) == "-"){
				$newMorphemeAffix->nodeValue = "prefix";
			} else{
				$newMorphemeAffix->nodeValue = "root";
			}
			$newMorphemeEntry->appendChild($newMorphemeAffix);
			
			$morphemeRootNode->appendChild($newMorphemeEntry);
		}
	}
}

// We will save the file and modify its 'last-modified' data.
$result = $morphemeXpath->query("/morphemedatabase/metadata"); 
$result->item(0)->getElementsByTagName("modified")->item(0)->nodeValue = date("Y-m-d");
$morphemeXmlDoc->save($morphemeFile);


echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Success!</h4></div></div></div></div>";

  include("morpheme_update_page.php");

?> 


<!DOCTYPE html>
<html>

<head>            
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- 1. Replace with your name. You can also delete this line; having it is totally optional. -->
	<meta name="author" content="You">

	<!-- 2. Replace with your name. You can also delete this line; having it is totally optional. -->
	<meta name="copyright" content="You" />

	<!-- 3. Replace with the name of your language. -->
	<title>Your Language Morphemes</title>  
		
	<!-- CSS: This page is powered by Bootstrap 4 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- CSS file with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="css/texts.css">
	
	<!-- fonts and icons -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">		
</head>

<body>
	<!-- 4. This is the bar at the top of the page. You can add or remove links to suit your website. -->
	<nav class="navbar fixed-top navbar-dark bg-dark">
		<a class="navbar-brand" href="../">Morphemes</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="../dictionary">Talking Dictionary</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../phrasicon">Phrasicon</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../sounds">Sounds of the Language</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../flashcards">Lessons with Flashcards</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../expressions">Everyday Expressions</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
				<!-- 5. Replace with the name of your website. -->
				<p> &copy; Your Website <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>
	
	<!-- Bootstrap's JS files -->
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>