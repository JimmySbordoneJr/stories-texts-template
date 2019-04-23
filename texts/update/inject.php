<?php
// There are five things for you to edit in this file. They are all way down at the bottom of the page. 

// When a user wants to add a story to the database, edit a story, mass edit a morpheme, or delete a story,
// this file takes their input and modifies the database accordingly. 

// We host our videos on Youtube (they are unlisted, meaning people cannot find them on Youtube). 
// We made this decision because when we tried serving the videos from our site, they would not load quickly.
// If you have a powerful server, you may be able to host your own videos. 

// This function will help us parse the Youtube embed codes and extract the base URL. 
function cropYoutubeURL($str){
	if(substr($str, 0, 7) === "<iframe"){
		$startIndex = 5 + strpos($str, "src=");
		$reducedString = substr($str, $startIndex);
		$endIndex = strpos($reducedString, '"');
		return substr($reducedString, 0, $endIndex);
	} else{
		return $str;
	}
};

// load story corpus
$storycorpusFile = '../stories.xml';
$storycorpusDoc = new DOMDocument();
$storycorpusDoc->preserveWhiteSpace = false;
$storycorpusDoc->formatOutput = true;
$storycorpusDoc->load($storycorpusFile);
$storycorpusXPath = new DOMXPath($storycorpusDoc);

// load phrasicon
$phrasiconFile = '../../phrasicon/phrasicon.xml';
$phrasiconDoc = new DOMDocument();
$phrasiconDoc->load($phrasiconFile);
$phrasiconXPath = new DOMXPath($phrasiconDoc);

// load dictionary
$dictFile = '../../dictionary/dictionary.xml';
$dictXmlDoc = new DOMDocument();
$dictXmlDoc->load($dictFile);
$dictXPath = new DOMXPath($dictXmlDoc);

// load morpheme database
$morphemeFile = '../../morphemes/morphemes.xml';
$morphemeXmlDoc = new DOMDocument();
$morphemeXmlDoc->preserveWhiteSpace = false;
$morphemeXmlDoc->formatOutput = true;
$morphemeXmlDoc->load($morphemeFile);
$morphemeXpath = new DOMXPath($morphemeXmlDoc);

