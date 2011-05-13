<?php
	session_start();
?>
<div id="nav">
	<ul>
		<li><a href="/osugds/index.php">Home</a></li>
		<li><a href="/osugds/galleries.php">Galleries</a></li>
		<li><a href="/osugds/createProject.php">Create a Project</a></li>
		<li><a href="/osugds/resources.php">Resources</a></li>
		<li><a href="http://gamedev.stackexchange.com/">Get Help</a></li>
		<li><a href="/osugds/about.php">About Us</a></li>
	</ul>
	<?php if (isset($_SESSION['engr'])) { print '<a id="login" href="doLogout.php">Log Out</a>'; } else { print '<a id="login" href="login.php">Log In</a>'; } ?>
</div> <!-- nav -->
