<?php

session_start();

if (isset($_POST['engr']))
{
	if (($_POST['engr'] == 'albertd') && ($_POST['password'] == 'foobar'))
	{
		$_SESSION['engr'] = $_POST['engr'];
	}
	else
	{
		unset($_SESSION['engr']);
	}
}

if (isset($_SESSION['engr']))
{
	header('Location: /osugds/profile.php');
}
else
{
	header('Location: /osugds/login.php?failed=1');
}

?>
