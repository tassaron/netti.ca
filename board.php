<?php
require 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {

if (empty($_GET['id']))
{
	header("Location: forum.php");
	die();
}

function displayThreads()
{
	// Echo the thread list into a table.
	$result = mysql_query("SELECT * FROM threads WHERE boardid='" . $_GET['id'] . "' ORDER BY sticky DESC, latestpost DESC") or die(mysql_error());  
	echo '<table><tr><th>Thread</th><th>Posted by</th><th>Posts</th><th>Latest</th></tr>';
	while($thread = mysql_fetch_array( $result ))
	{
		echo '<tr><td>';
		$threadname = stripslashes($thread['name']);
		if ($thread['sticky']==1) {echo '<img src="/img/sticky.gif" alt="[stickied] "> ';}
		echo "<a href=\"/thread.php?id=" . $thread['id'] . "\">" . $threadname . "</a>";
		if ($thread['lock']==1) {echo ' <img src="/img/lock.gif" alt=" [locked]>">';}
		echo '</td><td>';
		$result2 = mysql_query("SELECT `user` FROM users WHERE id='" . $thread['poster'] . "'") or die(mysql_error());
		$poster = mysql_fetch_array($result2);
		echo '<a href="/profile.php?id=' . $thread['poster'] . '">' . $poster['user'] . '</a>';
		echo '</td><td>';
		echo $thread['posts'];
		echo '</td><td>';
		echo $thread['latestpost'];
		echo '</td></tr>';
	}
	echo '</table><br>';
}

function displayActions()
{
	$result = mysql_query("SELECT writable FROM boards WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$board = mysql_fetch_array($result);
	if ($board['writable']==3)
	{
		if ($_SESSION['cgroup']==7)
		{
			echo '<span class="button"><a href="/post.php?board=' . $_GET['id'] . '">New Thread</a></span><br><br>';
		}
	} elseif ($board['writable']==2) {
		if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
		{
			echo '<span class="button"><a href="/post.php?board=' . $_GET['id'] . '">New Thread</a></span><br><br>';
		}
	} else {
		echo '<span class="button"><a href="/post.php?board=' . $_GET['id'] . '">New Thread</a></span><br><br>';
	}
}

$title=Forum;
include 'header.php';

if (!empty($_GET['id']))
{
	$result = mysql_query("SELECT * FROM boards WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$board = mysql_fetch_array($result);
	if ($board['readable'] == 3)
	{
		if ($row['group'] == 7)
		{
			echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> <a href="/board.php?id=' . $_GET['id'] . '">' . $board['name'] . '</a><br><br>';
			displayActions();
			displayThreads();
			displayActions();
		}
	} elseif ($board['readable'] == 2) {
		if ($row['group'] == 6 OR $row['group']==7)
		{
			echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> <a href="/board.php?id=' . $_GET['id'] . '">' . $board['name'] . '</a><br><br>';
			displayActions();
			displayThreads();
			displayActions();
		}
	} elseif (empty($board['readable'])) {
		die();
	} else {
		echo '<a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> <a href="/board.php?id=' . $_GET['id'] . '">' . $board['name'] . '</a><br><br>';
		displayActions();
		displayThreads();
		displayActions();
	}
}
}

include 'footer.php';
?>