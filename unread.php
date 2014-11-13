<?php

// All posts more than 1 day old (86400 seconds) are considered read.
$newposts = 0;

$result = mysql_query("SELECT `time` FROM `posts`") or die(mysql_error());
while ($post = mysql_fetch_array($result))
{
	$posttime = time($post['time']);
	if ($posttime > ($row['lastseen']-80))
	{
		if (empty($_SESSION['post' . $post['id'] . '']))
		{
			$newposts+=1;
		}
	}
}

if ($newposts>0)
{
	echo ' <span class="highlight">[' . $newposts . ']</span>';
}

?>