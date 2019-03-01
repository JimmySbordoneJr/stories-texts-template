<?php
// There are 21 things for you to edit in this file. 
if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    $id = $_POST["story"];
} else{
	$id = $_GET["story"];
}

$file = 'stories.xml';
$xmlDoc = new DOMDocument(); 
$xmlDoc->load($file); 
$xpath = new DOMXPath($xmlDoc); 

$story = $xpath->query("/storycorpus/story[@id='$id']")->item(0);
$storytitle = $story->getElementsByTagName("storytitle")->item(0)->nodeValue;
$audiodir = str_replace("/", "_", str_replace(' ', '', $storytitle)) . $id . "/";
$narrator = $story->getElementsByTagName("narrator")->item(0)->nodeValue;
$interviewer = $story->getElementsByTagName("interviewer")->item(0)->nodeValue;
$description = $story->getElementsByTagName("description")->item(0)->nodeValue;
$socialmediabuttontext = $story->getElementsByTagName("socialmediabuttontext")->item(0)->nodeValue;
$wholestoryaudio = $story->getElementsByTagName("wholestoryaudio")->item(0)->nodeValue;
$image = $story->getElementsByTagName("image")->item(0)->nodeValue;
$handout = $story->getElementsByTagName("handout")->item(0)->nodeValue;
$morphogloss = $story->getElementsByTagName("morphogloss")->item(0);

// we have to do some extra work to these links to hide some of Youtube's logos and ads
// replace youtube with youtube-nocookie? I'm not sure what nocookie actually does, if anything. If
// we want to take it out later, we could using PHP's str_replace() function
if(trim($story->getElementsByTagName("youtubelinksourcelang")->item(0)->nodeValue) == ""){
	$youtubelinksourcelang = ""; 
} else{
	$youtubelinksourcelang = $story->getElementsByTagName("youtubelinksourcelang")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
}

if(trim($story->getElementsByTagName("youtubelinktranslationlang")->item(0)->nodeValue) == ""){
	$youtubelinktranslationlang = ""; 
} else{
	$youtubelinktranslationlang = $story->getElementsByTagName("youtubelinktranslationlang")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
}

if(trim($story->getElementsByTagName("youtubelinkboth")->item(0)->nodeValue) == ""){
	$youtubelinkboth = ""; 
} else{
	$youtubelinkboth = $story->getElementsByTagName("youtubelinkboth")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
}

// checking to see if there are other versions of this story
$otherVersions = $xpath->query("/storycorpus/story/storytitle[text()='" . $storytitle . "']/.."); 

// okay, this takes a bit of explaining. In order for the modals to work, they cannot be nested within an element
// with fixed positioning (like a carousel item). Hence, we need to build the modals outside of the loop where the carousel items 
// are built. I will build a multidimensional array named modalInfo where I will store the data needed to build each modal.
// then, outside of the carousel, I will loop through modalInfo and build all of the needed modals.
$modalInfo = array();
?>

<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="utf-8" />
  <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />

	<!-- 1. Replace with the name of your language -->
  <title>Your Language Stories and Texts: <?php echo $storytitle; ?></title>

	<!-- 2. Replace with the name of your language -->
  <meta name="description" content="Your Language Stories and Texts: <?php echo $description; ?>" />
    
	<!-- 3. Replace with your name, or delete the whole line, if you'd like. It is optional. -->
	<meta name="author" content="You" />

	<!-- 4. Replace with your name or your website's name, or delete the whole line, if you'd like. It is optional. -->
  <meta name="copyright" content="You" />
	
	<!-- these tags fill in the Facebook post content -->

	<!-- 5. Replace with the name of your website. -->
  <meta property="og:url" content="http://www.yourwebsite.com/texts/story.php?story=<?php echo $id; ?>" />

	<meta property="og:type" content="website" />

	<!-- 6. Replace with the name of your language. -->
	<meta property="og:title" content="<?php echo $storytitle . ": Your Language Stories and Texts"; ?>" />

	<meta property="og:description" content="<?php echo $description; ?>" />

	<!-- 7. Replace with the name of your website. -->
	<meta property="og:image" content="http://www.yourwebsite.com/texts/img/<?php echo $image;?>" />
	
	<!-- this adds some fonts and icons -->
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.0.13/css/all.css" integrity="sha384-DNOHZ68U8hZfKXOrtjWvjxusGo9WQnrNx2sqG0tfsghAvtVlRW3tvkXWZh58N9jp" crossorigin="anonymous">
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">

	<!-- Bootstrap CSS file. This page runs on Bootstrap 4.1 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	
	<!-- CSS file with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="css/texts.css">

