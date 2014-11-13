<?php

echo '<div style="float:right;"><table class="map">';
if ($context=="system")
{
	echo '<tr><td class="net" colspan="3">' . $network['system'] . '</td></tr>';
} else {
	echo '<tr><td class="net" colspan="3">' . $network['name'] . ' Network</td></tr>';
}
echo '<tr style="height:100px;">';

if (empty($nodetopleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetopleft['img'] . '\');';
	if ($nodetopleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetopleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetopleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetopleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodetopleft['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodetopleft['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodetopleft['xpos'] . "' AND ypos='" . $nodetopleft['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($nodetop['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetop['img'] . '\');';
	if ($nodetop['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetop['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetop['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetop['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodetop['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodetop['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodetop['xpos'] . "' AND ypos='" . $nodetop['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($nodetopright['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodetopright['img'] . '\');';
	if ($nodetopright['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodetopright['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodetopright['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodetopright['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodetopright['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodetopright['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodetopright['xpos'] . "' AND ypos='" . $nodetopright['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

echo '</tr>';
echo '<tr style="height:100px;">';

if (empty($nodeleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodeleft['img'] . '\');';
	if ($nodeleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodeleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodeleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodeleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodeleft['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodeleft['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodeleft['xpos'] . "' AND ypos='" . $nodeleft['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($node['id'])) {
	echo '<td class="dead">VOID</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $node['img'] . '\');';
	if ($node['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($node['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($node['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($node['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($node['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $node['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $node['xpos'] . "' AND ypos='" . $node['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>1)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($noderight['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $noderight['img'] . '\');';
	if ($noderight['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($noderight['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($noderight['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($noderight['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($noderight['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $noderight['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $noderight['xpos'] . "' AND ypos='" . $noderight['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

echo '</tr>';
echo '<tr style="height:100px;">';

if (empty($nodelowleft['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelowleft['img'] . '\');';
	if ($nodelowleft['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelowleft['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelowleft['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelowleft['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodelowleft['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodelowleft['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodelowleft['xpos'] . "' AND ypos='" . $nodelowleft['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($nodelow['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelow['img'] . '\');';
	if ($nodelow['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelow['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelow['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelow['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodelow['name']=="none")
	{
		echo '">&nbsp;</span>';
	} else {
		echo '"><span class="mapsquare">' . $nodelow['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodelow['xpos'] . "' AND ypos='" . $nodelow['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}

if (empty($nodelowright['id'])) {
	echo '<td class="dead">&nbsp;</td>';
} else {
	if ($_SESSION['ccid'] != 0)
	{
	echo '<td style="vertical-align: middle; width: 33%; border: 0px solid;">&nbsp;</td>';
	} else {
	echo '<td style="vertical-align: middle; width: 33%; background-image:url(\'' . $nodelowright['img'] . '\');';
	if ($nodelowright['cangoup']==0) {echo ' border-top: 1px #f00; border-top-style: dotted;';} else {echo ' border-top: 0px;';}
	if ($nodelowright['cangoleft']==0) {echo ' border-left: 1px #f00; border-left-style: dotted;';} else {echo ' border-left: 0px;';}
	if ($nodelowright['cangoright']==0) {echo ' border-right: 1px #f00; border-right-style: dotted;';} else {echo ' border-right: 0px;';}
	if ($nodelowright['cangodown']==0) {echo ' border-bottom: 1px #f00; border-bottom-style: dotted;';} else {echo ' border-bottom: 0px;';}
	if ($nodelowright['name']=="none")
	{
		echo '">&nbsp;</td>';
	} else {
		echo '"><span class="mapsquare">' . $nodelowright['name'] . '</span><br>';
	}
	$result = mysql_query("SELECT id FROM users WHERE xpos='" . $nodelowright['xpos'] . "' AND ypos='" . $nodelowright['ypos'] . "'") or die(mysql_error());
	$nodepeople = mysql_num_rows($result);
	if ($nodepeople>0)
	{
		echo '<span class="mapsquare2">' . $nodepeople . '&nbsp;online</span>';
	}
	echo '</td>';
	}
}


echo '</tr></table>';
echo '<table style="text-align:center; width: 300px; border:0px solid;">';
echo '<tr><td class="move">'; // Left
echo '<a style="border:0px solid;" href="/move.php?x=' . ($node['xpos']-1) . '&amp;y=' . $node['ypos'] . '"><img src="/img/left' . $_SESSION['style'] . '.png" alt="&lt;"></a>';
echo '</td><td class="move">'; // Up
echo '<a style="border:0px solid;" href="/move.php?x=' . $node['xpos'] . '&amp;y=' . ($node['ypos']+1) . '"><img src="/img/up' . $_SESSION['style'] . '.png" alt="^"></a>';
echo '</td><td class="move">'; // Down
echo '<a style="border:0px solid;" href="/move.php?x=' . $node['xpos'] . '&amp;y=' . ($node['ypos']-1) . '"><img src="/img/down' . $_SESSION['style'] . '.png" alt="v"></a>';
echo '</td><td class="move">'; // Right
echo '<a style="border:0px solid;" href="/move.php?x=' . ($node['xpos']+1) . '&amp;y=' . $node['ypos'] . '"><img src="/img/right' . $_SESSION['style'] . '.png" alt="&gt;"></a>';
echo '</td></tr></table></div>';

?>