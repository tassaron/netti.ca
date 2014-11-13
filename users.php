<?php
require 'connect.php';
$title=Users;
include 'header.php';

// Get contents of user table.
$result = mysql_query("SELECT * FROM users") or die(mysql_error());  

// Echo the user list into a table.
echo '<table><tr><th>User</th><th>Sex</th><th>Cash</th></tr>';
while($row = mysql_fetch_array( $result ))
{
	// Translate the sex id into English first.
	if ($row['sex']==1) {$sex='Female';}
	if ($row['sex']==2) {$sex='Male';}
	if ($row['sex']==3) {$sex='Other';}
	// Create a row.
	echo '<tr><td>';
	
	// Make sure to get the colour of the name right.
	if ($row['group']==0)
	{
		echo "<a href=\"/profile.php?id=" . $row['id'] . "\">" . $row['user'] . "</a>";
	} else {
		$result2 = mysql_query("SELECT value FROM settings WHERE id='" . $row['group'] . "color'") or die(mysql_error());
		$pref = mysql_fetch_array($result2);
		echo "<a style=\"color: " . $pref['value'] . ";\" href=\"/profile.php?id=" . $row['id'] . "\">" . $row['user'] . "</a>";
	}

	echo '</td><td>';
	echo $sex;
	echo '</td><td>';
	echo '$' . $row['cash'];
	echo '</td></tr>';
}
echo '</table>';


include 'footer.php';
?>