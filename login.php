<?php
include 'connect.php';

// Log user out if they're logged in.
if ($_SESSION['authorized']==true)
{
	session_destroy();
	header("Location: index.php");
	die();
}

// If the form has been submitted, check against database.
if($_POST['formSubmit'] == "Submit")
{
	$user = $_POST['formUser'];
	$pass = md5($_POST['formPass']);
	$result = mysql_query('select * from users where user = "' . $user . '" and pass = "' . $pass . '"') or die(mysql_error());

	// If the user/pass combo matches...
	if (mysql_num_rows($result) !== 0) 
	{
		$_SESSION['authorized'] = true;
		$result = mysql_query('select * from users where user = "' . $user . '"') or die(mysql_error());
		$row = mysql_fetch_array($result);
		$result = mysql_query("SELECT `style` FROM `prefs` WHERE `id`='" . $row['id'] . "'") or die(mysql_error());
		$style = mysql_fetch_array($result);
		$_SESSION['cid'] = $row['id'];
		$_SESSION['cuser'] = $row['user'];
		$_SESSION['cgroup'] = $row['group'];
		$_SESSION['cxpos'] = $row['xpos'];
		$_SESSION['cypos'] = $row['ypos'];
		$_SESSION['ccid'] = $row['contractid'];
		$_SESSION['ccxpos'] = $row['contractx'];
		$_SESSION['ccypos'] = $row['contracty'];
		$_SESSION['kb'] = $row['kb'];
		$_SESSION['style'] = $style['style'];
		header("Location: profile.php");
		die();
	}
}

$title=Login;
include 'header.php';

$user = stripslashes($user);
?>

<form action="login.php" method="post">

Username: <input type="text" name="formUser" maxlength="30" value="<?=$user;?>"><br>
Password: <input type="password" name="formPass" maxlength="30"><br>

<input type="submit" name="formSubmit" value="Submit">
</form>

<?php
include 'footer.php';
?>