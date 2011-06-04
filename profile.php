<?php
	session_start();
	
	if (!isset($_SESSION['engr']))
	{
		$_SESSION['goto'] = $currentPage;
		header('Location: /osugds/login.php');
	}
?>
<!DOCTYPE HTML>
<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" >
		function saveChanges(memberID, projectID)
		{
			var dev = $("table#projects tbody tr#" + projectID + " td input[name='Developer']:checked").val();
			var art2d = $("table#projects tbody tr#" + projectID + " td input[name='Artist2D']:checked").val();
			var art3d = $("table#projects tbody tr#" + projectID + " td input[name='Artist3D']:checked").val();
			var sdesigner = $("table#projects tbody tr#" + projectID + " td input[name='SoundDesigner']:checked").val();
			var gdesigner = $("table#projects tbody tr#" + projectID + " td input[name='GameDesigner']:checked").val();
			var writer = $("table#projects tbody tr#" + projectID + " td input[name='Writer']:checked").val();
			
			if (dev == undefined)
			{
				dev = 0;
			}
			
			if (art2d == undefined)
			{
				art2d = 0;
			}
			
			if (art3d == undefined)
			{
				art3d = 0;
			}
			
			if (sdesigner == undefined)
			{
				sdesigner = 0;
			}
			
			if (gdesigner == undefined)
			{
				gdesigner = 0;
			}
			
			if (writer == undefined)
			{
				writer = 0;
			}
			
			$.ajax({type: "POST",
				url: "/osugds/doUpdateMemberRoles.php",
				data: { MemberID: memberID, ProjectID: projectID, Developer: dev, Artist2D: art2d, Artist3D: art3d, SoundDesigner: sdesigner, GameDesigner: gdesigner, Writer: writer },
				dataType: "text",
				success: function(text)
				{
					if (text == 0)
					{
						location.reload(true);
					}
					else
					{
						alert(text);
					}
				}});
		}
		
		function leaveProject(memberID, projectID)
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
					else if (text == 'forbidden')
					{
						window.location = '/osugds/forbidden.php';
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
	
	<h1>Edit Your Profile</h1>
	
	<?php
		if (!isset($_SESSION['valid']) OR !$_SESSION['valid'])
		{
			print '<p>You must fill out the required information before your account is created.</p>';
		}
		elseif (isset($_REQUEST['updated']) AND ($_REQUEST['updated'] == 1))
		{
			print '<p>Profile updated successfully.</p>';
		}
	?>
	
	<form action="doUpdateProfile.php" method="post">
		<label for="name">Full Name</label>
		
		<?php
			require_once 'mysql.php';
			$con = dbConnect();
			
			$engr = mysql_real_escape_string($_SESSION['engr']);
			$query = "SELECT Name FROM Members WHERE ENGR='" . $engr . "';";
			$result = mysql_query($query);
			mysql_close($con);
			
			$row = mysql_fetch_array($result);
			$name = $row['Name'];
			
			print '<input type="text" name="name" value="' . $name . '" />';
		?>
		
		<input type="submit" value="Save Changes"/>
	</form>
	
	<?php
		require_once 'accounts.php';
		require_once 'projects.php';
		
		$id = getCurrentMemberID();
		$projects = getMemberProjects($id);
		
		if (sizeof($projects) > 0)
		{
			print '<h1>Your Projects</h1>';
			
			print '<table id="projects" border="1"><thead><tr><th>Title</th><th>Developer</th><th>2D Artist</th><th>3D Artist</th><th>Sound Designer</th><th>Game Designer</th><th>Story Writer</th><th>Save Changes</th><th>Leave Project</th></thead><tbody>';
			foreach ($projects as $project)
			{
				print '<tr id="' . $project['ID'] . '">';
				print '<td><a href="/osugds/galleries.php#' . $project['ID'] . '">' . $project['Title'] . '</td>';
				
				print '<td><input type="checkbox" name="Developer" value="1" ';
				if ($project['Developer'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><input type="checkbox" name="Artist2D" value="1" ';
				if ($project['Artist2D'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><input type="checkbox" name="Artist3D" value="1" ';
				if ($project['Artist3D'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><input type="checkbox" name="SoundDesigner" value="1" ';
				if ($project['SoundDesigner'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><input type="checkbox" name="GameDesigner" value="1" ';
				if ($project['GameDesigner'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><input type="checkbox" name="Writer" value="1" ';
				if ($project['Writer'])
				{
					print 'checked="checked" ';
				}
				print '/></td>';
				
				print '<td><button onclick="saveChanges(' . $id . ', ' . $project['ID'] . ')">Save Changes</button></td>';
				print '<td><button onclick="leaveProject(' . $id . ', ' . $project['ID'] . ')">Leave Project</button></td>';
				print '</tr>';
			}
			print '</tbody></table>';
		}
	?>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

