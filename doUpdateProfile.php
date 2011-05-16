<?php

require_once 'mysql.php';

session_start();

if (isset($_SESSION['engr']) and isset($_POST['name']))
{
	$con = dbConnect();
	
	$name = mysql_real_escape_string($_POST['name']);
	$engr = mysql_real_escape_string($_SESSION['engr']);
	
	$query = "SELECT Name FROM Members WHERE ENGR='" . $engr . "';";
	print $query;
	$result = mysql_query($query);
	
	if (mysql_num_rows($result) == 0)
	{
		$query = "INSERT INTO Members (ENGR, Name) VALUES ('" . $engr .	"', '" . $name . "');";
	}
	else
	{
		$query = "UPDATE Members SET Name='" . $name . "' WHERE ENGR='" . $engr . "';";
	}
	
	mysql_query($query);
	
	if (!mysql_error())
	{
		$_SESSION['valid'] = true;
		if (isset($_SESSION['goto']))
		{
			$goto = $_SESSION['goto'];
			unset($_SESSION['goto']);
			header('Location: ' . $goto);
		}
		else
		{
			header('Location: /osugds/profile.php?updated=1');
		}
	}
	else
	{
		print mysql_error();
		#header('Location: /osugds/login.php');
	}
}
else
{
	header('Location: /osugds/login.php');
}

?>
