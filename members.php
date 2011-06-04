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
	
	<table>
		<tbody>
			<?php
				require_once 'accounts.php';
				require_once 'mysql.php';
				
				$con = dbConnect();
				if (!$con)
				{
					die('Could not connect to database server.');
				}
				
				$query = "SELECT ID, Name, Executive FROM Members ORDER BY Name ASC;";
				$result = mysql_query($query, $con);
				
				$memberID = getCurrentMemberID();
				$exec = memberIsExec($memberID);
				
				while ($row = mysql_fetch_array($result))
				{
					print '<tr><td><a href="memberInfo.php?id=' . $row['ID'] . '">' . $row['Name'] . '</a></td>';
					if ($exec)
					{
						if ($row['ID'] == $memberID)
						{
							print '<td></td>';
						}
						else
						{
							if ($row['Executive'])
							{
								print '<td><button onclick="demoteMember(' . $row['ID'] . ')">Demote Member</button></td>';
							}
							else
							{
								print '<td><button onclick="promoteMember(' . $row['ID'] . ')">Promote Member</button></td>';
							}
						}
					}
					print '</tr>';
				}
			?>
		</tbody>
	</table>
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>
