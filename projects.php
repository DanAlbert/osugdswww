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

# Not tolerant of errors
function getProjectManager($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT MemberID FROM ProjectManagers WHERE ProjectID='" . $id . "';";
	$result = mysql_query($query, $con);
	$row = mysql_fetch_array($result);
	return $row['MemberID'];
}

function getProjectMembers($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	$query = "SELECT Members.ID, Members.Name FROM Members, ProjectMembers WHERE ProjectMembers.ProjectID='" . $id . "' AND Members.ID=ProjectMembers.MemberID ORDER BY Members.Name ASC;";
	$result = mysql_query($query, $con);
	
	$members = array();
	while ($row = mysql_fetch_array($result))
	{
		$member = array();
		$member['id'] = $row['ID'];
		$member['name'] = $row['Name'];
		$members[] = $member;
	}
	
	return $members;
}

function getProjectMembersComplement($id)
{
	$con = dbConnect();
	if (!$con)
	{
		return null;
	}
	
	
	$query = "SELECT Members.ID, Members.Name FROM Members WHERE Members.ID NOT IN (SELECT Members.ID FROM Members, ProjectMembers WHERE ProjectMembers.ProjectID='" . $id . "' AND Members.ID=ProjectMembers.MemberID) ORDER BY Members.Name ASC;";
	$result = mysql_query($query, $con);
	
	$members = array();
	while ($row = mysql_fetch_array($result))
	{
		$member = array();
		$member['id'] = $row['ID'];
		$member['name'] = $row['Name'];
		$members[] = $member;
	}
	
	return $members;
}

function setProjectManager($memberID, $projectID)
{
	$con = dbConnect();
	if (!$con)
	{
		die('Could not connect to database server.');
	}
	
	$query = "UPDATE ProjectManagers SET MemberID='" . $memberID . "', ProjectID='" . $projectID . "' WHERE ProjectID='" . $projectID . "';";
	mysql_query($query, $con);
	
	if (mysql_errno() != 0)
	{
		mysql_close($con);
		return false;
	}
	else
	{
		mysql_close($con);
		return true;
	}
}

function addMemberToProject($memberID, $projectID)
{
	$con = dbConnect();
	if (!$con)
	{
		die('Could not connect to database server.');
	}
	
	$query = "INSERT INTO ProjectMembers (MemberID, ProjectID) VALUES ('" . $memberID . "', '" . $projectID . "');";
	mysql_query($query, $con);
	
	if (mysql_errno() != 0)
	{
		mysql_close($con);
		return false;
	}
	else
	{
		mysql_close($con);
		return true;
	}
}

function removeMemberFromProject($memberID, $projectID)
{
	$con = dbConnect();
	if (!$con)
	{
		die('Could not connect to database server.');
	}
	
	$query = "DELETE FROM ProjectMembers WHERE MemberID='" . $memberID . "' AND ProjectID='" . $projectID . "';";
	mysql_query($query, $con);
	
	if (mysql_errno() != 0)
	{
		mysql_close($con);
		return false;
	}
	else
	{
		mysql_close($con);
		return true;
	}
}

?>