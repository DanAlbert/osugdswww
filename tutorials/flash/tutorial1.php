<html>
<head>
	<title>OSU Game Design Studios</title>
	<meta name="author" content="Dan Albert" />
	<link rel="stylesheet" type="text/css" href="/osugds/style.css" />
</head>
<body>

<div id="container">

<?php
include '../../header.php';
include '../../nav.php';
?>

<div id="main">
	<div class="notice">
		<h2>Under Construction</h2>
		<p>
			This web site is currently under construction. Please check back
			later for updates.
		</p>
	</div>
	
	<p>
		Welcome to your first (or one of your first) tutorials to creating games in Flash Actionscript!
	</p>
	<p>
		In this tutorial I hope to guide you step by step in creating your own game.
	</p>
	<p>
		Firstly, you'll need to install some sort of Actionscript environment. You can do this by either buying Flash Professional or Flex Builder, but if you want to compile Actionscript code for free, download Flash Develop. I'm going to try and make this as environment friendly as possible, so you may have to figure out basic things like starting a new project based on which environment you're working in. I may also skip through basic programming skills. If you have any questions ask one of us.
	</p>
	<p>
		Open up whichever actionscript environment you're working in and start a New Flash Project. Name it whatever you want. Now add a new Actionscript 3 class to your project and name it 'MyGame'. This will be the main document for our game. You should see code similar to this:
	</p>
	<code>package  {
	public class MyGame {
		public function MyGame() {
			// constructor code
		}
	}	
}</code>
	
	<p>
		Our main class will always need to inherit the properties of an actionscript display object like sprite or movieclip. Don't worry too much about the details for now, but change the following line from this:
	</p>
	
	<code>public class MyGame {</code>
	
	<p>
		To this:
	</p>
	<code>public class MyGame extends MovieClip {</code>
	
	<p>
		We also need to import the Movieclip class, so below the package line write:
	</p>
	
	<code>package {
	import flash.display.MovieClip;</code>
	
	<p>
		From here we need to figure out what kind of game we want to make. It's probably not necessary to plan out every single class with smaller projects, but you should at least have an idea of how the game is going to play. In my game I want the following things to happen:
	</p>
	
	<ul>
		<li>The player's character is always in the center of the screen.</li>
		<li>The player's character always points to where the mouse is at on the screen.</li>
		<li>Every time the user click the player will fire a bullet in the direction he's pointing.</li>
		<li>Enemies will storm in from the sides to attack the player.</li>
		<li>If an enemy touches the player, the player loses a life and the enemy disappears.</li>
		<li>If one of the player's bullets hits an enemy, the bullet and enemy disappear and the player scores a point.</li>
		<li>Enemies get faster and faster as the game goes on.</li>
	</ul>
	
	<p>
		That's quite a list, but if we take things one step at a time it shouldn't be too difficult. First let's draw our player. Our player will simply be a sprite, which we will draw a triangle on. We will then place the sprite in the middle of the screen. The full code is as follows.
	</p>
	
	<code>package  {
	import flash.display.MovieClip
	import flash.display.Sprite;
	
	public class MyGame extends MovieClip
	{
		//initializes a variable of Sprite type called _player
		private var _player:Sprite = new Sprite();

		public function MyGame() 
		{
			//all sprites have an x and a y value that indicates where on the screen the sprite is located.
		
			//Our stage is like our game window.  The two properties stageWidth and stageHeight can tell use how
			//wide and how high our window is.  Dividing each one by two will place our sprite in the middle of the screen.
			
			_player.x = stage.stageWidth/2;		//set x value on player sprite to half our window width	
			_player.y = stage.stageHeight/2;	//set y value on player sprite to half our window height
			
			addChild(_player);			//any display object like a sprite or movieclip must be added to the scene through addChild to be seen
			drawPlayer();				//this is the function we're calling to draw our player.
		}
		
		public function drawPlayer()
		{
			//Every sprite has a drawing API that can draw basic lines.
			
			_player.graphics.lineStyle(2,0x000000);		//sets thickness of lines (2), and color(black) of the player Sprite
			_player.graphics.moveTo(10,0);				//moves the "pen" ten pixels to the right
			_player.graphics.lineTo(-10,5);				//draws a line left and down
			_player.graphics.lineTo(-10,-5);			//draw a line straight up
			_player.graphics.lineTo(10,0);				//draws a line to our first point, this completes our triangle
		}
	}
}</code>
	
	<p>
		If you compile the above code, you should see a black triangle in the middle of the screen. Kind of boring right now. Next we can have our sprite rotate to our mouse position no matter where our mouse is located. All new code will have comments.
	</p>
	
	<code>package  {
	import flash.display.MovieClip;
	import flash.display.Sprite;
	
	//need to import the MouseEvent class
	import flash.events.MouseEvent;
	
	public class MyGame extends MovieClip
	{
		private var _player:Sprite = new Sprite();

		public function MyGame() 
		{
			_player.x = stage.stageWidth/2;			
			_player.y = stage.stageHeight/2;
			
			addChild(_player);
			drawPlayer();
			
			//We add an 'EventListener' to our stage.  Every time our mouse moves, we send an event to our program.
			//Since we are listening for this event, it will run the function 'rotatePlayer'.
			
			stage.addEventListener(MouseEvent.MOUSE_MOVE, rotatePlayer);
		}
		
		//if a function is being called from an eventlistener it must have an event as its only parameter, in this case a MouseEvent
		public function rotatePlayer(e:MouseEvent)
		{
			//We need to find the angle between our mouse position and our player position.
			//To do this, we can take the tangent of the length of the opposite side (the y difference between mouse and player),
			//and the length of the adjacent side (the x difference between mouse and player)
			
			//this will give us the angle in radians
			var angle:Number = Math.atan2(mouseY - _player.y, mouseX - _player.x);
			
			//every sprite has a rotation value, but it must be in degrees.
			//The following equation will convert our angle from radians to degrees.
			angle = angle * 180 / Math.PI;
			
			//set the player sprite's rotation
			_player.rotation = angle;
		}
		
		public function drawPlayer()
		{
			//Every sprite has a drawing API that can draw basic lines.
			
			_player.graphics.lineStyle(2,0x000000);		
			_player.graphics.moveTo(10,0);				
			_player.graphics.lineTo(-10,5);				
			_player.graphics.lineTo(-10,-5);
			_player.graphics.lineTo(10,0);	
		}
	}
}</code>
	
	<p>
		Now you can move your mouse around and the sprite should be pointing to it no matter where you go. We'll do one last thing for this first part, and that's add enemies. Start a whole new Actionscript 3 class and name it Enemy. The code for the enemy class is as follows.
	</p>
	
	<code>package  {
	import flash.display.Sprite;
	
	public class Enemy extends Sprite{

		//The following is a constructor function.  This gets called whenever we create a new enemy.
		//All it does right now is call the drawEnemy function, which draws the enemy in a similar way to how we drew the player.
		
		public function Enemy()
		{
			drawEnemy();
		}
		
		public function drawEnemy()
		{
			graphics.lineStyle(1,0x000000);
			graphics.beginFill(0xFF0000);		//Sets up the fill color for solid objects (this is red in hex)
			graphics.drawCircle(0,0,5);			//draws a circle at 0,0 with a radius of 5.  There is also a similar drawRect command.
		}
	}
}</code>
	
	<p>
		As you can see this is pretty much what our player looks like. I've given enemies their own class because I expect that I will want them to move around, and each enemy will need its own properties to know which direction to move in. Let's create some enemies on screen. This will be the final part of this section.
	</p>
	
	<code>package  {
	import flash.display.MovieClip
	import flash.events.MouseEvent;
	import flash.display.Sprite;
	
	//importing these classes so we can use Timers and listen for TimerEvents
	
	import flash.utils.Timer;
	import flash.events.TimerEvent;
	
	public class MyGame extends MovieClip
	{
		//this will be a constant distance telling us how far away from the player enemies should spawn
		public static const ENEMY_DISTANCE = 180;
		
		private var _player:Sprite;
		
		//This variable will contain a list of our enemies on screen, similar to an array
		
		private var _enemies:Vector.<Enemy> = new Vector.<Enemy>;
		
		//this timer will tell us when to create a new enemy
		private var _enemyTimer:Timer;

		public function MyGame() 
		{
			_player = new Sprite();
			_player.x = stage.stageWidth/2;
			_player.y = stage.stageHeight/2;
			addChild(_player);
			drawPlayer();
			
			//we initialize the timer to tick after 1000 milliseconds or one second.
			_enemyTimer = new Timer(1000);
			
			//start the timer so it counts down
			_enemyTimer.start();
			
			//the timer will dispatch the 'TIMER' TimerEvent when it triggers.
			//When this happens the addEnemy function will be called.
			
			_enemyTimer.addEventListener(TimerEvent.TIMER, addEnemy);
			
			stage.addEventListener(MouseEvent.MOUSE_MOVE, rotatePlayer);
		}
		
		public function drawPlayer()
		{
			//same as last time
		}

		public function rotatePlayer(e:MouseEvent)
		{
			//same as last time
		}
		
		//our addEnemy function is called due to a TimerEvent
		public function addEnemy(e:TimerEvent)
		{
			//creates a random angle.
			//The Math.random() function returns a random number between 0 and 1. This is then multiplied
			//by two PI to give use a completely random angle.
			
			var randAngle:Number = Math.random() * 2*Math.PI;
			
			//creates a new Enemy
			var enemy:Enemy = new Enemy();
			
			//sets our new enemy sprite on a circle 180 pixels away from our player.
			//if our angle is 0 degrees, our enemy position would be
			// enemy.x = 180 * Math.cos(0) = 0;
			// enemy.y = 180 * Math.sin(0) = 180;
			// plus the center of our stage
			
			enemy.x = ENEMY_DISTANCE * Math.cos(randAngle) + stage.stageWidth/2;
			enemy.y = ENEMY_DISTANCE * Math.sin(randAngle) + stage.stageHeight/2;
			
			//adds this enemy to our list of enemies
			_enemies.push(enemy);
			
			//our enemy is a sprite and muse be added to the display list to be seen.
			addChild(enemy);	
		}
	}
}</code>
	
	<p>
		Well, now we have a player that rotates around and random circles that appear on the perimeter. It doesn't look like much, but in the next part we'll have the enemies attack our player and give our player a way to fight back.
	</p>
	
	<h2>Resources</h2>
	<ul>
		<li><a href="/osugds/resources/flash/Tutorial1.rar">Source</a></li>
	</ul>
	<div class="clear"></div>
</div> <!-- main -->

<?php
include '../../footer.php'
?>

</div> <!-- container -->

</body>
</html>

