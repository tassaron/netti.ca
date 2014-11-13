<?php
include 'connect.php';

// Function to display the profile.
function displayProfile($display) {

	if ($display['group']==0)
	{
		echo '<span class="highlight">' . $display['user'] . '</span>';
	} else {
		$result = mysql_query("SELECT value FROM settings WHERE id='" . $display['group'] . "color'") or die(mysql_error());
		$pref = mysql_fetch_array($result);
		echo '<span style="color: ' . $pref['value'] . ';">' . $display['user'] . '</span>';
	}

	if (empty($_GET['id']))
	{
		echo ' <a href="/profile.php?action=edit">[edit]</a><br>';
	} else {
		echo ' <a href="/email.php?action=compose&amp;id=' . $display['id'] . '">[send email]</a>';
		
		// If logged-in user is an admin, allow editing regardless
		if ($_SESSION['cgroup']==7)
		{
			echo ' <a href="/admin.php?action=edituser&amp;id=' . $display['id'] . '">[change history forever]</a>';
		}
		
		echo '<br>';
	}
	$avatar = stripslashes($display['avatar']);
	echo '<img width=100 height=100 alt="' . $display['user'] . '\'s avatar" src="' . $avatar . '"><br>';

	if (!empty($display['bio']))
	{
		$bio = stripslashes($display['bio']);
		$bio = nl2br($bio);
		echo $bio;
	}

	// Show add bio button if you have no bio... (just to remind people)
	if (empty($_GET['id']))
	{
		if (empty($display['bio']))
		{
			echo '<a href="/profile.php?action=edit">[add a bio]</a>';
		}
	}
	echo "<br>";

	// Left column
	echo "<div class='leftcol'><p>";
	echo "<ins>General:</ins><br>";
	echo "<span class='highlight'>Level:</span> " . $display['lvl'] . "<br>";
	echo "<span class='highlight'>EXP:</span> " . $display['exp'] . "<br>";
	echo "<span class='highlight'>Physical health:</span> " . $display['phealth'] . "%<br>";
	echo "<span class='highlight'>Mental health:</span> " . $display['mhealth'] . "%<br>";
	echo "<span class='highlight'>Cash:</span> $" . $display['cash'] . "<br><br>";
	echo "<ins>Skills:</ins><br>";
	echo "<span class='highlight'>Attack:</span> " . $display['attack'] . "<br>";
	echo "<span class='highlight'>Defence:</span> " . $display['defence'] . "<br>";
	echo "<span class='highlight'>Stealth:</span> " . $display['stealth'] . "<br>";
	echo "<span class='highlight'>Analysis:</span> " . $display['analysis'] . "<br>";
	echo "<span class='highlight'>Programming:</span> " . $display['programming'] . "<br>";
	echo "</p></div>";

	// Right column
	echo "<div class='rightcol'><p>";
	echo "<ins>System:</ins><br>";
	echo "<span class='highlight'>CPU:</span> " . $display['cpu'] . "<br>";
	echo "<span class='highlight'>Memory:</span> " . $display['mem'] . "<br>";
	echo "<span class='highlight'>Bandwidth bus:</span> " . $display['bandw'] . "<br>";
	echo "<span class='highlight'>Attack firmware:</span> " . $display['attackfirm'] . "<br>";
	echo "<span class='highlight'>Defence firmware:</span> " . $display['defencefirm'] . "<br>";
	echo "<span class='highlight'>Stealth firmware:</span> " . $display['stealthfirm'] . "<br>";
	echo "<span class='highlight'>Analysis firmware:</span> " . $display['analysisfirm'] . "<br><br>";
	echo "<ins>Programs:</ins><br>";
	echo "<span class='highlight'>Medic:</span> " . $display['medic'] . "<br>";
	echo "<span class='highlight'>Virus:</span> " . $display['virus'] . "<br>";
	echo "<span class='highlight'>Shield:</span> " . $display['shield'] . "<br>";
	echo "<span class='highlight'>Deceive:</span> " . $display['deceive'] . "<br>";
	echo "<span class='highlight'>Scan:</span> " . $display['scan'] . "<br>";
	echo "</p></div>";
}

