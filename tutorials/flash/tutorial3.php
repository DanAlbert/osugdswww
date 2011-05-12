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

<p>So what we have now I guess is what you could call a 'game'.  To make it so that it's actually fun to play (a small amount), there a couple things we need to do.

<list>
	<li> Make it so that the player can lose.
	<li> Guve the player some type of score that he has an incentive to beat.
	<li> Have the game be progressively harder the farther you go.
</list>

<p><p>Before we get to all that, there's a couple things I want to fix with our last project.  First, I noticed that a bullet won't fire if you click exactly on an enemy.
This has to do with the fact that your mouse click isn't registering with the 'stage', it's registering with the 'enemy'.  All that's needed to fix this is to set the
'mouseEnabled' property of our enemy class to false.  All display objects have a mouse enabled property that can disallow any interactivity with a mouse click.  Just put this
code in the 'addEnemy' function after you create an enemy.

<code><pre>
enemy.mouseEnabled = false
</pre></code>

Keep in mind that you could also set this code in the constructor of our enemy class.

<p><p>Next I realized that our bullet array could become very long, since objects that leave our screen are still being updated.  We could eventually have hundreds of bullet
objects flying off to who knows where, which could bog down our game.  To solve this we need to check every bullet if it is still inbounds per frame, and if it isn't, delete it
from our bullets array and from the display list.  Change the bullet 'for' loop in our 'updateGame' function.

<code><pre>

for( i = 0; i &lt; _bullets.length; i++)
{
	_bullets[i].update();
				
	//We remove a bullet if its not inBounds.
	//We check this using our function below.
	if(!checkInBounds(_bullets[i]))
	{
		removeChild(_bullets[i]);
		_bullets.splice(i,1);
		i--;
	}
}

</pre></code>

<p>This should be pretty familiar, except that  we still need to write our checkInBounds function.

<code><pre>

//Note that this function takes any display object so we could call this using a Sprite or Enemy
//or any other displayObject.
//It also returns a boolean value (true/false) depending on whether the object is in bounds or not.

public function checkInBounds(obj:DisplayObject):Boolean
{
	//if the x or y value is less than 0 or greater than the stage,
	//return false to indicate the object is not inbounds.
	if(obj.x &gt; stage.stageWidth ||
		obj.x &lt; 0 ||
		obj.y &gt; stage.stageHeight ||
		obj.y &lt; 0)
		return false;
		
	//return true if we haven't returned false
	return true;
}

</pre></code>

<p>Now that that's done, we can move on to adding functionality to our game.  First let's add a couple variables to hold our score
and our number of lives. Add these to our variables at the top of our MyGame class.

<code><pre>

private var _numLives:uint = 3;
private var _score:uint = 0;

</pre></code>

<p>All we really have to do now is increase the score every time we kill an enemy and decrease our lives when we die.

<code><pre>

for(var i = 0; i &lt; _enemies.length; i++)
{
	_enemies[i].update();
				
	if(_enemies[i].hitTestObject(_player))
	{
		<b>//Decrease lives if enemy hits player
		numLives--;</b>
		
		<b>//We also exit our function if we run out of lives so nothing else gets checked
		if(numLives == 0)return;</b>
					
		removeChild(_enemies[i]);
		_enemies.splice(i,1);
		i--;
		break;
	}
				
	for(var j = 0; j &lt; _bullets.length; j++)
	{
		if(_enemies[i].hitTestObject(_bullets[j]))
		{
			<b>//Increase score if bullet hits an enemy.
			score++;</b>
						
			removeChild(_enemies[i]);
			_enemies.splice(i,1);
			removeChild(_bullets[j]);
			_bullets.splice(j,1);
					
			i--;
			j--;
			break;
		}
	}
}

</pre></code>

<p>This isn't going to work if we plug this in, because notice that I used variables called numScore and score instead of _numScore and _score.
You may have been wondering why are variables generally have an underscore underneath them, and this is where we learn about getter and setter functions.
I'll post the code and explain it after.

<code><pre>

public function get score():uint
{
	return _score;
}

