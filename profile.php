<?php
	session_start();
	
	if (!isset($_SESSION['engr']))
	{
		$_SESSION['goto'] = $currentPage;
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
	
	<h1>Edit Your Profile</h1>
	
	<?php
		if (!isset($_SESSION['valid']) OR !$_SESSION['valid'])
		{
			print '<p>You must fill out the required information before your account is created.</p>';
		}
		elseif (isset($_REQUEST['updated']) AND ($_REQUEST['updated'] == 1))
		{
			print '<p>Profile updated successfully.</p>';
		}
	?>
	
	<form action="doUpdateProfile.php" method="post">
		<label for="name">Full Name</label>
		
		<?php
			require_once 'mysql.php';
			$con = dbConnect();
			
			$engr = mysql_real_escape_string($_SESSION['engr']);
			$query = "SELECT Name FROM Members WHERE ENGR='" . $engr . "';";
			$result = mysql_query($query);
			mysql_close($con);
			
			$row = mysql_fetch_array($result);
			$name = $row['Name'];
			
			print '<input type="text" name="name" value="' . $name . '" />';
		?>
		
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

