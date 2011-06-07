<?php
	session_start();
	require_once 'accounts.php';
	require_once 'projects.php';
	
	requireLogin($_SERVER['PHP_SELF']);
	if (!memberIsExec(getCurrentMemberID()))
	{
		header('Location: /osugds/forbidden.php');
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
	
	<?php
		require_once 'mysql.php';
		
		if (isset($_REQUEST['error']) && ($_REQUEST['error'] == 1))
		{
			print '<span>An error occured while submitting changes.</span>';
		}
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$id = $_REQUEST['id'];
		
		$query = "SELECT Title, Author, Presenter, Lang, URL, PresentedOn FROM Presentations WHERE ID='" . $id . "';";
		$result = mysql_query($query, $con);
		$row = mysql_fetch_array($result);
		
		$title = $row['Title'];
		$author = $row['Author'];
		$presenter = $row['Presenter'];
		$lang = $row['Lang'];
		$url = $row['URL'];
		$presentedOn = $row['PresentedOn'];
		
		print '<h1>Edit ' . $title . '</h1>';
		
	?>
	<form action="doUpdatePresentation.php?id=<?php echo $id; ?>" method="POST">
		<label for="title">Title *</label>
		<input id="title" type="text" name="title" value="<?php echo $title; ?>" />
		
		<label for="author">Author</label>
		<select id="author" name="author">
			<?php
				require_once 'accounts.php';
				
				$selected = false;
				$members = getAllMembers();
				foreach ($members as $member)
				{
					print '<option value="' . $member['ID'] . '"';
					if ($member['ID'] == $author)
					{
						$selected = true;
						print ' selected="selected"';
					}
					print '>' . $member['Name'] . '</option>';
				}
				print '<option value="0"';
				if (!$selected)
				{
					print ' selected="selected"';
				}
				print '>Non Member</option>';
			?>
		</select>
		
		<label for="presenter">Presenter</label>
		<select id="presenter" name="presenter">
			<?php
				require_once 'accounts.php';
				
				$selected = false;
				$members = getAllMembers();
				foreach ($members as $member)
				{
					print '<option value="' . $member['ID'] . '"';
					if ($member['ID'] == $presenter)
					{
						$selected = true;
						print ' selected="selected"';
					}
					print '>' . $member['Name'] . '</option>';
				}
				print '<option value="0"';
				if (!$selected)
				{
					print ' selected="selected"';
				}
				print '>Non Member</option>';
			?>
		</select>
		
		<label for="lang">Language</label>
		<select id="lang" name="lang">
			<option value="C/C++" <?php if ($lang == 'C/C++') { print ' selected="selected"'; } ?>>C/C++</option>
			<option value="C#" <?php if ($lang == 'C#') { print ' selected="selected"'; } ?>>C#</option>
			<option value="Flash" <?php if ($lang == 'Flash') { print ' selected="selected"'; } ?>>Flash</option>
			<option value="Other" <?php if ($lang == 'Other') { print ' selected="selected"'; } ?>>Other</option>
		</select>
		
		<label for="url">URL</label>
		<input id="url" type="text" name="url" value="<?php echo $url; ?>" />
		
		<?php
			$dateComp = explode('-', $row['PresentedOn']);
			$pyear = $dateComp[0];
			$pmonth = $dateComp[1];
			$pday = $dateComp[2];
			
			print '<label for="date">Date Presented</label>';
			print '<select id="date" name="day">';
			foreach (range(1, 31) as $day)
			{
				print '<option value="' . $day . '"';
				if ($day == $pday)
				{
					print ' selected="selected"';
				}
				print '>' . $day . '</option>';
			}
			print '</select>';
			
			$months = array('', 'January', 'February', 'March', 'April', 'May', 'June', 'July', 'August', 'September', 'October', 'November', 'December');
			
			print '<select name="month">';
			for ($i = 1; $i < sizeof($months); $i++)
			{
				print '<option value="' . $i . '"';
				if ($pmonth == $i)
				{
					print ' selected="selected"';
				}
				print '>' . $months[$i] . '</option>';
			}
			print '</select>';
			
			print '<select name="year">';
			$date = getdate();
			foreach (range(2010, $date['year']) as $year)
			{
				print '<option value="' . $year . '"';
				if ($year == $pyear)
				{
					print ' selected="selected"';
				}
				print '>' . $year . '</option>';
			}
			print '</select>';
		?>
		
		<input type="submit" value="Save Changes" />
		
	</form>	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php';
?>

</div> <!-- container -->

</body>
</html>

