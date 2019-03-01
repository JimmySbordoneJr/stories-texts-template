<?php
$user = isset($_POST['user']) ? $_POST['user'] : '';
$pass = isset($_POST['pass']) ? $_POST['pass'] : '';

// There are 6 things for you to edit in this file.
// 1. Change the text in quotes to set the username and password for viewing the update page.
if($user == "exampleusername"
&& $pass == "password"){
    include("story_update_page.php");
}
else{
    if(isset($_POST))
    { ?>
<!DOCTYPE html> 
<html lang="en">

<head>            
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1.0">
	
	<!-- 2. Replace this with your name, or delete the entire line, if you like. Not all websites have it: it is optional. -->
	<meta name="author" content="You">
	
	<!-- 3. Replace this with your name, or delete the entire line, if you like. Not all websites have it: it is optional. -->
	<meta name="copyright" content="You" />

	<!-- 4. Replace with the name of your language -->
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
	<div class="hidden">
	<!-- 5. This is the bar at the top of the page. You can add or delete nav-items to fit your website. -->
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

	<div class="jumbotron jumbotron-fluid">
		<div class="container-fluid">
			<div class="row">
				<div class="col-xs-0 col-sm-2"></div>
				
				<div class="col-xs-12 col-sm-8">
					<div class="black-box">
						<h1 class="text-center">Story Entry</h1>
					</div>
				</div>
				
				<div class="col-xs-0 col-sm-2"></div>
			</div>
		</div>
	</div>
	
	<div class="container-fluid bodyContainer">
		<div class="row">
			<div class="col-2">
			</div>
			
			<div class="col-8">
				<form method="POST" action="index.php">
					<div class="form-group">
						<div class="row">
							<div class="col-5">
								<input type='hidden' name='story' value='<?php echo "$id";?>'/>
								<input class="form-control" type="text" name="user" placeholder='Username' autofocus>
							</div>

							<div class="col-5">
								<input class="form-control" type="password" name="pass" placeholder='Password'>
							</div>

							<div class="col-2">
								<input class="btn btn-info" type="submit" value="Login" />
							</div>
						</div>
					</div>
				</form>
			</div>
			
			<div class="col-2">
			</div>
		</div>			
	</div>
	
	<footer class="container-fluid text-center footer">
		<div class="row">
			<div class="col">
				<!-- 6. Replace with the name of your website -->
				<p> &copy; Your Website <?php echo date("Y"); ?></p>
			</div>
		</div>
	</footer>	
</div>            
	<script src="https://code.jquery.com/jquery-3.3.1.js" integrity="sha256-2Kok7MbOyxpgUVvAk/HJ2jigOSYS2auK4Pfzbm7uH60=" crossorigin="anonymous"></script>    
	<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.3/umd/popper.min.js" integrity="sha384-ZMP7rVo3mIykV+2+9J3UJ46jBk0WLaUAdn689aCwoqbBJiSnjAK/l8WvCWPIPm49" crossorigin="anonymous"></script>
	<script src="https://stackpath.bootstrapcdn.com/bootstrap/4.1.3/js/bootstrap.min.js" integrity="sha384-ChfqqxuZUCnJSK3+MXmPNIyE6ZbWh2IMqE241rYiqJxyMiZ6OW/JmZQ5stwEULTy" crossorigin="anonymous"></script>

	<script src="../js/fadeAnimations.js"></script>

</body>
</html>
    <? }
}
?>