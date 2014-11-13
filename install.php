<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {

$title='Hard drive';
include 'header.php';

$result = mysql_query("SELECT * FROM inv WHERE userid='" . $_SESSION['cid'] . "' AND `exists`=1") or die(mysql_error());
echo '<table><tr><th>Program</th><th>Type</th><th>Power</th></tr>';
while($item = mysql_fetch_array( $result ))
{
	$result2 = mysql_query("SELECT * FROM items WHERE id='" . $item['itemid'] . "'") or die(mysql_error());
	while($item2 = mysql_fetch_array( $result2 ))
	{
		// Translate the type into English first.
		if ($item2['type']==0) {$type='Unknown';}
		if ($item2['type']==1) {$type='Medic';}
		if ($item2['type']==2) {$type='Virus';}
		if ($item2['type']==2) {$type='Virus';}
		if ($item2['type']==3) {$type='Shield';}
		if ($item2['type']==4) {$type='Deceive';}
		if ($item2['type']==5) {$type='Scan';}
		if ($item2['type']==6) {$type='Attack firmware';}
		if ($item2['type']==7) {$type='Defence firmware';}
		if ($item2['type']==8) {$type='Stealth firmware';}
		if ($item2['type']==9) {$type='Analysis firmware';}
		// Create a row.
		echo '<tr><td>';
		echo $item2['item'];
		echo '</td><td>';
		echo $type;
		echo '</td><td>';
		echo $item2['power'];
		echo '</td></tr>';
	}
}
echo '</table>';

}

include 'footer.php';
?>