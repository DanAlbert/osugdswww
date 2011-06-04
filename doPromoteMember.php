<?php

require_once 'accounts.php';

session_start();

if (!memberIsExec(getCurrentMemberID()))
{
	print 'forbidden';
	return;
}
	
$id = $_POST['id'];

print promoteMember($id);

?>
