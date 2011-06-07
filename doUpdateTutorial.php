<?php

require_once 'accounts.php';
require_once 'mysql.php';

session_start();

$id = $_REQUEST['id'];

requireLogin('/osugds/editTutorial.php?id=' . $id);

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
$lang = mysql_real_escape_string($_POST['lang']);
$url = mysql_real_escape_string($_POST['url']);

$query = "UPDATE Tutorials SET Title='" . $title . "', " .
	"Author='" . $author . "', " .
	"Lang='" . $lang . "', " .
	"URL='" . $url . "' " .
	"WHERE ID='" . $id . "';";

mysql_query($query, $con);
if (mysql_errno() != 0)
{
	mysql_close($con);
	header('Location: /osugds/editTutorial.php?error=1&id=' . $id);
}
else
{
	mysql_close($con);
	header('Location: /osugds/resources.php?status=1');
}

?>
