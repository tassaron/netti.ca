<?php
require 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

$title=Forum;
include 'header.php';

echo '<a href="/forum.php">Forum</a><br><br>';

// Echo the board list into a table.
$result = mysql_query("SELECT * FROM boards ORDER BY position") or die(mysql_error());  
echo '<table><tr><th>Board</th><th>Posts</th></tr>';
while($board = mysql_fetch_array( $result )){
	if ($board['readable']==1) // If anyone can read the board...
	{
		echo '<tr><td>';
		$boardname = stripslashes($board['name']);
		echo "<a href=\"/board.php?id=" . $board['id'] . "\">" . $boardname . "</a>";
		echo '</td><td>';
		echo $board['posts'];
		echo '</td></tr>';
	} elseif ($board['readable']==2) { // If only readable by mods and admins...
		if ($row['group']==6 OR $row['group']==7)
		{
			echo '<tr><td>';
			$boardname = stripslashes($board['name']);
			echo "<a href=\"/board.php?id=" . $board['id'] . "\">" . $boardname . "</a>";
			echo '</td><td>';
			echo $board['posts'];
			echo '</td></tr>';
		}
	} elseif ($board['readable']==3) { // If only readable by admins...
		if ($row['group']==7)
		{
			echo '<tr><td>';
			$boardname = stripslashes($board['name']);
			echo "<a href=\"/board.php?id=" . $board['id'] . "\">" . $boardname . "</a>";
			echo '</td><td>';
			echo $board['posts'];
			echo '</td></tr>';
		}
	}
}
echo '</table>';

$result = mysql_query("SELECT `id`, `user`, `group` FROM `users` WHERE `lastrel`>='" . ($curtime-$kb_rate) . "'") or die(mysql_error());
$userloop = mysql_num_rows($result);

// This message should usually appear, but an error in the kb rate could make it redundant sometimes.
if ($userloop>0)
{
	echo '<br>Users active in the last ' . ($kb_rate/60) . ' minutes:<br>';
}

while ($user=mysql_fetch_array($result))
{
	$result2 = mysql_query("SELECT value FROM settings WHERE id='" . $user['group'] . "color'") or die(mysql_query());
	$pref = mysql_fetch_array($result2);
	if ($user['group']==0)
	{
		echo '<a href="/profile.php?id=' . $user['id'] . '">' . $user['user'] . '</a>';
	} else {
		echo '<a style="color: ' . $pref['value'] . ';" href="/profile.php?id=' . $user['id'] . '">' . $user['user'] . '</a>';
	}
	$userloop-=1;
	if ($userloop>0) {echo ', ';}
}

}

include 'footer.php';
?>