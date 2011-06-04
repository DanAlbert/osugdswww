<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
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
				
				$query = "SELECT ID, Name FROM Members ORDER BY Name ASC;";
				$result = mysql_query($query, $con);
				
				while ($row = mysql_fetch_array($result))
				{
					print '<tr><td><a href="memberInfo.php?id=' . $row['ID'] . '">' . $row['Name'] . '</a></td>';
					if (memberIsExec(getCurrentMemberID()))
					{
						if (memberIsExec($row['ID']))
						{
							print '<td><button onclick="demoteMember(' . $row['ID'] . ')">Demote Member</button></td>';
						}
						else
						{
							print '<td><button onclick="promoteMember(' . $row['ID'] . ')">Promote Member</button></td>';
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

