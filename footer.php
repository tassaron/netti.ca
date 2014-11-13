<?php

if ($_SESSION['authorized']==true)
{
	if ($_SESSION['style']==1)
	{
		echo '<p style="line-height:90%;">#<img src="/img/caret.gif" alt=" [caret]"></p>';
	}
}

echo '</div>';

echo '<div id="footer">';
if ($_SESSION['authorized']==true)
{
	if ($_SESSION['style'] != 6)
	{
		echo '<br><br><a href="http://www.yudia.net">&copy; 2011 Yudia</a>';
	}
	
	if ($_SESSION['style']==7)
	{
		echo '<br><a href="http://crayonlegs.com/duncan/">background by Duncan Barrett</a>';
	}
	
	if ($prefs['minutesuntil']==1)
	{
		if ($_SESSION['style'] != 6)
		{
			$minutesuntil = (1-$minutessince);
			$remaining = ($kb_rate*$minutesuntil);
			$remaining = ceil($remaining/60);
			if ($remaining<1) {$remaining=($kb_rate/60);}
			if ($_SESSION['kb'] != ($kb_max+$row['bandw']))
			{
				if ($remaining==1)
				{
					echo '<br>' . $remaining . ' minute until your next kb';
				} else {
					echo '<br>' . $remaining . ' minutes until your next kb';
				}
			}
		}
	}
} else {echo '<br><br><a href="http://www.yudia.net">&copy; 2010 Yudia</a>';}

echo '</div>'; // end the footer
echo '</div>'; // end the wrapper
echo '</div></div></div>'; // end the three bges

echo '</body></html>';

?>