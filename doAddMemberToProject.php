<?php

require_once 'projects.php';

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
