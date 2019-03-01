<?php 
// This is the main stories and texts homepage. It only shows stories that are not password-protected.
// There are 11 things for you to edit. 
$lang = isset($_GET["lang"]) ? $_GET["lang"] : '';
$searchTerm = isset($_GET["searchTerm"]) ? $_GET["searchTerm"] : ''; 
$gloss = isset($_GET["searchGloss"]) ? $_GET["searchGloss"] : '';
$xmlDoc=new DOMDocument(); 
$xmlDoc->load("stories.xml"); 
$xpath = new DOMXPath($xmlDoc); 
$stories = $xpath->query("./story[approved = 'True']");
$drafts = $xpath->query("./story[approved = 'False']"); 
$count = $stories->length;
$count_drafts = $drafts->length;
$count_text = "";
if($count > 1){
	$count_text .= $count . " published stories";
} elseif($count < 1){
	$count_text .= "0 published stories";
} else{
	$count_text .= $count . " published story";
} 

if($count_drafts > 1){
	$count_text .= " and " . $count_drafts . " unpublished drafts";
} elseif($count_drafts < 1){
	$count_text .= " and 0 unpublished drafts";
} else{
	$count_text .= " and " . $count . " unpublished draft";
} 
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no" />
    
		<!-- 1. Replace with your language -->
		<title>Your Language Stories and Texts</title>
		<!-- 2. Replace with your language -->
    <meta name="description" content="Your Language Stories and Texts" />

		<!-- 3. Replace with your name, or delete the whole line if you'd like. Having it is totally optional. -->
    <meta name="author" content="You" />
		
		<!-- 4. Replace with your name, or delete the whole line if you'd like. Having it is totally optional. -->
    <meta name="copyright" content="You" />
    	
	<!-- Bootstrap CSS file. This page runs on Bootstrap 4.1 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/css/bootstrap.min.css" integrity="sha384-WskhaSGFgHYWDcbwN70/dfYBj47jz9qbsMId/iRN3ewGhXQFZCSftd1LZCfmhktB" crossorigin="anonymous">
	
	<!-- CSS files with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="css/texts.css">
	
	<!-- fonts and icons -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">
	
</head>

<body>

