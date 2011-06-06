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
	
	<h2>Presentations</h2>
	<?php
		require_once 'mysql.php';
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$query = "SELECT Title, Lang, URL, PresentedOn FROM Presentations ORDER BY Lang ASC, PresentedOn DESC;";
		$result = mysql_query($query, $con);
		
		$lastLang == '';
		while ($row = mysql_fetch_array($result))
		{
			if ($row['Lang'] != $lastLang)
			{
				if ($lastLang != '')
				{
					print '</ul>';
				}
				print '<h3>' . $row['Lang'] . ' Presentations</h3><ul>';
				$lastLang = $row['Lang'];
			}
			
			$dateComp = explode('-', $row['PresentedOn']);
			$year = $dateComp[0];
			$month = date("M", mktime(0, 0, 0, $dateComp[1], 1, 2005));
			$day = $dateComp[2];
			
			$date = "$day $month $year";
			
			print '<li><a href="' . $row['URL'] . '">' . $date . ' - ' . $row['Title'] . '</a></li>';
		}
	?>
	<!--<ul>
		<!--<li><a href="https://docs.google.com/present/edit?id=0AaQCl-92YIEcZGd0YzJ4OG1fMjE0dzQ1NjVnag&hl=en">24 January 2011 - Graphics and Animation in Games</a></li>
		<li><a href="/osugds/resources/Gaming%20Input%20and%20the%20Arcade.pptx">14 February 2011 - Gaming Input and the Arcade</a> - <a href="/osugds/resources/lesson03.zip">Source Code</a></li>
		<li>28 February 2011 - OpenGL - <a href="/osugds/resources/OpenGLDemo.tar.bz2">Source Code</a> (Note: You will need to place a copy of glut.h in C:\Program Files (x86)\Microsoft SDKs\Windows\v7.0A\Include\gl)</li>
	</ul>-->
	
	<h2>Tutorials</h2>
	<?php
		require_once 'mysql.php';
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$query = "SELECT Title, Lang, URL FROM Tutorials ORDER BY Lang ASC;";
		$result = mysql_query($query, $con);
		
		$lastLang == '';
		while ($row = mysql_fetch_array($result))
		{
			if ($row['Lang'] != $lastLang)
			{
				if ($lastLang != '')
				{
					print '</ul>';
				}
				print '<h3>' . $row['Lang'] . ' Tutorials</h3><ul>';
				$lastLang = $row['Lang'];
			}
			
			print '<li><a href="' . $row['URL'] . '">' . $row['Title'] . '</a></li>';
		}
	?>
	<!--<h3>Flash Tutorials</h3>
	<ul>
		<li><a href="/osugds/tutorials/flash/tutorial1.php">Tutorial 1</a></li>
		<li><a href="/osugds/tutorials/flash/tutorial2.php">Tutorial 2</a></li>
		<li><a href="/osugds/tutorials/flash/tutorial3.php">Tutorial 3</a></li>
	</ul>-->
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

