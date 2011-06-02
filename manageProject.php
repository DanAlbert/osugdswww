<?php
	session_start();
	require_once 'accounts.php';
	requireLogin($_SERVER['PHP_SELF']);
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
</head>
<body>

<div id="container">

<?php
include 'header.php';
include 'nav.php';
?>

<div id="main">
	<div class="notice">
		<h2>Under Construction</h2>
		<p>
			This web site is currently under construction. Please check back
			later for updates.
		</p>
	</div>
	
	<h1>Manage <?php require_once 'projects.php'; echo getProjectTitle($_REQUEST['id']); ?></h1>
	<form action="doUpdateProject.php?id=<?php echo $_REQUEST['id']; ?>" method="POST">
		<label for="title">Title *</label>
		<input id="title" type="text" name="title" value="<?php require_once 'projects.php'; echo getProjectTitle($_REQUEST['id']); ?>" />
		
		<label for="description">Description *</label>
		<textarea id="description" name="description" cols="50" rows="5" ><?php require_once 'projects.php'; echo getProjectDescription($_REQUEST['id']); ?></textarea>
		
		<label for="projectURL">Project URL</label>
		<input id="projectURL" type="text" name="projectURL" value="<?php require_once 'projects.php'; echo getProjectURL($_REQUEST['id']); ?>" />
		
		<label for="repoURL">Repository URL</label>
		<input id="repoURL" type="text" name="repoURL" value="<?php require_once 'projects.php'; echo getProjectRepoURL($_REQUEST['id']); ?>" />
		
		<label for="imageURL">Image URL</label>
		<input id="imageURL" type="text" name="imageURL" value="<?php require_once 'projects.php'; echo getProjectImageURL($_REQUEST['id']); ?>" />
		
		<table>
			<?php
				require_once 'accounts.php';
				require_once 'projects.php';
				
				$members = getProjectMembers($_REQUEST['id']);
				foreach ($members as $member)
				{
					print '<tr><td>' . $member['name'] . '</td></tr>';//<td><input type="checkbox" name="deleteMember[\'' . $member['id'] . '\']" value="1" /></td></tr>'
				}
			?>
		</table>
		
		<input type="submit" value="Save Changes" />
	</form>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php';
?>

</div> <!-- container -->

</body>
</html>

