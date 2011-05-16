<?php

require_once 'mysql.php';

session_start();

if (isset($_POST['engr']))
{
	if (($_POST['engr'] == 'albertd') && ($_POST['password'] == 'foobar'))
	{
		$_SESSION['engr'] = $_POST['engr'];
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$query = "SELECT Name FROM Memebers WHERE ENGR='" . $_SESSION['engr'] . "';";
		$result = mysql_query(mysql_real_escape_string($query));
		mysql_close($con);
		
		if ((mysql_fetch_array($result)) and (isset($_SESSION['goto'])))
		{
			$_SESSION['valid'] = true;
			$goto = $_SESSION['goto'];
			unset($_SESSION['goto']);
			header('Location: ' . $goto);
		}		
		else
		{
			header('Location: /osugds/profile.php');
		}
	}
	else
	{
		unset($_SESSION['engr']);
		header('Location: /osugds/login.php?failed=1');
	}
}
else
{
	header('Location: /osugds/login.php');
}

?>