</head>

<body>
<div class="hidden">
<!-- loading animation -->
<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>

<!-- This stuff makes the Facebook button work -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1177996378903661&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- -->

	<!-- 8. This is the bar at the top of the page. Replace, remove, or add nav items to fit your website. -->
<nav class="navbar fixed-top navbar-dark bg-dark">
<a class="navbar-brand" href="index.php">Back to Texts</a>
  <button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
    <span class="navbar-toggler-icon"></span>
  </button>
  <div class="collapse navbar-collapse" id="navbarSupportedContent">
    <ul class="navbar-nav mr-auto">
      <li class="nav-item">
        <a class="nav-link" href="../">Home </a>
      </li>
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
      <li class="nav-item">
        <a class="nav-link" href="../about">About the Language</a>
      </li>
      <li class="nav-item">
        <a class="nav-link" href="../contact">Feedback</a>
      </li>
    </ul>
  </div>
</nav>
<?php 
	if($otherVersions->length > 1){
		echo '<div id="storyCarousel" class="carousel slide" data-ride="carousel" data-interval="false">';

				// this block adds in the little things that you can click on to go from one slide to another
				echo '<ol class="carousel-indicators"><li data-target="#storyCarousel" data-slide-to="0" class="active"></li>'; 
				// for each story beyond the main one, add an li for it
				for($storyCount = 1; $storyCount < $otherVersions->length; $storyCount++){
					echo '<li data-target="#storyCarousel" data-slide-to="' . $storyCount . '"></li>';
				}
				echo '</ol>';
		
		echo	 '<div class="carousel-inner"><div class="carousel-item active">';
	}
 ?>

