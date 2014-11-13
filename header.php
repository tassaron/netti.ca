<?php

echo '<!DOCTYPE HTML PUBLIC "-//W3C//DTD HTML 4.01//EN" "http://www.w3.org/TR/html4/strict.dtd">';
echo '<html><head>';
echo '<meta http-equiv="Content-Type" content="text/html;charset=utf-8">';
echo '<meta name="description" content="An online hacking simulation MMORPG. Travel across the internet to hack other players and fulfill contracts.">';
echo '<meta name="keywords" content="nettica, hackers, crackers, hacking, mmorpg, mmo, simulation, decker, cyberpunk, matrix">';
echo '<link rel="shortcut icon" href="favicon.ico" type="image/x-icon">';

if ($_SESSION['authorized'] != 0)
{
	if ($_SESSION['style'] != 1)
	{
		echo '<link rel="stylesheet" href="/style/style' . $_SESSION['style'] . '.css" type="text/css">';
	} else {
		echo '<link rel="stylesheet" href="style.css" type="text/css">';
	}
} else {
	echo '<link rel="stylesheet" href="style.css" type="text/css">';
}

if (empty($title))
{
	echo '<title>Nettica</title></head>';
} elseif (empty($title2)) {
	echo '<title>Nettica \\ ' . $title . '</title></head>';
} else {
	echo '<title>Nettica \\ ' . $title . ' \\ ' . $title2 . '</title></head>';
}

echo '<body>';

// Make sure we're not in maintenance mode.
if ($maintenance != 0)
{
	echo '<div id="wrapper">';
	echo '<div id="header">Nettica</div><div id="nav"></div>';
	echo '<div id="content"><div class="error">' . $maintenance_msg . '</div>';
	include 'footer.php';
	die;
}

// Load low-level site settings.
$result = mysql_query("SELECT value FROM settings WHERE id='subtitle'") or die(mysql_error());
$settings = mysql_fetch_array( $result );
$subtitle = stripslashes($settings['value']);

if ($_SESSION['authorized']==false)
{
	echo '<div id="bge1">';
	echo '<div id="bge2">';
	echo '<div id="bge3">';
	echo '<div id="wrapper">';
	echo '<div id="header">Nettica<br><div class="subtitle">' . $subtitle . '</div></div>';
} else {
	echo '<div id="bge1">';
	echo '<div id="bge2">';
	echo '<div id="bge3">';
	echo '<div id="wrapper">';
	echo '<div id="header">';
	if ($_SESSION['style'] != 6)
	{
		echo 'Nettica<br><div class="subtitle">' . $subtitle . '</div>';
	}
	echo '</div>';
}


echo '<div id="nav">';