// If user is editing their profile...
if ($_POST['formEditSubmit']==Submit)
{
	$newBio = addslashes($_POST['formEditBio']);
	$biolength = strlen($newBio);
	if ($biolength > $maxbiolength)
	{
		$title=Profile;
		include 'header.php';
		echo '<div class="error">Your bio is too long. (Maximum length is ' . $maxbiolength . ' characters.)</div>';
		include 'footer.php';
		die();
	} else {
		mysql_query("UPDATE users SET bio='" . $newBio . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
	}
	$newAv = addslashes($_POST['formEditAv']);
	mysql_query("UPDATE users SET avatar='" . $newAv . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
	header("Location: profile.php");
	die();
}

// If user is editing their display prefs...
if ($_POST['formEdit2Submit']==Submit)
{
	mysql_query("UPDATE prefs SET style='" . $_POST['formEdit2Style'] . "' WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
	$_SESSION['style'] = $_POST['formEdit2Style'];
	if ($_POST['formEdit2Minutesuntil']==1) {mysql_query("UPDATE prefs SET minutesuntil=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET minutesuntil=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	if ($_POST['formEdit2Kbbar']==1) {mysql_query("UPDATE prefs SET kbbar=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET kbbar=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	if ($_POST['formEdit2Kbpercent']==1) {mysql_query("UPDATE prefs SET kbpercent=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET kbpercent=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	if ($_POST['formEdit2Showavs']==1) {mysql_query("UPDATE prefs SET showavs=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET showavs=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	if ($_POST['formEdit2Reverseposts']==1) {mysql_query("UPDATE prefs SET reverseposts=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET reverseposts=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	if ($_POST['formEdit2Quickreply']==1) {mysql_query("UPDATE prefs SET quickreply=1 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());} else {mysql_query("UPDATE prefs SET quickreply=0 WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());}
	header("Location: profile.php");
	die();
}
			
// This displays to logged out users either the login page, or the limited profile of an id specified in the url.
if ($_SESSION['authorized']==false)
{
	
	if (empty($_GET['id']))
	{
		header("Location: login.php");
		die();
	} else {
		$title=Profile;
		include 'header.php';
		$id = $_GET['id'];
		$result = mysql_query("SELECT * FROM users WHERE id='$id'") or die(mysql_error());
		if (mysql_num_rows($result)==0)
		{
			echo '<div class="error">No such user.</div>';
			include 'footer.php';
			die();
		} else {
			$profile = mysql_fetch_array($result);
			displayProfile($profile);
		}
	}
// This displays to logged in users either their own profile, or the full profile of an id specified in the url.
} else {

	if ($_GET['action']=='edit')
	{
		if (empty($_GET['id']))
		{
			$title=Profile;
			include 'header.php';
			echo '<span class="highlight">[profile]</span> <a href="/profile.php?action=edit2">[display]</a>';
			echo '<p>Edit your profile:';
			echo '<form action="profile.php" method="post"><p>';
			$result = mysql_query("SELECT bio, avatar FROM users WHERE id='" . $_SESSION['cid'] . "'") or die(mysql_error());
			$user = mysql_fetch_array($result);
			echo '<table style="border: 0px solid;">';
			echo '<tr><td style="border: 0px; width: 50%;">Direct URL to avatar:<br>(must be 100*100 pixels)</td><td style="border: 0px;">';
			$avatar = stripslashes($user['avatar']);
			echo '<img width=100 height=100 alt="Your avatar" src="' . $avatar . '"><br>';
			echo '<input type="text" name="formEditAv" maxlength="100" size="50" value="' . $avatar . '"</td>';
			echo '<tr><td style="border: 0px; width: 50%;">Bio:</td><td style="border: 0px;">';
			$bio = stripslashes($user['bio']);
			echo '<textarea cols="60" rows="6" name="formEditBio">' . $bio . '</textarea></td></tr>';
			echo '</table>';
			echo '<br><input type="submit" name="formEditSubmit" value="Submit"></form>';
		}
	}

	if ($_GET['action']=='edit2')
	{
		if (empty($_GET['id']))
		{
			$title=Profile;
			include 'header.php';
			echo '<a href="profile.php?action=edit">[profile]</a> <span class="highlight">[display]</span>';
			echo '<p>Edit your display preferences:';
			echo '<form action="profile.php" method="post"><p>';
			
			echo '<table style="border: 0px solid;">';
			echo '<tr><td style="border: 0px; width: 50%;">Stylesheet:</td><td style="border: 0px;">';
			echo '<select name="formEdit2Style">';
			if ($_SESSION['style']==1) {echo '<option style="background-color: #000000; color: #00FF00; font-family: fixedsys, monospace;" value="1" selected>Terminal</option>';} else {echo '<option style="background-color: #000000; color: #00FF00; font-family: fixedsys, monospace;" value="1">Terminal</option>';}
			if ($_SESSION['style']==2) {echo '<option style="background-color: #F3F3F3; color: #000000; font-family: Arial, sans-serif;" value="2" selected>Paper</option>';} else {echo '<option style="background-color: #F3F3F3; color: #000000; font-family: Arial, sans-serif;" value="2">Paper</option>';}
			if ($_SESSION['style']==3) {echo '<option style="background-color: #7E4901; color: #FFFFFF; font-family: Georgia, serif;" value="3" selected>Mocha</option>';} else {echo '<option style="background-color: #7E4901; color: #FFFFFF; font-family: Georgia, serif;" value="3">Mocha</option>';}
			if ($_SESSION['style']==4) {echo '<option style="background-color: #00485c; color: #EC3B86; font-family: Georgia, serif;" value="4" selected>Vagina</option>';} else {echo '<option style="background-color: #00485c; color: #EC3B86; font-family: Georgia, serif;" value="4">Vagina</option>';}
			if ($_SESSION['style']==5) {echo '<option style="background: url(/img/style5bg2.png); background-repeat: repeat; color: #FFFFFF; font-family: Arial, sans-serif;" value="5" selected>Queer</option>';} else {echo '<option style="background: url(/img/style5bg2.png); background-repeat: repeat; color: #FFFFFF; font-family: Arial, sans-serif;" value="5">Queer</option>';}
			if ($_SESSION['style']==6) {echo '<option style="background-color: #000080; color: #FFFFFF; font-family: System, Arial, sans-serif;" value="6" selected>Windows</option>';} else {echo '<option style="background-color: #000080; color: #FFFFFF; font-family: System, Arial, sans-serif;" value="6">Windows</option>';}
			if ($_SESSION['style']==7) {echo '<option style="background-color: #238E23; color: #FFFFFF; font-family: Arial, sans-serif;" value="7" selected>Jungle</option>';} else {echo '<option style="background-color: #238E23; color: #FFFFFF; font-family: Arial, sans-serif;" value="7">Jungle</option>';}
			if ($_SESSION['style']==8) {echo '<option style="background-color: #fefefe; color: #000000; font-family: Arial, sans-serif;" value="8" selected>Desktop</option>';} else {echo '<option style="background-color: #fefefe; color: #000000; font-family: Arial, sans-serif;" value="8">Desktop</option>';}
			if ($_SESSION['style']==9) {echo '<option style="background: url(/img/style9bg.png); background-repeat: repeat; color: #FFFFFF; font-family: Arial, sans-serif; font-weight: bold;" value="9" selected>Bromden</option>';} else {echo '<option style="background: url(/img/style9bg.png); background-repeat: repeat; color: #FFFFFF; font-family: Arial, sans-serif; font-weight: bold;" value="9">Bromden</option>';}
			if ($_SESSION['style']==10) {echo '<option style="background-color: #000000; color: #FFFFFF; font-family: Arial, sans-serif; font-weight: bold;" value="10" selected>Operator</option>';} else {echo '<option style="background-color: #000000; color: #FFFFFF; font-family: Arial, sans-serif; font-weight: bold;" value="10">Operator</option>';}
			echo '</select>';
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">Show minutes until next kb:</td><td style="border: 0px;">';
			if ($prefs['minutesuntil']==1) {echo '<input type="checkbox" name="formEdit2Minutesuntil" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Minutesuntil" value="1">';}
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">Display remaining bandwidth in a bar:</td><td style="border: 0px;">';
			if ($prefs['kbbar']==1) {echo '<input type="checkbox" name="formEdit2Kbbar" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Kbbar" value="1">';}
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">Display bandwidth as a percentage:</td><td style="border: 0px;">';
			if ($prefs['kbpercent']==1) {echo '<input type="checkbox" name="formEdit2Kbpercent" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Kbpercent" value="1">';}
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">Show users\' avatars on the forum:</td><td style="border: 0px;">';
			if ($prefs['showavs']==1) {echo '<input type="checkbox" name="formEdit2Showavs" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Showavs" value="1">';}
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">List most recent posts first:</td><td style="border: 0px;">';
			if ($prefs['reverseposts']==1) {echo '<input type="checkbox" name="formEdit2Reverseposts" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Reverseposts" value="1">';}
			echo '</td></tr>';
			echo '<tr><td style="border: 0px; width: 50%;">Show quick reply inside threads:</td><td style="border: 0px;">';
			if ($prefs['quickreply']==1) {echo '<input type="checkbox" name="formEdit2Quickreply" value="1" checked>';} else {echo '<input type="checkbox" name="formEdit2Quickreply" value="1">';}
			echo '</td></tr>';
			echo '</table><br>';
			echo '<input type="submit" name="formEdit2Submit" value="Submit"></p></form></p>';
		}
	}

	// Only check the id if there's no 'action' in the url.
	if (empty($_GET['action'])){
	if (empty($_GET['id']))
	{
		$id = $_SESSION['cid'];
	} else {
		$id = $_GET['id'];
	}
	$title=Profile;
	include 'header.php';
	$result = mysql_query("SELECT * FROM users WHERE id='$id'") or die(mysql_error());
	if (mysql_num_rows($result)==0)
	{
		echo '<div class="error">No such user.</div>';
	} else {
		$profile = mysql_fetch_array($result);
		displayProfile($profile);
	}}
}

include 'footer.php';
?>