<!-- This is the area covered by an image, and it contains the header and the videos -->
<div class="jumbotron jumbotron-fluid">
  <div class="container">
	<div class="row">
		<div class="col-md-6 col-sm-12">
			<div class="black-box black-box--notTitle">
				<h4><?php echo $storytitle; ?><span id="storyIdNumber" data-story="<?php echo $id;?>"></span></h4>
				<p><?php echo $description; ?></p>
				<div class="container-fluid">
					<div class="row">				
						<?php 
								if(strpos($narrator, ",") !== FALSE){
									echo '<div class="col-lg-3 col-xs-4">Speakers:</div>';
									$narrator_array = explode(",", $narrator);
									for($n = 0; $n < count($narrator_array); $n++){
										if($n != 0){
											echo '<div class="col-lg-3 col-xs-4">&nbsp; </div>';
										}
										// 9. Replace with your website name
										echo '<div class="col-lg-9 col-xs-8"><a class="text-light" target="_blank" href="http://yourwebsite.com/texts/secretIndex.php?lang=translation&searchTerm=Speaker:' . str_replace(" ", "_", $narrator_array[$n]) . '">' . $narrator_array[$n] . '</a></div>';
									}
								} else{
									echo '<div class="col-lg-3 col-xs-4">Speaker:</div>';
									// 10. Replace with your website name
									echo '<div class="col-lg-9 col-xs-8"><a class="text-light" target="_blank" href="http://yourwebsite.com/texts/secretIndex.php?lang=translation&searchTerm=Speaker:' . str_replace(" ", "_", $narrator) . '">' . $narrator . '</a></div>';
								}
							?>
					</div>
				</div>
            </div>
		</div>
		
		<div class="col-md-6 col-sm-12">
			<div class="tab-content" id="nav-tabContent">
			<?php if($youtubelinkboth !== "") : ?>
				<div class="tab-pane videoTab show active" id="SourceLangTranslationLang" role="tabpanel" aria-labelledby="SourceLangTranslationLang-tab">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe src="<?php echo $youtubelinkboth; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if($youtubelinksourcelang !== "") : ?>
				<div class="tab-pane videoTab" id="SourceLang" role="tabpanel" aria-labelledby="SourceLang-tab">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe src="<?php echo $youtubelinksourcelang; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
				<?php endif; ?>
				
				<?php if($youtubelinktranslationlang !== "") : ?>
				<div class="tab-pane videoTab" id="TranslationLang" role="tabpanel" aria-labelledby="TranslationLang-tab">
					<div class="embed-responsive embed-responsive-16by9">
						<iframe src="<?php echo $youtubelinktranslationlang; ?>" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
					</div>
				</div>
				<?php endif; ?>
			</div>

			<nav>
				<ul class="nav nav-pills nav-fill nav-justified" id="nav-tab" role="tablist">
				<?php if($youtubelinksourcelang !== "") : ?>
					<li class="nav-item">
						<a class="nav-item nav-link" id="SourceLang-tab" data-toggle="pill" href="#SourceLang" role="tab" aria-controls="SourceLang" aria-selected="false"><!-- 11. Replace with the name of your language--> Source Language Subtitles</a>
					</li>
					<?php endif; ?>


					<?php if($youtubelinktranslationlang !== "") : ?>
					<li class="nav-item">
						<a class="nav-item nav-link" id="TranslationLang-tab" data-toggle="pill" href="#TranslationLang" role="tab" aria-controls="TranslationLang" aria-selected="false"><!-- 12. Replace with the name of the other language language, most likely English. -->Translation Language Subtitles</a>
					</li>
					<?php endif; ?>

					<?php if($youtubelinkboth !== "") : ?>
					<li class="nav-item">
						<a class="nav-link active" id="SourceLangTranslationLang-tab" data-toggle="pill" href="#SourceLangTranslationLang" role="tab" aria-controls="SourceLangTranslationLang" aria-selected="true">Both Subtitles</a>
					</li>	
					<?php endif; ?>
		
				</ul>
			</nav>
		</div>
	</div>
  </div>
</div>

<!-- Here comes a fun PHP loop -->