<!-- This stuff makes the Facebook button work. -->
<div id="fb-root"></div>
<script>(function(d, s, id) {
  var js, fjs = d.getElementsByTagName(s)[0];
  if (d.getElementById(id)) return;
  js = d.createElement(s); js.id = id;
  js.src = 'https://connect.facebook.net/en_US/sdk.js#xfbml=1&version=v3.0&appId=1177996378903661&autoLogAppEvents=1';
  fjs.parentNode.insertBefore(js, fjs);
}(document, 'script', 'facebook-jssdk'));</script>
<!-- -->
<div class="hidden">
<!-- 5. This is the navigation bar at the top of the page. You can add or delete nav-items to suit the structure of your website -->
	<nav class="navbar fixed-top navbar-dark bg-dark">
		<a class="navbar-brand" href="../">Home</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>
		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<ul class="navbar-nav mr-auto">
				<li class="nav-item">
					<a class="nav-link" href="../../dictionary">Talking Dictionary</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../phrasicon">Phrasicon</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../sounds">Sounds of the Language</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../flashcards">Lessons with Flashcards</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../expressions">Everyday Expressions</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../about">About the Language</a>
				</li>
				<li class="nav-item">
					<a class="nav-link" href="../../contact">Feedback</a>
				</li>
			</ul>
		</div>
	</nav>

	<div class="jumbotron jumbotron-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-0 col-sm-2"></div>
				
				<div class="col-xs-12 col-sm-8">
					<div class="black-box">
						<!-- 6. Replace with the name of your language -->
						<h1 class="text-center">Your Language Stories and Texts</h1>
					</div>
				</div>
				
				<div class="col-xs-0 col-sm-2"></div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid bodyContainer">
		<div class="row">
			<div class="col">
				<div class="card bg-light border-secondary">
					<div class="card-header text-center" id="aboutBox">
						<h5 class="mb-0">
							<button id="aboutButton" class="btn btn-link" type="button" data-toggle="collapse" data-target="#collapseAbout" aria-expanded="true" aria-controls="collapseAbout">
								About these Stories &nbsp; <i class="fas fa-chevron-circle-down"></i>
							</button>
						</h5>
					</div>

					<div id="collapseAbout" class="collapse" aria-labelledby="aboutBox">
						<div class="card-body">
							<!-- 7. Here, you can enter a brief description of your revitalization project and the people involved. -->
							<p>Insert a brief description here</p>
							<p> If this is your first time and you would like a helpful walkthrough to see how the pages work, click <a class="text-success" href="tutorial.php">here</a>!</p>
							<p>This story database currently contains <?php echo $count_text ?>.</p>
						</div>
					</div>
				</div>
			</div>
		</div>
		<div class="row">
			<div class="col-xs-5 col-xl-3">
				<select class="form-control" name="languageChoice" id="languageChoice">
				<?php 
				if($lang == "source"){
					// 8. replace the text that says Your Language with the name of your language
					// If the other language is not English, change that value as well.  
					echo "<option value='source' selected='selected'>Your Language</option>
					<option value='translation'>English</option>";
				} else{
					// 9. replace the text that says Your Language with the name of your language
					// If the other language is not English, change that value as well. 
					echo "<option value='source'>Your Language</option>
					<option value='translation' selected='selected'>English</option>";					
				}
				?>
					
				</select>
			</div>
			
			<div class="col-xs-7 col-xl-6">
				<input class="form-control" id="storySearch" type="text" placeholder="Search" aria-label="Search" <?php if(trim($searchTerm) != ""){echo "value=\"" . $searchTerm . "\"";}?> <?php if(isset($gloss)){ echo "data-gloss='$gloss'";}?>>
			</div>

			<div class="col-xs-12 col-xl-3">
				<a class="btn btn-primary" id="searchButton" onclick="storySearch(true)"><i class="fas fa-search"></i>&nbsp; Search</a>
				<a class="btn btn-danger" id="clearButton" onclick="clearSearch()"><i class="fas fa-eraser"></i>&nbsp; Clear Search</a>
			</div>			
		</div>
		
		<div class="row">
			<div class="col-lg-3 col-xs-12"><a href="tutorial.php" class="btn btn-success" id="walkthroughButton"><i class="fas fa-tree"></i>&nbsp;Tutorial</a></div>
			
			<div class="col-lg-5 col-xs-12">
				<!-- 10. If you would like to provide users with buttons for typing special characters, you can add them here. Simply replace the 
				special characters below with the ones you need.  -->
				<a class="btn btn-light specialCharacter">ʔ</a>	
				<a class="btn btn-light specialCharacter">kʰ</a>	
				<a class="btn btn-light specialCharacter">pʰ</a>
				<a class="btn btn-light specialCharacter">tʰ</a>	
				<a class="btn btn-light specialCharacter">t̪</a>	
				<a class="btn btn-light specialCharacter">t̪'</a>	
				<a class="btn btn-light specialCharacter">t̪ʰ</a>
			</div>
			
			<div class="col-lg-4">
				<br class="d-block d-md-none"/>
				Sort By &nbsp;
				<a class="btn btn-info" onclick="sortByAuthor()"><i class="fas fa-user"></i>&nbsp; Speaker</a>&nbsp;
				<a class="btn btn-success" onclick="sortByTitle()"><i class="fas fa-book"></i>&nbsp; Title</a>
			</div>
		</div>
		
		<div id="storyContainer">
			<?php 
				$openDiv = "<div class='row'><div class='col'><div class='card-deck'>"; 
				$closeDiv = "</div></div></div>";
				$countForInvisibleCards = 3;
				for ($i = 0; $i < $count; $i++) {
					$countForInvisibleCards--;
					// if this is the fist element, create a new row
					if($i == 0){
						echo $openDiv;
					}
					$currentStory = $stories->item($i);
					$descriptionToCrop = explode(" ", $currentStory->childNodes->item(7)->nodeValue);
					$croppedDescription = "";
					
					// okay, so we will crop the descriptions a bit. 128 characters is a common limit. The average word length in English
					// is 5.1 letters, as of 2018. Hence, 128/5 is around 25 words as a limit. Hence, we will break the description into 
					// a list of words, and put the first 25 words together. 
					// Well, I was going to do it like that, but I got to thinking...
					// ...Just using word length like this neglects the fact that different text passages will have different
					// average word lengths. 
					// I decided to be really fancy. This uses the average word length of the description 
					// in determining how many words to show. 
					$totalCharacters = 0;
					for($word = 0; $word<count($descriptionToCrop); $word++){
						$totalCharacters += strlen($descriptionToCrop[$word]);
					}
					$averageWordLength = round($totalCharacters / count($descriptionToCrop));
					$adjustedNumberOfWords = round(128/$averageWordLength);
					for($word = 0; $word<$adjustedNumberOfWords; $word++){
						$croppedDescription .= $descriptionToCrop[$word] . " ";
					}
					
					if(count($descriptionToCrop) > $adjustedNumberOfWords){
						$croppedDescription .= "..."; // add ... to the end
					}
					
					// add the story 
					echo 
					"<div class=\"card bg-light border-secondary storyCard\" data-narrator=\"" . $currentStory->childNodes->item(3)->nodeValue ."\">
						<h5 class=\"card-header text-center\">
							<a href=\"story.php?story=" . $currentStory->getAttribute('id') . "\">" . $currentStory->childNodes->item(1)->nodeValue . "</a>
						</h5>
						<div class=\"card-body\" style=\"background: linear-gradient(to right bottom, rgba(255, 255, 255, 0.4), rgba(255, 255, 255, 0.4)), url('img/" . $currentStory->childNodes->item(19)->getAttribute("url") . "'); background-size: cover; background-position: center center;\">
							<p class=\"card-text\"><a href=\"story.php?story=" . $currentStory->getAttribute('id') . "\">" . $croppedDescription . "</a></p>
						</div>
					</div>";

					$endOfRow = ($i+1) % 3 == 0;
					$endOfStories = ($i+1) == $count;
					if($endOfRow && $endOfStories){
						echo $closeDiv;
					} elseif($endOfRow && !$endOfStories){
						echo $closeDiv;
						echo $openDiv;
						$countForInvisibleCards = 3;
					} elseif(!$endOfRow && $endOfStories){
						for($c = 0; $c<$countForInvisibleCards; $c++){
							echo 
							'<div class="card bg-light border-secondary qrCard invisible">
								<h5 class="card-header text-center"><a href="#" target="_blank"></a></h5>
								<div class="card-body"></div>
							</div>';
						}
						echo $closeDiv;
					}
				}
			?>
		</div>
	</div>
		
	<div class="alert alert-info text-center" role="alert">
		More stories will be added soon, so check this page frequently!
	</div>
	
	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
					<!-- 11. Replace this with the name of your website-->
				<p> &copy; Your Website <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>

