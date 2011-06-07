<?php

require_once 'accounts.php';
require_once 'mysql.php';
require_once 'projects.php';

session_start();

$id = $_POST['id'];

if (getCurrentMemberID() != getProjectManager($id))
{
	header('Location: /osugds/forbidden.php');
}

$con = dbConnect();
if (!$con)
{
	die('Could not connect to database server.');
}

$query = "DELETE FROM Projects WHERE ID='" . $id . "';";
mysql_query($query, $con);
mysql_close($con);

header('Location: /osugds/userProjects.php?status=1');

?>
