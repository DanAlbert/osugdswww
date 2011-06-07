<?php

require_once 'mysql.php';

session_start();

if (isset($_POST['engr']))
{
	if ((($_POST['engr'] == 'albertd') AND ($_POST['password'] == 'foobar')) OR
		(($_POST['engr'] == 'ta') && ($_POST['password'] == 'passwd')) OR
		(($_POST['engr'] == 'user') && ($_POST['password'] == 'passwd')))
	{
		$_SESSION['engr'] = $_POST['engr'];
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$query = "SELECT Name FROM Members WHERE ENGR='" . mysql_real_escape_string($_SESSION['engr']) . "';";
		$result = mysql_query($query, $con);
		mysql_close($con);
		
		if (mysql_num_rows($result) > 0)
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
				header('Location: /osugds/profile.php');
			}
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
