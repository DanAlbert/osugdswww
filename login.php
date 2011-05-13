<!DOCTYPE HTML>
<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
</head>
<body>
<?php
session_start();
?>

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
	
	<h1>Log In</h1>
	<?php if ($_REQUEST['failed'] == 1) { print '<p>Incorrect username or password. Please try again.</p>'; } ?>
	<form action="doLogin.php" method="post">
		<label for="engr">Engineering Username</label>
		<input type="text" name="engr" />
		
		<label for="password">Password</label>
		<input type="password" name="password" />
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

