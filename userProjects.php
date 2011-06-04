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
	
	<h1>Your Projects</h1>
	<?php
		require_once 'accounts.php';
		require_once 'mysql.php';
		require_once 'projects.php';
		
		$currentID = getCurrentMemberID();
		
		$con = dbConnect();
		if (!$con)
		{
			print 'Unable to connect to database: ' . mysql_error();
		}
		else
		{
			$query = "SELECT Projects.ID, Projects.Title FROM Projects, ProjectManagers WHERE ProjectManagers.MemberID='" . $currentID . "' AND Projects.ID=ProjectManagers.ProjectID;";
			$result = mysql_query($query, $con);
			
			while ($row = mysql_fetch_array($result))
			{
				print '<h3><a href="/osugds/manageProject.php?id=' . $row['ID'] . '">' . $row['Title'] . '</a></h3>';
			}
		}
		
		mysql_close($con);
	?>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

