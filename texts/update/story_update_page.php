<!DOCTYPE html>
<html lang="en">

<head>
  <meta charset="UTF-8">
	<!-- There are 12 things for you to replace in this file -->
	<meta name="viewport" content="width=device-width, initial-scale=1.0">

	<!-- 1. Replace with your name below, or delete the line if you like. Having it is totally optional. -->
	<meta name="copyright" content="You" />

	<!-- 2. Replace with your name below, or delete the line if you like. Having it is totally optional. -->
	<meta name="author" content="You">

	<meta http-equiv="Cache-control" content="no-cache">

	<!-- 3. Replace with the name of your language. -->
	<title>Your Language Stories and Texts</title>  
		
	<!-- CSS: This page is powered by Bootstrap 4 -->
	<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/css/bootstrap.min.css" integrity="sha384-MCw98/SFnGE8fJT3GXwEOngsV7Zt27NXFoaoApmYm81iuXoPkFOJwJ8ERdknLPMO" crossorigin="anonymous">

	<!-- CSS file with styling specific to the Stories and Texts pages -->
	<link rel="stylesheet" href="../css/texts.css">
	
	<!-- fonts and icons -->
	<link href="https://fonts.googleapis.com/css?family=Roboto+Slab:400,700" rel="stylesheet">
	<link rel="stylesheet" href="https://use.fontawesome.com/releases/v5.1.0/css/all.css" integrity="sha384-lKuwvrZot6UHsBSfcMvOkWwlCMgc0TaWr+30HWe3a4ltaBwTZhyTEggF5tJv8tbt" crossorigin="anonymous">

	<!-- styling for the walkthrough tutorial -->
	<link rel="stylesheet" href="../css/introjs.min.css">

	<!-- Bootstrap requires jQuery -->
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>    
</head>

<body>

