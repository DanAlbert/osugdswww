<?php

require_once 'projects.php';

$memberID = $_POST['memberID'];
$projectID = $_POST['projectID'];

if (removeMemberFromProject($memberID, $projectID))
{
	print 'success';
}
else
{
	print 'failure';
}

?>
