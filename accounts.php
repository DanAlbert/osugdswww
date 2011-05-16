<?php

function requireLogin($currentPage)
{
	if (!isset($_SESSION['engr']))
	{
		$_SESSION['goto'] = $currentPage;
		header('Location: /osugds/login.php');
	}
	else
	{
		if (!isset($_SESSION['valid']))
		{
			if (!isset($_SESSION['valid']) or !$_SESSION['valid'])
			{
				header('Location: /osugds/profile.php');
			}
		}
	}
}

?>