<div class="hidden">

	<!-- loadingAnimation -->
	<div class="fadeMe" id="loadingAnimation"><div style="height:100%; width: 100%;"><div class="drawing" id="loading"><div class="loading-dot"></div></div></div></div>

	<!-- 4. This is the bar at the top of the page. Add or replace nav items to suit the structure of your website. -->
	<nav class="navbar navbar-expand-lg navbar-dark bg-dark fixed-top">
		<a class="navbar-brand" href="../">Stories & Texts</a>
		<button class="navbar-toggler" type="button" data-toggle="collapse" data-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
			<span class="navbar-toggler-icon"></span>
		</button>

		<div class="collapse navbar-collapse" id="navbarSupportedContent">
			<!-- 4. a. These are buttons for special characters. Feel free to replace the characters or add more. -->
			<ul class="navbar-nav mr-auto">
				<li class="nav-item specialCharacter"><a class="nav-link">ʔ</a></li>
					
				<li class="nav-item specialCharacter"><a class="nav-link">kʰ</a></li>
					
				<li class="nav-item specialCharacter"><a class="nav-link">pʰ</a></li>
			
				<li class="nav-item specialCharacter"><a class="nav-link">tʰ</a></li>
					
				<li class="nav-item specialCharacter"><a class="nav-link">t̪</a></li>
					
				<li class="nav-item specialCharacter"><a class="nav-link">t̪'</a></li>
					
				<li class="nav-item specialCharacter"><a class="nav-link">t̪ʰ</a></li>
			</ul>
			
			<!-- These are quick links to other parts of the page. -->
			<ul class="navbar-nav ml-auto">
				<li class="nav-item"><a class="nav-link" href="#storyEntryJumbotron">Create</a></li>
					
				<li class="nav-item"><a class="nav-link" href="#displayRecordsJumbotron">Find</a></li>
					
				<li class="nav-item"><a class="nav-link" href="#editJumbotron">Edit</a></li>
			
				<li class="nav-item"><a class="nav-link" href="#storyDeletionJumbotron">Delete</a></li>
					
				<li class="nav-item"><a class="nav-link" href="#soundFileJumbotron">Uploading</a></li>				
			</ul>
		</div>
	</nav>
		
	<form id="create" method="POST" name="create" autocomplete="off">
		<input type="hidden" name="type" value="create">
		<div class="jumbotron jumbotron-fluid" id="storyEntryJumbotron">
			<div class="black-box black-box--full">
				<h1 class="text-center">Story Entry</h1>
			</div>
		</div>

		<div class="container-fluid bodyContainer">
			<p>Would you like to learn how to use this page? <a class="btn btn-success" id="walkthroughButton"><i class="fas fa-tree"></i>&nbsp;Tutorial</a></p>
			<hr/>
			<h3 class="text-center">Metadata</h3>
			<div class="row">
				<div class="col">
					<div class="autocomplete">
						<h4>Title*</h4>
						<input class="form-control" id="storytitle" type="text" name="storytitle" placeholder="Title of Story" required>
					</div>
				</div>
			</div>
				
			<div class="row">
				<div class="col">
					<h4>Narrator(s)*</h4>
					<p>If there is more than one person speaking, separate the names with a comma, like so: Joe Smith,Bob Smith.</p>
					<input class="form-control" id="narrator" type="text" name="narrator" placeholder="Narrator" onblur="fillInSpeakerInitials()" required>
				</div>
			</div>
				
			<div class="row">
				<div class="col">
					<h4>Interviewer(s)*</h4>
					<p>If there is more than one person interviewing the speaker, separate the names with a comma, like so: Joe Smith,Bob Smith.</p>
					<input class="form-control" id="interviewer" type="text" name="interviewer" placeholder="Interviewer" onblur="fillInSpeakerInitials()" required>
				</div>
			</div>
				
			<div class="row">
				<div class="col">
					<h4>Description*</h4>
					<textarea class="form-control" id="description" name="description" placeholder="This is a story about..." rows="4" required></textarea>
				</div>
			</div>
				
			<div class="row">
				<div class="col">
					<h4>Text for Social Media buttons</h4>
					<p>When people share a link to this story on Facebook or Twitter, this is the text that will be filled in automatically.</p>
					<input class="form-control" id="socialmediabuttontext" type="text" name="socialmediabuttontext" placeholder="This is a cool story. #hashtag">
				</div>
			</div>
				
			<hr/>
			<h3 class="text-center">Media Files</h3>
			<div class="row">
				<div class="col">
					<h4>Youtube Link <!-- 5. replace with the name of your language --> (Source language subtitles)</h4>
					<input class="form-control" id="youtubelinksourcelang" type="text" name="youtubelinksourcelang" placeholder="youtube.com/">
				</div>
			</div>

			<div class="row">
				<div class="col">
					<h4>Youtube Link <!-- 6. replace with the name of the other language, most likely English --> (Translation Language subtitles)</h4>
					<input class="form-control" id="youtubelinktranslationlang" type="text" name="youtubelinktranslationlang" placeholder="youtube.com/">
				</div>
			</div>

			<div class="row">
				<div class="col">
					<h4>Youtube Link (Both sets of subtitles)</h4>
					<input class="form-control" id="youtubelinkboth" type="text" name="youtubelinkboth" placeholder="youtube.com/">
				</div>
			</div>

			<div class="row">
				<div class="col">
					<h4>Filename for Audio of Whole Story</h4>
					<input class="form-control" id="wholestoryaudio" type="text" name="wholestoryaudio" placeholder="something.wav, something2.mp3" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
				</div>
			</div>				
				
			<div class="row">
				<div class="col">
					<h4>Filename for Background Image</h4>
					<input class="form-control" id="image" type="text" name="image" placeholder="something.jpg, something.png, something.svg" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
				</div>
			</div>
				
			<div class="row">
				<div class="col">
					<h4>Filename for Handout</h4>
					<input class="form-control" id="handout" type="text" name="handout" placeholder="something.docx" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
				</div>
			</div>			
				
			<hr/>
			<h3 class="text-center" id="storytext">Story Text</h3>
			<p>Note: If you would like to delete a line, leave the <em>Source</em> box blank. In other words, if you leave the <em>Source</em> box blank, no other fields in that line will be saved.</p>
			<!-- 7. replace with the name of your language and the other language, most likely English -->
			<p>Note: If you leave a source language morpheme blank, that morpheme (along with its Translation language gloss) will not be saved.</p>
			<div class="container-fluid bodyContainer" id="lineContainer">
				<fieldset id="line1" class="line">
					<div class="row">
						<div class="col">
							<h4>Line 1</h4>
						</div>
					</div>
						
					<div class="row">
						<div class="col-2">
							Speaker: <input id="line1_speakerDropDown" name="line[0][speaker]" class="form-control" list="list_line1_speakerDropDown">
									<datalist id="list_line1_speakerDropDown" class="speakerDropDown"><option value=" "></option></datalist>
						</div>
					</div>

					<div class="row">
						<div class="col">
							Source<br/>
							<input class="form-control" type="text" id="line1_source" name="line[0][source]">
							<a id="line1_segmentation" class="btn btn-success" onclick="segment('line1')">Segment&nbsp; <i class="fas fa-bolt"></i></a>
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							Translation<br/>
							<input class="form-control" id="line1_translation" type="text" name="line[0][translation]">
						</div>
					</div>

					<div class="row">
						<div class="col">
							Hints/Notes (for comparing multiple versions of a story)<br/>
							<input id="line1_notes" class="form-control" type="text" name="line[0][note]">
						</div>
					</div>
				
					<div class="row">
						<div class="col">
							Audio Filename<br/>
							<input id="line1_audio" class="form-control" type="text" name="line[0][lineaudio]" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
						</div>
					</div>
		
					<h5>Morphemes</h5>
					<div id="line1_morphemeContainer">
						<div class="row" id="line1_mRow1">
							<div class="col-3">
								<input id="line1_m1" class="line1_morpheme form-control" type="text" name="line[0][morpheme][0][m]" onkeyup="suggest(this.value, 'line1_g1')">
							</div>
						</div>

						<div class="row" id="line1_gRow1">
							<div class="col-3">
								<input id="line1_g1" class="line1_gloss form-control" type="text" name="line[0][morpheme][0][g]" list="list_line1_g1">
							</div>
						</div>
						
						<div class="row" id="line1_dRow1">
							<div class="col-3">
								<a class="btn btn-danger line1_delete" id="delete_line1_m1" onclick="deleteMorpheme('line1_m1')"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;Morpheme 1</a><a class="btn btn-info line1_add" id="addMorpheme_line1_m1" onclick="addMorpheme('line1_m2')"><i class="fas fa-plus"></i></a>
							</div>
						</div>
					</div>
					
					<div class="row">
						<div class="col">
							<a class="btn btn-info" id="line1_addLine" onclick="addLine(2)">+ Add Line</a>
							<a class="btn btn-danger" id="line1_deleteLine" onclick="deleteLine(1)"><i class="fas fa-trash"></i> Delete Line 1</a>
						</div>
					</div>
				</fieldset>
			</div>
				
			<div class="row">
				<div class="col">
					<button class="btn btn-primary btn-lg" id="createButton" type="submit" value="Create">Create&nbsp;<i class="fas fa-rocket"></i></button>
				</div>
			</div>
		</div>
		
		<div id="datalistContainer">
			<datalist id="list_line1_g1">
				<option value=" "></option>
			</datalist>
		</div>
	</form>
	<hr/>	
		
	<div class="jumbotron jumbotron-fluid" id="displayRecordsJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Finding a Story</h1>
		</div>
	</div>
			
	<div class="container-fluid bodyContainer">			
		<div class="row">
			<div class="col">
				<h4>Find by Title (Case-Sensitive)</h4> 
				<input class="form-control" type="text" name="field" id="lookUpStory" onkeyup="showRecords(this.value)">
			</div>
		</div>
				
		<div class="row">
			<div class="col">
				<div id="display">
					<h4>Records will be displayed here.</h4> 
					<p>Type a space to display all of the stories.</p>
				</div>
			</div>
		</div>
	</div>
	<hr/>
				
	<div class="jumbotron jumbotron-fluid" id="editJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Story Editing</h1>
		</div>
	</div>
				
	<form id="modify" name="modify">		
		<div class="container-fluid bodyContainer">
			
			<input type="hidden" name="checkSubmission" id="checkSubmission" value="" >
			
			<div class="row">
				<div class="col">
					<input type="hidden" name="type" value="modify">
					<h4>Enter ID</h4> 
						<input class="form-control" type="text" name="editID" id="editID">
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-info" type="button" id="getEntryButton" onclick="getStorytoEdit()"><i class="fas fa-book"></i> &nbsp;Get Entry</button>
					<button class="btn btn-danger" type="button" id="discardChangesButton" onclick="location.reload(true)"><i class="fas fa-ban"></i> &nbsp;Discard Changes</button>
					<button class="btn btn-warning" id="saveChangesButton" type="submit" value="Modify" disabled><i class="fas fa-pencil-alt"></i> &nbsp;Save Changes</button>
					&nbsp;Publish? &nbsp;
					<div class="form-check form-check-inline">
						<input type="radio" name="approved" id="approvedTrue" value="Yes" class="form-check-input"><label class="form-check-label" for="approvedTrue">Yes</label>
					</div>

					<div class="form-check form-check-inline">
						<input type="radio" name="approved" id="approvedFalse" value="No" class="form-check-input"><label class="form-check-label" for="approvedFalse">No</label>
					</div>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<label for="editTitle">Title</label> &nbsp;<input id="editTitle" type="text" name="editTitle" class="form-control" required>
				</div>

				<div class="col">
					<label for="editNarrator">Narrator(s)</label> &nbsp;<input id="editNarrator" type="text" name="editNarrator" class="form-control" onblur="fillInSpeakerInitials('edit')" required>
				</div>

				<div class="col">
					<label for="editInterviewer">Interviewer(s)</label> &nbsp;<input id="editInterviewer" type="text" class="form-control" name="editInterviewer" onblur="fillInSpeakerInitials('edit')" required>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<label for="editDescription">Description</label> &nbsp;<textarea id="editDescription" name="editDescription" class="form-control"  rows="4" required></textarea>
				</div>
			</div>

			<div class="row">
				<div class="col">
					<label for="editSocialMedia">Social Media Text</label> &nbsp;<input class="form-control" id="editSocialMedia" type="text" name="editSocialMedia">
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<label for="editYoutubeSourceLang">Youtube <!-- 8. replace with the name of your language --> (Source Language)</label> &nbsp;<input class="form-control" id="editYoutubeSourceLang" type="text" name="editYoutubeSourceLang">
				</div>
			</div>	

			<div class="row">
				<div class="col">
					<label for="editYoutubeBoth">Youtube (Both Languages)</label> &nbsp;<input class="form-control" id="editYoutubeBoth" type="text" name="editYoutubeBoth">
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<label for="editYoutubeTranslationLang">Youtube <!-- 9. replace with the name of the other language, most likely English --> (Translation Language)</label> &nbsp;<input class="form-control" id="editYoutubeTranslationLang" type="text" name="editYoutubeTranslationLang">			
				</div>
			</div>

			<div class="row">
				<div class="col">
					<label for="editWholeAudio">Whole Story Audio</label> &nbsp;<input id="editWholeAudio" type="text" name="editWholeAudio" class="form-control" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
				</div>

				<div class="col">				
					<label for="editImage">Image</label> &nbsp;<input id="editImage" type="text" name="editImage" class="form-control" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
				</div>

				<div class="col">
					<label for="editHandout">Handout</label> &nbsp;<input id="editHandout" type="text" name="editHandout" class="form-control" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">				
				</div>
			</div>

			
		</div>
			
		<h3 class="text-center">Edit Story Text</h3>
		<div class="container-fluid bodyContainer" id="editLineContainer">
			<fieldset id="editLine1" class="editLine">
				<div class="row">
					<div class="col">
						<h4>Line 1</h4>
					</div>
				</div>

				<div class="row">
					<div class="col-2">
						Speaker: <input id="editLine1_editSpeakerDropDown" name="line[0][speaker]" list="list_editLine1_editSpeakerDropDown" class="form-control">
						<datalist id="list_editLine1_editSpeakerDropDown" class="editSpeakerDropDown"><option value=" "></option></datalist>
					</div>
				</div>

				<div class="row">
					<div class="col">
						Source<br/>
						<input class="form-control" type="text" id="editLine1_source" name="line[0][source]">
						<a id="editLine1_segmentation" class="btn btn-success" onclick="segment('editLine1', 'edit')">Segment&nbsp;<i class="fas fa-bolt"></i></a>
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						Translation<br/>
						<input class="form-control" id="editLine1_translation" type="text" name="line[0][translation]">
					</div>
				</div>

				<div class="row">
					<div class="col">
						Hints/Notes (for comparing multiple versions of a story)<br/>
						<input class="form-control" id="editLine1_notes" type="text" name="line[0][note]">
					</div>
				</div>
				
				<div class="row">
					<div class="col">
						Audio File Name<br/>
						<input class="form-control" id="editLine1_audio" type="text" name="line[0][lineaudio]" pattern="[^&'<>\x22]*" title="Filenames should not contain &amp;, &apos;, &quot;, &gt; or &lt;.">
					</div>
				</div>
		
				<h5>Morphemes</h5>
				<div id="editLine1_editMorphemeContainer">
					<div class="row" id="editLine1_editMRow1">
						<div class="col-3">
							<input id="editLine1_m1" class="editLine1_editMorpheme form-control" type="text" name="line[0][morpheme][0][m]" onkeyup="suggest(this.value, 'editLine1_g1')">
						</div>
					</div>

					<div class="row" id="editLine1_editGRow1">
						<div class="col-3">
							<input id="editLine1_g1" class="editLine1_editGloss form-control" type="text" name="line[0][morpheme][0][g]" list="list_editLine1_g1">
						</div>
					</div>
					
					<div class="row" id="editLine1_editDRow1">
						<div class="col-3">
							<a class="btn btn-danger editLine1_editDelete" id="delete_editLine1_m1" onclick="deleteEditMorpheme('editLine1_m1')"><i class="fas fa-trash-alt fa-lg"></i>&nbsp;Morpheme 1</a><a class="btn btn-info editLine1_editAdd" id="addEditMorpheme_editLine1_m1" onclick="addEditMorpheme('editLine1_m2')"><i class="fas fa-plus"></i></a>
						</div>
					</div>	
				</div>
			</fieldset>
			
			<div id="datalistEditContainer">		
				<datalist id="list_editLine1_g1">
					<option value=" "></option>
				</datalist>
			</div>
			
			<div class="row">
				<div class="col">
					<a class="btn btn-info" id="editLine1_addEditLine" onclick="addEditLine(2)">+ Add Line</a>
					<a class="btn btn-danger" id="editLine1_deleteEditLine" onclick="deleteEditLine(1)"><i class="fas fa-trash"></i> Delete Line 1</a>
				</div>
			</div>
		</div>
	</form>	
	<hr/>
	<form id="mass_edit" name="mass_edit">
		<div class="jumbotron jumbotron-fluid" id="massEditJumbotron">
			<div class="black-box black-box--full">
				<h1 class="text-center">Mass Editing</h1>
			</div>
		</div>
				
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
					<!-- 10. replace with the names of your 2 languages -->
					<p>Use this form to edit how a morpheme was transcribed in Your Language and/or how it is glossed in Translation Language. This form will edit all occurrences of a morpheme in the story corpus.</p>
				</div>
			</div>
					
			<div class="row">
				<div class="col">
					<h5>Old Transcriptions</h5>
				</div>
			</div>
					
			<div class="row">
				<div class="col">
					<input type="hidden" name="type" value="mass_edit">
					<h6>Morpheme</h6> 
					<input type="text" name="morph" id="morph" class="form-control">
				</div>
						
				<div class="col">
					<h6>Gloss</h6> 
					<input type="text" name="gloss" id="gloss" class="form-control">
				</div>
			</div>
					
			<div class="row">
				<div class="col">
					<h5>New Transcriptions</h5>
				</div>
			</div>
					
			<div class="row">
				<div class="col">
					<h6>Morpheme</h6> 
					<input type="text" name="edit_m" id="edit_m" class="form-control">
				</div>
						
				<div class="col">
					<h6>Gloss</h6> 
					<input type="text" name="edit_g" id="edit_g"  class="form-control">
				</div>					
			</div>
					
			<div class="row">
				<div class="col">
					<button class="btn btn-info" type="submit" value="Edit" id="massEditButton">Edit&nbsp;<i class="fas fa-beer"></i> </button>
				</div>
			</div>
		</div>			
	</form>

	<div class="jumbotron jumbotron-fluid" id="storyDeletionJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Story Deletion</h1>
		</div>
	</div>
		
	<form id="delete" method="POST" name="delete">
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
						<input type="hidden" name="type" value="delete">
						<h4>Delete by ID</h4>
						<input type="text" name="id" class="form-control">
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-danger" type="submit" value="Delete">Delete&nbsp;<i class="fas fa-eraser"></i></button>
				</div>
			</div>
		</div>
	</form>
	<hr/>

	<div class="jumbotron jumbotron-fluid" id="xmlJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Database Importing/Exporting</h1>
		</div>
	</div>
		
	<form action="upload_XML.php" method="post" enctype="multipart/form-data">
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
					<p>Click <em>Export</em> to download a copy of the story corpus. This allows us to back up the story corpus by saving a copy of it somewhere other than just on the website.</p>
					<p>Click <em>Import</em> to upload a backup of the story corpus. This should only need to be done if the website has been compromised.</p>
						<input type="file" name="file[]">
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-secondary" type="submit" name="submit" value="Import">Import&nbsp;<i class="fas fa-upload"></i></button>
					<a class="btn btn-info" href="../stories.xml" download>Export&nbsp;<i class="fas fa-download"></i></a>
				</div>
			</div>
		</div>
	</form>
						
	<hr/>
	<div class="jumbotron jumbotron-fluid" id="soundFileJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Sound File Uploading</h1>
		</div>
	</div>		

	<form action="upload_sound.php" method="post" id="soundFileForm" enctype="multipart/form-data">
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
					<p>Click <em>Update List of Stories</em> to generate a list of all of the stories. Choose which version the sound files belong to, choose your sound files, and then click <em>Upload</em> to upload the files to the correct story.</p>
					<p>Note: You can upload up to 25 files at once, and the total file size cannot exceed 10GB. The latter number can be changed, so <a class="text-info" href="../../contact" target="_blank">let us know</a> if you would like to upload more than 10GB at once. </p>
						<p>Note: The script will time out and quit if it takes more than 10 minutes to upload all of the files. </p>
				</div>
			</div>

			<div class="row">
				<div class="col-10">
					<select id="storyDropdown" name="storyDropdown" class="form-control" required></select> 
				</div>
			</div>
			
			<div class="row">
				<div class="col-2">
					<a class="btn btn-info" onclick="updateStoryVersions()">Update List of Stories &nbsp;<i class="fas fa-atlas"></i></a>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<input type="file" name="file[]" multiple>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-primary btn-lg" type="submit" name="submit" value="Submit">Upload&nbsp;<i class="fas fa-music"></i></button>
				</div>
			</div>
		</div>
	</form>
	<hr/>
							
	<div class="jumbotron jumbotron-fluid" id="imageJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Image File Uploading</h1>
		</div>
	</div>		

	<form action="upload_image.php" method="post" enctype="multipart/form-data">
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
					<input id="image" type="file" name="file[]" accept="image/*" multiple>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-primary btn-lg" type="submit" name="imageSubmit" value="Submit">Upload&nbsp;<i class="fas fa-image"></i></button>
				</div>
			</div>
		</div>
	</form>
	<hr/>
		
	<div class="jumbotron jumbotron-fluid" id="handoutJumbotron">
		<div class="black-box black-box--full">
			<h1 class="text-center">Handout File Uploading</h1>
		</div>
	</div>

	<form action="upload_handout.php" method="post" enctype="multipart/form-data">
		<div class="container-fluid bodyContainer">
			<div class="row">
				<div class="col">
					<input id="handout" type="file" name="file[]" multiple>
				</div>
			</div>
			
			<div class="row">
				<div class="col">
					<button class="btn btn-primary btn-lg" type="submit" name="submit" value="Submit">Upload&nbsp;<i class="fas fa-file-word"></i></button>
				</div>
			</div>
		</div>
	</form>
	<hr/>

	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
				<!-- 11. Replace with the name of your website -->
				<p> &copy; Your Website Name <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>
