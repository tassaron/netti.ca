<?php
include 'connect.php';

// If user is logged in, don't do anything.
if ($_SESSION['authorized']==true)
{
	header("Location: index.php");
	die();
}

// Check if form has been submitted and take action accordingly.
if($_POST['formSubmit'] == "Submit")
{
	$error=0;
	// Check if fields are empty. Return an error if some are.
	if (empty($_POST['formUser'])) {$error=1;}
	if (empty($_POST['formPass1'])) {$error=1;}
	if (empty($_POST['formSex'])) {$error=1;}
	$user = addslashes(strip_tags($_POST['formUser']));

	// Ensure both password fields match.
	if ($_POST['formPass1'] != $_POST['formPass2'])
	{
		$error=2;
	}
	
	// Check if username is already in use.
	$query = mysql_query ("SELECT * FROM users WHERE user='$user'");
	$numrows = mysql_num_rows($query);
	if ($numrows !== 0)
	{
		$error=3;
	}
	
	// If there are no errors, add the user to the database.
	if ($error==1)
	{
		include 'header.php';
		echo '<div class="error">The registration form must be completely filled in.</div><br>';
		include 'footer.php';
		die();
	} elseif ($error==2) {
		include 'header.php';
		echo '<div class="error">The password fields must match.</div><br>';
		include 'footer.php';
		die();
	} elseif ($error==3) {
		include 'header.php';
		echo '<div class="error">That username is already in use.</div><br>';
		include 'footer.php';
		die();
	} else {
		addUser();
	}
}

// addUser function to insert user data into database.
function addUser()
{
	// Strip out unwieldy characters.
	$user=addslashes(strip_tags($_POST['formUser']));
	$pass=md5(addslashes($_POST['formPass1']));
	$sex=$_POST['formSex'];
	$email=$_POST['formEmail'];
	$curtime=time();
	// Add user to users table.
	mysql_query("INSERT INTO users (user, pass, email, sex, lastseen) VALUES ('$user','$pass', '$email', '$sex', '$curtime')") or die(mysql_error());
	$result2 = mysql_query("SELECT id FROM users WHERE user='" . $user . "'") or die(mysql_error());
	$user = mysql_fetch_array($result2);
	mysql_query("INSERT INTO prefs (id) VALUES ('" . $user['id'] . "')") or die(mysql_error());
	// Send user a welcome email.
	$result = mysql_query("SELECT value FROM settings WHERE id='welcomesub'") or die(mysql_error());
	$welcomesub = mysql_fetch_array( $result );
	$result = mysql_query("SELECT value FROM settings WHERE id='welcomemsg'") or die(mysql_error());
	$welcomemsg = mysql_fetch_array( $result );
	$result = mysql_query("SELECT * FROM users WHERE user='$user'") or die(mysql_error());
	$register = mysql_fetch_array( $result );
	mysql_query("INSERT INTO email (recipient, sender, subject, message)
	VALUES ('" . $register['id'] . "', '1', '" . $welcomesub['value'] . "', '" . $welcomemsg['value'] . "')")
	or die(mysql_error());
	header("Location: login.php");
	die();
}

$title = Register;
include 'header.php';

if ($register==0)
{
	echo '<form action="register.php" method="post"><p>';
	echo 'Username: <input type="text" name="formUser" maxlength="30" value="' . $user . '"><br>';
	echo 'Password: <input type="password" name="formPass1" maxlength="30"><br>';
	echo 'Confirm password: <input type="password" name="formPass2" maxlength="30"><br>';
	echo 'Sex: <select name="formSex">';
	echo '<option value="0">Pick one</option>';
	echo '<option value="1">Female</option>';
	echo '<option value="2">Male</option>';
	echo '<option value="3">Other</option>';
	echo '</select><br>';
	echo 'Email: <input type="text" name="formEmail" maxlength="50"> <span class="highlight">(optional)</span><br>';
	echo '<input type="submit" name="formSubmit" value="Submit">';
	echo '</form>';
} else {
	echo '<div class="error">Registration is closed.</div>';
}


include 'footer.php';
?>