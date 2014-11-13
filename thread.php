<?php

require 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {
unset($_SESSION['threadid']); // Just in case!

// Processing the move form...
if ($_POST['formMoveSubmit']==Submit)
{
	$result = mysql_query("SELECT id, boardid, posts FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$thread = mysql_fetch_array($result);
	// Change the post counts.
	mysql_query("UPDATE boards SET posts=(posts-" . $thread['posts'] . ") WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
	mysql_query("UPDATE boards SET posts=(posts+" . $thread['posts'] . ") WHERE id='" . $_POST['formMove'] . "'") or die(mysql_error());
	// Move the thread.
	mysql_query("UPDATE threads SET boardid='" . $_POST['formMove'] . "' WHERE id='" . $thread['id'] . "'") or die(mysql_error());
	header("Location: thread.php?id=" . $_GET['id']);
	die();
}

// Processing quick reply...
if ($_POST['formPostSubmit']==Submit)
{
	$error=0;
	$message = $_POST['formPost'];
	//require_once 'bbc.php';

    //$stringParser = new Parsers/BBCodeParser;

    //$parsedString = $mysqli->real_escape_string($stringParser->parseString($message));
	
	$message = mysql_real_escape_string($message);
	
	$msglength = strlen($message);
	if (empty($message))
	{
		$error=1;
	} elseif ($msglength > $maxtextarealength) {
		$error=2;
	}

	if ($error==0)
	{
		$result = mysql_query("SELECT boardid FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		$thread = mysql_fetch_array($result);
		$tempname = rand(0, 500000);
		mysql_query("INSERT INTO posts (threadid, message, poster) VALUES ('" . $_GET['id'] . "', '" . $tempname . "', '" . $_SESSION['cid'] . "')") or die(mysql_error());
		mysql_query("UPDATE posts SET `originaltime`=`time` WHERE message='" . $tempname . "'") or die(mysql_error());
		mysql_query("UPDATE posts SET `message`='" . $message . "' WHERE message='" . $tempname . "'") or die(mysql_error());
		mysql_query("UPDATE users SET posts=(1+posts) WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
		mysql_query("UPDATE threads SET posts=(1+posts) WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		mysql_query("UPDATE threads SET latestid='" . $_SESSION['cid'] . "' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		mysql_query("UPDATE boards SET posts=(1+posts) WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
		mysql_query("UPDATE settings SET number=(1+number) WHERE id='posts'") or die(mysql_error());
		$result = mysql_query("SELECT `originaltime` FROM posts WHERE threadid='" . $_GET['id'] . "' ORDER BY `originaltime` DESC") or die(mysql_error());
		$latestpost = mysql_fetch_array($result);
		mysql_query("UPDATE threads SET latestpost='" . $latestpost['originaltime'] . "' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		header("Location: thread.php?id=" . $_GET['id']);
		die();
	} elseif ($error==1) {
		$title=Forum;
		include 'header.php';
		echo '<div class="error">You need to enter a message!</div>';
		include 'footer.php';
		die();
	} else {
		$title=Forum;
		include 'header.php';
		echo '<div class="error">Your message is too long. (The maximum length is ' . $maxtextarealength . ' characters.)</div>';
		include 'footer.php';
		die();
	}
}

// Figure out the current page.
if (!empty($_GET['id']) AND empty($_GET['action']))
{
	if (isset($_GET['page']))
	{
		$page = $_GET['page'];
	} else {
		$page = 0;
	}

	$result = mysql_query("SELECT count(*) FROM posts WHERE threadid='" . $_GET['id'] . "'") or die(mysql_error());
	$result2 = mysql_fetch_row($result);
	$numrows = $result2[0]; // Number of posts in thread.
	$rowsPerPage = 15;
	$lastpage = ceil($numrows/$rowsPerPage); // How many pages we'll need.

	// If no page is defined in the URL, redirect to the last page.
	if ($page==0)
	{
		header("Location: thread.php?id=" . $_GET['id'] . "&page=" . $lastpage);
		die();
	}
}

function displayPosts()
{
	require 'settings.php';
	// Show the breadcumb path at the top of the page.
	$result = mysql_query("SELECT id, boardid, name FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$thread = mysql_fetch_array($result);
	$result = mysql_query("SELECT id, name FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
	$board = mysql_fetch_array($result);
	echo '<div><a href="/forum.php">Forum</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> <a href="/board.php?id=' . $board['id'] . '">' . $board['name'] . '</a> <img style="vertical-align: middle;" src="/img/right' . $_SESSION['style'] . '.png" alt="-&gt;" height="5px" width="5px"> ';
	echo '<a href="/thread.php?id=' . $thread['id'] . '">' . $thread['name'] . '</a></div><br>';

	// Figure out the current page.
	if (isset($_GET['page']))
	{
		$page = $_GET['page'];
	} else {
		$page = 0;
	}

	$result = mysql_query("SELECT count(*) FROM posts WHERE threadid='" . $thread['id'] . "'") or die(mysql_error());
	$result2 = mysql_fetch_row($result);
	$numrows = $result2[0]; // Number of posts in thread.
	$lastpage = ceil($numrows/$rowsPerPage); // How many pages we'll need.

	// Make sure the page number is valid (not higher than $lastpage, but higher than 0).
	$page = (int)$page;
	if ($page > $lastpage)
	{
		$page = $lastpage;
	} elseif ($page < 1) {
		$page = 1;
	}
	
	// Display preferences...
	$result = mysql_query("SELECT * FROM prefs WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
	$prefs=mysql_fetch_array($result);

	// Echo the posts into a table.
	echo '<table><tr><th colspan="2">' . $thread['name'] . '</th></tr>';
	$limit = 'LIMIT ' . ($page - 1) * $rowsPerPage . ',' . $rowsPerPage;
	if ($prefs['reverseposts']==1)
	{
		$result = mysql_query("SELECT * FROM posts WHERE threadid='" . $_GET['id'] . "' ORDER BY `originaltime` DESC " . $limit) or die(mysql_error());
	} else {
		$result = mysql_query("SELECT * FROM posts WHERE threadid='" . $_GET['id'] . "' ORDER BY `originaltime` ASC " . $limit) or die(mysql_error());
	}
	while($post = mysql_fetch_array( $result ))
	{
		echo '<tr><td class="thin"><a name="' . $post['id'] . '"></a>';
		$result2 = mysql_query("SELECT user, posts, avatar, cash, `group` FROM users WHERE id='" . $post['poster'] . "'") or die(mysql_error());  
		$poster = mysql_fetch_array($result2);
		
		// Get the colour right.
		if ($poster['group']==0)
		{
			echo '<a href="/profile.php?id=' . $post['poster'] . '">' . $poster['user'] . '</a><br>';
		} else {
			$result3 = mysql_query("SELECT value FROM settings WHERE id='" . $poster['group'] . "color'") or die(mysql_query());
			$proef = mysql_fetch_array($result3);
			echo '<a style="color: ' . $proef['value'] . ';" href="/profile.php?id=' . $post['poster'] . '">' . $poster['user'] . '</a><br>';
		}
		
		$avatar = stripslashes($poster['avatar']);
		if ($prefs['showavs']==1)
		{
			echo '<img width=100px height=100px src="' . $avatar . '" alt="' . $poster['user'] . '\'s avatar"><br>';
		}
		echo '<br>';
		echo 'Cash: $' . $poster['cash'] . '<br>';
		echo 'Posts: ' . $poster['posts'];
		echo '</td><td class="fat">';
		$message = stripslashes($post['message']);
		$message = nl2br($message);
		echo $message;
		echo '</td></tr>';
		echo '<tr><td colspan="2">';
		echo '<a href="/thread.php?id=' . $post['threadid'] . '#' . $post['id'] . '">Posted at ' . $post['originaltime'] . '</a>';
		
		if ($post['edited'] != 0)
		{
			$result3 = mysql_query("SELECT user FROM users WHERE id='" . $post['edited'] . "'") or die(mysql_error());
			$editedby = mysql_fetch_array($result3);
			echo ' - Last edited by ' . $editedby['user'] . ' at ' . $post['time'];
		}
		
		if ($post['poster']==$_SESSION['cid'])
		{
			echo ' - <a href="/edit.php?post=' . $post['id'] . '">Edit</a>';
		} elseif ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7) {
			echo ' - <a href="/edit.php?post=' . $post['id'] . '">Edit</a>';
		}
		echo '</td></tr>';
	}

	// Show page navigation links.
	echo '<tr><td colspan="2"><div class="center">';

	$moreprevpage = $page-2;
	$prevpage = $page-1;
	$nextpage = $page+1;
	$morenextpage = $page+2;

	if ($page == 1)
	{
		echo "| <- ";
	} else {
		echo "<a href='/thread.php?id=" . $_GET['id'] . "&amp;page=1'>1</a> <- ";
	}

	if ($page > 3 AND $lastpage > ($page+2))
	{
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $moreprevpage . '">' . $moreprevpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $morenextpage . '">' . $morenextpage . '</a>';
	} elseif ($page > 3 AND $lastpage > ($page+1)) {
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $moreprevpage . '">' . $moreprevpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
	} elseif ($page > 3) {
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $moreprevpage . '">' . $moreprevpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
	} elseif ($page==3 AND $lastpage > ($page+2)) {
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $morenextpage . '">' . $morenextpage . '</a>';
	} elseif ($page==3 AND $lastpage > ($page+1)) {
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
	} elseif ($page==3) {
		echo '<a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $prevpage . '">' . $prevpage . '</a> ';
		echo $page;
	} elseif ($page < 3 AND $lastpage > ($page+2)) {
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $morenextpage . '">' . $morenextpage . '</a>';
	} elseif ($page < 3 AND $lastpage > ($page+1)) {
		echo $page;
		echo ' <a href="/thread.php?id=' . $_GET['id'] . '&amp;page=' . $nextpage . '">' . $nextpage . '</a> ';
	} else {
		echo $page;
	}

	if ($page == $lastpage)
	{
		echo " -> |";
	} else {
		echo " -> <a href='/thread.php?id=" . $_GET['id'] . "&amp;page=$lastpage'>$lastpage</a>";
	}
	echo '</div></td></tr></table><br>';

	// Show the line of buttons.
	$result = mysql_query("SELECT *  FROM posts WHERE threadid='" . $_GET['id'] . "'") or die(mysql_error());  
	$post = mysql_fetch_array($result);
	$result = mysql_query("SELECT boardid  FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());  
	$thread = mysql_fetch_array($result);
	echo '<span class="button"><a href="/board.php?id=' . $thread['boardid'] . '">Back</a></span>';
	$result = mysql_query("SELECT `lock`, sticky FROM threads WHERE id='" . $post['threadid'] . "'");
	$thread = mysql_fetch_array($result);
	if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
	{
		// Let them post regardless of thread status!
		echo '<span class="button"><a href="/post.php?thread=' . $post['threadid'] . '">Post</a></span>';
		// Lock or unlock?
		if (empty($thread['lock']))
		{
			echo '<span class="button"><a href="/thread.php?id=' . $post['threadid'] . '&amp;action=lock">Lock</a></span>';
		} else {
			echo '<span class="button"><a href="/thread.php?id=' . $post['threadid'] . '&amp;action=lock">Unlock</a></span>';
		}
		// Sticky or unsticky?
		if (empty($thread['sticky']))
		{
			echo '<span class="button"><a href="/thread.php?id=' . $post['threadid'] . '&amp;action=sticky">Sticky</a></span>';
		} else {
			echo '<span class="button"><a href="/thread.php?id=' . $post['threadid'] . '&amp;action=sticky">Unsticky</a></span>';
		}
		// They can even move the thread to another board. HOLY CRAP!!
		echo '<span class="button"><a href="/thread.php?id=' . $post['threadid'] . '&amp;action=move">Move</a></span>';
	} else {
		if (empty($thread['lock']))
		{
			echo '<span class="button"><a href="/post.php?thread=' . $post['threadid'] . '">Post</a></span>';
		} else {
			echo '<span class="button">Locked</span>';
		}
	}
	echo '<span class="button"><a href="/thread.php?id=' . $_GET['id'] . '&amp;action=reply">Quick Reply</a></span>';
	echo '<br><br><a name="bottom"></a>';
	
	// Quick reply
	if ($prefs['quickreply']==1)
	{
		echo '<div class="highlight" style="width: 80%; font-weight: bold; text-align: center; font-variant: small-caps;">quick reply</div>';
		echo '<form action="thread.php?id=' . $_GET['id'] . '" method="post"><div style="text-align: center; width:80%;">';
		echo '<textarea cols="60" rows="10" name="formPost"></textarea><br>';
		echo '<input type="submit" name="formPostSubmit" value="Submit"></form></div>';
	}
}

if (empty($_GET['id']))
{
	header("Location: forum.php");
	die();
} else {
	if (empty($_GET['action']))
	{
		$title=Forum;
		include 'header.php';
		$result = mysql_query("SELECT * FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		$thread = mysql_fetch_array($result);
		$subject = stripslashes($thread['name']);
		$result = mysql_query("SELECT * FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
		$board = mysql_fetch_array($result);
		if ($board['readable'] == 3)
		{
			if ($_SESSION['cgroup'] == 7)
			{
				displayPosts();
			}
		} elseif ($board['readable'] == 2) {
			if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
			{
				displayPosts();
			}
		} elseif (empty($board['readable'])) {
			header("Location: forum.php");
			die();
		} else {
			displayPosts();
		}
	} else {
		if ($_GET['action']=='sticky')
		{
			if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
			{
				$result = mysql_query("SELECT sticky, boardid FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
				$thread = mysql_fetch_array($result);
				$result = mysql_query("SELECT postable FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
				$board = mysql_fetch_array($result);
				if ($board['postable'] != 3)
				{
					if (empty($thread['sticky']))
					{
						mysql_query("UPDATE threads SET sticky='1' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					} else {
						mysql_query("UPDATE threads SET sticky='0' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					}
				} else {
					if ($_SESSION['cgroup']==7)
					{
						if (empty($thread['sticky']))
						{
							mysql_query("UPDATE threads SET sticky='1' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
						} else {
							mysql_query("UPDATE threads SET sticky='0' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
						}
					}
				}
			}
			header("Location: thread.php?id=" . $_GET['id']);
			die();
		}

		if ($_GET['action']=='lock')
		{
			if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
			{
				$result = mysql_query("SELECT `lock`, boardid FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
				$thread = mysql_fetch_array($result);
				$result = mysql_query("SELECT postable FROM boards WHERE id='" . $thread['boardid'] . "'") or die(mysql_error());
				$board = mysql_fetch_array($result);
				if ($board['postable'] != 3)
				{
					if (empty($thread['lock']))
					{
						mysql_query("UPDATE threads SET `lock`='1' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					} else {
						mysql_query("UPDATE threads SET `lock`='0' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					}
				} else {
					if ($_SESSION['cgroup']==7)
					{
						if (empty($thread['lock']))
						{
							mysql_query("UPDATE threads SET `lock`='1' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
						} else {
							mysql_query("UPDATE threads SET `lock`='0' WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
						}
					}
				}
			}
			header("Location: thread.php?id=" . $_GET['id']);
			die();
		}

		if ($_GET['action']=='reply')
		{
			$result = mysql_query("SELECT quickreply FROM prefs WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$prefs = mysql_fetch_array($result);
			if ($prefs['quickreply'] == 1)
			{
				mysql_query("UPDATE prefs SET quickreply=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
				header("Location: thread.php?id=" . $_GET['id'] . "#bottom");
			} else {
				mysql_query("UPDATE prefs SET quickreply=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
				header("Location: thread.php?id=" . $_GET['id'] . "#bottom");
			}
			die();
		}

		if ($_GET['action']=='move')
		{
			if ($_SESSION['cgroup']==6 OR $_SESSION['cgroup']==7)
			{
				$result = mysql_query("SELECT boardid, name FROM threads WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
				$thread = mysql_fetch_array($result);
				if (empty($thread['name']))
				{
					header("Location: thread.php?id=" . $_GET['id']);
					die();
				} else {
					$title=Forum;
					include 'header.php';
					echo '<form action="thread.php?id=' . $_GET['id'] . '" method="post">';
					echo 'Move "' . $thread['name'] . '" to ';
					echo '<select name="formMove">';
					$result = mysql_query("SELECT id, name, readable FROM boards") or die(mysql_error());
					while($board = mysql_fetch_array($result))
					{
						$boardname = stripslashes($board['name']);
						if ($board['readable']==3 AND $_SESSION['cgroup']==7)
						{
							echo '<option value="' . $board['id'] . '">' . $boardname . '</option>';
						} elseif ($board['readable'] != 3) {
							echo '<option value="' . $board['id'] . '">' . $boardname . '</option>';
						}
					}
					echo '</select>';
					echo '<br><br><input type="submit" name="formMoveSubmit" value="Submit"></form>';
				}
			} else {
				header("Location: thread.php?id=" . $_GET['id']);
				die();
			}
		}
	}		
}

}

include 'footer.php';

?>