</div>

<!-- this page fades in on load and fades out on exit, and that behavior is powered by this script -->
<script src="../js/fadeAnimations.js"></script>
    
<!-- this page is powered by Bootstrap 4.0, and these three scripts are required for Bootstrap -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	
<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

<!-- this script organizes the morpheme rows in a way that is much more legible and easy to use -->
<script src="../js/organizeMorphemeRows.js"></script>
	
<!-- this script powers the addLine button -->
<script src="../js/addLine.js"></script>

<!-- this script powers the addMorpheme button -->
<script src="../js/addMorpheme.js"></script>
	
<!-- this script suggests translations for source language morphemes -->
<script src="../js/suggestEnglish.js"></script>
	
<!-- this script cleans up form inputs and submits them for all sections of this page except for the file uploads -->
<script src="../js/formSubmissionFunctions.js"></script>

<!-- special character insertion -->
<script src="../js/specialCharacterInsertion.js"></script>
	
<!-- this script gets the story and version numbers for uploading sound files -->
<script src="../js/getStoryVersions.js"></script>

<!-- this script powers the autofilling of the story title, narrator, and interviewer parts of the story creation section -->
<script src="../js/autocomplete.js"></script>
	
<!-- this script powers the deleteMorpheme buttons -->
<script src="../js/deleteMorpheme.js"></script>
	
