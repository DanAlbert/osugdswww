<?php

require_once 'mysql.php';

function requireLogin($currentPage)
{
	if (!isset($_SESSION['engr']))
	{
		$_SESSION['goto'] = $currentPage;
		header('Location: /osugds/login.php');
	}
	else
	{
		if (!isset($_SESSION['valid']))
		{
			if (!isset($_SESSION['valid']) or !$_SESSION['valid'])
			{
				header('Location: /osugds/profile.php');
			}
		}
	}
}

function getMemberID($engr)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT ID FROM Members WHERE ENGR='" . $engr . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['ID'];
	}
}

?>