<div class="container-fluid">
	<div class="row">
		<div class="col">
			<button class="btn btn-success" id="playStoryButton" data-toggle="collapse" href="#wholeAudio" role="button" aria-expanded="false" aria-controls="wholeAudio"><i class="fas fa-volume-up"></i>&nbsp; <span class="d-none d-sm-inline">Play </span>Entire Story </button>	
			<!-- This button opens and closes all of the glosses at once. It works using an extra Javascript file below -->
			<button class="btn btn-info" id="toggleAllButton" data-toggle="collapse" role="button" onclick="toggleAllGlosses()"><span data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Note:</em> This button can be slow for large stories.">Toggle All <span class="d-none d-sm-inline">Glosses</span></span></button>
		</div>
	</div>

	<div class="row collapse multi-collapse" id="wholeAudio">
		<div class="col">
			<br/>
			<audio src="<?php echo "sounds/" . $audiodir . $wholestoryaudio; ?>" preload="auto" controls></audio>
		</div>
	</div>
	<br/>
	
	<!-- loop must create content from here -->
	<?php 
		$i = 1;
		$lines = $morphogloss->getElementsByTagName("line");
		if($lines->length > 0){
		foreach($lines as $currentLine){
			$hintText = "<button type=\"button\" class=\"btn btn-sm btn-invisible\" disabled><i class=\"fas fa-lightbulb\"></i></button>";
			// if the hint is not empty, create a button and add it to hintText, and create a modal to display the text 
			if(trim($currentLine->getElementsByTagName("note")->item(0)->nodeValue) != ""){
				$hintText = "<button type=\"button\" class=\"btn btn-sm btn-lightbulb\" data-toggle=\"modal\" data-target=\"#Note" . $i . "\"><i class=\"fas fa-lightbulb\"></i></button>";
				
				// let's grab the ID and text required to build the modal and save it for later
				$modalId = "Note" . $i;
				$newModal = array($modalId, $currentLine->getElementsByTagName("note")->item(0)->nodeValue);
				array_push($modalInfo, $newModal);
			}
			
			echo '<div class="row"><div class="col-lg-2 col-xs-12"><div class="row"><div class="col-1">' . $i . '</div><div class="col">';

			if($currentLine->getElementsByTagName("lineaudio")->item(0)->nodeValue != ""){
				echo '<audio id="line' . $i . 'audio" src="sounds/' . $audiodir. $currentLine->getElementsByTagName("lineaudio")->item(0)->nodeValue . '" preload="auto"></audio>' .
				'<button class="btn btn-sm btn-light" onclick="document.getElementById(\'line' . $i . 'audio\').play();"><i class="fas fa-volume-up"></i></button>';	
			} else{
				echo '<button class="btn btn-sm btn-invisible" disabled><i class="fas fa-volume-up"></i></button>';
			}

			if(($currentLine->getElementsByTagName("morpheme")->length > 0) && (trim($currentLine->getElementsByTagName("translation")->item(0)->nodeValue) !== "")){
				echo '<button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse' . $i . '" aria-expanded="false" aria-controls="line' . $i . 'gloss line' . $i . 'Translation">Gloss</button>';
				echo $hintText . $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div><div class="col-lg-5 col-xs-12">' .
				'<p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p> </div>' .
				'<div class="col-lg-5 col-xs-12 collapse multi-collapse' . $i . ' show translation" id="line' . $i . 'Translation">' . 
				'<p>' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p></div></div>' . 
				'<div class="row collapse multi-collapse' . $i . ' gloss" id="line' . $i . 'gloss"><div class="col-lg-2 col-xs-0"></div>' . 
				'<div class="col-lg-10 col-xs-12"><dl>';
				// for loop to handle the morphemes
				$bagOfMorphemes = $currentLine->getElementsByTagName("morpheme");
				if($bagOfMorphemes->length > 0){
					foreach($bagOfMorphemes as $morpheme){
						echo '<div class="word"><dt>' . $morpheme->getElementsByTagName("m")->item(0)->nodeValue . '</dt>' . 
						'<dd>' . $morpheme->getElementsByTagName("g")->item(0)->nodeValue;
						if(trim($morpheme->getElementsByTagName("g")->item(0)->nodeValue) == ""){
							echo " &nbsp; ";
						}
						echo '</dd></div>';
					}
				}
				echo '</dl> <p class="mainTranslationLang">' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p><br/></div>';
			}elseif(($currentLine->getElementsByTagName("morpheme")->length <= 0) && (trim($currentLine->getElementsByTagName("translation")->item(0)->nodeValue) !== "")){
				echo '<button class="btn btn-sm btn-invisible" disabled>Gloss</button>';
				echo $hintText . $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div><div class="col"><p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p></div>';
				echo '<div class="col-lg-5 col-xs-12' . $i . ' translation" id="line' . $i . 'Translation">' . 
				'<p>' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p></div>';
			}else{
				echo '<button class="btn btn-sm btn-invisible" disabled>Gloss</button>';
				echo $hintText . $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div><div class="col"><p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p></div>';
			}

			echo '</div>';  // close the row
			$i++;
		}
	}
	?>	
</div>

