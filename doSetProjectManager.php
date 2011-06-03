<?php

require_once 'accounts.php';
require_once 'projects.php';

if (getCurrentMemberID() != getProjectManager($_REQUEST['id']))
{
	header('Location: /osugds/403.php');
}

$memberID = $_POST['memberID'];
$projectID = $_REQUEST['id'];

if (setProjectManager($memberID, $projectID))
{
	header('Location: /osugds/manageProject.php?id=' . $projectID);
}
else
{
	header('Location: /osugds/manageProject.php?id=' . $projectID . '&error=1');
}

?>
