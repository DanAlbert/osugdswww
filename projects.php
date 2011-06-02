<?php

require_once 'mysql.php';

function getProjectID($title)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT ID FROM Projects WHERE Title='" . $title . "';";
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

function getProjectTitle($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT Title FROM Projects WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['Title'];
	}
}

function getProjectDescription($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT Description FROM Projects WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['Description'];
	}
}

function getProjectURL($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT ProjectURL FROM Projects WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['ProjectURL'];
	}
}

function getProjectRepoURL($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT RepoURL FROM Projects WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['RepoURL'];
	}
}

function getProjectImageURL($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT ImageURL FROM Projects WHERE ID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$row = mysql_fetch_array($result);
	if ($row === false)
	{
		return null;
	}
	else
	{
		return $row['ImageURL'];
	}
}

function getProjectMembers($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT Members.ID, Members.Name FROM Members, ProjectMembers WHERE ProjectMembers.ProjectID='" . $id . "';";
	$result = mysql_query($query, $con);
	
	$members = array();
	while ($row = mysql_fetch_array($result))
	{
		$member = array();
		$member['id'] = $row['ID'];
		$member['name'] = $row['Name'];
	}
	
	return $members;
}

?>