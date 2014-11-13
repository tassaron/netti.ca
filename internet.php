<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

if ($_SESSION['ccid'] != 0)
{
	header("Location: system.php");
	die();
}

$title=Internet;
include 'header.php';

$result = mysql_query("SELECT xpos, ypos FROM users WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
$kesey = mysql_fetch_array($result);
$_SESSION['cxpos'] = $kesey['xpos'];
$_SESSION['cypos'] = $kesey['ypos'];

// Figure out the entire surrounding area...
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $_SESSION['cxpos'] . "' AND ypos='" . $_SESSION['cypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$node = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "-1) AND ypos='" . $_SESSION['cypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodeleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "+1) AND ypos='" . $_SESSION['cypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$noderight = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "-1) AND ypos=(" . $_SESSION['cypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $_SESSION['cxpos'] . "' AND ypos=(" . $_SESSION['cypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetop = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "+1) AND ypos=(" . $_SESSION['cypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopright = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "-1) AND ypos=(" . $_SESSION['cypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $_SESSION['cxpos'] . "' AND ypos=(" . $_SESSION['cypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelow = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $_SESSION['cxpos'] . "+1) AND ypos=(" . $_SESSION['cypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowright = mysql_fetch_array($result);}
$result = mysql_query("SELECT id, name FROM networks WHERE id='" . $node['networkid'] . "'") or die(mysql_error());
$network = mysql_fetch_array($result);

include 'map.php';

$desc = stripslashes($node['desc']);
echo nl2br($desc);
echo '<br><br>';

// Display the public systems.
$result = mysql_query("SELECT `id`, `system` FROM `contracts` WHERE `xpos`='" . $_SESSION['cxpos'] . "' AND `ypos`='" . $_SESSION['cypos'] . "' AND `lvl`<='" . $row['lvl'] . "'") or die(mysql_error());
$system = mysql_fetch_array($result);
if (mysql_num_rows($result)==1)
{
	echo 'A public system named <a href="/contract.php?id=' . $system['id'] . '">' . $system['system'] . '</a> can be accessed from here.<br><br>';
} elseif (mysql_num_rows($result)>1) {
	$list=mysql_num_rows($result);
	echo 'The public systems named ';
	while ($system=mysql_fetch_array($result))
	{
		echo '<a href="/contract.php?id=' . $system['id'] . '">' . $system['system'] . '</a>';
		if ($list>2)
		{
			echo ', ';
		} elseif ($list==2) {
			echo ', and ';
		}
		$list-=1;
	}
	echo ' can be accessed from here.<br><br>';
}

// Display the other users in this node
$result = mysql_query("SELECT id, user, avatar FROM users WHERE xpos='" . $_SESSION['cxpos'] . "' AND ypos='" . $_SESSION['cypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 1)
{
	echo '<span class="highlight">Other people in this node:</span><br>';
	while ($people = mysql_fetch_array($result)) // Loop through and display everyone's avatars
	{
		if ($people['id'] != $_SESSION['cid']) // but not the current user, obviously
		{
			echo '<a style="border: 0px solid;" href="/profile.php?id=' . $people['id'] . '"><img src="' . $people['avatar'] . '" alt="' . $people['user'] . '" title="' . $people['user'] . '" width=50 height=50></a>';
		}
	}
	echo '<br><br>';
}

// Display any drops in this node
$result = mysql_query("SELECT id, userid, invid, name FROM `drops` WHERE nodeid='" . $node['id'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0)
{
	echo '<span class="highlight">Unencrypted files in this node:</span><br>';
	echo '<table style="width:50%;">';
	echo '<tr><th>File</th><th>Type</th><th>From</th></tr>';
	while ($drop = mysql_fetch_array($result)) // Loop through and display all the drops
	{
		echo '<tr><td>';
		if ($drop['invid']==0)
		{
			echo '<a href="/get.php?id=' . $drop['id'] . '">' . $drop['name'] . '.txt</a>';
			echo '</td><td>';
			echo 'Text';
			echo '</td><td>';
		} else {
			$result2 = mysql_query("SELECT itemid FROM inv WHERE id='" . $drop['invid'] . "'") or die(mysql_error());
			$item = mysql_fetch_array($result2);
			$result2 = mysql_query("SELECT item FROM items WHERE id='" . $item['itemid'] . "'") or die(mysql_error());
			if (mysql_num_rows($result2) < 1) // Make sure the item actually exists
			{
				$dropname=md5(rand(0, 500000)); // this just generates a weird-looking garbled filename; it doesn't really mean anything
				$droptype="?";
				$dropuser=f;
			} else {
				$drop2=mysql_fetch_array($result2);
				$dropname=$drop2['item'];
				$droptype=Program;
			}
			echo '<a href="/get.php?id=' . $drop['id'] . '">' . $dropname . '</a>';
			echo '</td><td>';
			echo $droptype;
			echo '</td><td>';
		}
		if (empty($dropuser)) // If the item didn't exist earlier, all info on the file gets garbled, so we can skip this part
		{
			$result2 = mysql_query("SELECT user FROM users WHERE id='" . $drop['userid'] . "'") or die(mysql_error());
			if (mysql_num_rows($result2)==1) // Make sure the user actually exists
			{
				$drop2=mysql_fetch_array($result2);
				$dropuser=$drop2['user'];
			} else {
				$dropuser=f;
			}
		}
		if ($dropuser==f)
		{
			echo '?';
		} else {
			echo '<a href="/profile.php?id=' . $drop['userid'] . '">' . $dropuser . '</a>';
		}
		echo '</td></tr>';
	}
	echo '</table>';
	echo '<br>';
}

echo '<span class="highlight">Possible actions:</span><ul>';
echo '<li><a href="/txt.php">Create a txt file</a></li>';
echo '<li><a href="/drop.php">Leave a program here</a></li>';
if ($_SESSION['cgroup']==7)
{
	echo '<li><a href="/admin.php?action=editnode&amp;id=' . $node['id'] . '">Edit this node</a></li>';
}
echo '</ul>';

}

include 'footer.php';
?>