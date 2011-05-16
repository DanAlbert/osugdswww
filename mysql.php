<?php

function dbConnect()
{
	$host = 'mysql.gingerhq.net';
	$database = 'osugds';
	$username = 'osugds';
	$password = 'CUUh7N4aUWDJR2rF';
	
	$con = mysql_connect($host, $username, $password);
	mysql_select_db($database, $con);
	return $con;
}

?>