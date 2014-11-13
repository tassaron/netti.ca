<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

if ($_POST['formEditdropSubmit']==Submit)
{
	$error=0;
	$message = addslashes($_POST['formEditdropDesc']);
	$msglength = strlen($message);
	if ($msglength > $maxtextarealength)
	{
		$error=1;
	}

	if ($error==0)
	{
		mysql_query("UPDATE drops SET name='" . $_POST['formEditdropName'] . "' WHERE id='" . $_SESSION['dropid'] . "'") or die(mysql_error());
		mysql_query("UPDATE drops SET `desc`='" . $message . "' WHERE id='" . $_SESSION['dropid'] . "'") or die(mysql_error());
		$drop = $_SESSION['dropid'];
		unset($_SESSION['dropid']);
		header("Location: get.php?id=" . $drop);
		die();
	} else {
		$title=Internet;
		include 'header.php';
		echo '<div class="error">The file is too big. (The maximum length is ' . $maxtextarealength . ' characters.)</div>';
		include 'footer.php';
		die();
	}
}

if ($_POST['formPostSubmit']==Submit)
{
	$error=0;
	$message = addslashes($_POST['formPostmsg']);
	$subject = addslashes($_POST['formPostsub']);
	$msglength = strlen($message);
	if ($msglength > $maxtextarealength)
	{
		$error=1;
	}

	if ($error==0)
	{
		mysql_query("UPDATE `posts` SET `message`='" . $message . "' WHERE id='" . $_SESSION['postid'] . "'") or die(mysql_error());
		mysql_query("UPDATE `posts` SET `edited`='" . $_SESSION['cid'] . "' WHERE id='" . $_SESSION['postid'] . "'") or die(mysql_error());
		if (!empty($_POST['formPostsub']))
		{
			mysql_query("UPDATE `threads` SET `name`='" . $subject . "' WHERE id='" . $_SESSION['threadid'] . "'") or die(mysql_error());
		}
		$thread = $_SESSION['threadid'];
		$post = $_SESSION['postid'];
		unset($_SESSION['postid']);
		unset($_SESSION['threadid']);
		header("Location: thread.php?id=" . $thread);
		// Edit this when I'm less busy so it figures out the page and redirects directly to the post.
		// I imagine this could be accomplished with a while loop etc. I'm just too lazy atm.
		// header("Location: thread.php?id=" . $thread . "&amp;page=" . $page . "#" . $post);
		die();
	} else {
		$title=Forum;
		include 'header.php';
		echo '<div class="error">Your new message is too long. (The maximum length is ' . $maxtextarealength . ' characters.)</div>';
		include 'footer.php';
		die();
	}
}

$error=0;
$canedit=0; // 0 can't edit, 1 edits a drop, 2 edits a post

if (empty($_GET['post']))
{
	if (isset($_GET['drop']))
	{
		if ($_SESSION['cgroup']==7)
		{ // Admins can do whatever they want.
			$canedit=1;
		} else {
			$result = mysql_query("SELECT userid FROM drops WHERE `id`='" . $_GET['drop'] . "'") or die(mysql_error());
			if (mysql_num_rows($result)==1)
			{
				$drop = mysql_fetch_array($result);
				if ($drop['userid']==$_SESSION['cid'])
				{ // Users can edit their own drops.
					$canedit=1;
				}
			} else {
				$error=2;
			}
		}
	}
} elseif (empty($_GET['drop'])) {
	if ($_SESSION['cgroup']==7)
	{ // Admins can do whatever they want.
		$canedit=2;
	} else {
		$result = mysql_query("SELECT poster FROM `posts` WHERE id='" . $_GET['post'] . "'") or die(mysql_error());
		if (mysql_num_rows($result)==1)
		{
			$post=mysql_fetch_array($result);
			if ($post['poster']==$_SESSION['cid'])
			{ // Users can edit their own posts.
				$canedit=2;
			}
		} else {
			$error=2;
		}
	}
} else {
	$error=1;
}

if ($error==0)
{
	if ($canedit==1)
	{ // Editing a drop
		$title=Internet;
		include 'header.php';
		$result = mysql_query("SELECT `id`, `invid`, `name`, `desc` FROM `drops` WHERE `id`='" . $_GET['drop'] . "'") or die(mysql_error());
		$drop = mysql_fetch_array($result);
		$_SESSION['dropid'] = $drop['id'];
		
		if ($drop['invid'] != 0)
		{ // Editing a program
			echo 'Nothing here yet....';
		} else {
			// Editing a txt file
			$desc = stripslashes($drop['desc']);
			echo '<form action="edit.php" method="post"><p>';
			echo '<input type="text" name="formEditdropName" maxlength="50" value="' . $drop['name'] . '">.txt<br>';
			echo '<textarea cols="100" rows="15" name="formEditdropDesc">' . $desc . '</textarea><br>';
			echo '<input type="submit" name="formEditdropSubmit" value="Submit"></form>';
		}
	} elseif ($canedit==2) {
		// Editing a post
		$title=Forum;
		include 'header.php';
		
		// Show breadcrumb path
		$result = mysql_query("SELECT * FROM posts WHERE id='" . $_GET['post'] . "'") or die(mysql_error());
		$post = mysql_fetch_array($result);
		$result = mysql_query("SELECT id, boardid, name FROM threads WHERE id='" . $post['threadid'] . "'") or die(mysql_error());
		$thread = mysql_fetch_array($result);
		$result = mysql_query("SELECT id FROM posts WHERE threadid='" . $thread['id'] . "' ORDER BY `originaltime` ASC") or die(mysql_error());
		$firstpost = mysql_fetch_array($result);
		$result = mysql_query("SELECT id, name FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
		$board = mysql_fetch_array($result);
		echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
		echo '<a href="/board.php?id=' . $board['id'] . '">' . $board['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
		echo '<a href="/thread.php?id=' . $thread['id'] . '">' . $thread['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> Edit Post<br><br>';
		
		$_SESSION['threadid'] = $thread['id'];
		$_SESSION['postid'] = $post['id'];
		$message = stripslashes($post['message']);
		
		echo '<form action="edit.php" method="post"><p>';
		
		// If this is the first post in the thread, allow user to edit the subject as well
		if ($post['id']==$firstpost['id'])
		{
			echo 'Subject: <input type="text" name="formPostsub" maxlength="100" value="' . $thread['name'] . '"><br>';
		}
		
		echo '<textarea cols="60" rows="6" name="formPostmsg">' . $message . '</textarea><br>';
		echo '<input type="submit" name="formPostSubmit" value="Submit"></form>';
	} else {
		echo '<div class="error">Invalid parameters.</div>';
	}
} elseif ($error==1) {
	echo '<div class="error">Invalid parameters.</div>';
} elseif ($error==2) {
	echo '<div class="error">FATAL ERROR: MySQL query returns too many results. <a href="/email.php?action=compose&amp;id=1">Report this immediately.</a></div>';
} else {
	echo '<div class="error">I got nothin\'.</div>';
}

}

include 'footer.php';
?>