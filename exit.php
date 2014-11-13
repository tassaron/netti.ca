<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

// Make sure user is in an exit...
$result = mysql_query("SELECT `open` FROM `systems` WHERE xpos='" . $_SESSION['ccxpos'] . "' AND ypos='" . $_SESSION['ccypos'] . "' AND contractid='" . $_SESSION['ccid'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0)
{
	$contract = mysql_fetch_array($result);
	if ($contract['open']==1)
	{ // User is in an entrance. Always allow passage.
		mysql_query("UPDATE users SET contractid=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		$_SESSION['ccid']=0;
		$_SESSION['kb']-=1;
		header("Location: internet.php");
		die();
	} elseif ($contract['open']==2) { // User is in an exit.
		// nothing here yet
	} else {
		header("Location: system.php");
		die();
	}
} else {
	header("Location: system.php");
	die();
}


}

?>