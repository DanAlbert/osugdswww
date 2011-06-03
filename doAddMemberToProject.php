<?php

require_once 'accounts.php';
require_once 'projects.php';

session_start();

if (getCurrentMemberID() != getProjectManager($_POST['projectID']))
{
	print 'forbidden';
	return;
}
	
$memberID = $_POST['memberID'];
$projectID = $_POST['projectID'];

if (addMemberToProject($memberID, $projectID))
{
	print 'success';
}
else
{
	print 'failure';
}

?>
