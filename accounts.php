<?php

require_once 'mysql.php';

function isValidLogIn()
{
	if (!isset($_SESSION['engr']))
	{
		return false;
	}
	else
	{
		if (!isset($_SESSION['valid']))
		{
			if (!isset($_SESSION['valid']) or !$_SESSION['valid'])
			{
				return false;
			}
		}
	}
	
	return true;
}

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
				$_SESSION['goto'] = $currentPage;
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
	mysql_close($con);
	
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['ID'];
	}
}

function getCurrentMemberID()
{
	if (isset($_SESSION['engr']))
	{
		return getMemberID($_SESSION['engr']);
	}
	else
	{
		return null;
	}
}

function memberIsExec($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT * FROM Members WHERE Executive='1' AND ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	if (mysql_num_rows($result) > 0)
	{
		mysql_close($con);
		return true;
	}
	else
	{
		mysql_close($con);
		return false;
	}
}

function memberIsManager($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT * FROM ProjectManagers WHERE MemberID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	if (mysql_num_rows($result) > 0)
	{
		mysql_close($con);
		return true;
	}
	else
	{
		mysql_close($con);
		return false;
	}
}

function promoteMember($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "UPDATE Members SET Executive='1' WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$errno = mysql_errno();
	mysql_close($con);
	
	return $errno;
}

function demoteMember($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "UPDATE Members SET Executive='0' WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$errno = mysql_errno();
	mysql_close($con);
	
	return $errno;
}

function getAllMembers($execFirst = false)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = '';
	if ($execFirst)
	{
		$query = "SELECT ID, Name, Executive FROM Members ORDER BY Executive DESC, Name ASC;";
	}
	else
	{
		$query = "SELECT ID, Name, Executive FROM Members ORDER BY Name ASC;";
	}
	
	$result = mysql_query($query, $con);
	
	$members = array();
	while ($row = mysql_fetch_array($result))
	{
		$member = array();
		$member['ID'] = $row['ID'];
		$member['Name'] = $row['Name'];
		$member['Executive'] = $row['Executive'];
		
		if ($member['ID'] != 0)
		{
			$members[] = $member;
		}
	}
	
	mysql_close($con);
	
	return $members;
}

?>