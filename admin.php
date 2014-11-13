<?php
include 'connect.php';

// If user is logged in...
if ($_SESSION['authorized']==false)
{
	// User is not even logged in.
	header("Location: login.php");
} else {
	// If user is an admin...
	if ($_SESSION['cgroup']==7)
	{
		// If user is changing subtitle...
		if ($_POST['formSubtitleSubmit']==Submit)
		{
			// Escape troublesome characters first.
			$newSubtitle = addslashes($_POST['formSubtitle']);
			mysql_query("UPDATE settings SET value='" . $newSubtitle . "' WHERE id='subtitle'") or die(mysql_error());
			header("Location: admin.php");
			die();
		}

		// If user is changing welcome email...
		if ($_POST['formWelcomeSubmit']==Submit)
		{
			// Make sure the textarea input isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
			$error=0;
			$msglength = strlen($_POST['formWelcomemsg']);
			if ($msglength > $maxtextarealength)
			{
				$error=1;
			}

			if ($error==0)
			{
				mysql_query("UPDATE settings SET value='" . $_POST['formWelcomesub'] . "' WHERE id='welcomesub'") or die(mysql_error());
				mysql_query("UPDATE settings SET value='" . $_POST['formWelcomemsg'] . "' WHERE id='welcomemsg'") or die(mysql_error());
				header("Location: admin.php");
				die();
			} else {
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The message is too long. (Maximum is ' . $maxtextarealength . ' characters.)</div>';
				include 'footer.php';
				die();
			}
		}

		// If user is sending a mass email...
		if ($_POST['formMassemailSubmit']==Submit)
		{
			// Make sure the textarea input isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
			$error=0;
			$message = addslashes($_POST['formMassemailmsg']);
			$msglength = strlen($message);
			if ($msglength > $maxtextarealength)
			{
				$error=1;
			}

			if ($error==0)
			{
				$result = mysql_query("SELECT * FROM users");
				while($recipient = mysql_fetch_array( $result ))
				{
					mysql_query("INSERT INTO email (recipient, sender, subject, message)
					VALUES ('" . $recipient['id'] . "', '" . $_SESSION['cid'] . "'
					,'" . $_POST['formMassemailsub'] . "', '" . $message . "')")
					or die(mysql_error());
					header("Location: admin.php");
					die();
				}
			} else {
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The message is too long.</div>';
				include 'footer.php';
				die();
			}
		}

		// If user is editing a user...
		if ($_POST['formEdituserSubmit']==Submit)
		{
			// Make sure the bio input isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
			$newBio = addslashes($_POST['formEdituserBio']);
			$error=0;
			$biolength = strlen($newBio);
			if ($biolength > $maxbiolength)
			{
				$error=1;
			}

			if ($error==0)
			{
			$newSex = $_POST['formEdituserSex'];
			$newGroup = $_POST['formEdituserGroup'];
			$newAvatar = $_POST['formEdituserAvatar'];
			$newCash = $_POST['formEdituserCash'];
			$newUser = addslashes($_POST['formEdituserUser']);
			$newEmail = $_POST['formEdituserEmail'];
			$newPhealth = $_POST['formEdituserPhealth'];
			$newMhealth = $_POST['formEdituserMhealth'];
			$newLvl = $_POST['formEdituserLvl'];
			$newExp = $_POST['formEdituserExp'];
			$newAttack = $_POST['formEdituserAttack'];
			$newDefence = $_POST['formEdituserDefence'];
			$newStealth = $_POST['formEdituserStealth'];
			$newAnalysis = $_POST['formEdituserAnalysis'];
			mysql_query("UPDATE users SET analysis='" . $newAnalysis . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET stealth='" . $newStealth . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET defence='" . $newDefence . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET attack='" . $newAttack . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET exp='" . $newExp . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET lvl='" . $newLvl . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET bio='" . $newBio . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET mhealth='" . $newMhealth . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET phealth='" . $newPhealth . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET email='" . $newEmail . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET user='" . $newUser . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET cash='" . $newCash . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET avatar='" . $newAvatar . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET `group`='" . $newGroup . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			mysql_query("UPDATE users SET sex='" . $newSex . "' WHERE id='" . $_SESSION['edituserid'] . "'") or die(mysql_error());
			// Free up the temporary session variable.
			unset($_SESSION['edituserid']);
			header("Location: admin.php");
			die();
			} else {
			$title=Admin;
			include 'header.php';
			echo '<div class="error">The bio is too long. (Maximum is ' . $maxbiolength . ' characters.)</div>';
			include 'footer.php';
			die();
			}
		}
		
		// If user is changing group colors...
		if ($_POST['formGroupcolorsSubmit']==Submit)
		{
			mysql_query("UPDATE settings SET value='" . $_POST['form7color'] . "' WHERE id='6color'") or die(mysql_error());
			mysql_query("UPDATE settings SET value='" . $_POST['form7color'] . "' WHERE id='7color'") or die(mysql_error());
			mysql_query("UPDATE settings SET value='" . $_POST['form7color'] . "' WHERE id='8color'") or die(mysql_error());
			header("Location: admin.php");
			die();
		}

		// If user is adding an item...
		if ($_POST['formAdditemSubmit']==Submit)
		{
			$error=0;
			// Check if fields are empty. Return an error if some are.
			if (empty($_POST['formAdditemItem'])) {$error=1;}
			if (empty($_POST['formAdditemCost'])) {$error=1;}
			if (empty($_POST['formAdditemType'])) {$error=1;}
			if (empty($_POST['formAdditemPower'])) {$error=1;}
			if (empty($_POST['formAdditemMem'])) {$error=1;}
			if (empty($_POST['formAdditemShop'])) {$error=1;}
			if (empty($_POST['formAdditemDesc'])) {$error=1;}
			$desc = addslashes($_POST['formAdditemDesc']);
			$desclength = strlen($desc);
			if ($desclength > $maxbiolength)
			{
				$error=2;
			}
			
			// If there are no errors, add the item.
			if ($error==1)
			{
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The form must be completely filled in.</div><br>';
				include 'footer.php';
				die();
			} elseif ($error==2) {
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The description is too long. (Maximum length is ' . $maxbiolength . ' characters.)</div><br>';
				include 'footer.php';
				die();
			} else {
				$item=addslashes($_POST['formAdditemItem']);
				mysql_query("INSERT INTO items (item, `desc`, cost, type, power, mem, shop)
				VALUES ('$item', '" . $desc . "', '" . $_POST['formAdditemCost'] . "', '"
				 . $_POST['formAdditemType'] . "', '" . $_POST['formAdditemPower'] . "', '"
				 . $_POST['formAdditemMem'] . "', '" . $_POST['formAdditemShop'] . "')") or die(mysql_error());
				header("Location: admin.php");
				die();
			}
		}

		// If user is editing an item...
		if ($_POST['formEdititemSubmit']==Submit)
		{
			// Make sure the desc input isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
			$newDesc = addslashes($_POST['formEdititemDesc']);
			$error=0;
			$desclength = strlen($newDesc);
			if ($desclength > $maxbiolength)
			{
				$error=1;
			}

			if ($error==0)
			{
			$newItem = $_POST['formEdititemItem'];
			$newCost = $_POST['formEdititemCost'];
			$newType = $_POST['formEdititemType'];
			$newPower = $_POST['formEdititemPower'];
			$newMem = $_POST['formEdititemMem'];
			$newShop = $_POST['formEdititemShop'];
			mysql_query("UPDATE items SET shop='" . $newShop . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET mem='" . $newMem . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET power='" . $newPower . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET type='" . $newType . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET cost='" . $newCost . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET item='" . $newItem . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			mysql_query("UPDATE items SET `desc`='" . $newDesc . "' WHERE id='" . $_SESSION['edititemid'] . "'") or die(mysql_error());
			// Free up the temporary session variable.
			unset($_SESSION['edititemid']);
			header("Location: admin.php");
			die();
			} else {
			$title=Admin;
			include 'header.php';
			echo '<div class="error">The description is too long. (Maximum is ' . $maxbiolength . ' characters.)</div>';
			include 'footer.php';
			die();
			}
		}
		
		// Adding a network...
		if ($_POST['formAddnetworkSubmit']==Submit)
		{
			$networkname = $_POST['formAddnetworkName'];
			mysql_query("INSERT INTO networks (name) VALUES ('" . $networkname . "')") or die(mysql_error());
			header("Location: admin.php");
			die();
		}
		
		// Edting a network...
		if ($_POST['formEditnetworkSubmit']==Submit)
		{
			$networkname = $_POST['formEditnetworkName'];
			mysql_query("UPDATE networks SET name='" . $networkname . "' WHERE id='" . $_SESSION['editnetworkid'] . "'") or die(mysql_error());
			unset($_SESSION['editnetworkid']);
			header("Location: admin.php");
			die();
		}
			

		// Adding a node to a network...
		if ($_POST['formAddnodeSubmit']==Submit)
		{
			$error=0;
			// Check if fields are empty. Return an error if some are.
			if (empty($_POST['formAddnodeName'])) {$error=1;}
			if ($_POST['formAddnodeNetwork']==0) {$error=1;}
			if ($_POST['formAddnodeXpos']==x) {$error=1;}
			if ($_POST['formAddnodeYpos']==y) {$error=1;}
			if (empty($_POST['formAddnodeDesc'])) {$error=1;}
			$desc = addslashes($_POST['formAddnodeDesc']);
			$desclength = strlen($desc);
			if ($desclength > $maxtextarealength)
			{
				$error=2;
			}
			if ($_POST['formAddnodeCangoup']==cangoup) {$cangoup=1;} else {$cangoup=0;}
			if ($_POST['formAddnodeCangoleft']==cangoleft) {$cangoleft=1;} else {$cangoleft=0;}
			if ($_POST['formAddnodeCangoright']==cangoright) {$cangoright=1;} else {$cangoright=0;}
			if ($_POST['formAddnodeCangodown']==cangodown) {$cangodown=1;} else {$cangodown=0;}
			
			// If there are no errors, add the node.
			if ($error==1)
			{
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The form must be completely filled in.</div><br>';
				include 'footer.php';
				die();
			} elseif ($error==2) {
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The description is too long. (Maximum length is ' . $maxtextarealength . ' characters.)</div><br>';
				include 'footer.php';
				die();
			} else {
				$name=addslashes($_POST['formAddnodeName']);
				mysql_query("INSERT INTO nodes (name, `desc`, networkid, xpos, ypos, cangoup, cangodown, cangoleft, cangoright, img)
				VALUES ('" . $name . "', '" . $desc . "', '" . $_POST['formAddnodeNetwork'] . "', '"
				 . $_POST['formAddnodeXpos'] . "', '" . $_POST['formAddnodeYpos'] . "', '" . $cangoup . "', '"
				 . $cangodown . "', '" . $cangoleft . "', '" . $cangoright . "', '" . $_POST['formAddnodeTile'] . "')") or die(mysql_error());
				$result = mysql_query("SELECT id FROM nodes WHERE xpos='" . $_POST['formAddnodeXpos'] . "' AND ypos='" . $_POST['formAddnodeYpos'] . "'") or die(mysql_error());
				$newnode = mysql_fetch_array($result);
				header("Location: admin.php?action=editnode&id=" . $newnode['id']);
				die();
			}
		}
		
		// If user is editing a node...
		if ($_POST['formEditnodeSubmit']==Submit)
		{
			// Make sure the desc input isn't too long... (thanks to HTML 4.01 for not having a maxlength attribute)
			$newDesc = addslashes($_POST['formEditnodeDesc']);
			$error=0;
			$desclength = strlen($newDesc);
			if ($desclength > $maxtextarealength)
			{
				$error=1;
			}

			if ($error==0)
			{
			$newName = addslashes($_POST['formEditnodeName']);
			$newXpos = $_POST['formEditnodeXpos'];
			$newYpos = $_POST['formEditnodeYpos'];
			$newNetwork = $_POST['formEditnodeNetwork'];
			$newTile = $_POST['formEditnodeTile'];
			if ($_POST['formEditnodeCangoup']==cangoup)
			{
				$newCangoup = 1;
			} else {
				$newCangoup = 0;
			}
			if ($_POST['formEditnodeCangoleft']==cangoleft)
			{
				$newCangoleft = 1;
			} else {
				$newCangoleft = 0;
			}
			if ($_POST['formEditnodeCangoright']==cangoright)
			{
				$newCangoright = 1;
			} else {
				$newCangoright = 0;
			}
			if ($_POST['formEditnodeCangodown']==cangodown)
			{
				$newCangodown = 1;
			} else {
				$newCangodown = 0;
			}
			mysql_query("UPDATE nodes SET name='" . $newName . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET `desc`='" . $newDesc . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET xpos='" . $newXpos . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET ypos='" . $newYpos . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET networkid='" . $newNetwork . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET cangoup='" . $newCangoup . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET cangoleft='" . $newCangoleft . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET cangoright='" . $newCangoright . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET cangodown='" . $newCangodown . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			mysql_query("UPDATE nodes SET img='" . $newTile . "' WHERE id='" . $_SESSION['editnodeid'] . "'") or die(mysql_error());
			// Free up the temporary session variable.
			header("Location: admin.php?action=editnode&id=" . $_SESSION['editnodeid']);
			die();
			} else {
			$title=Admin;
			include 'header.php';
			echo '<div class="error">The description is too long. (Maximum is ' . $maxtextarealength . ' characters.)</div>';
			include 'footer.php';
			die();
			}
		}

		// If user is adding an object...
		if ($_POST['formAddobjSubmit']==Submit)
		{
			$error=0;
			if ($_POST['formAddobjWhatid']==0) {$error=1;}
			$msgdestroy = addslashes($_POST['formAddobjMsgdestroy']);
			$msglength = strlen($msgdestroy);
			if ($msglength > $maxtextarealength)
			{
				$error=2;
			}
			$msgother = addslashes($_POST['formAddobjMsgother']);
			$msglength = strlen($msgother);
			if ($msglength > $maxtextarealength)
			{
				$error=2;
			}
			
			// If there are no errors, add the object.
			if ($error==1)
			{
				$title=Admin;
				include 'header.php';
				echo '<div class="error">The form must be completely filled in.</div><br>';
				include 'footer.php';
				die();
			} elseif ($error==2) {
				$title=Admin;
				include 'header.php';
				echo '<div class="error">Your message is too long. (Maximum length is ' . $maxtextarealength . ' characters.)</div><br>';
				include 'footer.php';
				die();
			} else {
				mysql_query("INSERT INTO objects (type, whatid, before1, before2, before3, before4, after1, after2, after3, after4, destroymsg, othermsg) VALUES ('" . $_SESSION['objtype'] . "', '" . $_POST['formAddobjWhatid'] . "', '" . $_POST['formAddobjBefore1'] . "', '" . $_POST['formAddobjBefore2'] . "', '" . $_POST['formAddobjBefore3'] . "', '" . $_POST['formAddobjBefore4'] . "', '" . $_POST['formAddobjAfter1'] . "', '" . $_POST['formAddobjAfter2'] . "', '" . $_POST['formAddobjAfter3'] . "', '" . $_POST['formAddobjAfter4'] . "', '" . $msgdestroy . "', '" . $msgother . "')") or die(mysql_error());
				unset($_SESSION['objtype']);
				header("Location: admin.php");
				die();
			}
		}
		
		$title=Admin;
		include 'header.php';
		
		// If user is performing an action (not processing one)...
		if (empty($_GET['action']))
		{
			// Here's the admin panel.
			echo 'ADMIN PANEL: (<a href="/admin.php?action=help">confused?</a>)<br><br>';
			echo '<div class="leftcol">Globals:<ul>';
			echo '<li><a href="/hire">Access phpMyAdmin.</a></li>';
			echo '<li><a href="?action=subtitle">Change the subtitle.</a></li>';
			echo '<li><a href="?action=edituser">Edit a user profile.</a></li>';
			echo '<li><a href="?action=welcome">Change welcome email.</a></li>';
			echo '<li><a href="?action=massemail">Send mass email.</a></li>';
			echo '<li><a href="?action=groupcolours">Change group colours.</a></li>';
			echo '</ul>Forum:<ul>';
			echo '<li><a href="?action=addboard">Create a new board.</a></li>';
			echo '<li><a href="?action=editboard">Edit an existing board.</a></li>';
			echo '<li><a href="?action=delboard">Mass delete stuff.</a></li>';
			echo '</ul>Systems:<ul>';
			echo '<li><a href="?action=addsystem">Create part of a system.</a></li>';
			echo '<li><a href="?action=editsystem">Edit part of a system.</a></li>';
			echo '<li><a href="?action=delsystem">Delete part of a system.</a></li>';
			echo '<li><a href="?action=addiobj">Create an item object.</a></li>';
			echo '<li><a href="?action=editiobj">Edit an item object.</a></li>';
			echo '<li><a href="?action=deliobj">Delete an item object.</a></li>';
			echo '<li><a href="?action=addhobj">Create a hostile object.</a></li>';
			echo '<li><a href="?action=edithobj">Edit a hostile object.</a></li>';
			echo '<li><a href="?action=delhobj">Delete a hostile object.</a></li>';
			echo '</ul></div>';
			echo '<div class="rightcol">Items:<ul>';
			echo '<li><a href="?action=additem">Add an item to the game.</a></li>';
			echo '<li><a href="?action=edititem">Edit an item.</a></li>';
			echo '<li><a href="?action=delitem">Delete an item.</a></li>';
			echo '</ul>Internet:<ul>';
			echo '<li><a href="?action=addnetwork">Add a network to the internet.</a></li>';
			echo '<li><a href="?action=editnetwork">Edit a network.</a></li>';
			echo '<li><a href="?action=delnetwork">Delete a network.</a></li>';
			echo '<li><a href="?action=addnode">Add a node to a network.</a></li>';
			echo '<li><a href="?action=editnode">Edit a node.</a></li>';
			echo '<li><a href="?action=delnode">Delete a node.</a></li>';
			echo '<li><a href="?action=addcontract">Add a contract to the game.</a></li>';
			echo '<li><a href="?action=editcontract">Edit a contract.</a></li>';
			echo '<li><a href="?action=delncontract">Delete a contract.</a></li>';
			echo '</ul>';
			echo '<span class="highlight">Nettica v' . $version . '</span><br>';
			echo '<span class="highlight">Programmed by Bran Rainey</span><br>';
			echo '<span class="highlight">&copy; 2011 Yudia</span>';
			echo '</div>';
		} else {
			if ($_GET['action']=='subtitle')
			{
				echo '<p>Subtitle:';
				echo '<form action="admin.php" method="post"><p>';
				echo '<input type="text" name="formSubtitle" maxlength="100" size="60" value="' . $subtitle . '">';
				echo '<input type="submit" name="formSubtitleSubmit" value="Submit"></p></form>';
			}elseif ($_GET['action']=='welcome') {
				echo '<p>This is the in-game email that is sent to new users when they register:';
				$result = mysql_query("SELECT * FROM settings WHERE id='welcomesub'") or die(mysql_error());
				$welcomesub = mysql_fetch_array( $result );
				$result = mysql_query("SELECT * FROM settings WHERE id='welcomemsg'") or die(mysql_error());
				$welcomemsg = mysql_fetch_array( $result );
				echo '<form action="admin.php" method="post"><p>';
				echo '<input type="text" name="formWelcomesub" maxlength="100" size="70" value="' . $welcomesub['value'] . '"><br>';
				echo '<textarea cols="60" rows="6" name="formWelcomemsg">' . $welcomemsg['value'] . '</textarea><br>';
				echo '<input type="submit" name="formWelcomeSubmit" value="Submit"></p></form>';
			}elseif ($_GET['action']=='massemail') {
				echo '<p>Send an in-game email to every non-banned user from your account:<br><br>';
				echo '<span class="highlight">CAUTION: </span>This will strain the database under some conditions.<br>';
				echo '<div class="error">Use only when absolutely necessary!</div><br><br>';
				echo '<form action="admin.php" method="post"><p>';
				echo '<input type="text" name="formMassemailsub" maxlength="100" size="70" value="(no subject)"><br>';
				echo '<textarea cols="60" rows="6" name="formMassemailmsg"></textarea><br>';
				echo '<input type="submit" name="formMassemailSubmit" value="Submit"></p></form>';
			} elseif ($_GET['action']=='edituser') {
				// If there's no id specified, display a list of users.
				if (empty($_GET['id']))
				{
					echo 'Select a user to edit:';
					// Get contents of user table.
					$result = mysql_query("SELECT id, user FROM users") or die(mysql_error());  
					// Echo the user list into a list.
					echo '<ul>';
					while($row = mysql_fetch_array( $result ))
					{
						echo '<li><a href="/admin.php?action=edituser&amp;id=' . $row['id'] . '">' . $row['user'] . '</a></li>';
					}
					echo '</ul>';
				} else {
					$result = mysql_query("SELECT * FROM users WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					$row = mysql_fetch_array( $result );
					echo "Editing " . $row['user'] . " (ID " . $row['id'] . "):";

					// Save edited user id to session so it can be retrieved during processing.
					$_SESSION['edituserid'] = $row['id'];

					echo '<p><form action="admin.php" method="post">';
					echo '<div class="leftcol"><span class="highlight">General:</span><br>';
					echo 'Username: <input type="text" name="formEdituserUser" maxlength="30" value="' . $row['user'] . '"><br>';
					echo 'Email: <input type="text" name="formEdituserEmail" maxlength="50" value="' . $row['email'] . '"><br>';
					echo 'Avatar: <input type="text" name="formEdituserAvatar" maxlength="100" value="' . $row['avatar'] . '"><br>';
					echo 'Cash: <input type="text" name="formEdituserCash" maxlength="9" value="' . $row['cash'] . '"><br>';
					echo 'Physical: <input type="text" name="formEdituserPhealth" maxlength="3" value="' . $row['phealth'] . '"><br>';
					echo 'Mental: <input type="text" name="formEdituserMhealth" maxlength="3" value="' . $row['mhealth'] . '"><br>';
					echo 'Sex: <select name="formEdituserSex">';
					if ($row['sex']==1) {echo '<option value="1" selected>Female</option>';} else {
					echo '<option value="1">Female</option>';}
					if ($row['sex']==2) {echo '<option value="2" selected>Male</option>';} else {
					echo '<option value="2">Male</option>';}
					if ($row['sex']==3) {echo '<option value="3" selected>Other</option>';} else {
					echo '<option value="3">Other</option>';}
					echo '</select>';
					$bio = stripslashes($row['bio']);
					echo '<br>Bio:<br><textarea name="formEdituserBio" cols="20" rows="5">' . $bio . '</textarea><br>';
					echo 'Group: <select name="formEdituserGroup">';
					if ($row['group']==0) {echo '<option value="0" selected>Normal</option>';} else {
					echo '<option value="0">Normal</option>';}
					if ($row['group']==6) {echo '<option value="6" selected>Moderator</option>';} else {
					echo '<option value="6">Moderator</option>';}
					if ($row['group']==7) {echo '<option value="7" selected>Admin</option>';} else {
					echo '<option value="7">Admin</option>';}
					if ($row['group']==8) {echo '<option value="8" selected>Banned</option>';} else {
					echo '<option value="8">Banned</option>';}
					echo '</select>';
					echo '</div>';
					echo '<div class="rightcol"><span class="highlight">Stats:</span><br>';
					echo 'Level: <input type="text" name="formEdituserLvl" maxlength="3" value="' . $row['lvl'] . '"><br>';
					echo 'EXP: <input type="text" name="formEdituserExp" maxlength="9" value="' . $row['exp'] . '"><br>';
					echo 'Attack: <input type="text" name="formEdituserAttack" maxlength="3" value="' . $row['attack'] . '"><br>';
					echo 'Defence: <input type="text" name="formEdituserDefence" maxlength="3" value="' . $row['defence'] . '"><br>';
					echo 'Stealth: <input type="text" name="formEdituserStealth" maxlength="3" value="' . $row['stealth'] . '"><br>';
					echo 'Analysis: <input type="text" name="formEdituserAnalysis" maxlength="3" value="' . $row['analysis'] . '"><br>';
					echo '</div>';
					echo '<div><input type="submit" name="formEdituserSubmit" value="Submit"></div></form>';
				}
			} elseif ($_GET['action']=='groupcolours')
			{
				echo '<p>Change group colours:';
				echo '<form action="admin.php" method="post"><p>';
				echo '<table style="border: 0px solid;"><tr style="border: 0px solid;">';
				echo '<td style="border: 0px solid; width:50%;">';
				$result2 = mysql_query("SELECT value FROM settings WHERE id='7color'") or die(mysql_error());
				$pref = mysql_fetch_array($result2);
				echo 'Admins:';
				echo '</td><td style="border: 0px solid; width:50%;">';
				echo '<input style="color: ' . $pref['value'] . ';" type="text" name="form7color" maxlength="7" size="10" value="' . $pref['value'] . '">';
				echo '</td></tr><tr style="border: 0px solid;">';
				echo '<td style="border: 0px solid; width:50%;">';
				$result2 = mysql_query("SELECT value FROM settings WHERE id='6color'") or die(mysql_error());
				$pref = mysql_fetch_array($result2);
				echo 'Moderators:';
				echo '</td><td style="border: 0px solid; width:50%;">';
				echo '<input style="color: ' . $pref['value'] . ';" type="text" name="form6color" maxlength="7" size="10" value="' . $pref['value'] . '">';
				echo '</td></tr><tr style="border: 0px solid;">';
				echo '<td style="border: 0px solid; width:50%;">';
				$result2 = mysql_query("SELECT value FROM settings WHERE id='8color'") or die(mysql_error());
				$pref = mysql_fetch_array($result2);
				echo 'Banned:';
				echo '</td><td style="border: 0px solid; width:50%;">';
				echo '<input style="color: ' . $pref['value'] . ';" type="text" name="form8color" maxlength="7" size="10" value="' . $pref['value'] . '">';
				echo '</td></tr><tr style="border: 0px solid;">';
				echo '<td style="border: 0px solid; width:50%;">';
				echo 'Normal:';
				echo '</td><td style="border: 0px solid; width:50%;">';
				echo 'Defined by stylesheet.';
				echo '</td></tr>';
				echo '</table><p>';
				echo '<input type="submit" name="formGroupcolorsSubmit" value="Submit"></p></form>';
			} elseif ($_GET['action']=='additem') {
				echo '<p>Add an item to the game:';
				echo '<form action="admin.php" method="post"><p>';
				echo 'Name: <input type="text" name="formAdditemItem" maxlength="30"><br>';
				echo 'Type: <select name="formAdditemType">';
				echo '<option value="00">Unknown</option>';
				echo '<option value="01">Medic</option>';
				echo '<option value="02">Virus</option>';
				echo '<option value="03">Shield</option>';
				echo '<option value="04">Deceive</option>';
				echo '<option value="05">Scan</option>';
				echo '<option value="06">Attack firmware</option>';
				echo '<option value="07">Defence firmware</option>';
				echo '<option value="08">Stealth firmware</option>';
				echo '<option value="09">Analysis firmware</option>';
				echo '<option value="10">CPU</option>';
				echo '<option value="11">Memory</option>';
				echo '<option value="12">Bandwidth</option>';
				echo '<option value="13">Special</option>';
				echo '</select> (don\'t pick unknown or special unless absolutely necessary)<br>';
				echo 'Power: <input type="text" name="formAdditemPower" maxlength="3"><br>';
				echo 'Memory: <input type="text" name="formAdditemMem" maxlength="3"><br>';
				echo 'Cost: <input type="text" name="formAdditemCost" maxlength="9"><br>';
				echo 'Available in the shop? <select name="formAdditemShop">';
				echo '<option value="0">No</option>';
				echo '<option value="1">Yes</option>';
				echo '</select><br>';
				echo 'Description: (please be creative and <span class="highlight">watch your spelling!</span>)<br>';
				echo '<textarea name="formAdditemDesc" cols="60" rows="6"></textarea><br>';
				echo '<input type="submit" name="formAdditemSubmit" value="Submit"></form>';
			} elseif ($_GET['action']=='edititem') {
				// If there's no id specified, display a list of items.
				if (empty($_GET['id']))
				{
					echo 'Select an item to edit:';
					// Get contents of item table.
					$result = mysql_query("SELECT id, item FROM items") or die(mysql_error());
					echo '<ul>';
					while($row = mysql_fetch_array( $result ))
					{
						echo '<li><a href="/admin.php?action=edititem&amp;id=' . $row['id'] . '">' . $row['item'] . '</a></li>';
					}
					echo '</ul>';
				} else {
					$result = mysql_query("SELECT * FROM items WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					$row = mysql_fetch_array( $result );
					$itemname = stripslashes($row['item']);
					echo "Editing " . $row['item'] . " (ID " . $row['id'] . "):";

					// Save edited item id to session so it can be retrieved during processing.
					$_SESSION['edititemid'] = $row['id'];

					echo '<p><form action="admin.php" method="post"><p>';
					echo 'Name: <input type="text" name="formEdititemItem" maxlength="30" value="' . $itemname . '"><br>';
					echo 'Cost: <input type="text" name="formEdititemCost" maxlength="9" value="' . $row['cost'] . '"><br>';
					echo 'Type: <select name="formEdititemType">';
					if ($row['type']==00) {echo '<option value="00" selected>Unknown</option>';} else {
					echo '<option value="00">Unknown</option>';}
					if ($row['type']==01) {echo '<option value="01" selected>Medic</option>';} else {
					echo '<option value="01">Medic</option>';}
					if ($row['type']==02) {echo '<option value="02" selected>Virus</option>';} else {
					echo '<option value="02">Virus</option>';}
					if ($row['type']==03) {echo '<option value="03" selected>Shield</option>';} else {
					echo '<option value="03">Shield</option>';}
					if ($row['type']==04) {echo '<option value="04" selected>Deceive</option>';} else {
					echo '<option value="04">Deceive</option>';}
					if ($row['type']==05) {echo '<option value="05" selected>Scan</option>';} else {
					echo '<option value="05">Scan</option>';}
					if ($row['type']==06) {echo '<option value="06" selected>Attack firmware</option>';} else {
					echo '<option value="06">Attack firmware</option>';}
					if ($row['type']==07) {echo '<option value="07" selected>Defence firmware</option>';} else {
					echo '<option value="07">Defence firmware</option>';}
					if ($row['type']==08) {echo '<option value="08" selected>Stealth firmware</option>';} else {
					echo '<option value="08">Stealth firmware</option>';}
					if ($row['type']==09) {echo '<option value="09" selected>Analysis firmware</option>';} else {
					echo '<option value="09">Analysis firmware</option>';}
					if ($row['type']==10) {echo '<option value="10" selected>CPU</option>';} else {
					echo '<option value="10">CPU</option>';}
					if ($row['type']==11) {echo '<option value="11" selected>Memory</option>';} else {
					echo '<option value="11">Memory</option>';}
					if ($row['type']==12) {echo '<option value="12" selected>Bandwidth</option>';} else {
					echo '<option value="12">Bandwidth</option>';}
					if ($row['type']==13) {echo '<option value="13" selected>Special</option>';} else {
					echo '<option value="13">Special</option>';}
					echo '</select> (don\'t pick unknown or special unless absolutely necessary)<br>';
					echo 'Power: <input type="text" name="formEdititemPower" maxlength="3" value="' . $row['power'] . '"><br>';
					echo 'Memory: <input type="text" name="formEdititemMem" maxlength="3" value="' . $row['mem'] . '"><br>';
					echo 'Available in the shop? <select name="formEdititemShop">';
					if ($row['shop']==0) {echo '<option value="0" selected>No</option>';} else {
					echo '<option value="0">No</option>';}
					if ($row['shop']==1) {echo '<option value="1" selected>Yes</option>';} else {
					echo '<option value="1">Yes</option>';}
					echo '</select><br>';
					$desc = stripslashes($row['desc']);
					echo 'Description: (please be creative and <span class="highlight">watch your spelling!</span>)<br>';
					echo '<textarea name="formEdititemDesc" cols="50" rows="6">' . $desc . '</textarea><br>';
					echo '<div><input type="submit" name="formEdititemSubmit" value="Submit"></div></form>';
				}
			} elseif ($_GET['action']=='delitem') {
					echo 'oh';
			} elseif ($_GET['action']=='addboard') {
					echo 'oh';
			} elseif ($_GET['action']=='editboard') {
					echo 'oh';
			} elseif ($_GET['action']=='delboard') {
					echo 'oh';
			} elseif ($_GET['action']=='addnetwork') {
				echo '<p>Add a network to the game:';
				echo '<form action="admin.php" method="post"><p>';
				echo 'Name: <input type="text" name="formAddnetworkName" maxlength="100"><br>';
				echo '<input type="submit" name="formAddnetworkSubmit" value="Submit"></form>';
			} elseif ($_GET['action']=='editnetwork') {
				// If there's no id specified, display a list of networks.
				if (empty($_GET['id']))
				{
					echo 'Select a network to edit:';
					// Get contents of network table.
					$result = mysql_query("SELECT id, name FROM networks") or die(mysql_error());
					echo '<ul>';
					while($row = mysql_fetch_array( $result ))
					{
						echo '<li><a href="/admin.php?action=editnetwork&amp;id=' . $row['id'] . '">' . $row['name'] . '</a></li>';
					}
					echo '</ul>';
				} else {
					$result = mysql_query("SELECT * FROM networks WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					$row = mysql_fetch_array( $result );
					echo "Editing " . $row['name'] . ":";

					// Save edited network id to session so it can be retrieved during processing.
					$_SESSION['editnetworkid'] = $row['id'];

					echo '<form action="admin.php" method="post"><p>';
					echo 'Name: <input type="text" name="formEditnetworkName" maxlength="100" value="' . $row['name'] . '"><br>';
					echo '<input type="submit" name="formEditnetworkSubmit" value="Submit"></form>';
				}
			} elseif ($_GET['action']=='delnetwork') {
					echo 'oh';
			} elseif ($_GET['action']=='addnode') {
				echo '<p>Add a node to a network:';
				echo '<form action="admin.php" method="post"><p>';
				echo 'Name: <input type="text" name="formAddnodeName" value="none" maxlength="100"><br>';
				if (isset($_GET['x']) AND isset($_GET['y']))
				{
					echo 'Tile: <input type="text" name="formAddnodeTile" maxlength="30" value="/tile/' . $_GET['x'] . 'x' . $_GET['y'] . '.jpg"><br>';
				} else {
					echo 'Tile: <input type="text" name="formAddnodeTile" maxlength="30" value="/tile/notile.png"><br>';
				}
				echo 'Network: <select name="formAddnodeNetwork">';
				echo '<option value="0">Pick one</option>';
				$result = mysql_query("SELECT id, name FROM networks") or die(mysql_error());
				while($network = mysql_fetch_array($result))
					{
						$networkname = stripslashes($network['name']);
						echo '<option value="' . $network['id'] . '">' . $networkname . '</option>';
					}
				echo '</select><br>';
				echo 'Coordinates:';
				if (empty($_GET['x']))
				{
					echo '<input type="text" value="x" name="formAddnodeXpos" size="4" maxlength="4">';
				} else {
					echo '<input type="text" value="' . $_GET['x'] . '" name="formAddnodeXpos" size="4" maxlength="4">';
				}
				if (empty($_GET['y']))
				{
					echo '<input type="text" value="y" name="formAddnodeYpos" size="4" maxlength="4"><br>';
				} else {
					echo '<input type="text" value="' . $_GET['y'] . '" name="formAddnodeYpos" size="4" maxlength="4"><br>';
				}
				echo 'What directions can the user move from this node?<br>';
				echo 'Up?<input type="checkbox" name="formAddnodeCangoup" value="cangoup" checked> ';
				echo 'Left?<input type="checkbox" name="formAddnodeCangoleft" value="cangoleft" checked> ';
				echo 'Right?<input type="checkbox" name="formAddnodeCangoright" value="cangoright" checked> ';
				echo 'Down?<input type="checkbox" name="formAddnodeCangodown" value="cangodown" checked><br><br>';
				echo 'Description: (please be creative and <span class="highlight">watch your spelling!</span>)<br>';
				echo '<textarea name="formAddnodeDesc" cols="60" rows="6"></textarea><br>';
				echo '<input type="submit" name="formAddnodeSubmit" value="Submit"></form>';
			} elseif ($_GET['action']=='editnode') {
				// If there's no id specified, display a list of nodes.
				if (empty($_GET['id']))
				{
					echo 'Select a node to edit:';
					// Get contents of node table.
					$result = mysql_query("SELECT id, name, xpos, ypos FROM nodes") or die(mysql_error());
					echo '<ul>';
					while($row = mysql_fetch_array( $result ))
					{
						echo '<li><a href="/admin.php?action=editnode&amp;id=' . $row['id'] . '">' . $row['name'] . '</a> ';
						echo '(' . $row['xpos'] . ', ' . $row['ypos'] . ')</li>';
					}
					echo '</ul>';
				} else {
					$result = mysql_query("SELECT * FROM nodes WHERE id='" . $_GET['id'] . "'") or die(mysql_error());
					$row = mysql_fetch_array( $result );
					$nodename = stripslashes($row['name']);
					$desc = stripslashes($row['desc']);
					echo "Editing " . $row['name'] . " (" . $row['xpos'] . ", " . $row['ypos'] . "):";
					
					include 'adminmap.php';

					// Save edited node id to session so it can be retrieved during processing.
					$_SESSION['editnodeid'] = $row['id'];

					echo '<form action="admin.php" method="post"><p>';
					echo 'Name: <input type="text" name="formEditnodeName" maxlength="100" value="' . $nodename . '"><br>';
					echo 'Tile: <input type="text" name="formEditnodeTile" maxlength="30" value="' . $row['img'] . '"><br>';
					echo 'Network: <select name="formEditnodeNetwork">';
					$result = mysql_query("SELECT id, name FROM networks") or die(mysql_error());
					while($network = mysql_fetch_array($result))
					{
						$networkname = stripslashes($network['name']);
						if ($row['networkid']==$network['id'])
						{
							echo '<option value="' . $network['id'] . '" selected>' . $networkname . '</option>';
						} else {
							echo '<option value="' . $network['id'] . '">' . $networkname . '</option>';
						}
					}
					echo '</select><br>';
					echo 'Coordinates: <input type="text" value="' . $row['xpos'] . '" name="formEditnodeXpos" size="4" maxlength="4"><input type="text" value="' . $row['ypos'] . '" name="formEditnodeYpos" size="4" maxlength="4"><br>';
					echo 'What directions can the user move from this node?<br>';
					if ($row['cangoup']==1)
					{
						echo 'Up?<input type="checkbox" name="formEditnodeCangoup" value="cangoup" checked> ';
					} else {
						echo 'Up?<input type="checkbox" name="formEditnodeCangoup" value="cangoup"> ';
					}
					if ($row['cangoleft']==1)
					{
						echo 'Left?<input type="checkbox" name="formEditnodeCangoleft" value="cangoleft" checked> ';
					} else {
						echo 'Left?<input type="checkbox" name="formEditnodeCangoleft" value="cangoleft"> ';
					}
					if ($row['cangoright']==1)
					{
						echo 'Right?<input type="checkbox" name="formEditnodeCangoright" value="cangoright" checked> ';
					} else {
						echo 'Right?<input type="checkbox" name="formEditnodeCangoright" value="cangoright"> ';
					}
					if ($row['cangodown']==1)
					{
						echo 'Down?<input type="checkbox" name="formEditnodeCangodown" value="cangodown" checked><br><br>';
					} else {
						echo 'Down?<input type="checkbox" name="formEditnodeCangodown" value="cangodown"><br><br>';
					}
					echo 'Description: (please be creative and <span class="highlight">watch your spelling!</span>)<br>';
					echo '<textarea name="formEditnodeDesc" cols="40" rows="6">' . $desc . '</textarea><br>';
					echo '<input type="submit" name="formEditnodeSubmit" value="Submit"></form>';
				}
			} elseif ($_GET['action']=='delnode') {
					echo 'oh';
			} elseif ($_GET['action']=='help') {
					include 'adminhelp.php';
			} elseif ($_GET['action']=='addcontract') {
					echo 'oh';
			} elseif ($_GET['action']=='editcontract') {
					echo 'oh';
			} elseif ($_GET['action']=='delncontract') {
					echo 'oh';
			} elseif ($_GET['action']=='addsystem') {
					echo 'oh';
			} elseif ($_GET['action']=='editsystem') {
					echo 'oh';
			} elseif ($_GET['action']=='delsystem') {
					echo 'oh';
			} elseif ($_GET['action']=='addiobj') {
				echo '<p>Create a new item object:';
				$_SESSION['objtype']=1;
				echo '<form action="admin.php" method="post"><p>';
				echo 'Item: <select name="formAddobjWhatid">';
				echo '<option value="0" selected>Pick one</option>';
				$result = mysql_query("SELECT id, item FROM items WHERE 1=1") or die(mysql_error());
				while ($item=mysql_fetch_array($result))
				{
					echo '<option value="' . $item['id'] . '">' . $item['item'] . '</option>';
				}
				echo '</select><br><br>';
				echo 'Before conditions:<br><select name="formAddobjBefore1">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjBefore2">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjBefore3">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjBefore4">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select><br><br>';
				echo 'After conditions:<br><select name="formAddobjAfter1">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjAfter2">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjAfter3">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select>';
				echo '<select name="formAddobjAfter4">';
				echo '<option value="0">None</option>';
				echo '<option value="1">Can go up</option>';
				echo '<option value="2">Can go left</option>';
				echo '<option value="3">Can go right</option>';
				echo '<option value="4">Can go down</option>';
				echo '<option value="5">Can\'t go up</option>';
				echo '<option value="6">Can\'t go left</option>';
				echo '<option value="7">Can\'t go right</option>';
				echo '<option value="8">Can\'t go down</option>';
				echo '<option value="9">Can win</option>';
				echo '<option value="10">Can\'t win</option>';
				echo '<option value="11">Can steal local</option>';
				echo '<option value="12">Can\'t steal local</option>';
				echo '<option value="13">Can steal global</option>';
				echo '<option value="14">Can\'t steal global</option>';
				echo '<option value="15">Can exit</option>';
				echo '<option value="16">Can\'t exit</option>';
				echo '</select><br><br>';
				echo 'Message if destroyed:<br>';
				echo '<textarea name="formAddobjMsgdestroy" cols="60" rows="6"></textarea><br><br>';
				echo 'Message if downloaded:<br>';
				echo '<textarea name="formAddobjMsgother" cols="60" rows="6"></textarea><br>';
				echo '<input type="submit" name="formAddobjSubmit" value="Submit"></form>';
			} elseif ($_GET['action']=='editiobj') {
					echo 'oh';
			} elseif ($_GET['action']=='deliobj') {
					echo 'oh';
			} elseif ($_GET['action']=='addhobj') {
					echo 'oh';
			} elseif ($_GET['action']=='edithobj') {
					echo 'oh';
			} elseif ($_GET['action']=='delhobj') {
					echo 'oh';
			} else {
				echo '<div class="error">Invalid parameter.</div>';
			}
		}
	} else {
		// User is not an admin. Fuck 'em!
		$title=Admin;
		include 'header.php';
		echo '<div class="error">Access denied.</a></div>';
	}
}

include 'footer.php';
?>