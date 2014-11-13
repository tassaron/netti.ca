<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {

if (!empty($_GET['id']))
{
	if ($_POST['formVerifyNo']=='No')
	{
		header("Location: software.php");
		die();
	}

	if ($_POST['formVerifyYes']=='Yes')
	{
		$stuff = mysql_query("SELECT * FROM items WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		$item = mysql_fetch_array( $stuff );
		mysql_query("UPDATE users SET cash=(cash-" . $item['cost'] . ") WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("INSERT INTO inv (`itemid`, `userid`, `exists`) VALUES ('" . $_GET['id'] . "', '" . $_SESSION['cid'] . "', '1')") or die(mysql_error());
		header("Location: software.php");
		die();
	}
}

$title=Software;
include 'header.php';

if (empty($_GET['id']))
{
	// Get contents of item table with a type less than 10 (software only).
	$stuff = mysql_query("SELECT * FROM items WHERE type < 10") or die(mysql_error()); 
	echo '<table><tr><th>Program</th><th>Type</th><th>Cost</th></tr>';
	while($item = mysql_fetch_array( $stuff ))
	{
		// Translate the type into English first.
		if ($item['type']==0) {$type='Unknown';}
		if ($item['type']==1) {$type='Medic';}
		if ($item['type']==2) {$type='Virus';}
		if ($item['type']==3) {$type='Shield';}
		if ($item['type']==4) {$type='Deceive';}
		if ($item['type']==5) {$type='Scan';}
		if ($item['type']==6) {$type='Attack firmware';}
		if ($item['type']==7) {$type='Defence firmware';}
		if ($item['type']==8) {$type='Stealth firmware';}
		if ($item['type']==9) {$type='Analysis firmware';}
		// Create a row.
		echo '<tr><td>';
		echo '<a href="/software.php?id=' . $item['id'] . '">' . $item['item'] . '</a>';
		echo '</td><td>';
		echo $type;
		echo '</td><td>';
		echo '$' . $item['cost'];
		echo '</td></tr>';
	}
	echo '</table>';
}

if (!empty($_GET['id']))
{
	$stuff = mysql_query("SELECT * FROM items WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$item = mysql_fetch_array( $stuff );
	if ($item['shop']==0)
	{
		echo '<div class="error">Invalid ID.</div>';
	} elseif ($item['type'] > 9) {
		echo '<div class="error">Invalid ID.</div>';
	} elseif ($item['cost'] > $row['cash']) {
		echo '<div class="error">You can\'t afford it.</div>';
	} else {
		echo 'Are you sure you want to buy ' . $item['item'] . ' for $' . $item['cost'] . '?<br>';
		echo '<form name="formVerify" action="software.php?id=' . $item['id'] . '" method="post">';
		echo '<input type="submit" name="formVerifyYes" value="Yes" />';
		echo '<input type="submit" name="formVerifyNo" value="No" />';
		echo '</form>';
	}
}

}

include 'footer.php';
?>