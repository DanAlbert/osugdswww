<?php

require_once 'accounts.php';
require_once 'mysql.php';
require_once 'projects.php';

session_start();

requireLogin('/osugds/createProject.php');

$con = dbConnect();
if (!$con)
{
	header('Location: createProject.php?error=5');
}

$title = mysql_real_escape_string($_POST['title']);
$description = mysql_real_escape_string($_POST['description']);
$projectURL = mysql_real_escape_string($_POST['projectURL']);
$repoURL = mysql_real_escape_string($_POST['repoURL']);
$imageURL = mysql_real_escape_string($_POST['imageURL']);

$query = "SELECT * FROM Projects WHERE Title='" . $title . "';";
$result = mysql_query($query, $con);
if (mysql_num_rows($result) > 0)
{
	header('Location: createProject.php?error=1');
}
else
{
	$query = "INSERT INTO Projects (Title, Description, ProjectURL, RepoURL, ImageURL) VALUES ('" .
		$title . "', '" .
		$description . "', '" .
		$projectURL . "', '" .
		$repoURL . "', '" .
		$imageURL . "');";
	
	mysql_query($query, $con);
	if (mysql_errno() != 0)
	{
		mysql_close($con);
		header('Location: createProject.php?error=2');
	}
	else
	{
		# getCurrentMemberID() and getProjectID() creates their own connections, which kills ours.
		mysql_close($con);
		
		$memberID = getCurrentMemberID();		
		$projectID = getProjectID($title);
		
		# Reopen our connection
		$con = dbConnect();
		if (!$con)
		{
			header('Location: createProject.php?error=5');
		}
		
		$query = "INSERT INTO ProjectManagers (MemberID, ProjectID) VALUES ('" . $memberID . "', '" . $projectID . "');";
		mysql_query($query, $con);
		if (mysql_errno() != 0)
		{
			mysql_close($con);
			header('Location: createProject.php?error=3');
		}
		else
		{
			$query = "INSERT INTO ProjectMembers (MemberID, ProjectID) VALUES ('" . $memberID . "', '" . $projectID . "');";
			mysql_query($query, $con);
			if (mysql_errno() != 0)
			{
				mysql_close($con);
				header('Location: createProject.php?error=4');
			}
			else
			{
				mysql_close($con);
				header('Location: manageProject.php?id=' .  $projectID);
			}
		}
	}
}

?>
