<?php

require_once 'mysql.php';
require_once 'projects.php';

$con = dbConnect();

$id = mysql_real_escape_string($_POST['id']);
$title = mysql_real_escape_string($_POST['title']);
$description = mysql_real_escape_string($_POST['description']);
$projectURL = mysql_real_escape_string($_POST['projectURL']);
$repoURL = mysql_real_escape_string($_POST['repoURL']);
$imageURL = mysql_real_escape_string($_POST['imageURL']);

$query = "UPDATE Projects SET Title='" . $title . "', Description='" . $description . "', ProjectURL='" . $projectURL . "', RepoURL='" . $repoURL . "', ImageURL='" . $imageURL . "' WHERE ID='" . $id . "';";
//print $query;
mysql_query($query);

if (mysql_error())
{
	header('Location: /osugds/manageProject.php?id=' . $id . '&error=' . mysql_errno());
}
else
{
	header('Location: /osugds/manageProject.php?id=' . $id);
}

?>
