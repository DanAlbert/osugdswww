<?php

require_once 'accounts.php';
require_once 'mysql.php';

session_start();

requireLogin('/osugds/contribute.php');

$con = dbConnect();
if (!$con)
{
	die('Could not connect to database server.');
}

$title = mysql_real_escape_string($_POST['title']);
$author = mysql_real_escape_string($_POST['author']);
$presenter = mysql_real_escape_string($_POST['presenter']);
$lang = mysql_real_escape_string($_POST['lang']);
$url = mysql_real_escape_string($_POST['url']);
$day = mysql_real_escape_string($_POST['day']);
$month = mysql_real_escape_string($_POST['month']);
$year = mysql_real_escape_string($_POST['year']);

$query = "SELECT * FROM Presentations WHERE Title='" . $title . "';";
$result = mysql_query($query, $con);
if (mysql_num_rows($result) > 0)
{
	mysql_close($con);
	header('Location: /osugds/contribute.php?error=1');
}
else
{
	$date = "$year-$month-$day";
	$query = "INSERT INTO Presentations (Title, Author, Presenter, Lang, URL, PresentedOn) VALUES ('" .
		$title . "', '" .
		$author . "', '" .
		$presenter . "', '" .
		$lang . "', '" .
		$url . "', '" .
		$date . "');";
	
	mysql_query($query, $con);
	if (mysql_errno() != 0)
	{
		print $query . '<br />';
		die(mysql_error());
		mysql_close($con);
		header('Location: /osugds/contribute.php?error=2');
	}
	else
	{
		$query = "SELECT ID FROM Presentations WHERE Title='" . $title . "';";
		$result = mysql_query($query, $con);
		$row = mysql_fetch_array($result);
		$tutorialID = $row['ID'];
		mysql_close($con);
		header('Location: /osugds/resources.php#p' . $tutorialID);
	}
}

?>
