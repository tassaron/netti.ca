<?php
include 'connect.php';

if ($_SESSION['authorized']==false)
{
header("Location: login.php");
die();
} else {

// If user is sending an email...
if ($_POST['formEmailSubmit']==Submit)
{
	if (empty($_POST['formEmailrecipient'])) {$error=1;}
	if (empty($_POST['formEmailsub'])) {$error=1;}

	// Make sure the message isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
	$msglength = strlen($_POST['formEmailmsg']);
	if (empty($msglength))
	{
		$error=1;
	} elseif ($msglength > $maxtextarealength) {
		$error=2;
	}

	if ($error==1)
	{
		include 'header.php';
		echo '<div class="error">All fields must be filled!</div>';
		include 'footer.php';
		die();
	} elseif ($error==2) {
		include 'header.php';
		echo '<div class="error">Your message is too long. (Maximum length is ' . $maxtextarealength . ' characers.)</div>';
		include 'footer.php';
		die();
	} else {
		$result = mysql_query("SELECT * FROM users WHERE user='" . $_POST['formEmailrecipient'] . "'") or die(mysql_error());
		$recipient = mysql_fetch_array( $result );
		if (empty($recipient['id']))
		{
			include 'header.php';
			echo '<div class="error">Invalid username.</div>';
			include 'footer.php';
			die();
		} else {
			$emailmsg = addslashes($_POST['formEmailmsg']);
			$emailsub = addslashes($_POST['formEmailsub']);
			mysql_query("INSERT INTO email (recipient, sender, subject, message)
			VALUES ('" . $recipient['id'] . "', '" . $_SESSION['cid'] . "'
			,'" . $emailsub . "', '" . $emailmsg . "')")
			or die(mysql_error());
			include 'header.php';
			echo 'Email sent!';
			include 'footer.php';
			die();
		}
	}
}

if ($_GET['action']==reply)
{
	if (empty($_GET['id']))
	{
		// User might want to compose a new email...
		header("Location: email.php?action=compose");
		die();
	}
}

$title=Email;
include 'header.php';

// If there's no action in the url, we're either looking at the inbox or reading a message.
if (empty($_GET['action']))
{
	if (empty($_GET['id']))
	{
		$result = mysql_query("SELECT id, subject, time, sender, `read` FROM email WHERE recipient='" . $_SESSION['cid'] . "'") or die(mysql_error());
		echo '<table><tr><th>Subject</th><th>From</th><th>Time</th></tr>';
		while($email = mysql_fetch_array( $result ))
		{
			$result2 = mysql_query("SELECT id, user FROM users WHERE id='" . $email['sender'] . "'") or die(mysql_error());
			while($sender = mysql_fetch_array( $result2 ))
			{	
				// Create a row.
				echo '<tr><td>';
				echo '<a href="/email.php?id=' . $email['id'] . '">' . $email['subject'] . '</a>';
				if ($email['read']==0) {echo '<span class="highlight"> NEW!</span>';}
				echo '</td><td>';
				echo '<a href="/profile.php?id=' . $sender['id'] . '">' . $sender['user'] . '</a>';
				echo '</td><td>';
				echo $email['time'];
				echo '</td></tr>';
			}
		}
		echo '</table><br><span class="button"><a href="/email.php?action=compose">Compose</a></span>';
	} else {
		$result = mysql_query("SELECT * FROM email WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		$email = mysql_fetch_array( $result );
		$result2 = mysql_query("SELECT * FROM users WHERE id='" . $email['sender'] . "'") or die(mysql_error());
		while($sender = mysql_fetch_array( $result2 ))
		if ($email['recipient']==$_SESSION['cid'])
		{
			if ($email['read']==0)
			{
				mysql_query("UPDATE email SET `read`='1' WHERE id='" . $email['id'] . "'") or die(mysql_error());
			}
			// Preserve linebreaks in the message.
			$message = stripslashes($email['message']);
			echo '<table><tr><th>' . $email['subject'];
			echo ' from <a href="/profile.php?id=' . $sender['id'] . '">' . $sender['user'] . '</a>';
			echo ' at ' . $email['time'] . '</th></tr>';
			echo '<tr><td>' . nl2br($message) . '</td></tr>';
			echo '</table><br><span class="button"><a href="/email.php">Back</a></span>';
			echo '<span class="button"><a href="/email.php?action=reply&amp;id=' . $email['id'] . '">Reply</a></span>';
		} else {
			echo '<div class="error">Invalid ID.</div>';
		}
	}
}

if ($_GET['action']==compose)
{
	echo '<p>Compose new email:';
	echo '<form action="email.php" method="post"><p>';
	// If an id is not specified in the url (from the forum, a profile, etc)...
	if (empty($_GET['id']))
	{
		echo 'Recipient: <input type="text" name="formEmailrecipient" maxlength="30"><br>';
	} else { // Otherwise, lookup the id and insert the appropriate username...
		$result = mysql_query("SELECT * FROM users WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
		$recipient = mysql_fetch_array( $result );
		if (empty($recipient['user']))
		{
			die();
		} else {
			echo 'Recipient: <input type="text" name="formEmailrecipient" maxlength="30" value="' . $recipient['user'] . '"><br>';
		}
	}
	echo 'Subject: <input type="text" name="formEmailsub" maxlength="100" size="70" value="(no subject)"><br>';
	echo '<br>Message:<br><textarea cols="60" rows="6" name="formEmailmsg"></textarea><br>';
	echo '<input type="submit" name="formEmailSubmit" value="Submit"></form>';
}

if ($_GET['action']==reply)
{
	echo '<p>Reply to the email:';
	echo '<form action="email.php" method="post"><p>';
	$result = mysql_query("SELECT * FROM email WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
	$source = mysql_fetch_array( $result );
	if ($source['recipient']==$_SESSION['cid']) // Make sure the source email was actually sent to this user!
	{
		$result = mysql_query("SELECT * FROM users WHERE id='" . $source['sender'] . "'") or die(mysql_error());
		$recipient = mysql_fetch_array( $result );
		if (empty($recipient['user']))
		{
			die();
		} else {
			echo '<p>Recipient: <input type="text" name="formEmailrecipient" maxlength="30" value="' . $recipient['user'] . '"><br>';
			echo 'Subject: <input type="text" name="formEmailsub" maxlength="100" size="70" value="Re: ' . $source['subject'] . '"><br>';
		}
		echo '<br>Message:<br><textarea cols="60" rows="6" name="formEmailmsg"></textarea><br>';
		echo '<input type="submit" name="formEmailSubmit" value="Submit"></form>';
	}
}

}

include 'footer.php';
?>