<!-- this script powers the getEntry button in the story editing section-->
<script src="../js/getStoryToEdit.js"></script>
	
<!-- this JS file helps the translation autocomplete work in Safari and older versions of Internet Explorer -->
<script src="../js/datalist.polyfill.min.js"></script>
	
<!-- this JS file powers the segment button -->
<script src="../js/segmentation.js"></script>

<!-- this script takes the initials of the interviewer and narrator and makes initials for the speaker dropdown menus -->
<script src="../js/speakerInitials.js"></script>

<!-- this script converts all curly quotes into straight quotes so that the database consistently uses only one type -->
<script src="../js/replaceCurlyQuotes.js"></script>

<!-- this script powers the delete line button -->
<script src="../js/deleteLine.js"></script>

<!-- this script removes the loading animation once the page has loaded -->
<script src="../js/removeLoader.js"></script>

<!-- code for the walkthrough tutorial -->
<script src="../js/intro.min.js"></script>

<script>
// 12. This is a tutorial that teaches people how to use this page. Each step of it has an element, which is the
// class or ID of the HTML element that gets highlighted, the intro, the text that is shown in the tutorial,
// and optionally a position, which is where the text should appear relative to the element being shown. For more 
// information, see the documentation online for IntroJS. 
	$(function(){
		  var walkthrough = introJs();
		  walkthrough.setOptions({
			  steps: [
				{
					element: ".navbar",
					intro: "On this page, you can create, edit, and delete stories and texts. You can also upload sound files, images, and handouts to go along with these stories.",
				},
					
				{
					element: "#storyEntryJumbotron",
					intro: "In this top section, you can create stories.",
				},
					
				{
					element: "#storytitle",
					intro: "The story title, narrator, and interviewer fields all automatically suggest existing values, so that you can be consistent across stories.",
				},
				
				{
					element: "#description",
					intro: "Here, you can type a brief description of the story. This description will be featured on the Stories and Texts homepage, as well as at the top of the story's individual page.",
				},

				{
					element: "#socialmediabuttontext",
					intro: "Here, you can write in some text that will be automatically filled in when someone clicks the Facebook or Twitter sharing buttons for this story.",
				},

				{
					element: "#youtubelinknp",
					intro: "Each story has three videos, where one can hear the speaker saying the story with translation language subtitles, with source language subtitles, or with both subtitles. In order to speed up page loading times, these videos are hosted on Youtube. Hence, here, one can write in the links to the videos on Youtube.",
				},

				{
					element: "#wholestoryaudio",
					intro: "Here, write the filename of the audio file of the entire story, as well as the filenames of the handout and image that correspond to this story. You will upload these files later on.",
				},

				{
					element: "#storytext",
					intro: "Here, you will write the text of the story.",
				},

				{
					element: "#line1_speakerDropDown",
					intro: "If you would like to denote which interviewer or narrator is speaking in this line, you can choose from a list of automatically initials or write your own",
				},

				{
					element: "#line1_source",
					intro: "This box is where you will write in the source language of the line.",
				},

				{
					element: "#line1_segmentation",
					intro: "If you click this button, the webpage will try to guess the word-by-word breakdown of the source text you wrote in. The more items in the morpheme database, the better the segmenter will get.",
				},

				{
					element: "#line1_translation",
					intro: "Write the full translation here.",
				},

				{
					element: "#line1_notes",
					intro: "If you would like to add a hint, factoid, or note to this line, write its text here",
				},

				{
					element: "#line1_audio",
					intro: "If this line has an audio file, write in the filename here. You will upload the sound files later.",
				},

				{
					element: "#line1_morphemeContainer",
					intro: "Here is where a word-by-word breakdown of the line will go.",
				},

				{
					element: "#line1_m1",
					intro: "Here is where the source language  of the first word will go. As you type, the webpage will pull up possible translations.",
				},

				{
					element: "#line1_g1",
					intro: "When you finish typing, all possible translations that the website could find will be here. You can also type your own.",
				},

				{
					element: "#delete_line1_m1",
					intro: "Clicking this button will delete the contents of this morpheme.",
				},

				{
					element: "#addMorpheme_line1_m1",
					intro: "Clicking this button will add a blank morpheme to the right of the current morpheme.",
				},

				{
					element: "#line1_addLine",
					intro: "Clicking this button will add a new blank line below the current line.",
				},

				{
					element: "#line1_deleteLine",
					intro: "Clicking this button will delete the contents of the entire line.",
				},

				{
					element: "#createButton",
					intro: "Click this button to create an entry in the database for this story. Do this before uploading any files for this story.",
				},

				{
					element: "#displayRecordsJumbotron",
					intro: "In order to edit or delete a story, you will need it's ID number. You can look up that number here.",
				},

				{
					element: "#lookUpStory",
					intro: "You can try typing in the story title here, or, if you simply type a blank space, all stories will be displayed.",
				},

				{
					element: "#editID",
					intro: "Once you have found the ID, enter it in here,",					
				},

				{
					element: "#getEntryButton",
					intro: "and click this button.",
				},

				{
					element: "#discardChangesButton",
					intro: "If you want to discard your edits, click this button.",
				},

				{
					element: "#saveChangesButton",
					intro: "Once you are done editing the story, click this button.",
				},

				{
					element: ".form-check-inline",
					intro: "Click 'yes' before saving the story to make this story visible on the stories and texts homepage.",
				},

				{
					element: "#massEditJumbotron",
					intro: "If you wish to change how all instances of a morpheme are transcribed or translated, you can use this form.",
				},

				{
					element: "#morph",
					intro: "Simply enter how the morpheme is currently transcribed",
				},

				{
					element: "#gloss",
					intro: "and translated,",
				},

				{
					element: "#edit_m",
					intro: "and enter the new transcription",
				},

				{
					element: "#edit_g",
					intro: "and the new translation,",
				},

				{
					element: "#massEditButton",
					intro: "and click this button. All instances of the old morpheme in the Phrasicon and Story Corpus will be edited.",
				},

				{
					element: "#delete",
					intro: "To delete a story, enter its ID number here and click 'delete'.",
				},

				{
					element: "#xmlJumbotron",
					intro: "In this section, you can download a copy of the story corpus to back it up. You can also upload a copy of the story corpus. This should only be done if the website has been hacked and the story corpus file has been destroyed or otherwise corrupted.",
				},

				{
					element: "#soundFileJumbotron",
					intro: "Once you have created a story above, you can upload its sound files here.",
				},

				{
					element: "#soundFileForm",
					intro: "Click Update List of Stories to get a list of all existing stories. Select one from the drop down, choose the file(s) you want to upload, and click the 'upload' button.",
				},

				{
					element: "#imageJumbotron",
					intro: "Use this form to upload the image file for a story once the story has been created.",
				},

				{
					element: "#handoutJumbotron",
					intro: "Use this form to upload the handout file for a story once the story has been created.",
				},

				{
					element: "#handoutJumbotron",
					intro: "And that's it!",
				},
			  ]
		  });
		  $("#walkthroughButton").on("click", function(){
				walkthrough.start();
			})
		});
	</script>

</body>

</html>