<?php 

/**

 Author: Pro Chatrooms
 Software: Avatar Chat
 Url: http://www.prochatrooms.com
 Copyright 2007-2010 All Rights Reserved

 Avatar Chat and all of its source code/files are protected by Copyright Laws. 
 The license for Avatar Chat permits you to install this software on a single domain only (.com, .co.uk, .org, .net, etc.). 
 Each additional installation requires an additional software licence, please contact us for more information.
 You may NOT remove the copyright information and credits for Avatar Chat unless you have been granted permission. 
 Avatar Chat is NOT free software - For more details http://www.prochatrooms.com/software_licence.php

**/

// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");

// install file is present

	if(file_exists("install/index.php")){

		die("Please delete the 'install' folder to continue.");
	}

// software licence is not found

	if(!file_exists("software_licence.txt")){

		die("Please upload the 'software_licence.txt' file.");
	}

// include files

	include("includes/session.php");
	include("includes/db.php");
	include("includes/config.php");
	include("includes/functions.php");

	unset($_SESSION['avatarID']);

// do CMS integration

	if($CONFIG['cms_integration']=='1' && !$_SESSION['avatarchat_nickname']){

		die("Please login via the website.");

	}

// show register page

	if($_GET['do'] == 'register' || $_POST['do'] == 'register'){

		// register user

		if($_POST && $_POST['do'] == 'register'){

			$reg = regUser($_POST['nickName'], $_POST['nickPass'], $_POST['nickEmail'], $_POST['gender']);

			// assign errors

			if($reg=='1'){$eMessage = 'Successfully Registered! - <a href="index.php">Please Login</a>';}
			if($reg=='2'){$eMessage = 'Error: Username Already Registered';}
			if($reg=='3'){$eMessage = 'Invalid Username, 3-16 Characters Alphanumeric &amp; Underscore Only';}
			if($reg=='4'){$eMessage = 'Invalid Password,  3-16 characters';}
			if($reg=='5'){$eMessage = 'Invalid Email, Please Enter Your Valid Email Address';}

		}

		include("templates/register.php");

		die;

	}

// show lost password page

	if($_GET['do'] == 'password' || $_POST['do'] == 'password'){

		// get password

		if($_POST && $_POST['do'] == 'password'){

			$create_pass = sendUserMail($_POST['nickName'], $_POST['nickEmail'], $_POST['nickPass'], '1');

			// assign errors

			if($create_pass=='1'){$eMessage = 'Your Details Have Been Resent!';}
			if($create_pass=='2'){$eMessage = 'Error: User Details Not Found';}
			if($create_pass=='3'){$eMessage = 'Invalid Username, 3-16 Characters Alphanumeric &amp; Underscore Only';}
			if($create_pass=='4'){$eMessage = 'Invalid Email, Please Enter Your Valid Email Address';}

		}

		include("templates/lost.php");

		die;

	}

// do user logout

	if($_GET['do']=='logout'){

		// add exit message

		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('logout', '".$_SESSION['userref']."', '".mysql_real_escape_string($uid)."', 'SYSTEM', '', '".mysql_real_escape_string($_SESSION['username'])." has left the room', '".mysql_real_escape_string($_SESSION['userroom'])."', '".mysql_real_escape_string($uavatar)."', '".mysql_real_escape_string($uXX)."', '".mysql_real_escape_string($uYY)."', '".mysql_real_escape_string($timeNow)."')";mysql_query($sql) or die(mysql_error());

		// tell users friends that user is offline

		$timeNow= date("U");

		$tmp=mysql_query("
		SELECT DISTINCT friendname, room  
		FROM ".$CONFIG['mysql_prefix']."friends 
		WHERE username = '".$_SESSION['username']."' AND online = '1'
		") or die(mysql_error()); 

		while($fdata = mysql_fetch_array($tmp)) {

			$sql = "
			INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) 
			VALUES ('logout', '1', '1', 'SYSTEM', '".$fdata['friendname']."', '".mysql_real_escape_string($_SESSION['username'])." is now offline', '".$fdata['room']."', '".mysql_real_escape_string($uavatar)."', '0', '0', '".$timeNow."')
			";mysql_query($sql) or die(mysql_error());
	
		}

		// update user online

		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET room = '1', online_time = '0' WHERE username = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

		// update room for friends list

		$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET room = '".mysql_real_escape_string($_SESSION['userroom'])."', online = '0' WHERE friendname = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

		if($_GET['action']=='banned'){

			// update user bans

			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET status = '1' WHERE username = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

			//show banned message

			$exit_message = "You have been banned!";
		}

		// unset sessions

		unset($_SESSION['username']);
		unset($_SESSION['doLogin']);
		unset($_SESSION['userpass']);
		unset($_SESSION['userroom']);
		unset($_SESSION['userref']);
		unset($_SESSION['chat_moderator']);
		unset($_SESSION['chatmod']);
		unset($_SESSION['avatarID']);
		unset($_SESSION['tmppass']);
		unset($_SESSION['rID']);
		unset($_SESSION['roomID']);

		// if cms integrated, close window

		if($CONFIG['cms_integration'] == '1'){

			unset($_SESSION['avatarchat_nickname']);

			?>
				<script language="javascript">
				parent.window.close();	
				</script>

			<?php	

		}else{

			// redirect to login page

			header('Location: index.php');

		}

		// and kill it off

		die;

	}

// do VIP

	if($_GET['do']=='vip'){

		include('templates/vip.php');

		die;

	}

// do VIP

	if($_GET['do']=='upgrade'){

		include('templates/upgrade.php');

		die;

	}

// do Terms

	if($_GET['do']=='terms'){

		include('templates/terms.php');

		die;

	}

// do Privacy

	if($_GET['do']=='privacy'){

		include('templates/privacy.php');

		die;

	}

// show login/main

	if(
		$_GET['do'] != 'register' || 
		$_GET['do'] != 'password' || 
		$_GET['do'] != 'logout' || 
		$_GET['do'] != 'vip' || 
		$_GET['do'] != 'terms' || 
		$_GET['do'] != 'privacy'
	)
	{
		include("includes/main.php");

		die;
	}

?>