// if they want to create a story... 
if ($_POST['type'] == 'create') {
     
	$result = $storycorpusXPath->query("/storycorpus/story[last()]");

	if($result->item(0)){
		$id = ($result->item(0)->getAttribute('id')) + 1;
	} else{
		$id = 1;
	} 

	$entry = $storycorpusDoc->createElement("story");
	$entry->setAttribute("id", $id);

	// story metadata
	$storytitle = $storycorpusDoc->createElement('storytitle');
	$storytitleText = $storycorpusDoc->createTextNode($_POST['storytitle']);
	$storytitle->appendChild($storytitleText);
	$entry->appendChild($storytitle);

	$narrator = $storycorpusDoc->createElement('narrator');
	$narratorText = $storycorpusDoc->createTextNode($_POST['narrator']);
	$narrator->appendChild($narratorText);
	$entry->appendChild($narrator);

	$interviewer = $storycorpusDoc->createElement('interviewer');
	$interviewerText = $storycorpusDoc->createTextNode($_POST['interviewer']);
	$interviewer->appendChild($interviewerText);
	$entry->appendChild($interviewer);

	$description = $storycorpusDoc->createElement('description');
	$descriptionText = $storycorpusDoc->createTextNode($_POST['description']);
	$description->appendChild($descriptionText);
	$entry->appendChild($description);

	$socialmediabuttontext = $storycorpusDoc->createElement('socialmediabuttontext');
	$socialmediabuttontextText = $storycorpusDoc->createTextNode($_POST['socialmediabuttontext']);
	$socialmediabuttontext->appendChild($socialmediabuttontextText);
	$entry->appendChild($socialmediabuttontext);

	// media files: youtube links, whole story audio, image, handout 
	$youtubelinksourcelang = $storycorpusDoc->createElement('youtubelinksourcelang');
	$youtubelinksourcelangText = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['youtubelinksourcelang']));
	$youtubelinksourcelang->appendChild($youtubelinksourcelangText);
	$entry->appendChild($youtubelinksourcelang);

	$youtubelinktranslationlang = $storycorpusDoc->createElement('youtubelinktranslationlang');
	$youtubelinktranslationlangText = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['youtubelinktranslationlang']));
	$youtubelinktranslationlang->appendChild($youtubelinktranslationlangText);
	$entry->appendChild($youtubelinktranslationlang);

	$youtubelinkboth = $storycorpusDoc->createElement('youtubelinkboth');
	$youtubelinkbothText = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['youtubelinkboth']));
	$youtubelinkboth->appendChild($youtubelinkbothText);
	$entry->appendChild($youtubelinkboth);

	$wholestoryaudio = $storycorpusDoc->createElement('wholestoryaudio');
	$wholestoryaudioText = $storycorpusDoc->createTextNode($_POST['wholestoryaudio']);
	$wholestoryaudio->appendChild($wholestoryaudioText);
	$entry->appendChild($wholestoryaudio);

	$image = $storycorpusDoc->createElement('image');
	// if an image url was not given, insert a default picture 
	if(trim($_POST['image']) != ""){
		$imageText = $storycorpusDoc->createTextNode($_POST['image']);
	} else{
		$imageText = $storycorpusDoc->createTextNode("");
	}
	$image->appendChild($imageText);
	$entry->appendChild($image);

	$handout = $storycorpusDoc->createElement('handout');
	$handoutText = $storycorpusDoc->createTextNode($_POST['handout']);
	$handout->appendChild($handoutText);
	$entry->appendChild($handout);

	// story lines
	$morphogloss = $storycorpusDoc->createElement('morphogloss');
	$lines = $_POST['line'];
	for ($x=0; $x<count($lines); $x++) {
		$currentline = $lines[$x];
		// if the current line is not blank
		if($currentline['source']!= ""){
			// add it to the new entry
			$line = $storycorpusDoc->createElement('line');
			$lineid = $id . "_" . ($x + 1);
			$line->setAttribute('id', $lineid);

			$speaker = $storycorpusDoc->createElement('speaker');
			$speakerText = $storycorpusDoc->createTextNode($currentline['speaker']);
			$speaker->appendChild($speakerText);
			$line->appendChild($speaker);

			$lineaudio = $storycorpusDoc->createElement('lineaudio');
			$lineaudioText = $storycorpusDoc->createTextNode($currentline['lineaudio']);
			$lineaudio->appendChild($lineaudioText);
			$line->appendChild($lineaudio);

			$source = $storycorpusDoc->createElement('source');
			$sourceText = $storycorpusDoc->createTextNode($currentline['source']);
			$source->appendChild($sourceText);
			$line->appendChild($source);

			$translation = $storycorpusDoc->createElement('translation');
			$translationText = $storycorpusDoc->createTextNode($currentline['translation']);
			$translation->appendChild($translationText);
			$line->appendChild($translation);

			$note = $storycorpusDoc->createElement('note');
			$noteText = $storycorpusDoc->createTextNode($currentline['note']);
			$note->appendChild($noteText);
			$line->appendChild($note);
		
			// loop through the morphemes
			for ($y=0;$y<=(count($currentline['morpheme'])+1); $y++) {
				// if the current morpheme is not blank
				if($currentline['morpheme'][$y]['m'] != ""){
					$morpheme = $storycorpusDoc->createElement('morpheme');

					$m = $storycorpusDoc->createElement('m');
					$mText = $storycorpusDoc->createTextNode($currentline['morpheme'][$y]['m']);
					$m->appendChild($mText);
					$morpheme->appendChild($m);
				
					$g = $storycorpusDoc->createElement('g');
					$gText = $storycorpusDoc->createTextNode($currentline['morpheme'][$y]['g']);
					$g->appendChild($gText);
					$morpheme->appendChild($g);

					$line->appendChild($morpheme);

					// check to see if we need to add this morpheme to our morpheme database
					$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme");
					$needToEnter = true;
					
					$originalEntrySource = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $currentline['morpheme'][$y]['m'])))));
					$entrySource = trim($currentline['morpheme'][$y]['m']);
					$entrySource = str_replace("‘", "'", $entrySource);
					$entrySource = str_replace("’", "'", $entrySource);
					$entrySource = str_replace(")", "", $entrySource);
					$entrySource = str_replace("(", "", $entrySource);
					$entrySource = trim($entrySource, "-");

					$originalEntryGloss = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $currentline['morpheme'][$y]['g'])))));
					$entryGloss = trim($currentline['morpheme'][$y]['g']);
					$entryGloss = str_replace("‘", "'", $entryGloss);
					$entryGloss = str_replace("’", "'", $entryGloss);
					$entryGloss = str_replace(")", "", $entryGloss);
					$entryGloss = str_replace("(", "", $entryGloss);
					$entryGloss = trim($entryGloss, "-");

					if(substr($originalEntrySource, 0, 1) == "-"){
						$entryAffix = "suffix";
					} elseif(substr($originalEntrySource, -1, 1) == "-"){
						$entryAffix = "prefix";
					} else{
						$entryAffix = "root";
					}
					foreach($resultMorph as $existingMorpheme){
						$existingSource = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
						$existingGloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);

						if(($entrySource == $existingSource) && ($entryGloss == $existingGloss)){
							$needToEnter = false;
							$existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue = $existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue . $id . ",";
							
							// check to see if we need to change the affix tag
							$existingAffix = $existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue;
							if(strpos($existingAffix, $entryAffix) === FALSE){
								$existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue = $existingAffix . "," . $entryAffix;
							}
							break;
						}
					}
					if($needToEnter == true){
						$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
						if($resultMorph->item(0)){
							$idMorph = ($resultMorph->item(0)->getAttribute('id')) + 1;
						} else{
							$idMorph = 1;
						} 

						$entryMorph = $morphemeXmlDoc->createElement("morpheme");
						$entryMorph->setAttribute("id",$idMorph);
						
						$entryMorphSource = $morphemeXmlDoc->createElement("source");
						$entryMorphSourceText = $morphemeXmlDoc->createTextNode($entrySource);
						$entryMorphSource->appendChild($entryMorphSourceText);
						$entryMorph->appendChild($entryMorphSource);
						
						$entryMorphGloss = $morphemeXmlDoc->createElement("gloss");
						$entryMorphGlossText = $morphemeXmlDoc->createTextNode($entryGloss);
						$entryMorphGloss->appendChild($entryMorphGlossText);
						$entryMorph->appendChild($entryMorphGloss);
						
						$entryMorphRoot = $morphemeXmlDoc->createElement("root");
						$entryMorphRootText = $morphemeXmlDoc->createTextNode($entrySource);
						$entryMorphRoot->appendChild($entryMorphRootText);
						$entryMorph->appendChild($entryMorphRoot);
						
						$entryMorphHypernym = $morphemeXmlDoc->createElement("hypernym");
						$entryMorphHypernymText = $morphemeXmlDoc->createTextNode($entryGloss);
						$entryMorphHypernym->appendChild($entryMorphHypernymText);
						$entryMorph->appendChild($entryMorphHypernym);
						
						$entryMorphPhrasicon = $morphemeXmlDoc->createElement("phrasicon");
						$entryMorph->appendChild($entryMorphPhrasicon);
						
						$entryMorphDictionary = $morphemeXmlDoc->createElement("dictionary");
						$entryMorph->appendChild($entryMorphDictionary);
						
						$entryMorphStoryCorpus = $morphemeXmlDoc->createElement("storycorpus", ($id . ","));
						$entryMorph->appendChild($entryMorphStoryCorpus);					

						$entryMorphAffix = $morphemeXmlDoc->createElement("affix", $entryAffix);
						$entryMorph->appendChild($entryMorphAffix);
						
						$morphemeRootNode = $morphemeXpath->query("//morphemedatabase")->item(0);
						$morphemeRootNode->appendChild($entryMorph);
					}
					$morphemeMetadata = $morphemeXpath->query("//modified")->item(0); 
					$morphemeMetadata->nodeValue = date("Y-m-d");	
					$morphemeXmlDoc->save($morphemeFile);
					// end of check for morphemeDB
				}
			}
			$morphogloss->appendChild($line);
		}
	}
	$entry->appendChild($morphogloss);

	// by default, a new entry is unpublished. It must be approved by getting it in the edit story section and clicking on the button to publish
	$approved = $storycorpusDoc->createElement('approved', "False");
	$entry->appendChild($approved);

	// create sound file dir for this version of the story
	$first_audio_dir = str_replace(" ", "", $_POST['storytitle']);
	$first_audio_dir = str_replace("/", "_", $first_audio_dir);
	$audio_dir = "../sounds/" . $first_audio_dir;
	$z = $id;
	while(1===1){
		$dir_name = $audio_dir . $z;
		if(!(is_dir($dir_name))){
			$audio_dir = $dir_name;
			mkdir($audio_dir);
			break;
		}
		$z++;
	}

	// add the completed story entry to our story corpus
	$storycorpusDoc->getElementsByTagName("storycorpus")->item(0)->appendChild($entry);

	// save changes
	$storycorpusDoc->save($storycorpusFile);

