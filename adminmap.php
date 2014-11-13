<?php

// Figure out the entire surrounding area...
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $row['xpos'] . "' AND ypos='" . $row['ypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$node = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "-1) AND ypos='" . $row['ypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodeleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "+1) AND ypos='" . $row['ypos'] . "'") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$noderight = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "-1) AND ypos=(" . $row['ypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $row['xpos'] . "' AND ypos=(" . $row['ypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetop = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "+1) AND ypos=(" . $row['ypos'] . "+1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodetopright = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "-1) AND ypos=(" . $row['ypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowleft = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos='" . $row['xpos'] . "' AND ypos=(" . $row['ypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelow = mysql_fetch_array($result);}
$result = mysql_query("SELECT * FROM nodes WHERE xpos=(" . $row['xpos'] . "+1) AND ypos=(" . $row['ypos'] . "-1)") or die(mysql_error());
if (mysql_num_rows($result) > 0) {$nodelowright = mysql_fetch_array($result);}
$result = mysql_query("SELECT id, name FROM networks WHERE id='" . $node['networkid'] . "'") or die(mysql_error());
$network = mysql_fetch_array($result);

echo '<div style="float:right;"><table class="map">';
echo '<tr><td class="net" colspan="3">' . $network['name'] . ' Network</td></tr>';
echo '<tr style="height:100px;">';

if (empty($nodetopleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetopleft['img'] . '\');';
	if ($nodetopleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetopleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetopleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetopleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodetopleft['name'] . ' (' . $nodetopleft['xpos'] . ', ' . $nodetopleft['ypos'] . ')</td>';
}

if (empty($nodetop['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetop['img'] . '\');';
	if ($nodetop['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetop['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetop['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetop['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodetop['name'] . ' (' . $nodetop['xpos'] . ', ' . $nodetop['ypos'] . ')</td>';
}

if (empty($nodetopright['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetopright['img'] . '\');';
	if ($nodetopright['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetopright['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetopright['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetopright['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodetopright['name'] . ' (' . $nodetopright['xpos'] . ', ' . $nodetopright['ypos'] . ')</td>';
}

echo '</tr>';
echo '<tr style="height:100px;">';

if (empty($nodeleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodeleft['img'] . '\');';
	if ($nodeleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodeleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodeleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodeleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodeleft['name'] . ' (' . $nodeleft['xpos'] . ', ' . $nodeleft['ypos'] . ')</td>';
}

if (empty($node['id'])) {
	echo '<td class="dead">VOID</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $node['img'] . '\');';
	if ($node['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($node['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($node['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($node['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $node['name'] . ' (' . $node['xpos'] . ', ' . $node['ypos'] . ')</td>';
}

if (empty($noderight['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $noderight['img'] . '\');';
	if ($noderight['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($noderight['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($noderight['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($noderight['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $noderight['name'] . ' (' . $noderight['xpos'] . ', ' . $noderight['ypos'] . ')</td>';
}

echo '</tr>';
echo '<tr style="height:100px;">';

if (empty($nodelowleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelowleft['img'] . '\');';
	if ($nodelowleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelowleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelowleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelowleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodelowleft['name'] . ' (' . $nodelowleft['xpos'] . ', ' . $nodelowleft['ypos'] . ')</td>';
}

if (empty($nodelow['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelow['img'] . '\');';
	if ($nodelow['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelow['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelow['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelow['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodelow['name'] . ' (' . $nodelow['xpos'] . ', ' . $nodelow['ypos'] . ')</td>';
}

if (empty($nodelowright['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelowright['img'] . '\');';
	if ($nodelowright['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelowright['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelowright['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelowright['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	echo '">' . $nodelowright['name'] . ' (' . $nodelowright['xpos'] . ', ' . $nodelowright['ypos'] . ')</td>';
}


echo '</tr></table>';
echo '<table style="text-align:center; width: 300px; border:0px solid;">';

echo '<tr><td class="move">'; // Left
if (empty($nodeleft['id']))
{
	echo '<a style="border:0px solid;" href="/admin.php?action=addnode&amp;x=' . ($node['xpos']-1) . '&amp;y=' . $node['ypos'] . '"><img src="/img/left' . $_SESSION['style'] . '.png" alt="&lt;"></a>';	
} else {
	echo '<a style="border:0px solid;" href="/admin.php?action=editnode&amp;id=' . $nodeleft['id'] . '"><img src="/img/left' . $_SESSION['style'] . '.png" alt="&lt;"></a>';
}

echo '</td><td class="move">'; // Up
if (empty($nodetop['id']))
{
	echo '<a style="border:0px solid;" href="/admin.php?action=addnode&amp;x=' . $node['xpos'] . '&amp;y=' . ($node['ypos']+1) . '"><img src="/img/up' . $_SESSION['style'] . '.png" alt="^"></a>';	
} else {
	echo '<a style="border:0px solid;" href="/admin.php?action=editnode&amp;id=' . $nodetop['id'] . '"><img src="/img/up' . $_SESSION['style'] . '.png" alt="^"></a>';
}

echo '</td><td class="move">'; // Down
if (empty($nodelow['id']))
{
	echo '<a style="border:0px solid;" href="/admin.php?action=addnode&amp;x=' . $node['xpos'] . '&amp;y=' . ($node['ypos']-1) . '"><img src="/img/down' . $_SESSION['style'] . '.png" alt="v"></a>';	
} else {
	echo '<a style="border:0px solid;" href="/admin.php?action=editnode&amp;id=' . $nodelow['id'] . '"><img src="/img/down' . $_SESSION['style'] . '.png" alt="v"></a>';
}

echo '</td><td class="move">'; // Right
if (empty($noderight['id']))
{
	echo '<a style="border:0px solid;" href="/admin.php?action=addnode&amp;x=' . ($node['xpos']+1) . '&amp;y=' . $node['ypos'] . '"><img src="/img/right' . $_SESSION['style'] . '.png" alt="&gt;"></a>';	
} else {
	echo '<a style="border:0px solid;" href="/admin.php?action=editnode&amp;id=' . $noderight['id'] . '"><img src="/img/right' . $_SESSION['style'] . '.png" alt="&gt;"></a>';
}

echo '</td></tr></table></div>';

?>