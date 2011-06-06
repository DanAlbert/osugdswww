<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
	
	<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
	<script type="text/javascript" >
		function promoteMember(id)
		{
			$.ajax({type: "POST",
				url: "/osugds/doPromoteMember.php",
				data: { id: id },
				dataType: "text",
				success: function(text)
				{
					if (text == 0)
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
		
		function demoteMember(id)
		{
			$.ajax({type: "POST",
				url: "/osugds/doDemoteMember.php",
				data: { id: id },
				dataType: "text",
				success: function(text)
				{
					if (text == 0)
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
<?php
session_start();
?>

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
	
	<?php
		require_once 'accounts.php';
		require_once 'mysql.php';
		
		$con = dbConnect();
		if (!$con)
		{
			die('Could not connect to database server.');
		}
		
		$members = getallMembers(true);
		
		$memberID = getCurrentMemberID();
		$exec = memberIsExec($memberID);
		
		$lastMemberExec = true;
		print '<h2>Club Executives</h2><table><tbody>';
		foreach ($members as $member)
		{
			if ($lastMemberExec AND !$member['Executive'])
			{
				print '</tbody></table><h2>Club Members</h2><table><tbody>';
				$lastMemberExec = false;
			}
			
			print '<tr><td><a href="memberInfo.php?id=' . $member['ID'] . '">' . $member['Name'] . '</a></td>';
			if ($exec)
			{
				if ($member['ID'] == $memberID)
				{
					print '<td></td>';
				}
				else
				{
					if ($member['Executive'])
					{
						print '<td><button onclick="demoteMember(' . $member['ID'] . ')">Demote Member</button></td>';
					}
					else
					{
						print '<td><button onclick="promoteMember(' . $member['ID'] . ')">Promote Member</button></td>';
					}
				}
			}
			print '</tr>';
		}
		
		print '</tbody></table>';
	?>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