// If user is logged in, display stats etc. before the rest.
if ($_SESSION['authorized'] != 0)
{
	$result = mysql_query("SELECT * FROM prefs WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
	$prefs=mysql_fetch_array($result);
	// Set pertinent user variables...
	$result = mysql_query("SELECT id, user, avatar, `group`, lvl, exp, phealth, mhealth, cash, kb, bandw, lastseen, contractid FROM users WHERE id='" . $_SESSION['cid']  . "'") or die(mysql_error());
	$row = mysql_fetch_array( $result );
	$curtime=time();
	mysql_query("UPDATE `users` SET `lastrel`='" . $curtime . "' WHERE `id`='" . $_SESSION['cid'] . "'") or die(mysql_error());

	// Determine if user has unread emails to check.
	$new=0;
	$result = mysql_query("SELECT `read` FROM email WHERE recipient='" . $row['id'] . "'") or die(mysql_error());
	while($unread = mysql_fetch_array( $result ))
	{
		if ($unread['read']==0)
		{
			$new+=1;
		}
	}

	// Echo the stats.
	echo '<div style="width: 100px; height: 100px; background: url(' . $row['avatar'] . '); background-repeat: norepeat;"><span style="text-align: center; background-color: #000000;"><a style="color: #FFFFFF;" href="/profile.php">' . $row['user'] . '</a></span></div>';
	echo "<span class='highlight'>Level</span> " . $row['lvl'] . "<br>";
	echo "<span class='highlight'>EXP</span> " . $row['exp'] . "<br>";
	echo "<span class='highlight'>Physical</span> " . $row['phealth'] . "%<br>";
	echo "<span class='highlight'>Mental</span> " . $row['mhealth'] . "%<br>";
	echo "<span class='highlight'>Cash</span> $" . $row['cash'] . "<br>";
	
	// Check if the current bandw is capable of being increased...
	if ($row['kb']<($row['bandw']+$kb_max))
	{
		$minutessince=(($curtime-$row['lastseen'])/$kb_rate);
		$newkb=floor($minutessince); // always round down
		if ($newkb>0)
		{
			if (($row['kb']+$newkb)>=($row['bandw']+$kb_max))
			{
				mysql_query("UPDATE `users` SET `kb`=('" . $row['bandw'] . "'+" . $kb_max . ") WHERE `id`='" . $_SESSION['cid'] . "'") or die(mysql_error());
				$_SESSION['kb']=($row['bandw']+$kb_max);
			} else {
				mysql_query("UPDATE `users` SET `kb`=(kb+'" . $newkb . "') WHERE `id`='" . $_SESSION['cid'] . "'") or die(mysql_error());
				$_SESSION['kb']=($row['kb']+$newkb);
			}
			// Now, preserve the remainder of $minutessince to quell unfair loss of kb...
			// Essentially, this makes sure that 1.95 turns into 0.95 instead of 0.00
			$lastseen2=0;
			while ($newkb>0)
			{
				$lastseen2+=$kb_rate;
				$newkb-=1;
			}
			mysql_query("UPDATE `users` SET `lastseen`=(lastseen+'" . $lastseen2 . "') WHERE `id`='" . $_SESSION['cid'] . "'") or die(mysql_error());
		}
	}
	$percentkb = ($_SESSION['kb'] / $kb_max) * 100;
	if ($prefs['kbbar']==1)
	{
		echo '<div class="badkb" style="width: 102px;">';
		if ($percentkb>99)
		{ // for stylesheets with dotted lines, don't show one if the bandw is 100% full
			echo '<div class="goodkb" style="width: ' . $percentkb . '%; border-right: 0px;">';
		} else {
			echo '<div class="goodkb" style="width: ' . $percentkb . '%;">';
		}
		if ($prefs['kbpercent']==1)
		{
			echo $percentkb . '%</div></div><br>';
		} else {
			echo $_SESSION['kb'] . '&nbsp;kb</div></div><br>';
		}
	} else {
		if ($prefs['kbpercent']==1)
		{
			echo $percentkb . '%<br><br>';
		} else {
			echo $_SESSION['kb'] . '&nbsp;kb<br><br>';
		}
	}

	// Echo the logged-in links.
	echo '<a href="/install.php">Hard drive</a><br>';
	echo '<a href="/create.php">Create</a><br>';
	echo '<a href="/hardware.php">Hardware</a><br>';
	echo '<a href="/software.php">Software</a><br>';
	echo '<a href="/contracts.php">Contracts</a><br>';
	
	if ($row['contractid'] != 0)
	{
		echo '<a href="/system.php">Internet</a><br><br>';
	} else {
		echo '<a href="/internet.php">Internet</a><br><br>';
	}

	echo '<a href="/email.php">Email</a>';
	if ($new != 0)
	{
		echo '<span class="highlight">[' . $new . ']</span>';
	}
	echo '<br><a href="/clan.php">Clan</a><br>';
	echo '<a href="/forum.php">Forum</a>';
	//include 'unread.php';
	echo '<br>';
	echo '<a href="/help.php">Help</a><br><br>';
}
?>

<a href="/index.php">Home</a><br>
<a href="/about.php">About</a><br>
<a href="/users.php">Users</a><br>

<?php
if ($_SESSION['authorized'] == 0)
{
	echo '<a href="/register.php">Register</a><br>';
	echo '<a href="/login.php">Login</a><br>';
} else {
	echo '<a href="/login.php">Logout</a>';
	// Show admin link if user is an admin.
	if ($_SESSION['cgroup']==7)
	{
		echo '<br><a href="/admin.php">Admin</a>';
	}
}
?>

</div>

<div id="content"><br>

<?php
// If user is banned, fuck 'em!
if ($_SESSION['cgroup']==8)
{
	echo 'Fuck you!';
	include 'footer.php';
	die();
}

if ($row['lvl']==1)
{
	echo '<div class="notification">It seems you\'re new to Nettica. If you don\'t know what to do, get some ';
	echo '<a href="/help.php">help</a>, then jump right into the tutorial at <a href="/internet.php">Nettica University</a>. ';
	echo 'Happy hacking!</div><p>';
}

?>