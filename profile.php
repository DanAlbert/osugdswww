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
	
	<h1>Edit Your Profile</h1>
	<?php if ($_REQUEST['updated'] == 1) { print '<p>Profile updated successfully.</p>'; } ?>
	<form action="doUpdateProfile.php" method="post">
		<!-- TODO: Load existing name from database -->
		<label for="name">Full Name</label>
		<input type="text" name="name" />
		
		<input type="submit" value="Save Changes"/>
	</form>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

