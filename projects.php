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

?>