<!-- let's have the carousel end here -->
<?php 
// if there more than one story with this title...
if($otherVersions->length > 1){
	// close the carousel item div that surrounded the main version of this story.
	echo '</div>';
	
	// foreach loop to build other panels for other versions of this story
	$storyCount2 = 1;
	foreach($otherVersions as $nextStory){
		// if $nextStory is the story we already did in the code above, we want to skip it now
		if($nextStory->getAttribute('id') != $id){
			$nextId = $nextStory->getAttribute('id');
			// open a new carousel item
			echo '<div class="carousel-item">';
			// get story parts 
			$nextStorytitle = $nextStory->getElementsByTagName("storytitle")->item(0)->nodeValue;
			$nextAudiodir = str_replace("/", "_", str_replace(' ', '', $nextStorytitle)) . $nextId . "/";
			$nextNarrator = $nextStory->getElementsByTagName("narrator")->item(0)->nodeValue;
			$nextInterviewer = $nextStory->getElementsByTagName("interviewer")->item(0)->nodeValue;
			$nextDescription = $nextStory->getElementsByTagName("description")->item(0)->nodeValue;
			$nextWholestoryaudio = $nextStory->getElementsByTagName("wholestoryaudio")->item(0)->nodeValue;
			$nextImage = $nextStory->getElementsByTagName("image")->item(0)->nodeValue;
			$nextHandout = $nextStory->getElementsByTagName("handout")->item(0)->nodeValue;
			$nextMorphogloss = $nextStory->getElementsByTagName("morphogloss")->item(0);

			if(trim($nextStory->getElementsByTagName("youtubelinksourcelang")->item(0)->nodeValue) == ""){
				$nextYoutubelinksourcelang = ""; 
			} else{
				$nextYoutubelinksourcelang = $nextStory->getElementsByTagName("youtubelinksourcelang")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
			}

			if(trim($nextStory->getElementsByTagName("youtubelinktranslationlang")->item(0)->nodeValue) == ""){
				$nextYoutubelinktranslationlang = ""; 
			} else{
				$nextYoutubelinktranslationlang = $nextStory->getElementsByTagName("youtubelinktranslationlang")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
			}

			if(trim($nextStory->getElementsByTagName("youtubelinkboth")->item(0)->nodeValue) == ""){
				$nextYoutubelinkboth = ""; 
			} else{
				$nextYoutubelinkboth = $nextStory->getElementsByTagName("youtubelinkboth")->item(0)->nodeValue . "?rel=0&amp;controls=1&amp;showinfo=0"; 
			}

			// ^build jumbotron-- title, description, videos
			echo '<div class="jumbotron jumbotron-fluid">
					<div class="container">
						<div class="row">
							<div class="col-md-6 col-sm-12">
								<div class="black-box black-box--notTitle">
									<h4>' . $nextStorytitle . '</h4>
									<p>' . $nextDescription . '</p>
									<div class="container-fluid">
										<div class="row">';				
									if(strpos($nextNarrator, ",") !== FALSE){
										echo '<div class="col-lg-3 col-xs-4">Speakers:</div>';
										$narrator_array = explode(",", $nextNarrator);
										for($n = 0; $n < count($narrator_array); $n++){
											if($n != 0){
												echo '<div class="col-lg-3 col-xs-4">&nbsp; </div>';
											}
											// 13. Replace with your website name
											echo '<div class="col-lg-9 col-xs-8"><a class="text-light" target="_blank" href="http://yourwebsite.com/texts/secretIndex.php?lang=translation&searchTerm=Speaker:' . str_replace(" ", "_", $narratorArray[$n]) . '">' . $narratorArray[$n] . '</a></div>';
										}
									} else{
										echo '<div class="col-lg-3 col-xs-4">Speaker:</div>';
										// 14. Replace with your website name
										echo '<div class="col-lg-9 col-xs-8"><a class="text-light" target="_blank" href="http://yourwebsite.com/texts/secretIndex.php?lang=translation&searchTerm=Speaker:' . str_replace(" ", "_", $nextNarrator) . '">' . $nextNarrator . '</a></div>';
									}
							
					echo '</div>
				</div>';
								echo '</div>
							</div>
							
							<div class="col-md-6 col-sm-12">
								<div class="tab-content" id="nav-tabContent' . $storyCount2 . '">';

								if($nextYoutubelinkboth !== ""){
									echo '<div class="tab-pane videoTab show active" id="SourceLangTranslationLang' . $storyCount2 . '" role="tabpanel" aria-labelledby="SourceLangTranslationLang-tab' . $storyCount2 . '">
									<div class="embed-responsive embed-responsive-16by9">' .
										'<iframe src="' . $nextYoutubelinkboth . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
									</div>
								</div>';
								}

								if($nextYoutubelinksourcelang !== ""){
									echo '<div class="tab-pane videoTab" id="SourceLang' . $storyCount2 . '" role="tabpanel" aria-labelledby="SourceLang-tab' . $storyCount2 . '">
									<div class="embed-responsive embed-responsive-16by9">' .
										'<iframe src="' . $nextYoutubelinksourcelang . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
									</div>
								</div>';
								}

								if($nextYoutubelinktranslationlang !== ""){
									echo '<div class="tab-pane videoTab" id="TranslationLang' . $storyCount2 . '" role="tabpanel" aria-labelledby="TranslationLang-tab' . $storyCount2 . '">' .
									'<div class="embed-responsive embed-responsive-16by9">
										<iframe src="' . $nextYoutubelinktranslationlang . '" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>' .
									'</div>
								</div>';
								}
									
								echo '</div>
								
								<nav>
									<ul class="nav nav-pills nav-fill nav-justified" id="nav-tab' . $storyCount2 . '" role="tablist">';
										if($nextYoutubelinksourcelang !== ""){
											echo '<li class="nav-item"><a class="nav-item nav-link" id="SourceLang-tab'. $storyCount2 .'" data-toggle="pill" href="#SourceLang' . $storyCount2 . '" role="tab" aria-controls="SourceLang' . $storyCount2 . '" aria-selected="false">SourceLang Subtitles</a></li>'; // 15. Replace SourceLang Subtitles with your language
										}	

										if($nextYoutubelinktranslationlang !== ""){
											echo '<li class="nav-item"><a class="nav-item nav-link" id="TranslationLang-tab'. $storyCount2 . '" data-toggle="pill" href="#TranslationLang' . $storyCount2 . '" role="tab" aria-controls="TranslationLang' . $storyCount2 . '" aria-selected="false">TranslationLang Subtitles</a></li>';// 16. Replace Translation lang subtitles with your language

										}

										if($nextYoutubelinkboth !== ""){
											'<li class="nav-item"><a class="nav-link active" id="SourceLangTranslationLang-tab' . $storyCount2 . '" data-toggle="pill" href="#SourceLangTranslationLang' . $storyCount2 . '" role="tab" aria-controls="SourceLangTranslationLang' . $storyCount2 . '" aria-selected="true">Both Subtitles</a></li>';
										}
									echo '</ul>
								</nav>
							</div>
						</div>
					</div>
				</div>';

				echo '<div class="container-fluid">
					<div class="row">
						<div class="col">
							<button class="btn btn-success" id="playStoryButton' . $storyCount2 . '" data-toggle="collapse" href="#wholeAudio' . $storyCount2. '" role="button" aria-expanded="false" aria-controls="wholeAudio' . $storyCount2 . '"><i class="fas fa-volume-up"></i>&nbsp; <span class="d-none d-sm-inline">Play </span>Entire Story </button>	
							<!-- This button opens and closes all of the glosses at once. It works using an extra Javascript file below -->
							<button class="btn btn-info" id="toggleAllButton' . $storyCount2 . '" data-toggle="collapse" role="button" onclick="toggleAllGlosses(\''. $storyCount2 .'\')"><span data-toggle="tooltip" data-placement="right" data-html="true" title="<em>Note:</em> This button can be slow for large stories.">Toggle All <span class="d-none d-sm-inline">Glosses</span></span></button>
						</div>
					</div>

					<div class="row collapse multi-collapse" id="wholeAudio' . $storyCount2 . '">
						<div class="col">
							<br/>
							<audio src="sounds/' . $nextAudiodir .  $nextWholestoryaudio . '" preload="auto" controls></audio>
						</div>
					</div>
					<br/>';	
				//story lines
					$i = 1;
					$lines = $nextMorphogloss->getElementsByTagName("line");
					foreach($lines as $currentLine){
					$hintText = "<button type=\"button\" class=\"btn btn-sm btn-invisible\" disabled><i class=\"fas fa-lightbulb\"></i></button>";
					// if the hint is not empty, create a button and add it to hintText, and create a modal to display the text 
					if(trim($currentLine->getElementsByTagName("note")->item(0)->nodeValue) != ""){
						$hintText = "<button type=\"button\" class=\"btn btn-sm btn-lightbulb\" data-toggle=\"modal\" data-target=\"#Note" . $i . "_" . $storyCount2 . "\"><i class=\"fas fa-lightbulb\"></i></button>";
						$modalId = "Note" . $i . "_" . $storyCount2;
						$newModal = array($modalId, $currentLine->note);
						array_push($modalInfo, $newModal);
					}
					echo '<div class="row"><div class="col-lg-2 col-xs-12"><div class="row"><div class="col-1">' . $i . '</div><div class="col">';
						if($currentLine->getElementsByTagName("lineaudio")->item(0)->nodeValue != ""){
							echo '<audio id="line' . $i . '_' . $storyCount2 . 'audio" src="sounds/' . $nextAudiodir . $currentLine->getElementsByTagName("lineaudio")->item(0)->nodeValue . '" preload="auto"></audio>' .
							'<button class="btn btn-sm btn-light" onclick="document.getElementById(\'line' . $i . '_' . $storyCount2 . 'audio\').play();"><i class="fas fa-volume-up"></i></button>';
						} else{
							echo '<button class="btn btn-sm btn-invisible" disabled><i class="fas fa-volume-up"></i></button>';
						}

						if(($currentLine->getElementsByTagName("morpheme")->length > 0) && (trim($currentLine->getElementsByTagName("translation")->item(0)->nodeValue !== ""))){
							echo '<button class="btn btn-sm btn-info" type="button" data-toggle="collapse" data-target=".multi-collapse' . $i . '_' . $storyCount2 . '" aria-expanded="false" aria-controls="line' . $i . '_' . $storyCount2 . 'gloss line' . $i . '_' . $storyCount2 . 'Translation">Gloss</button>';
							echo $hintText
							. $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div>' . 
						
						'<div class="col-lg-5 col-xs-12">' .
							'<p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p> 
						</div>' .
					
						'<div class="col-lg-5 col-xs-12 collapse multi-collapse' . $i . '_' . $storyCount2 . ' show translation' . $storyCount2 . '" id="line' . $i . '_' . $storyCount2 . 'Translation">' . 
							'<p>' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p>
						</div>
						</div>' . 
					
						'<div class="row collapse multi-collapse' . $i . '_' . $storyCount2 . ' gloss' . $storyCount2. '" id="line' . $i . '_' . $storyCount2 . 'gloss">
							<div class="col-lg-2 col-xs-0"></div>' . 
							'<div class="col-lg-10 col-xs-12"><dl>';
						// for loop to handle the morphemes
						$bagOfMorphemes = $currentLine->getElementsByTagName("morpheme");
						if($bagOfMorphemes->length > 0){
							foreach($bagOfMorphemes as $morpheme){
								echo '<div class="word"><dt>' . $morpheme->getElementsByTagName("m")->item(0)->nodeValue . '</dt>' . 
								'<dd>' . $morpheme->getElementsByTagName("g")->item(0)->nodeValue;
								if(trim($morpheme->getElementsByTagName("g")->item(0)->nodeValue) == ""){
									echo " &nbsp; ";
								}
								echo '</dd></div>';
							}
						}
					echo '</dl> <p  class="mainTranslationLang">' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p><br/></div>';
						}elseif(($currentLine->getElementsByTagName("morpheme")->length <= 0) && (trim($currentLine->getElementsByTagName("translation")->item(0)->nodeValue) !== "")){
							echo '<button class="btn btn-sm btn-invisible" disabled>Gloss</button>';
							echo $hintText . $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div><div class="col"><p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p></div>';
							echo '<div class="col-lg-5 col-xs-12' . $i . ' translation" id="line' . $i . 'Translation">' . 
							'<p>' . $currentLine->getElementsByTagName("translation")->item(0)->nodeValue . '</p></div>';
						}else{							
							echo '<button class="btn btn-sm btn-invisible" disabled>Gloss</button>';
							echo $hintText. $currentLine->getElementsByTagName("speaker")->item(0)->nodeValue . '</div></div></div><div class="col"><p class="mainSourceLang">' . $currentLine->getElementsByTagName("source")->item(0)->nodeValue . '</p></div>';
						}	

					echo '</div>'; // close row
					$i++;
				}
			// ^unlike above, we do not need to change the page metadata or the social media buttons
			// fix id name collisions in foreach loop 
			// close a new container and carousel item
			echo '</div></div>';
			$storyCount2++;
		}
	}
	echo '</div>
	<a class="carousel-control-prev" href="#storyCarousel" role="button" data-slide="prev">
		<span class="carousel-control-prev-icon" aria-hidden="true"></span>
		<span class="sr-only">Previous</span>
	</a>
	<a class="carousel-control-next" href="#storyCarousel" role="button" data-slide="next">
		<span class="carousel-control-next-icon" aria-hidden="true"></span>
		<span class="sr-only">Next</span>
	</a>'; 

	echo '</div>';
}
?>

