<?php

require_once 'mysql.php';

$con = dbConnect();
if (!$con)
{
	die('Could not connect to database server.');
}

$memberID = $_POST['MemberID'];
$projectID = $_POST['ProjectID'];
$developer = $_POST['Developer'];
$artist2D = $_POST['Artist2D'];
$artist3D = $_POST['Artist3D'];
$soundDesigner = $_POST['SoundDesigner'];
$gameDesigner = $_POST['GameDesigner'];
$writer = $_POST['Writer'];

$query = "UPDATE ProjectMembers SET Developer='$developer', Artist2D='$artist2D', Artist3D='$artist3D', SoundDesigner='$soundDesigner', GameDesigner='$gameDesigner', Writer='$writer' WHERE MemberID='$memberID' AND ProjectID='$projectID';";
mysql_query($query, $con);

return 'MySQL Error: ' . mysql_errno();

?>
