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
	
	<?php
		$projects = getProjects();
		foreach ($projects as $project)
		{
			$project->printGallery();
		}
		
		class Project
		{
			private $title;
			private $description;
			private $imageURL;
			private $repoURL;
			private $projectURL;
			private $members;
			
			function __construct(
				$title,
				$description,
				$imageURL,
				$repoURL,
				$projectURL,
				$members)
			{
				$this->title = $title;
				$this->description = $description;
				$this->imageURL = $imageURL;
				$this->repoURL = $repoURL;
				$this->projectURL = $projectURL;
				$this->members = $members;
			}
			
			public function getTitle()
			{
				return $this->title;
			}
			
			public function getDescription()
			{
				return $this->description;
			}
			
			public function getImageURL()
			{
				return $this->imageURL;
			}
			
			public function getRepoURL()
			{
				return $this->repoURL;
			}
			
			public function getProjectURL()
			{
				return $this->projectURL;
			}
			
			public function getMembers()
			{
				return $this->members;
			}
			
			public function printGallery()
			{
				$membersString = '';
				
				$first = true;
				foreach ($this->members as $member)
				{
					if (!$first)
					{
						$membersString .= ', ';
					}
					
					$membersString .= $member['name'];
					
					$first = false;
				}
				
				print '<div class="project-container"><img src="' .
					$this->imageURL . '" /><h2><a href="'.
					$this->projectURL . '">' . $this->title . '</a></h2>' .
					'<h3>Project Members</h3><p>' . $membersString .
					'</p><br /><h4>Description:</h4><p>' .
					$this->description . '</p><div class="clear"></div>' .
					'</div>';
				
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
		
		function getProjects()
		{
			require_once 'mysql.php';
			require_once 'projects.php';
			
			$projects = array();
			
			$con = dbConnect();
			if (!$con)
			{
				print 'Unable to connect to database: ' . mysql_error();
			}
			else
			{
				$sql = mysql_real_escape_string('SELECT ID, Title, ' .
					'Description, ImageURL, RepoURL, ProjectURL FROM ' .
					'Projects ORDER BY Title DESC;');
				
				$result = mysql_query($sql, $con);
				
				while ($row = mysql_fetch_array($result))
				{
					$members = getProjectMembers($row['ID']);
					
					$projects[] = new Project(
						$row['Title'],
						$row['Description'],
						$row['ImageURL'],
						$row['RepoURL'],
						$row['ProjectURL'],
						$members);
				}
				
				mysql_close($con);
			}
			
			return $projects;
		}
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