// if they want to edit a story    
} elseif ($_POST['type'] == 'modify') {

// if editID is empty, or if it does not match the most recently accessed story, do not edit anything	
if($_POST['editID']!="" || ($_POST['checkSubmission'] == $_POST['editID'])){      
	$editID = (int)$_POST['editID'];

	$result = $storycorpusXPath->query("/storycorpus/story[@id='$editID']");
	if(!isset($result)){
		// if no entry exists with that ID, do nothing
		return;
	}    
	$result = $result->item(0);

	// change name of sound files dir
	$olddir = "../sounds/" . str_replace("/", "_", str_replace(" ", "", $result->getElementsByTagName("storytitle")->item(0)->nodeValue)) . $editID;
	$newdir = "../sounds/" . str_replace("/", "_", str_replace(" ", "", $_POST['editTitle'])).$editID;
	rename($olddir,$newdir);

	// if they did not click one of the publish options, do not change whether or not it is published
	if(isset($_POST['approved'])){
		// if they clicked the radio button to approve the story, make it visible. 
		if($_POST['approved'] == "Yes"){
			$result->getElementsByTagName("approved")->item(0)->nodeValue = "True";
		} else{// Else, they must have clicked No, so we will hide it
			$result->getElementsByTagName("approved")->item(0)->nodeValue = "False";
		}
	}

	$oldTitle = $result->getElementsByTagName("storytitle")->item(0);
	$newTitle = $storycorpusDoc->createTextNode($_POST['editTitle']);
	if(!is_null($oldTitle->firstChild)){
		$oldTitle->replaceChild($newTitle, $oldTitle->firstChild);
	} else{
		$oldTitle->appendChild($newTitle);
	}

	$oldNarrator = $result->getElementsByTagName("narrator")->item(0);
	$newNarrator = $storycorpusDoc->createTextNode($_POST['editNarrator']);
	if(!is_null($oldNarrator->firstChild)){
		$oldNarrator->replaceChild($newNarrator, $oldNarrator->firstChild);
	} else{
		$oldNarrator->appendChild($newNarrator);
	}

	$oldInterviewer = $result->getElementsByTagName("interviewer")->item(0);
	$newInterviewer = $storycorpusDoc->createTextNode($_POST['editInterviewer']);
	if(!is_null($oldInterviewer->firstChild)){
		$oldInterviewer->replaceChild($newInterviewer, $oldInterviewer->firstChild);
	} else{
		$oldInterviewer->appendChild($newInterviewer);
	}

	$oldDescription = $result->getElementsByTagName("description")->item(0);
	$newDescription = $storycorpusDoc->createTextNode($_POST['editDescription']);
	if(!is_null($oldDescription->firstChild)){
		$oldDescription->replaceChild($newDescription, $oldDescription->firstChild);
	} else{
		$oldDescription->appendChild($newDescription);
	}

	$oldSocialMediaButtonText = $result->getElementsByTagName("socialmediabuttontext")->item(0);
	$newSocialMediaButtonText = $storycorpusDoc->createTextNode($_POST['editSocialMedia']);
	if(!is_null($oldSocialMediaButtonText->firstChild)){
		$oldSocialMediaButtonText->replaceChild($newSocialMediaButtonText, $oldSocialMediaButtonText->firstChild);
	} else{
		$oldSocialMediaButtonText->appendChild($newSocialMediaButtonText);
	}

	$oldYoutubelinksourcelang = $result->getElementsByTagName("youtubelinksourcelang")->item(0);
	$newYoutubelinksourcelang = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['editYoutubeSourceLang']));
	if(!is_null($oldYoutubelinksourcelang->firstChild)){
		$oldYoutubelinksourcelang->replaceChild($newYoutubelinksourcelang, $oldYoutubelinksourcelang->firstChild);
	} else{
		$oldYoutubelinksourcelang->appendChild($newYoutubelinksourcelang);
	}

	$oldYoutubelinkboth = $result->getElementsByTagName("youtubelinkboth")->item(0);
	$newYoutubelinkboth = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['editYoutubeBoth']));
	if(!is_null($oldYoutubelinkboth->firstChild)){
		$oldYoutubelinkboth->replaceChild($newYoutubelinkboth, $oldYoutubelinkboth->firstChild);
	} else{
		$oldYoutubelinkboth->appendChild($newYoutubelinkboth);
	}

	$oldYoutubelinktranslationlang = $result->getElementsByTagName("youtubelinktranslationlang")->item(0);
	$newYoutubelinktranslationlang = $storycorpusDoc->createTextNode(cropYoutubeURL($_POST['editYoutubeTranslationLang']));
	if(!is_null($oldYoutubelinktranslationlang->firstChild)){
		$oldYoutubelinktranslationlang->replaceChild($newYoutubelinktranslationlang, $oldYoutubelinktranslationlang->firstChild);
	} else{
		$oldYoutubelinktranslationlang->appendChild($newYoutubelinktranslationlang);
	}

	$oldWholeAudio = $result->getElementsByTagName("wholestoryaudio")->item(0);
	$newWholeAudio = $storycorpusDoc->createTextNode($_POST['editWholeAudio']);
	if(!is_null($oldWholeAudio->firstChild)){
		$oldWholeAudio->replaceChild($newWholeAudio, $oldWholeAudio->firstChild);
	} else{
		$oldWholeAudio->appendChild($newWholeAudio);
	}

	$oldImage = $result->getElementsByTagName("image")->item(0);
	$newImage = $storycorpusDoc->createTextNode($_POST['editImage']);
	if(!is_null($oldImage->firstChild)){
		$oldImage->replaceChild($newImage, $oldImage->firstChild);
	} else{
		$oldImage->appendChild($newImage);
	}

	$oldHandout = $result->getElementsByTagName("handout")->item(0);
	$newHandout = $storycorpusDoc->createTextNode($_POST['editHandout']);
	if(!is_null($oldHandout->firstChild)){
		$oldHandout->replaceChild($newHandout, $oldHandout->firstChild);
	} else{
		$oldHandout->appendChild($newHandout);
	}

	// story lines
	$morphogloss = $result->getElementsByTagName("morphogloss")->item(0);
	$oldLines = $morphogloss->getElementsByTagName("line");
	while($oldLines->length > 0){
		$currentLine = $oldLines->item(0);
		$currentLine->parentNode->removeChild($currentLine);
	}

	// HTML lines
	$lines = $_POST['line'];

	for ($x=0; $x<count($lines); $x++) {
		// looping through lines from the HTML form
		$currentline = $lines[$x];
		
		// if the first morpheme is empty, we will assume the whole line is empty 
		if($currentline['source'] != ""){
			$line = $storycorpusDoc->createElement('line');
			$lineid = $editID . "_" . ($x + 1);
			$line->setAttribute('id', $lineid);

			$speaker = $storycorpusDoc->createElement('speaker');
			$speakerText = $storycorpusDoc->createTextNode($currentline['speaker']);
			$speaker->appendChild($speakerText);
			$line->appendChild($speaker);

			$lineaudio = $storycorpusDoc->createElement('lineaudio');
			$lineaudioText = $storycorpusDoc->createTextNode($currentline['lineaudio']);
			$lineaudio->appendChild($lineaudioText);
			$line->appendChild($lineaudio);

			$source = $storycorpusDoc->createElement('source');
			$sourceText = $storycorpusDoc->createTextNode($currentline['source']);
			$source->appendChild($sourceText);
			$line->appendChild($source);

			$translation = $storycorpusDoc->createElement('translation');
			$translationText = $storycorpusDoc->createTextNode($currentline['translation']);
			$translation->appendChild($translationText);
			$line->appendChild($translation);

			$note = $storycorpusDoc->createElement('note');
			$noteText = $storycorpusDoc->createTextNode($currentline['note']);
			$note->appendChild($noteText);
			$line->appendChild($note);

			for ($y=0;$y<count($currentline['morpheme']); $y++) {
				if($currentline['morpheme'][$y]['m'] != ""){
					$morpheme = $storycorpusDoc->createElement('morpheme');
					
					$m = $storycorpusDoc->createElement('m');
					$mText = $storycorpusDoc->createTextNode($currentline['morpheme'][$y]['m']);
					$m->appendChild($mText);
					$morpheme->appendChild($m);

					$g = $storycorpusDoc->createElement('g');
					$gText = $storycorpusDoc->createTextNode($currentline['morpheme'][$y]['g']);
					$g->appendChild($gText);
					$morpheme->appendChild($g);
					
					$line->appendChild($morpheme);
					// check to see if we need to add this morpheme to our morpheme database
					$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme");
					$needToEnter = true;
					
					$originalEntrySource = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $currentline['morpheme'][$y]['m'])))));
					$entrySource = trim($currentline['morpheme'][$y]['m']);
					$entrySource = str_replace("‘", "'", $entrySource);
					$entrySource = str_replace("’", "'", $entrySource);
					$entrySource = str_replace(")", "", $entrySource);
					$entrySource = str_replace("(", "", $entrySource);
					$entrySource = trim($entrySource, "-");

					$originalEntryGloss = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $currentline['morpheme'][$y]['g'])))));
					$entryGloss = trim($currentline['morpheme'][$y]['g']);
					$entryGloss = str_replace("‘", "'", $entryGloss);
					$entryGloss = str_replace("’", "'", $entryGloss);
					$entryGloss = str_replace(")", "", $entryGloss);
					$entryGloss = str_replace("(", "", $entryGloss);
					$entryGloss = trim($entryGloss, "-");

					if(substr($originalEntrySource, 0, 1) == "-"){
						$entryAffix = "suffix";
					} elseif(substr($originalEntrySource, -1, 1) == "-"){
						$entryAffix = "prefix";
					} else{
						$entryAffix = "root";
					}
					foreach($resultMorph as $existingMorpheme){
						$existingSource = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
						$existingGloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);
						
						if(($entrySource == $existingSource) && ($entryGloss == $existingGloss)){
							$needToEnter = false;
							$existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue = $existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue . $id . ",";
							
							// check to see if we need to change the affix tag
							$existingAffix = $existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue;
							if(strpos($existingAffix, $entryAffix) === FALSE){
								$existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue = $existingAffix . "," . $entryAffix;
							}
							break;
						}
					}
					if($needToEnter == true){
						$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
						if($resultMorph->item(0)){
							$idMorph = ($resultMorph->item(0)->getAttribute('id')) + 1;
						} else{
							$idMorph = 1;
						} 

						$entryMorph = $morphemeXmlDoc->createElement("morpheme");
						$entryMorph->setAttribute("id",$idMorph);
						
						$entryMorphSource = $morphemeXmlDoc->createElement("source");
						$entryMorphSourceText = $morphemeXmlDoc->createTextNode($entrySource);
						$entryMorphSource->appendChild($entryMorphSourceText);
						$entryMorph->appendChild($entryMorphSource);
						
						$entryMorphGloss = $morphemeXmlDoc->createElement("gloss");
						$entryMorphGlossText = $morphemeXmlDoc->createTextNode($entryGloss);
						$entryMorphGloss->appendChild($entryMorphGlossText);
						$entryMorph->appendChild($entryMorphGloss);
						
						$entryMorphRoot = $morphemeXmlDoc->createElement("root");
						$entryMorphRootText = $morphemeXmlDoc->createTextNode($entrySource);
						$entryMorphRoot->appendChild($entryMorphRootText);
						$entryMorph->appendChild($entryMorphRoot);
						
						$entryMorphHypernym = $morphemeXmlDoc->createElement("hypernym");
						$entryMorphHypernymText = $morphemeXmlDoc->createTextNode($entryGloss);
						$entryMorphHypernym->appendChild($entryMorphHypernymText);
						$entryMorph->appendChild($entryMorphHypernym);
						
						$entryMorphPhrasicon = $morphemeXmlDoc->createElement("phrasicon");
						$entryMorph->appendChild($entryMorphPhrasicon);
						
						$entryMorphDictionary = $morphemeXmlDoc->createElement("dictionary");
						$entryMorph->appendChild($entryMorphDictionary);
						
						$entryMorphStoryCorpus = $morphemeXmlDoc->createElement("storycorpus", ($id . ","));
						$entryMorph->appendChild($entryMorphStoryCorpus);					

						$entryMorphAffix = $morphemeXmlDoc->createElement("affix", $entryAffix);
						$entryMorph->appendChild($entryMorphAffix);
						
						$morphemeRootNode = $morphemeXpath->query("//morphemedatabase")->item(0);
						$morphemeRootNode->appendChild($entryMorph);
					}
					$morphemeMetadata = $morphemeXpath->query("//modified")->item(0); 
					$morphemeMetadata->nodeValue = date("Y-m-d");	
					$morphemeXmlDoc->save($morphemeFile);
					// end of check for morphemeDB
				}
			}
			$morphogloss->appendChild($line);
		}
	}

	// save changes   
	$storycorpusDoc->save($storycorpusFile);
	}    

