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
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" >
		function addSelectedMember(projectID)
		{
			$.ajax({type: "POST",
				url: "/osugds/doAddMemberToProject.php",
				data: { memberID: $("select option:selected").val(), projectID: projectID },
				dataType: "text",
				success: function(text)
				{
					if (text == 'success')
					{
						location.reload(true);
					}
					else
					{
						alert(text);
					}
				}});
		}
		
		function removeMember(memberID, projectID)
		{
			$.ajax({type: "POST",
				url: "/osugds/doRemoveMemberFromProject.php",
				data: { memberID: memberID, projectID: projectID },
				dataType: "text",
				success: function(text)
				{
					if (text == 'success')
					{
						location.reload(true);
					}
					else
					{
						alert(text);
					}
				}});
		}
	</script>
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
		
		<input type="submit" value="Save Changes" />
		
	</form>
	
	<table border="1">
		<thead>
			<tr>
				<th>Member Name</th>
				<th>Modify</th>
			</tr>
		</thead>
		<tbody>
			<?php
				require_once 'accounts.php';
				require_once 'projects.php';
				
				$members = getProjectMembers($_REQUEST['id']);
				foreach ($members as $member)
				{
					print '<tr><td>' . $member['name'] . '</td><td align="center"><button onclick="removeMember(' . $member['id'] . ', ' . $_REQUEST['id'] . ');" >Remove Member</button></td></tr>';
				}
				
				print '<tr><td><select name="addMember">';
				$unmembers = getProjectMembersComplement($_REQUEST['id']);
				foreach ($unmembers as $unmember)
				{
					print '<option value="' . $unmember['id'] . '">' . $unmember['name'] . '</option>';
				}
				print '</select></td><td><button onclick="addSelectedMember(' . $_REQUEST['id'] . ');" >Add Member</button></td></tr>';
			?>
		</tbody>
	</table>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php';
?>

</div> <!-- container -->

</body>
</html>

