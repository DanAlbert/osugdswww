<?php

require_once 'accounts.php';
require_once 'projects.php';

session_start();

$memberID = $_POST['memberID'];
$projectID = $_POST['projectID'];

$id = getCurrentMemberID();
if (($id != getProjectManager($_POST['projectID'])) AND ($id != $memberID))
{
	print 'forbidden';
	return;
}

if (removeMemberFromProject($memberID, $projectID))
{
	print 'success';
}
else
{
	print 'failure';
}

?>
