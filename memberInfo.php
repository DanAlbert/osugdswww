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
	<!--<div class="notice">
		<h2>Under Construction</h2>
		<p>
			This web site is currently under construction. Please check back
			later for updates.
		</p>
	</div>-->
	
	<?php
		require_once 'mysql.php';
		require_once 'projects.php';
		
		$member = new Member($_REQUEST['id']);
		$member->printInfo();
		
		class Member
		{
			private $name;
			private $executive;
			private $projects;
			
			function __construct($id)
			{
				$this->projects = array();
				$this->loadMember($id);
			}
			
			public function isValid()
			{
				return ($this->name != '__INVALID__');
			}
			
			public function getName()
			{
				return $this->name;
			}
			
			public function getExecutive()
			{
				return $this->executive;
			}
			
			public function getProjects()
			{
				return $this->projects;
			}
			
			public function loadMember($id)
			{
				$con = dbConnect();
				if (!$con)
				{
					$this->name = '__INVALID__';
					return;
				}
				
				$query = "SELECT Name, Executive FROM Members WHERE ID='" . $id . "';";
				$result = mysql_query($query, $con);
				
				$row = mysql_fetch_array($result);
				$this->name = $row['Name'];
				$this->executive= $row['Executive'];
				
				$query = "SELECT ProjectID FROM ProjectMembers WHERE MemberID='" . $id . "';";
				$result = mysql_query($query, $con);
				
				while ($row = mysql_fetch_array($result))
				{
					$this->projects[] = $row['ProjectID'];
				}
			}
			
			public function printInfo()
			{
				print '<div class="project-container"><h2 class="group-title">';
				print $this->name;
				if ($this->executive)
				{
					print ' - Executive';
				}
				print '</h2><h3>Projects:</h3><p>';
				
				$first = true;
				foreach ($this->projects as $project)
				{
					if (!$first)
					{
						print ', ';
					}
					else
					{
						$first = false;
					}
					
					print '<a href="/osugds/galleries.php#' . $project . '">' . getProjectTitle($project) . '</a>';
				}
				print '<div class="clear"></div></div>';
				/*<div class="project-container">
					<img src="" />
					
					<h2 class="group-title"><a href="/osugds/project.php?title=foobar">Project FooBar</a></h2>
					<h3>Project Members:</h3>
					<p>
						Obi-wan Kenobi, Jean-Luc Picard, The Batman
					</p>
					<br />
					<h4>Description:</h4>
					<p>
						Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut
						ligula pulvinar odio tempus suscipit sagittis non erat. Suspendisse
						elementum imperdiet augue sit amet volutpat. Duis aliquet ultrices
						sem molestie iaculis. Quisque placerat posuere mattis.
					</p>
					<div class="clear"></div>
				</div>*/
			}
		};
	?>
	
	<!--<div class="project-container">
		<img src="" />
		
		<h2 class="group-title"><a href="/osugds/project.php?title=foobar">Project FooBar</a></h2>
		<h3>Project Members:</h3>
		<p>
			Obi-wan Kenobi, Jean-Luc Picard, The Batman
		</p>
		<br />
		<h4>Description:</h4>
		<p>
			Lorem ipsum dolor sit amet, consectetur adipiscing elit. Cras ut
			ligula pulvinar odio tempus suscipit sagittis non erat. Suspendisse
			elementum imperdiet augue sit amet volutpat. Duis aliquet ultrices
			sem molestie iaculis. Quisque placerat posuere mattis.
		</p>
		<div class="clear"></div>
	</div>-->
	
	<div class="clear"></div>
</div> <!-- main -->

<?php
include 'footer.php'
?>

</div> <!-- container -->

</body>
</html>

