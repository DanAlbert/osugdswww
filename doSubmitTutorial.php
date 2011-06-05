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
$lang = mysql_real_escape_string($_POST['lang']);
$url = mysql_real_escape_string($_POST['url']);

$query = "SELECT * FROM Tutorials WHERE Title='" . $title . "';";
$result = mysql_query($query, $con);
if (mysql_num_rows($result) > 0)
{
	mysql_close($con);
	header('Location: /osugds/contribute.php?error=1');
}
else
{
	$query = "INSERT INTO Tutorials (Title, Author, Lang, URL) VALUES ('" .
		$title . "', '" .
		$author . "', '" .
		$lang . "', '" .
		$url . "');";
	
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
		$query = "SELECT ID FROM Tutorials WHERE Title='" . $title . "';";
		$result = mysql_query($query, $con);
		$row = mysql_fetch_array($result);
		$tutorialID = $row['ID'];
		mysql_close($con);
		header('Location: /osugds/resources.php#t' . $tutorialID);
	}
}

?>
