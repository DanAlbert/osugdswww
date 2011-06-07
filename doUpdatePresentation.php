<?php

require_once 'accounts.php';
require_once 'mysql.php';

session_start();

$id = $_REQUEST['id'];

requireLogin('/osugds/editPresentation.php?id=' . $id);

if (!memberIsExec(getCurrentMemberID()))
{
	header('Location: /osugds/forbidden.php');
}

$con = dbConnect();
if (!$con)
{
	die('Could not connect to database server.');
}

$id = mysql_real_escape_string($_REQUEST['id']);
$title = mysql_real_escape_string($_POST['title']);
$author = mysql_real_escape_string($_POST['author']);
$presenter = mysql_real_escape_string($_POST['presenter']);
$lang = mysql_real_escape_string($_POST['lang']);
$url = mysql_real_escape_string($_POST['url']);
$day = mysql_real_escape_string($_POST['day']);
$month = mysql_real_escape_string($_POST['month']);
$year = mysql_real_escape_string($_POST['year']);

$date = "$year-$month-$day";

$query = "UPDATE Presentations SET Title='" . $title . "', " .
	"Author='" . $author . "', " .
	"Presenter='" . $presenter . "', " .
	"Lang='" . $lang . "', " .
	"URL='" . $url . "', " .
	"PresentedOn='" . $date . "' " .
	"WHERE ID='" . $id . "';";

mysql_query($query, $con);
if (mysql_errno() != 0)
{
	mysql_close($con);
	header('Location: /osugds/editPresentation.php?error=1&id=' . $id);
}
else
{
	mysql_close($con);
	header('Location: /osugds/resources.php?status=3');
}

?>
