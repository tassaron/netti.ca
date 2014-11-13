<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

$result = mysql_query("SELECT `id`, `list`, `lvl` FROM `contracts` WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
$contract = mysql_fetch_array($result);

if ($contract['list']==1)
{
	$title=Contracts;
	include 'header.php';
	echo 'Nothing here yet!';
} else {
	if ($_SESSION['kb']<1)
	{
		header("Location: internet.php");
		die();
	} else {
		$result = mysql_query("SELECT `xpos`, `ypos` FROM `systems` WHERE `contractid`='" . $contract['id'] . "' AND `open`='1'") or die(mysql_error());
		$entrance = mysql_fetch_array($result);
		mysql_query("UPDATE users SET contractid='" . $contract['id'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE users SET contractx='" . $entrance['xpos'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE users SET contracty='" . $entrance['ypos'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE users SET kb=(kb-1) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		$_SESSION['ccid']=$contract['id'];
		$_SESSION['kb']-=1;
		header("Location: system.php");
		die();
	}
}

include 'footer.php';
}

?>