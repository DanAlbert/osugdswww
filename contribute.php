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
	
	<h1>Sumit a Tutorial</h1>
	<form action="doSubmitTutorial.php" method="POST">
		<label for="t_title">Title *</label>
		<input id="t_title" type="text" name="title" />
		
		<label for="t_author">Author</label>
		<select id="t_author" name="author">
			<?php
				require_once 'accounts.php';
				
				$members = getAllMembers();
				foreach ($members as $member)
				{
					print '<option value="' . $member['ID'] . '">' . $member['Name'] . '</option>';
				}
			?>
			<option value="0">Non Member</option>
		</select>
		
		<label for="t_lang">Language</label>
		<select id="t_lang" name="lang">
			<option value="C/C++">C/C++</option>
			<option value="C#">C#</option>
			<option value="Flash">Flash</option>
			<option value="Other">Other</option>
		</select>
		
		<label for="t_url">URL *</label>
		<input id="t_url" type="text" name="url" />
		
		<input type="submit" />
	</form>
	
	<?php
		require_once 'accounts.php';
		
		if (memberIsExec(getCurrentMemberID()))
		{
			print '<h1>Submit a Presentation</h1>';
			print '<form action="doSubmitPresentation.php" method="POST">';
			print '<label for="p_title">Title *</label>';
			print '<input id="p_title" type="text" name="title" />';
			print '<label for="p_author">Author</label>';
			print '<select id="p_author" name="author">';
			
			$members = getAllMembers();
			foreach ($members as $member)
			{
				print '<option value="' . $member['ID'] . '">' . $member['Name'] . '</option>';
			}
			
			print '<option value="0">Non Member</option>';
			print '</select>';
			
			print '<label for="p_presenter">Presenter</label>';
			print '<select id="p_presenter" name="presenter">';
			
			foreach ($members as $member)
			{
				print '<option value="' . $member['ID'] . '">' . $member['Name'] . '</option>';
			}
			
			print '<option value="0">Non Member</option>';
			print '</select>';
			
			print '<label for="p_lang">Language</label>';
			print '<select id="p_lang" name="lang">';
			print '<option value="C/C++">C/C++</option>';
			print '<option value="C#">C#</option>';
			print '<option value="Flash">Flash</option>';
			print '<option value="Other">Other</option>';
			print '</select>';
			
			print '<label for="p_url">URL *</label>';
			print '<input id="p_url" type="text" name="url" />';
			
			print '<label for="p_date">Date Presented</label>';
			print '<select id="p_date" name="day">';
			foreach (range(1, 31) as $day)
			{
				print '<option value="' . $day . '">' . $day . '</option>';
			}
			print '</select>';
			
			print '<select name="month">';
			print '<option value="1">January</option>';
			print '<option value="2">February</option>';
			print '<option value="3">March</option>';
			print '<option value="4">April</option>';
			print '<option value="5">May</option>';
			print '<option value="6">June</option>';
			print '<option value="7">July</option>';
			print '<option value="8">August</option>';
			print '<option value="9">September</option>';
			print '<option value="10">October</option>';
			print '<option value="11">November</option>';
			print '<option value="12">December</option>';
			print '</select>';
			
			print '<select name="year">';
			$date = getdate();
			foreach (range(2010, $date['year']) as $year)
			{
				print '<option value="' . $year . '">' . $year . '</option>';
			}
			print '</select>';
			
			print '<input type="submit" />';
			print '</form>';
		}
	?>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

