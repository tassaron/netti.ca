<?php
// Stop using that www, people. >:|
if ($_SERVER['HTTP_HOST']=="www.netti.ca")
{
	header("Location: http://netti.ca");
}

session_start();
include 'settings.php';

// Connect to database.
mysql_connect($db_server, $db_user, $db_pass) or die(mysql_error());
mysql_select_db($db_name) or die(mysql_error());
?>