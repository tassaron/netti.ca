<?php
/*
require 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {

if ($_POST['formPostSubmit']==Submit)
{
	$error=0;
	$message = $_POST['formPost'];
	require_once 'bbc.php';

    $stringParser = new Parsers/BBCodeParser;

    $parsedString = $mysqli->real_escape_string($stringParser->parseString($message));

	$msglength = strlen($message);
	if (empty($message))
	{
		$error=1;
	} elseif ($msglength > $maxtextarealength) {
		$error=2;
	}

	if ($error==0)
	{	
		mysql_query("INSERT INTO posts (threadid, message, poster)
		VALUES ('" . $_SESSION['threadid'] . "', '" . $_SESSION['tempname'] . "', '" . $_SESSION['cid'] . "')") or die(mysql_error());
		mysql_query("UPDATE posts SET `originaltime`=`time` WHERE `message`='" . $_SESSION['tempname'] . "'") or die(mysql_error());
		mysql_query("UPDATE posts SET `message`='" . $message . "' WHERE `message`='" . $_SESSION['tempname'] . "'") or die(mysql_error());
		
		mysql_query("UPDATE users SET posts=(1+posts) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE threads SET posts=(1+posts) WHERE id='" . $_SESSION['threadid'] . "'") or die(mysql_error());
		mysql_query("UPDATE threads SET latestid='" . $_SESSION['cid'] . "' WHERE id='" . $_SESSION['threadid'] . "'") or die(mysql_error());
		mysql_query("UPDATE boards SET posts=(1+posts) WHERE id='" . $_SESSION['boardid'] . "'") or die(mysql_error());
		mysql_query("UPDATE settings SET number=(1+number) WHERE id='posts'") or die(mysql_error());
		$result = mysql_query("SELECT `originaltime` FROM posts WHERE threadid='" . $_SESSION['threadid'] . "' ORDER BY `originaltime` DESC") or die(mysql_error());
		$latestpost = mysql_fetch_array($result);
		mysql_query("UPDATE threads SET latestpost='" . $latestpost['originaltime'] . "' WHERE id='" . $_SESSION['threadid'] . "'") or die(mysql_error());
		unset($_SESSION['boardid']);
		unset($_SESSION['tempname']);
		header("Location: thread.php?id=" . $_SESSION['threadid']);
		die();
	} elseif ($error==1) {
		$title=Forum;
		include 'header.php';
		echo '<div class="error">You need to enter a message!</div>';
		include 'footer.php';
		die();
	} else {
		$title=Forum;
		include 'header.php';
		echo '<div class="error">Your message is too long. (The maximum length is ' . $maxtextarealength . ' characters.)</div>';
		include 'footer.php';
		die();
	}
}

if ($_POST['formThreadSubmit']==Submit)
{
	$error=0;
	$message = $_POST['formThreadmsg'];
	require_once 'bbc.php';

    $stringParser = new Parsers/BBCodeParser;

    $parsedString = $mysqli->real_escape_string($stringParser->parseString($message));
	
	$msglength = strlen($message);
	if (empty($message))
	{
		$error=1;
	} elseif ($msglength > $maxtextarealength) {
		$error=2;
	} elseif (empty($_POST['formThreadsub'])) {
		$error=3;
	}

	if ($error==1)
	{
		echo '<div class="error">You need to enter a message!</div>';
		include 'footer.php';
		die();
	} elseif ($error==3) {
		echo '<div class="error">You need to enter a subject!</div>';
		include 'footer.php';
		die();
	} elseif ($error==2) {
		echo '<div class="error">Your message is too long. (Maximum length is ' . $maxtextarealength . ' characters.)</div>';
		include 'footer.php';
		die();
	} else {
		$subject = addslashes($_POST['formThreadsub']);
		// Create the thread...
		mysql_query("INSERT INTO threads (boardid, name, poster, latestid) VALUES ('" . $_SESSION['boardid'] . "','" . $_SESSION['tempname'] . "', '" . $_SESSION['cid'] . "', '" . $_SESSION['cid'] . "')") or die(mysql_error());
		$result = mysql_query("SELECT id FROM threads WHERE name='" . $_SESSION['tempname'] . "'") or die(mysql_error());
		$thread = mysql_fetch_array($result);
		// Now we have the newly-generated thread id, we can remove the tempname...
		mysql_query("UPDATE threads SET name='" . $subject . "' WHERE id='" . $thread['id'] . "'") or die(mysql_error());
		// Create the first post...
		mysql_query("INSERT INTO posts (threadid, message, poster)
		VALUES ('" . $thread['id'] . "', '" . $_SESSION['tempname'] . "', '" . $_SESSION['cid'] . "')") or die(mysql_error());
		mysql_query("UPDATE posts SET `originaltime`=`time` WHERE `message`='" . $_SESSION['tempname'] . "'") or die(mysql_error());
		mysql_query("UPDATE posts SET `message`='" . $message . "' WHERE `message`='" . $_SESSION['tempname'] . "'") or die(mysql_error());
		// Give the poster a new post and update various other statistics.
		mysql_query("UPDATE users SET posts=(1+posts) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE threads SET posts=(1+posts) WHERE id='" . $thread['id'] . "'") or die(mysql_error());
		mysql_query("UPDATE boards SET posts=(1+posts) WHERE id='" . $_SESSION['boardid'] . "'") or die(mysql_error());
		$result = mysql_query("SELECT `originaltime` FROM posts WHERE threadid='" . $thread['id'] . "' ORDER BY `originaltime` DESC") or die(mysql_error());
		$latestpost = mysql_fetch_array($result);
		mysql_query("UPDATE threads SET latestpost='" . $latestpost['originaltime'] . "' WHERE id='" . $thread['id'] . "'") or die(mysql_error());
		unset($_SESSION['boardid']);
		unset($_SESSION['tempname']);
		header("Location: thread.php?id=" . $thread['id']);
		die();
	}
}

if (empty($_GET['thread']) AND empty($_GET['board']))
{
	header("Location: forum.php");
	die();
}

if (!empty($_GET['thread']) AND empty($_GET['board']))
{
	$result = mysql_query("SELECT id, name, poster, `lock`, boardid FROM threads WHERE id='" . $_GET['thread'] . "'") or die(mysql_error());
	$thread = mysql_fetch_array($result);
	if (empty($thread['name']))
	{
		header("Location: forum.php");
		die();
	}
	$ableToPost = 0;
	$result = mysql_query("SELECT id, name, postable FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
	$board = mysql_fetch_array($result);
	if ($board['postable']==3) // Only admins can post?
	{
		if ($_SESSION['cgroup']==7)
		{
			$ableToPost = 1;
		}
	} elseif ($board['postable']==2) { // Only mods and admins can post?
		if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
		{
			$ableToPost = 1;
		}
	} else {
		$ableToPost = 1;
	}
	if ($thread['lock']==1)
	{
		// If user is a mod or admin, they can post regardless of lock.
		if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
		{
			$ableToPost = 1;
		} else {
			$ableToPost = 0;
		}
	} else {
		$ableToPost = 1;
	}
	if ($ableToPost == 0)
	{
		header("Location: forum.php");
		die();
	} else {
		$title=Forum;
		include 'header.php';
		$_SESSION['boardid'] = $board['id'];
		$_SESSION['threadid'] = $thread['id'];
		// This random number is used to identify the post before the database asigns its unique id #.
		$tempname = rand(0, 500000);
		$_SESSION['tempname'] = $tempname;
		echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
		echo '<a href="/board.php?id=' . $board['id'] . '">' . $board['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
		echo '<a href="/thread.php?id=' . $thread['id'] . '">' . $thread['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> Post<br><br>';
		echo '<form action="post.php" method="post"><p>';
		echo '<textarea cols="60" rows="6" name="formPost"></textarea><br>';
		echo '<input type="submit" name="formPostSubmit" value="Submit"></form>';
	}
}

if (!empty($_GET['board']) AND empty($_GET['thread']))
{
	$result = mysql_query("SELECT id, name, writable FROM boards WHERE id='" . $_GET['board'] . "'") or die(mysql_error());
	$board = mysql_fetch_array($result);
	if (empty($board['name']))
	{
		header("Location: forum.php");
		die();
	}
	$ableToWrite = 0;
	if ($board['writable']==3) // Only admins can write?
	{
		if ($_SESSION['cgroup']==7)
		{
			$ableToWrite = 1;
		}
	} elseif ($board['writable']==2) { // Only mods and admins can write?
		if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
		{
			$ableToWrite = 1;
		}
	} else {
		$ableToWrite = 1;
	}
	if ($ableToWrite == 0)
	{
		header("Location: forum.php");
		die();
	} else {
		$title=Forum;
		include 'header.php';
		$_SESSION['boardid'] = $board['id'];
		// This random number is used to identify the thread before the database asigns its unique id #.
		$tempname = rand(0, 500000);
		$_SESSION['tempname'] = $tempname;
		echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
		echo '<a href="/board.php?id=' . $board['id'] . '">' . $board['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> New Thread<br><br>';
		echo '<form action="post.php" method="post"><p>';
		echo 'Subject: <input type="text" name="formThreadsub" maxlength="100"><br>';
		echo '<textarea cols="60" rows="6" name="formThreadmsg"></textarea><br>';
		echo '<input type="submit" name="formThreadSubmit" value="Submit"></form>';
	}
}

}

include 'footer.php';
*/
?>