public function set score(score:uint)
{
	_score = score;
}

public function get numLives():uint
{
	return _numLives;
}

public function set numLives(lives:uint)
{
	_numLives = lives;
}

</pre></code>

With these functions our increase of score and numLives should work.  Using getter and setter functions do two things, they allow us to access private memners
of other classes, which is something we don't need for this project, and we can run other code whenever we get or set a variable.  For instance, we may want to
check whether _numLives is equal to zero every time we set it, and end the game if it is.  So we change the _numLives setter function to this:

<code><pre>

public function set numLives(lives:uint)
{
	_numLives = lives
	
	if(_numLives == 0)endGame();
}
</pre></code>
Now whenever we set numLives, it will change the _numLives variable and check whether is is zero, and run the endGame function if it is.  Let's program our endGame function.

<code><pre>

//At the end of the game we remove all our bullets and enemies (We don't need to splice because we will be creating
//a completely new array anyway).  We also remove the player and our head, stop the timer, and remove all our event
//listeners.  We then call the init function with a value of false indicating that this is not our first game.
public function endGame()
{
	for(var i = 0; i &lt; _bullets.length; i++)
	{
		removeChild(_bullets[i]);
	}
	for(i = 0; i &lt; _enemies.length; i++)
	{
		removeChild(_enemies[i]);
	}
	removeChild(_player);
			
	_enemyTimer.stop();
	_enemyTimer.removeEventListener(TimerEvent.TIMER, addEnemy);
			
	stage.removeEventListener(MouseEvent.MOUSE_MOVE, rotatePlayer);
	stage.removeEventListener(Event.ENTER_FRAME, updateGame);
	stage.removeEventListener(MouseEvent.CLICK, fireBullet);
			
}

</code></pre>
In the above function we remove all our display objects, stop our timer, and remove all our event listeners.  If you play the game now and get hit three times you should
see a blank white screen.

<p>Next let's let the player see his score and number of lives with an on screen HUD.  If we ever want text on the screen we need to use flash's TextField object.
We'll need to import a couple of classes.
<code><pre>

//allows us to use text fields
import flash.text.TextField;

//allows greater formatting of our text
import flash.text.TextFormat;

</code></pre>

And we need a new variable to hold our hud text.

<code><pre>
_hudText:TextField = new TextField();
</pre></code>

We'll also create a new function to set up our hudTextField, which should be called in the constructor of our MyGame class.

<code><pre>

public function setHudTextField()
{
	var tFormat:TextFormat = new TextFormat();
	tFormat.font = "Arial";
	tFormat.size = 20;
	tFormat.bold = true;
	tFormat.color = 0x000000;
			
	_hudText.defaultTextFormat = tFormat;	//Sets the text field information to read from our TextFormat above
	_hudText.width = 500;
	_hudText.selectable = false;		//allows text to be selectable by mouse
	addChild(_hudText);					//adds textfield to the display list like any other display object
}

</code></pre>

Hopefully some of this is self explanatory.  Whenever you want to have text field on a screen you will need to set up many of these same parameters.
We can also set the 'x' and 'y' values of a text field, but since we want the textfield to be in the upper left corner of our screen, we can keep the default
position values which are (0,0).

<p>We're going to do three things next, write a function that sets the text of our HUD, and change a couple setter functions so that our HUD will change based
on the values of our score and lives.

<code><pre>

//This is called every time the score or number of lives changes using the 
//set score and set numLives methods.

public function setHudText()
{
	//We convert our _score and _numLives values to strings using the toString() method
	_hudText.text = "Lives: " + _numLives.toString() + "		" +
					"Score: " + _score.toString();
}

public function set score(score:uint)
{
	_score = score;
			
	//The score changes so our hud must reflect that
	setHudText();
		
}
	
public function set numLives(lives:uint)
{
	_numLives = lives;
	
	setHudText();

	if(_numLives == 0)endGame();
}

</pre></code>

Now every time our _numLives or _score changes, we call the setHudText function which will reset the text to our new values of _numLives and _score.
<b>Keep in my mind that we must also call the setHudText() function in the constructor so that the text appears at the start of the game</b>

