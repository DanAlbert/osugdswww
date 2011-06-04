<?php
	session_start();
?>
<div id="nav">
	<ul>
		<li><a href="/osugds/index.php">Home</a></li>
		<li><a href="/osugds/galleries.php">Galleries</a></li>
		<li><a href="/osugds/createProject.php">Create a Project</a></li>
		<?php require_once 'accounts.php'; if (isValidLogIn() AND memberIsManager(getCurrentMemberID())) { print '<li><a href="userProjects.php">Manage Projects</a></li>'; } ?>
		<li><a href="/osugds/members.php">Members</a></li>
		<li><a href="/osugds/resources.php">Resources</a></li>
		<li><a href="http://gamedev.stackexchange.com/">Get Help</a></li>
		<li><a href="/osugds/about.php">About Us</a></li>
	</ul>
	<?php require_once 'accounts.php'; if (isValidLogIn()) { print '<a id="login" href="doLogout.php">Log Out</a>'; } else { print '<a id="login" href="login.php">Log In</a>'; } ?>
	<?php require_once 'accounts.php'; if (isValidLogIn()) { print '<a id="profile" href="/osugds/profile.php">Profile</a>'; } ?>
</div> <!-- nav -->
