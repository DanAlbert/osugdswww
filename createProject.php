<?php
	session_start();
	require_once 'accounts.php';
	requireLogin($_SERVER['PHP_SELF']);
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
	
	<?php
		if (isset($_REQUEST['error']))
		{
			switch ($_REQUEST['error'])
			{
			case 1:
				print '<span>A project with that title already exists.</span>';
				break;
				
			case 2:
				print '<span>Could not create new project.</span>';
				break;
				
			case 3:
				print '<span>Could not add project manager.</span>';
				break;
				
			case 4:
				print '<span>Could not add project member.</span>';
				break;
				
			case 4:
				print '<span>Could not connect to the database.</span>';
				break;
			}
		}
	?>
	
	<h1>Create a Project</h1>
	<form action="doCreateProject.php" method="POST">
		<label for="title">Title *</label>
		<input id="title" type="text" name="title" />
		
		<label for="description">Description *</label>
		<textarea id="description" name="description" cols="50" rows="5"></textarea>
		
		<label for="projectURL">Project URL</label>
		<input id="projectURL" type="text" name="projectURL" />
		
		<label for="repoURL">Repository URL</label>
		<input id="repoURL" type="text" name="repoURL" />
		
		<label for="imageURL">Image URL</label>
		<input id="imageURL" type="text" name="imageURL" />
		
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

