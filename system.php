<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
	header("Location: login.php");
	die();
} else {

if ($_SESSION['ccid'] != 0)
{

$title=Internet;
include 'header.php';

$result = mysql_query("SELECT contractx, contracty FROM users WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
$kesey = mysql_fetch_array($result);
$_SESSION['cxpos'] = $kesey['contractx'];
$_SESSION['cypos'] = $kesey['contracty'];

// Figure out the entire surrounding area...
$result = mysql_query("SELECT * FROM systems WHERE xpos='" . $_SESSION['ccxpos'] . "' AND ypos='" . $_SESSION['ccypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$node = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "-1) AND ypos='" . $_SESSION['ccypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodeleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "+1) AND ypos='" . $_SESSION['ccypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$noderight = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "-1) AND ypos=(" . $_SESSION['ccypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos='" . $_SESSION['ccxpos'] . "' AND ypos=(" . $_SESSION['ccypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetop = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "+1) AND ypos=(" . $_SESSION['ccypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopright = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "-1) AND ypos=(" . $_SESSION['ccypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos='" . $_SESSION['ccxpos'] . "' AND ypos=(" . $_SESSION['ccypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelow = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM systems WHERE xpos=(" . $_SESSION['ccxpos'] . "+1) AND ypos=(" . $_SESSION['ccypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowright = mysql_fetch_array($result);}
$result = mysql_query("SELECT `system` FROM contracts WHERE id='" . $node['contractid'] . "'") or die(mysql_error());
$network = mysql_fetch_array($result);

$context=system;
include 'map.php';

// Figure out all the objects...
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj1'] . "'") or die(mysql_error());
$obj1 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj2'] . "'") or die(mysql_error());
$obj2 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj3'] . "'") or die(mysql_error());
$obj3 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj4'] . "'") or die(mysql_error());
$obj4 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj5'] . "'") or die(mysql_error());
$obj5 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj6'] . "'") or die(mysql_error());
$obj6 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj7'] . "'") or die(mysql_error());
$obj7 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj8'] . "'") or die(mysql_error());
$obj8 = mysql_fetch_array($result);
$result = mysql_query("SELECT * FROM objects WHERE id='" . $node['obj9'] . "'") or die(mysql_error());
$obj9 = mysql_fetch_array($result);

if ($node['open']>0)
{
echo '<span class="highlight">Possible actions:</span><ul>';
echo '<li><a href="/exit.php">Exit the system.</a></li>';
echo '</ul>';
}

include 'footer.php';

} else {
header("Location: internet.php");
die();
}
}

?>