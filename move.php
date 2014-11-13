<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

if ($_SESSION['ccid'] != 0)
{
	if (empty($_GET['x']))
	{
		header("Location: system.php");
		die();
	}
	if (empty($_GET['y']))
	{
		header("Location: system.php");
		die();
	}
} else {
	if (empty($_GET['x']))
	{
		header("Location: internet.php");
		die();
	}
	if (empty($_GET['y']))
	{
		header("Location: internet.php");
		die();
	}
}

$result = mysql_query("SELECT xpos, ypos, contractx, contracty, kb FROM users WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
$user = mysql_fetch_array($result);

if ($user['kb']<1)
{
	if ($_SESSION['ccid'] != 0)
	{
		header("Location: system.php");
		die();
	} else {
		header("Location: internet.php");
		die();
	}
}

if ($_SESSION['ccid'] != 0)
{
	if ($_GET['x'] > ($user['contractx']+1) OR $_GET['x'] < ($user['contractx']-1))
	{ // Can't move more than one square at a time!
		header("Location: system.php");
		die();
	}
	if ($_GET['y'] > ($user['contracty']+1) OR $_GET['y'] < ($user['contracty']-1))
	{ // Can't move more than one square at a time!
		header("Location: system.php");
		die();
	}
} else {
	if ($_GET['x'] > ($user['xpos']+1) OR $_GET['x'] < ($user['xpos']-1))
	{ // Can't move more than one square at a time!
		header("Location: internet.php");
		die();
	}
	if ($_GET['y'] > ($user['ypos']+1) OR $_GET['y'] < ($user['ypos']-1))
	{ // Can't move more than one square at a time!
		header("Location: internet.php");
		die();
	}
}


if ($_SESSION['ccid'] != 0)
{
	if ($_GET['x'] != $user['contractx'])
	{
	if ($_GET['y'] == $user['contracty'])
	{ // One of these variables has to stay unaltered by the requested movement.
		$result = mysql_query("SELECT id FROM systems WHERE xpos='" . $_GET['x'] . "' AND ypos='" . $user['contracty'] . "'") or die(mysql_error());
		if (mysql_num_rows($result) != 1)
		{ // The square at the new position must exist.
			header("Location: system.php");
			die();
		}
		$error=0;
		if ($_GET['x'] == ($user['contractx']-1))
		{ // if going left...
			$dir=0;
		}
		if ($_GET['x'] == ($user['contractx']+1))
		{ // if going right...
			$dir=0;
		}
	}
	}
} else {
	if ($_GET['x'] != $user['xpos'])
	{
	if ($_GET['y'] == $user['ypos'])
	{ // One of these variables has to stay unaltered by the requested movement.
	$result = mysql_query("SELECT id FROM nodes WHERE xpos='" . $_GET['x'] . "' AND ypos='" . $user['ypos'] . "'") or die(mysql_error());
	if (mysql_num_rows($result) != 1)
	{ // The node at the new position must exist.
		header("Location: internet.php");
		die();
	} else {
		$result = mysql_query("SELECT cangoleft, cangoright FROM nodes WHERE xpos='" . $user['xpos'] . "' AND ypos='" . $user['ypos'] . "'") or die(mysql_error());
		$node = mysql_fetch_array($result);
		$error=0;
		if ($_GET['x'] == ($user['xpos']-1))
		{ // if going left...
			$dir=0;
			if ($node['cangoleft']==0) {$error=1;}
		}
		if ($_GET['x'] == ($user['xpos']+1))
		{ // if going right...
			$dir=0;
			if ($node['cangoright']==0) {$error=1;}
		}
	}
	}
}
}

if ($_SESSION['ccid'] != 0)
{
	if ($_GET['y'] != $user['contracty'])
	{
	if ($_GET['x'] == $user['contractx'])
	{ // One of these variables has to stay unaltered by the requested movement.
		$result = mysql_query("SELECT id FROM systems WHERE ypos='" . $_GET['y'] . "' AND xpos='" . $user['contractx'] . "'") or die(mysql_error());
		if (mysql_num_rows($result) != 1)
		{ // The square at the new position must exist.
			header("Location: system.php");
			die();
		} else {
			$error=0;
			$dir=2;
			if ($_GET['y'] == ($user['contracty']-1))
			{ // if going down...
				$dir=1;
			}
			if ($_GET['y'] == ($user['contracty']+1))
			{ // if going up...
				$dir=1;
			}
		}
	}
	}
} else {
	if ($_GET['y'] != $user['ypos'])
	{
	if ($_GET['x'] == $user['xpos'])
	{ // One of these variables has to stay unaltered by the requested movement.
		$result = mysql_query("SELECT id FROM nodes WHERE ypos='" . $_GET['y'] . "' AND xpos='" . $user['xpos'] . "'") or die(mysql_error());
		if (mysql_num_rows($result) != 1)
		{ // The node at the new position must exist.
			header("Location: internet.php");
			die();
		} else {
			$result = mysql_query("SELECT cangoup, cangodown FROM nodes WHERE xpos='" . $user['xpos'] . "' AND ypos='" . $user['ypos'] . "'") or die(mysql_error());
			$node = mysql_fetch_array($result);
			$error=0;
			$dir=2;
			if ($_GET['y'] == ($user['ypos']-1))
			{ // if going down...
				$dir=1;
				if ($node['cangodown']==0) {$error=1;}
			}
			if ($_GET['y'] == ($user['ypos']+1))
			{ // if going up...
				$dir=1;
				if ($node['cangoup']==0) {$error=1;}
			}
		}
	}
	}
}

if ($error==1)
{
	header("Location: internet.php");
	die();
} else {
	// It's a valid movement! YAY!
	if ($_SESSION['ccid'] != 0)
	{
		if ($dir==0)
		{
			mysql_query("UPDATE users SET contractx='" . $_GET['x'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$_SESSION['ccxpos']=$_GET['x'];
			$_SESSION['kb']-=1;
		}
		if ($dir==1)
		{
			mysql_query("UPDATE users SET contracty='" . $_GET['y'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$_SESSION['ccypos']=$_GET['y'];
			$_SESSION['kb']-=1;
		}
		header("Location: system.php");
		die();
	} else {
		if ($dir==0)
		{
			mysql_query("UPDATE users SET xpos='" . $_GET['x'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$_SESSION['cxpos']=$_GET['x'];
			$_SESSION['kb']-=1;
		}
		if ($dir==1)
		{
			mysql_query("UPDATE users SET ypos='" . $_GET['y'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$_SESSION['cypos']=$_GET['y'];
			$_SESSION['kb']-=1;
		}
		header("Location: internet.php");
		die();
	}
}

}

?>