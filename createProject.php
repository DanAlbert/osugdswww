<?php
	session_start();
	
	if (!isset($_SESSION['engr']))
	{
		$_SESSION['goto'] = '/osugds/createProject.php';
		header('Location: /osugds/login.php');
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
</head>
<body>

<div id="container">

<?php
include 'header.php';
include 'nav.php';
?>

<div id="main">
	<div class="notice">
		<h2>Under Construction</h2>
		<p>
			This web site is currently under construction. Please check back
			later for updates.
		</p>
	</div>
	
	<h1>Create a Project</h1>
	<form>
		<label for="title">Title *</label>
		<input type="text" name="title" />
		
		<!-- TODO: Load list of members from database -->
		<label for="members">Members *</label>
		<textarea name="members" cols="17" rows="10"></textarea>
		
		<label for="description">Description *</label>
		<textarea name="description" cols="50" rows="5"></textarea>
		
		<label for="projectURL">Project URL</label>
		<input type="text" name="projectURL" />
		
		<label for="repoURL">Repository URL</label>
		<input type="text" name="repoURL" />
		
		<label for="imageURL">Image URL</label>
		<input type="text" name="imageURL" />
		
		<input type="submit" />
	</form>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

