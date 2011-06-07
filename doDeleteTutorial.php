<?php

require_once 'accounts.php';
require_once 'mysql.php';

session_start();

$id = $_REQUEST['id'];

if (!memberIsExec(getCurrentMemberID()))
{
	header('Location: /osugds/forbidden.php');
}

$con = dbConnect();
if (!$con)
{
	die('Could not connect to database server.');
}

$query = "DELETE FROM Tutorials WHERE ID='" . $id . "';";
mysql_query($query, $con);
mysql_close($con);

header('Location: /osugds/resources.php?status=2');

?>
