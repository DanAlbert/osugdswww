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
		Okay, so last section we have a player that can rotate around and enemies appearing randomly on an invisible circle. We can at least get the enemies moving right now. We do this by adding an event listener to the ENTER FRAME, which will run a function every time the window draws a new frame, about 60 times a second (depending on what your project is set up as). We need to update our enemy class so that it can hold some velocity values. We will also give it an 'update' function so that it can update its position by adding its velocity to its x and y values.
	</p>
	
	<code>package  {
	import flash.display.Sprite;
	
	public class Enemy extends Sprite{
		
		public var speed:Number = 1.0;
		
		//these variables hold how much our enemies will move in the
		// x direction and y direction per frame.
		
		public var vx:Number;
		public var vy:Number;

		public function Enemy() 
		{
			drawEnemy();
		}
		
		public function drawEnemy()
		{
			graphics.lineStyle(1,0x000000);
			graphics.beginFill(0xFF0000);
			graphics.drawCircle(0,0,5);
		}
		
		//every time we call the enemies update function, it will add its velocity x and y values
		//to its position.
		public function update()
		{
			x += vx;
			y += vy;
		}
	}
}</code>
	
	<p>
		Now that our enemy is set up to be moved, we'll have to go to our main class and give the enemy its velocity, as well as call its update function once per frame.
	</p>

	<code>package  {
	import flash.display.MovieClip
	import flash.events.MouseEvent;
	import flash.utils.Timer;
	import flash.events.TimerEvent;
	import flash.events.Event;
	import flash.display.Sprite;
	
	public class MyGame extends MovieClip
	{
		public static const ENEMY_DISTANCE = 180;
		
		private var _player:Sprite;
		private var _enemies:Vector.&lt;Enemy&gt; = new Vector.&lt;Enemy&gt;;
		
		private var _enemyTimer:Timer;

		public function MyGame() 
		{
			//same as before
			
			//At the end of the game constructor we've added an event listener for entering the frame.
			//Once every frame the 'updateGame' function will run.  This is where all our update code will go.
			
			stage.addEventListener(Event.ENTER_FRAME, updateGame);
			
		}
		
		public function rotatePlayer(e:MouseEvent)
		{
			//same as before
		}
		
		public function addEnemy(e:TimerEvent)
		{
			//same as before
			
			//at the end of our addEnemy function we need the angle our enemy will be walking toward.
			//this angle is the opposite of the angle we used to determine it's position, so we subtract Math.PI
			//from it to rotate it one half of a revolution.
			
			var oppAngle = randAngle - Math.PI;
			
			//We initialize the enemies velocity values by using basic trig.  If our randAngle is 0, our oppAngle
			//is -Math.PI, and our velocity values are:
			//enemy.vx = 1.0 * Math.cos(-Math.PI) = -1;
			//enemy.vy = 1.0 * Math.sin(-Math.PI) = 0;
			
			enemy.vx = enemy.speed * Math.cos(oppAngle);
			enemy.vy = enemy.speed * Math.sin(oppAngle);
			
		}
		
		//this is our update game function that gets called every frame.
		public function updateGame(e:Event)
		{
			//this is the syntax for a 'for' loop.  This will run through each enemy in our _enemies Vector and run code on it.
			//right now we are running the enemies 'update' function that we gave it before.
			
			for(var i = 0; i &lt _enemies.length; i++)
			{
				_enemies[i].update();
			}
		}
	}
}</code>
	
	<p>
		If you run this you should see enemies coming toward you. Let's have it so that if they hit the player, the enemy disappears. That only require a change to our 'for' loop inside updateGame.
	</p>
	
	<code>for(var i = 0; i < _enemies.length; i++)
{
	_enemies[i].update();
	
	//hitTestObject is an actionscript function that belongs to all sprite objects.
	//It tests the bounding box of the first display object against the second display
	//object and will return 'true' if they intersect.
	//In this case, it tests our current enemy sprite against our player sprite.
	
	if(_enemies[i].hitTestObject(_player))
	{
		//if our sprites intersect, we remove the enemy from the display list by using removeChild
		removeChild(_enemies[i]);
		
		//we also must remove our enemy from our _enemies array by using the splice method.  The will delete
		//one element from the 'i' index.  This enemy will no longer be updated.
		
		_enemies.splice(i,1);
		
		//if we delete something from our array that we're looping through, we need to subtract from the 'i'
		//index or else elements in the _enemies array will be skipped from being checked.
		i--;
	}
}</code>
	
	<p>
		Now hopefully you can see that when the enemies get to the center of the screen, they disappear when they come into contact with the player. Now let's give him a chance to fight back! We'll create a new class for every bullet that the player fires. Call it the 'Bullet' class.
	</p>
	
	<code>package  {
	
	import flash.display.Sprite;
	public class Bullet extends Sprite
	{
		public var speed:Number = 4.0;
		public var vx:Number;
		public var vy:Number;
			
		public function Bullet() 
		{
			drawBullet();
		}
		
		public function drawBullet()
		{
			graphics.lineStyle(1,0x000000);
			graphics.beginFill(0x0000FF);
			graphics.drawCircle(0,0,3);
			graphics.endFill();
		}
		
		public function update()
		{
			x += vx;
			y += vy;
		}
	}	
}</code>
	
	<p>
		As you see, this looks almost identical to our enemy class. In the future we may want to add more variables to the bullet class, like a bullet 'type', but for now this will do. Now we want to fire these bullet's every time the player click the mouse button. We'll need another event listener.
	</p>

	<code>package  {
	import flash.display.MovieClip
	import flash.events.MouseEvent;
	import flash.utils.Timer;
	import flash.events.TimerEvent;
	import flash.events.Event;
	import flash.display.Sprite;
	
	public class MyGame extends MovieClip
	{
		public static const ENEMY_DISTANCE = 180;
		
		private var _player:Sprite;
		private var _enemies:Vector.&lt;Enemy&gt; = new Vector.&lt;Enemy&gt;;
		
		//this is our new bullets Vector that look the same as the one for our enemies.
		private var _bullets:Vector.&lt;Bullet&gt; = new Vector.&lt;Bullet&gt;;
		
		private var _enemyTimer:Timer;

		public function MyGame() 
		{
			//same as before
			
			//Now we're adding another eventListener that listens for when the mouse clicks.
			//On every mouse click we're calling the fireBullet function. 
			stage.addEventListener(MouseEvent.CLICK, fireBullet);
		}
		
		public function rotatePlayer(e:MouseEvent)
		{
			//same as before
		}
		
		public function addEnemy(e:TimerEvent)
		{
			//same as before
			
		}
		
		public function fireBullet(e:Event)
		{
			//create a new bullet and place it at the center of the stage;
			var bullet = new Bullet();
			bullet.x = stage.stageWidth/2;
			bullet.y = stage.stageHeight/2;
			
			//the angle that the bullet it travels in will equal the player's current angle.
			//this angle must be converted to radians
			var angle = _player.rotation / 180 * Math.PI;
			
			//we calculate the bullets velocity values the same way as we did for the enemy.
			bullet.vx = bullet.speed * Math.cos(angle);
			bullet.vy = bullet.speed * Math.sin(angle);
			
			//add the bullet to the display list and the _bullets Vector
			addChild(bullet);
			_bullets.push(bullet);
		}
		
		public function updateGame(e:Event)
		{
			//we need to update our bullets the same way we update our enemies.
			
			for(var i = 0; i < _bullets.length; i++)
			{
				_bullets[i].update();
			}
			
			for(var i = 0; i < _enemies.length; i++)
			{
				_enemies[i].update();
				
				if(_enemies[i].hitTestObject(_player))
				{
					removeChild(_enemies[i]);
					_enemies.splice(i,1);
					i--;
				}
			}
		}
	}
}</code>
	
	<p>
		Now you should see a bullet fly away from the player at every click of the mouse. We'll finish this section by checking whether enemy is intersecting a bullet every frame and deleting both if so. Only changes need to be made to updateGame function.
	</p>
	
	<code>public function updateGame(e:Event)
{
	for( i = 0; i < _bullets.length; i++)
	{
		_bullets[i].update();
	}
			
	for(var i = 0; i < _enemies.length; i++)
	{
		_enemies[i].update();
				
		if(_enemies[i].hitTestObject(_player))
		{
			removeChild(_enemies[i]);
			_enemies.splice(i,1);
			i--;
			
			//this break statement breaks out of the loop.  If the enemies hits a player, it doesn't need
			//to check all its bullets.
			break;
		}
		
		//inside of our enemies loop  we need to make another loop that loops through all the bullets.
		//for every enemy that we're checking, we check every bullet to see if it intersects with that enemy.
		
		for(var j = 0; j < _bullets.length; j++)
		{
			if(_enemies[i].hitTestObject(_bullets[j]))
			{
				//remove the enemy and the bullet in the collision from the display list and its respective array.
				removeChild(_enemies[i]);
				_enemies.splice(i,1);
				removeChild(_bullets[j]);
				_bullets.splice(j,1);
						
				//subtract the indexes
				i--;
				j--;
				
				//the break statement will quit running code in the for loop.  We know that if a bullet hits an enemy,
				//we no longer need to check if any other bullets hit the enemy since it will be dead.
				break;
			}
		}
	}
}</code>
	
	<p>
		Okay, that ends this section. Feel free to change any values that you think would work better. If everything works, you should have something that vaguely resembles gameplay now. Time to finish up our game in the last section!
	</p>
	
	<h2>Resources</h2>
	<ul>
		<li><a href="/osugds/resources/flash/Tutorial2.rar">Source</a></li>
	</ul>
	<div class="clear"></div>
</div> <!-- main -->

<?php
include '../../footer.php'
?>

</div> <!-- container -->

</body>
</html>