// if they want to mass edit a morpheme
} elseif ($_POST['type'] == 'mass_edit') {

	$morph = $storycorpusDoc->createTextNode(trim($_POST['morph']))->nodeValue;
	$gloss = $storycorpusDoc->createTextNode(trim($_POST['gloss']))->nodeValue;

	$edit_m = $storycorpusDoc->createTextNode(trim($_POST['edit_m']))->nodeValue;
	$edit_g = $storycorpusDoc->createTextNode(trim($_POST['edit_g']))->nodeValue;

	// check to see if we need to add this morpheme to our morpheme database
				$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme");
				$needToEnter = true;

				$originalEntrySource = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $edit_m)))));
				$entrySource = trim($edit_m);
				$entrySource = str_replace("‘", "'", $entrySource);
				$entrySource = str_replace("’", "'", $entrySource);
				$entrySource = str_replace(")", "", $entrySource);
				$entrySource = str_replace("(", "", $entrySource);
				$entrySource = trim($entrySource, "-");
				
				$originalEntryGloss = trim(str_replace("‘", "'", str_replace("’", "'", str_replace("(", "", str_replace(")", "", $edit_g)))));
				$entryGloss = trim($edit_g);
				$entryGloss = str_replace("‘", "'", $entryGloss);
				$entryGloss = str_replace("’", "'", $entryGloss);
				$entryGloss = str_replace(")", "", $entryGloss);
				$entryGloss = str_replace("(", "", $entryGloss);
				$entryGloss = trim($entryGloss, "-");

				if(substr($originalEntrySource, 0, 1) == "-"){
					$entryAffix = "suffix";
				} elseif(substr($originalEntrySource, -1, 1) == "-"){
					$entryAffix = "prefix";
				} else{
					$entryAffix = "root";
				}

				foreach($resultMorph as $existingMorpheme){
					$existingSource = trim($existingMorpheme->getElementsByTagName("source")->item(0)->nodeValue);
					$existingGloss = trim($existingMorpheme->getElementsByTagName("gloss")->item(0)->nodeValue);

					if(($entrySource == $existingSource) && ($entryGloss == $existingGloss)){
						$needToEnter = false;
						$existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue = $existingMorpheme->getElementsByTagName("storycorpus")->item(0)->nodeValue . $id . ",";
						
						// check to see if we need to change the affix tag
						$existingAffix = $existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue;
						if(strpos($existingAffix, $entryAffix) === FALSE){
							$existingMorpheme->getElementsByTagName("affix")->item(0)->nodeValue = $existingAffix . "," . $entryAffix;
						}
						break;
					}
				}
				if($needToEnter == true){
					$resultMorph = $morphemeXpath->query("/morphemedatabase/morpheme[last()]");
					if($resultMorph->item(0)){
						$idMorph = ($resultMorph->item(0)->getAttribute('id')) + 1;
					} else{
						$idMorph = 1;
					} 

					$entryMorph = $morphemeXmlDoc->createElement("morpheme");
					$entryMorph->setAttribute("id",$idMorph);
					
					$entryMorphSource = $morphemeXmlDoc->createElement("source");
					$entryMorphSourceText = $morphemeXmlDoc->createTextNode($entrySource);
					$entryMorphSource->appendChild($entryMorphSourceText);
					$entryMorph->appendChild($entryMorphSource);
					
					$entryMorphGloss = $morphemeXmlDoc->createElement("gloss");
					$entryMorphGlossText = $morphemeXmlDoc->createTextNode($entryGloss);
					$entryMorphGloss->appendChild($entryMorphGlossText);
					$entryMorph->appendChild($entryMorphGloss);
					
					$entryMorphRoot = $morphemeXmlDoc->createElement("root");
					$entryMorphRootText = $morphemeXmlDoc->createTextNode($entrySource);
					$entryMorphRoot->appendChild($entryMorphRootText);
					$entryMorph->appendChild($entryMorphRoot);
					
					$entryMorphHypernym = $morphemeXmlDoc->createElement("hypernym");
					$entryMorphHypernymText = $morphemeXmlDoc->createTextNode($entryGloss);
					$entryMorphHypernym->appendChild($entryMorphHypernymText);
					$entryMorph->appendChild($entryMorphHypernym);
					
					$entryMorphPhrasicon = $morphemeXmlDoc->createElement("phrasicon");
					$entryMorph->appendChild($entryMorphPhrasicon);
					
					$entryMorphDictionary = $morphemeXmlDoc->createElement("dictionary");
					$entryMorph->appendChild($entryMorphDictionary);
					
					$entryMorphStoryCorpus = $morphemeXmlDoc->createElement("storycorpus", ($id . ","));
					$entryMorph->appendChild($entryMorphStoryCorpus);					
					
					$entryMorphAffix = $morphemeXmlDoc->createElement("affix", $entryAffix);
					$entryMorph->appendChild($entryMorphAffix);
					
					$morphemeRootNode = $morphemeXpath->query("//morphemedatabase")->item(0);
					$morphemeRootNode->appendChild($entryMorph);
				}
				$morphemeMetadata = $morphemeXpath->query("//modified")->item(0); 
				$morphemeMetadata->nodeValue = date("Y-m-d");	
				$morphemeXmlDoc->save($morphemeFile);
	// end of check for morphemeDB
	
	// if the user actually filled in a morpheme to replace, we will look up all instances where the source language text matches that morpheme
	if(isset($morph)){
		// editing the story corpus 
		$morphemes_s = $storycorpusXPath->query("//morpheme");

		foreach($morphemes_s as $possible){
			$possible_m = $possible->getElementsByTagName("m")->item(0);
			$possible_g = $possible->getElementsByTagName("g")->item(0);
			if(($possible_m->nodeValue == $morph)&&($possible_g->nodeValue == $gloss)){
				$possible_m->nodeValue = $edit_m;
				$possible_g->nodeValue = $edit_g;
			}
		}
		$storycorpusDoc->save($storycorpusFile);
	}    
    