</div>
	
<!-- Bootstrap Javascript files -->
<script src="https://code.jquery.com/jquery-3.3.1.min.js" integrity="sha256-FgpCb/KJQlLNfOu91ta32o/NMZxltwRo8QtmkMRdAu8=" crossorigin="anonymous"></script><script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.1/js/bootstrap.min.js" integrity="sha384-smHYKdLADwkXOn1EmN1qk/HfnUcbVRZyYmZ4qpPea6sjB/pTJ0euyQp0Mk8ck+5T" crossorigin="anonymous"></script>

<!-- This JS file powers the sort by title and sort by author functions. -->
<script src="js/storySorting.js"></script>	

<!-- This JS file resets the homepage when the user enters a blank space -->
<script src="js/resetStories.js"></script>

<!-- This JS file handles story searching. -->
<script src="js/storySearch.js"></script>

<!-- this script: 1. fires a search when the enter key is pressed, and 2. fires a search when the page is loaded -->
<script src="js/firingStorySearch.js"></script>

<!-- special character insertion -->
<script src="js/specialCharacterInsertion.js"></script>

<!-- I made a function to convert things to title case -->
<script src="js/toTitleCase.js"></script>

<!-- this script powers the pages' fading in and out behavior -->
<script src="js/fadeAnimations.js"></script>

<!-- this script converts all curly quotes into straight quotes so that the database consistently uses only one type -->
<script src="js/replaceCurlyQuotes.js"></script>
</body>

</html>