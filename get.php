<?php
include 'connect.php';
$title=Internet;

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

if (isset($_GET['id']))
{

	$result = mysql_query("SELECT * FROM `drops` WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	if (mysql_num_rows($result) < 1)
	{
		header("Location: internet.php");
		die();
	} else {
		$drop=mysql_fetch_array($result);
		$result=mysql_query("SELECT xpos, ypos FROM nodes WHERE id='" . $drop['nodeid'] . "'") or die(mysql_error());
		$node=mysql_fetch_array($result);
		if ($_SESSION['cxpos'] != $node['xpos'])
		{
			header("Location: internet.php");
			die();
		}
		if ($_SESSION['cypos'] != $node['ypos'])
		{
			header("Location: internet.php");
			die();
		}
		
		include 'header.php';
		
		if ($drop['invid']==0)
		{
			$desc = stripslashes($drop['desc']);
			echo '<table>';
			echo '<tr><th>' . $drop['name'] . '.txt</th></tr>';
			echo '<tr><td>' . nl2br($desc) . '</td></tr>';
			echo '</table>';
		} else {
			echo 'Nothing here yet...<br><br>';
		}
		
		echo '<br><span class="button"><a href="/internet.php">Back</a></span>';
		
		if ($_SESSION['cgroup']==7)
		{
			if ($drop['invid'] > 0)
			{
				echo '<span class="button"><a href="/edit.php?drop=' . $_GET['id'] . '">Delete</a></span>';
			} else {
				echo '<span class="button"><a href="/edit.php?drop=' . $_GET['id'] . '">Edit</a></span>';
			}
		}
	}	
} else {
header("Location: internet.php");
die();
}
include 'footer.php';
}