<?php
require 'connect.php';
include 'header.php';

$result = mysql_query("SELECT id, name FROM threads WHERE boardid='1' ORDER BY `id` DESC") or die(mysql_error());
$loop=2; // This is depleted for every loop that displays a newspost, thus limiting us to 2 posts.
$morenews=0; // This counts the # of posts that are not displayed.

// Echo two most recent newsposts into a table.
echo '<div><span class="highlight">Current events:</span><br><br></div>';
echo '<table>';
while ($thread = mysql_fetch_array($result))
{
	if ($loop>0)
	{
		echo '<tr><th colspan="2">' . $thread['name'] . '</th></tr>';
		$result2 = mysql_query("SELECT * FROM posts WHERE threadid='" . $thread['id'] . "' ORDER BY `originaltime` ASC") or die(mysql_error());
		$post = mysql_fetch_array($result2);
		$loop-=1;
		
		echo '<tr><td class="thin"><a name="' . $post['id'] . '"></a>';
		$result2 = mysql_query("SELECT user, posts, avatar, cash, `group` FROM users WHERE id='" . $post['poster'] . "'") or die(mysql_error());  
		$poster = mysql_fetch_array($result2);
		$result3 = mysql_query("SELECT value FROM settings WHERE id='" . $poster['group'] . "color'") or die(mysql_query());
		$pref = mysql_fetch_array($result3);
		
		if ($poster['group']==0)
		{
			echo '<a href="/profile.php?id=' . $post['poster'] . '">' . $poster['user'] . '</a><br>';
		} else {
			echo '<a style="color: ' . $pref['value'] . ';" href="/profile.php?id=' . $post['poster'] . '">' . $poster['user'] . '</a><br>';
		}
		
		$avatar = stripslashes($poster['avatar']);
		echo '<img src="' . $avatar . '" alt="' . $poster['user'] . '\'s avatar"><br>';
		
		echo '<br>';
		echo 'Cash: $' . $poster['cash'] . '<br>';
		echo 'Posts: ' . $poster['posts'];
		echo '</td><td class="fat">';
		$message = stripslashes($post['message']);
		$message = nl2br($message);
		echo $message;
		echo '</td></tr>';
		echo '<tr><td colspan="2">';
		echo '<a href="/thread.php?id=' . $post['threadid'] . '#' . $post['id'] . '">Posted at ' . $post['originaltime'] . '</a>';
		
		if ($_SESSION['authorized']==true)
		{
			if ($post['poster']==$_SESSION['cid'])
			{
				echo ' - <a href="/edit.php?post=' . $post['id'] . '">Edit</a>';
			} elseif ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7) {
				echo ' - <a href="/edit.php?post=' . $post['id'] . '">Edit</a>';
			}
		}
		
		$result2 = mysql_query("SELECT count(*) FROM posts WHERE threadid='" . $thread['id'] . "'") or die(mysql_error());
		$result3 = mysql_fetch_row($result2);
		$numrows = $result3[0]; // Number of posts in thread.
		$numrows-=1; // Not counting the first post...
		echo ' - <a href="/thread.php?id=' . $thread['id'] . '">' . $numrows;
		if ($numrows==1)
		{
			echo ' comment</a>';
		} else {
			echo ' comments</a>';
		}
		
		echo '</td></tr>';
	} else {
		$morenews+=1;
	}
	if ($_SESSION['authorized']==true)
	{
		echo '<tr><th colspan="2"><a href="/board.php?id=1">[see ' . $morenews . ' more]</th></tr>';
	} else {
		echo '<tr><th colspan="2"><a style="color: #00FF00;" href="/login.php">[log in to see ' . $morenews . ' more]</th></tr>';
	}
	echo '</table>';
}

include 'footer.php';
?>