// if they want to delete a story
} elseif ($_POST['type'] == 'delete') {
	$id = (int)$_POST['id'];  
	if($id!=""){    
		$result = $storycorpusXPath->query("/storycorpus/story[@id='$id']");
		$result->item(0)->parentNode->removeChild($result->item(0));
		$storycorpusDoc->save($storycorpusFile);	
	}	
}

// update the last modified date in the story corpus
$storycorpusMetadata = $storycorpusXPath->query("/storycorpus/metadata")->item(0); 
$storycorpusMetadata->getElementsByTagName("modified")->item(0)->nodeValue = date("Y-m-d");
$storycorpusDoc->save($storycorpusFile);


echo "<div class=\"jumbotron\"><div class=\"container-fluid\"><div class=\"row\"><div class=\"col\"><hr><br><h4>Success!</h4></div></div></div></div>";
include("story_update_page.php");

?> 


<!DOCTYPE html>
<html>

<head>            
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- 1. Insert your name below, if you like. You can also delete that line; having it is entirely optional! -->
	<meta name="author" content="You">

	<!-- 2. Insert your name below, if you like. You can also delete that line; having it is entirely optional! -->
	<meta name="copyright" content="You" />

	<!-- 3. Replace with the name of your language. -->
	<title>Your Language Stories and Texts</title>  
		
	<!-- CSS: This page is powered by Bootstrap 4 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- CSS file with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="../css/texts.css">
	
	<!-- fonts and icons -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">		
</head>

<body>
	<!-- 4. This is the bar at the top of the page. Feel free to add or remove links to match your site. -->
	<nav class="navbar fixed-top navbar-dark bg-dark">
		<a class="navbar-brand" href="../">Stories & Texts</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="../../../dictionary">Talking Dictionary</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../../phrasicon">Phrasicon</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../../sounds">Sounds of the Language</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../../flashcards">Lessons with Flashcards</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../../expressions">Everyday Expressions</a>
				</li>
			</ul>
		</div>
	</nav>
	
	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
				<!-- 5. Replace with the name of your website -->
				<p> &copy; Your Website <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>
	
	<script src="https://code.jquery.com/jquery-3.3.1.slim.min.js" integrity="sha384-q8i/X+965DzO0rT7abK41JStQIAqVgRVzpbzo5smXKp4YfRvH+8abtTE1Pi6jizo" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>
</body>
</html>