<p><p>The last thing I'm going to go through is making the game harder as we go.  There's a few ways we could do this, but I decided the following rule:
	<list><li>For every ten points we score, make the enemies speed and spawn time ten percent faster.</li><list>
	<p><p>For this I've made a new variable to store our speed multiplier and the time for our enemy spawn.
<code><pre>
private var _speedMultiplier = 1.0;
private var _enemyTimerValue = 1500;
</pre></code>

There's a few thing we have to change.  First we have to change the way we start the enemy timer in our constructor to this:

<code><pre>
_enemyTimer = new Timer(_enemyTimerValue);
</pre></code>

<p>Also, every time we create an enemy we have to multiply its speed by our speed multiplier value in our 'addEnemy' function.

<code><pre>
enemy.vx = enemy.speed * _speedMultiplier * Math.cos(oppAngle);
enemy.vy = enemy.speed * _speedMultiplier * Math.sin(oppAngle);
</code></pre>

I've also increased our bullet's speed the same way in our 'AddBullet' function, but I suppose you wouldn't have to.

<p>The last and most important thing we have to do is change these new variables so that they affect our enemies.  Since we'll want to check whether our
score is a certain value we'll need to change our set score function.  Here's the code.

<code><pre>
//This is a setter function, which allows to run code every time we set score to a value (et. score = 5)
public function set score(score:uint)
{
	_score = score;
			
	setHudText();
			
			
	//This is a modulus operator which gives us the remainder of dividing the score and ten.
	//It will only be 0 if score is evenly divisible by 10 (30,40,50,etc.)
	if(_score%10 == 0)
	{
		//Increase our speedMultiplier by ten percent and decrease our timer value by ten percent
		_speedMultiplier += 0.1 * _speedMultiplier;
		_enemyTimerValue -= 0.1 * _enemyTimerValue;
				
		//Reset the timer so that its now running on the new timer value.
		//All these steps must be done.
		_enemyTimer.removeEventListener(TimerEvent.TIMER, addEnemy);
		_enemyTimer = new Timer(_enemyTimerValue);
		_enemyTimer.start();
		_enemyTimer.addEventListener(TimerEvent.TIMER, addEnemy);
	}
}
</code></pre>

That should just about do it.  You should see your enemies moving fast and appearing fast as your score gets higher.  I think that's the last part I'm going to specifically go over.
The final product looks a little bit different than it does here, but it shouldn't be anything new.  In the source files you'll see I've done the following things:
<p><list>
	<li>Moved everything out of the constructor and into a startGame function.
	<li>Added an 'init' function that display a Play button, which when clicked, will start a Game.
</list>
<p><p>There's a few other little things, but I'll try to heavily comment the code so that it's easy to understand.  If you're interested in much more competant and thorough tutorials
in the same vein as this one, there's a book called <a href = "http://www.amazon.com/ActionScript-3-0-Game-Programming-University/dp/0789747324/ref=sr_1_1?ie=UTF8&s=books&qid=1301866105&sr=8-1">
ActionScript 3.0 Game Programming University</a> that has many examples like the one here.

<p><p>
At this point there's many things you could do to expand upon this example.  You could do have bullets fired based not on mouse click but on holding the mouse button down (by listening for the
MouseEvent.MOUSE_DOWN, and MousEvent.MOUSE_UP events), or you could even have the player move around with arrow keys.  You could also make a more permanent high score setting, but you'll have to
look up Flash's SharedObject class.  I'm sure there are a few tutorials on it.  One of the easier things to do is put in your own graphics, but each Flash environment has a slightly different way
doing this, although it's easy to find out.  If you have any questions about this tutorial or any other game questions give us an email or contact one of us
at a meeting.  Thanks for reading the tutorial and I hope you enjoyed it!



	<h2>Resources</h2>
	<ul>
		<li><a href="/osugds/resources/flash/Tutorial3.rar">Source</a></li>
	</ul>
	<div class="clear"></div>
</div> <!-- main -->

<?php
include '../../footer.php'
?>

</div> <!-- container -->

</body>
</html>