<?php
// now, let's build some modals!
foreach($modalInfo as $buildingModal){
	echo '<div class="modal fade" id="' . $buildingModal[0] . '" tabindex="-1" role="dialog" aria-labelledby="' . $buildingModal[0] . 'Label" aria-hidden="true"><div class="modal-dialog" role="document"><div class="modal-content"><div class="modal-header"><h5 class="modal-title" id="' . $buildingModal[0] . 'Label">Note</h5><button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button></div><div class="modal-body">' .
						$buildingModal[1] . '</div><div class="modal-footer"><button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button></div></div></div></div>';
}

?>

<footer class="container-fluid text-center footer">
	<div class="row">
		<div class="col">
			<!-- 17., 18. Replace with the name of your website X 2 -->
			<div class="fb-share-button" data-href="http://yourwebsite.com/texts/story.php?story=<?php echo $id ?>" data-layout="button_count" data-size="large" data-mobile-iframe="true"><a target="_blank" href="https://www.facebook.com/sharer/sharer.php?u=http%3A%2F%2Fyourwebsite.com%2Ftexts%2Fstory.php?story=<?php echo $id ?>%2F&amp;src=sdkpreparse" class="fb-xfbml-parse-ignore">Share</a></div>
			&nbsp;
			<a class="btn btn-info printable-button" href="handouts/<?php echo $handout ?>" download><i class="fas fa-download d-inline d-sm-none"></i><span class="d-none d-sm-inline">Printable Version</span></a>
			&nbsp;

			<!-- 19., 20. Replace with the name of your website X 2 -->
			<a href="https://twitter.com/share?ref_src=twsrc%5Etfw" class="twitter-share-button" data-size="large" data-text="<?php echo $socialmediabuttontext ?>" data-url="http://yourwebsite.com/texts/story.php?story=<?php echo $id ?>" data-lang="en" data-show-count="false">Tweet</a><script async src="https://platform.twitter.com/widgets.js" charset="utf-8"></script>
		</div>
	</div>
	
	<div class="row">
		<div class="col">
		<!-- 21. Replace with the name of your website -->
			<p> &copy; Your Website Name <?php echo date("Y"); ?></p>
		</div>
	</div>
</footer>
	</div>
	<!-- Bootstrap Javascript files -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>
	
	<!-- This file contains the code to animate the page fading in when a user opens the page and fading out
when the user leaves the page. -->
	<script src="js/fadeAnimations.js"></script>

	<!-- This script removes the loading animation once the page has loaded. -->
	<script src="js/removeLoader.js"></script>

	<!-- Bootstrap: enable tooltips -->
	<script>
		$(function () {
			$('[data-toggle="tooltip"]').tooltip()
		})
	</script>
	
	<!-- This script lets people use the arrow keys to scroll through different story versions. -->	
	<script src="js/keyPressScroll.js"></script>
	
	<!-- This script powers the 'toggle all glosses' button -->
	<script src="js/toggleAll.js"></script>
	
	<!-- This script powers the linking of the story text morphemes to other parts of the website. -->
	<script src="js/glossLinking.js"></script>
	
</body>

</html>