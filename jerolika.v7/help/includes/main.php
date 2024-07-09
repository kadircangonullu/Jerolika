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

	// assign splash page 

	if($_COOKIE['showSplashPage'] && !is_numeric($_COOKIE['showSplashPage']))
	{
		setcookie("showSplashPage", "0", time()+2678400, "/");  // 31 day expiry
	}

	$showSplashPage = '0';

	// assign user POST ID details

	if($_SESSION['avatarchat_uid'])
	{
		$uid = $_SESSION['avatarchat_uid'];
	}
	else
	{
		$uid = '1';
	}

	// first time login, check user login details are valid

	if($_POST && $_POST['nickName'] || $_SESSION['avatarchat_login'] == '1' && !$_SESSION['doLogin'])
	{
		if($_SESSION['roomID'])
		{
			unset($_SESSION['roomID']);
		}

		// assign default room
		$_GET['rID'] = $CONFIG['defaultRoom'];

		// if CMS integration
		if($CONFIG['cms_integration']=='1')
		{
			// assign username
			$_POST['nickName'] = $_SESSION['avatarchat_nickname'];
		}

		// assign name/pass value

		$thisUser = strip_tags($_POST['nickName']);
		$thisPass = strip_tags($_POST['nickPass']);

		// shorten POST username/password to 16 characters
		// helps to prevent mailicious remote logins

		$thisUser = substr($thisUser, 0, 16);
		$thisPass = substr($thisPass, 0, 16);

		// remove special characters from username

		$thisUser = remSpcChars($thisUser);

		// remove spaces for username length check

		$thisUser = str_replace(" ","",$thisUser);

		// check username is alphanumeric and underscores only

		$valid_name = _alpha_numeric($thisUser);

		// if username is less than 3 characters, greater than 16 characters or invalid username

		if(strlen($thisUser) < 3 || strlen($thisUser) > 16 || !$valid_name)
		{
			// set error message

			$errorID = '1';

			// login failed

			unset($_SESSION['doLogin']);

			include("templates/login.php");

			die;	
		}
		else
		{
			if(!$CONFIG['cms_integration'])
			{
				// check if active within last 15 secs 
				// helps to prevent multiple logins

				$userOffline = date("U")-15;

				$userActive=mysql_query("SELECT online_time FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string($thisUser)."' AND online_time > '".$userOffline."' LIMIT 1") or die(mysql_error()); 
				$userOnline = mysql_num_rows($userActive);

				if($userOnline)
				{
					$errorID='3';

					include("templates/login.php");

					die;
				}

			}

			// Database Management

			// reset any inactive users within last 180 secs
			// reset any VIP accounts that have expired

			$usersOffline = date("U")-180;
			$timeNow = date("U");

			$tmp=mysql_query("
				SELECT username, userid, avatar, avatar_x, avatar_y  
				FROM ".$CONFIG['mysql_prefix']."user 
				WHERE online_time != '0' AND online_time < '".$usersOffline."'") or die(mysql_error()); 

			while($got_data = mysql_fetch_array($tmp)) 
			{
				// update user table (online)
				$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET online_time = '0' WHERE online_time != '0' AND online_time < '".$usersOffline."'";mysql_query($sql) or die(mysql_error());

				// update friends table (online)
				$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET online = '0' WHERE username = '".$got_data['username']."' OR friendname = '".$got_data['username']."'";mysql_query($sql) or die(mysql_error());

				// tell users friends that user is offline
				$tmp2=mysql_query("
					SELECT DISTINCT friendname, room  
					FROM ".$CONFIG['mysql_prefix']."friends 
					WHERE username = '".$got_data['username']."' AND online = '1'
					") or die(mysql_error()); 

				while($fdata = mysql_fetch_array($tmp2))
				{

					$sql = "
						INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) 
						VALUES ('logout', '1', '".$got_data['userid']."', 'SYSTEM', '".$fdata['friendname']."', '".mysql_real_escape_string($got_data['username'])." is now online', '".$fdata['room']."', '".$got_data['avatar']."', '".$got_data['avatar_x']."', '".$got_data['avatar_y']."', '".$timeNow."')
						";mysql_query($sql) or die(mysql_error());
				}

			}

			// alls ok, assign username

			$_SESSION['doLogin'] = '1';

			$_SESSION['username'] = $thisUser;

			if(!empty($thisPass))
			{
				$_SESSION['userpass'] = md5(md5($thisPass));
			}
			else
			{
				$_SESSION['userpass'] = '';
			}

			$_GET['userName'] = $thisUser;

		}

		// show splash page on first visit

		if($CONFIG['splashpage']=='1')
		{
			// set cookie for splash page

			if($_COOKIE['showSplashPage']!='0' || !is_numeric($_COOKIE['showSplashPage']))
			{
				setcookie("showSplashPage", "0", time()+2678400, "/");  // 31 day expiry

				// show splash page
				$showSplashPage ='1';
			}
			else
			{
				// hide splash page
				$showSplashPage ='0';
			}

		}
		else
		{
			// hide splash page
			$showSplashPage ='0';
		}

		if(isset($_SESSION['avatarchat_login']))
		{
			unset($_SESSION['avatarchat_login']);
		}

	}

	// if user is not logged in

	if(!$_SESSION['doLogin'])
	{
		include("templates/login.php");

		die;
	}

	// assign administrators

	if($_SESSION['avatarchat_userlevel'] == '1' || in_array(strtolower($_SESSION['username']),$chatroom_mods) || "-".$_SESSION['userref'] == $_GET['rID'])
	{
		// assign admin

		$sAdmin = '0';

		// set session

		$_SESSION['chat_moderator'] = '1';

		// update database

		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET adminID = '1' WHERE username = '".$_SESSION['username']."'";mysql_query($sql) or die(mysql_error());

		// set admin (set in config.php)

		if($_SESSION['avatarchat_userlevel'] == '1' || in_array(strtolower($_SESSION['username']),$chatroom_mods))
		{
			//assign admin

			$sAdmin = '1';

			// update database

			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET adminID = '2' WHERE username = '".$_SESSION['username']."'";mysql_query($sql) or die(mysql_error());
		}

	}
	else
	{

		if(isset($_SESSION['chat_moderator']))
		{
			// unset session

			unset($_SESSION['chat_moderator']);

			// update database

			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET adminID = '0' WHERE username = '".$_SESSION['username']."'";mysql_query($sql) or die(mysql_error());
		}

	}

	//assign room ID

	if($_POST['rID'])
	{
		// if post is set
		$_SESSION['roomID'] = $_POST['rID'];
	}

	if(!$_GET['rID'] && $_SESSION['roomID'])
	{
		// if get is empty 
		$_GET['rID'] = $_SESSION['roomID'];
	}

	// assign prev room

	$_SESSION['prev_roomID'] = $_SESSION['roomID'];

	// assign new room

	if($_GET['rID'])
	{
		$_SESSION['roomID'] = $_GET['rID'];
	}

	// check GET['rID'] and $_SESSION['roomID'] values are numeric only

	if($_GET['rID'] && !is_numeric($_GET['rID']) || $_SESSION['roomID'] && !is_numeric($_SESSION['roomID']))
	{
		die('Room ID value is not numeric');
	}

	//assign private room details

	if($_GET['rID'] < '0')
	{
		// get users room details
		$tmp=mysql_query("
			SELECT username, myroomIMG, roomname, music, startX, startY, vip, roomaccess, roommax      
			FROM ".$CONFIG['mysql_prefix']."user 
			WHERE myroomID ='".$_GET['rID']."' 
			LIMIT 1") or die(mysql_error()); 

		//check room exists
		$roomExists = mysql_num_rows($tmp);

		if($roomExists)
		{
			while($got_data = mysql_fetch_array($tmp))
			{
				// get total users in room
				$getTotalUsers=mysql_query("
				SELECT id      
				FROM ".$CONFIG['mysql_prefix']."user 
				WHERE room ='".$_GET['rID']."' 
				") or die(mysql_error()); 

				$gotTotalUsers = mysql_num_rows($getTotalUsers);

				// room is full
				if($gotTotalUsers >= $got_data['roommax'])
				{
					// set previous room id
					$_SESSION['roomID'] = $_SESSION['prev_roomID'];

					// set session for room full (denied)
					$_SESSION['roomFull'] = '1';

					// header redirect
					header("Status: 200");
					header("Location: index.php");
					die;
				}

				// get background
				$background_url = $got_data['myroomIMG'];

				// assign room id
				$uroom = $_GET['rID'];

				// set start posistions
				$uXX = $got_data['startX'];
				$uYY = $got_data['startY'];
				$offsetuXX = $got_data['startX'] - '20';
				$offsetuYY = $got_data['startY'] - '20';

				// get music url
				$music_url = $got_data['music'];

				// get room name
				$roomname = $got_data['roomname'];

				// get room owner id
				$room_owner = $got_data['username'];

				// get room access
				$room_access = $got_data['roomaccess'];

				// get max users
				$max_room_users = $got_data['roommax'];
			}

		}

		// if not room owner or admin user, check user is in friends list

		$friendExists = '1';

		if(!in_array(strtolower($_SESSION['username']),$chatroom_mods) && strtolower($room_owner) != strtolower($_SESSION['username']) && $room_access=='1')
		{
			// strip - for room check
			$checkRoomID = str_replace("-","",$_GET['rID']);

			// get users room image
			$tmp=mysql_query("
				SELECT friendname    
				FROM ".$CONFIG['mysql_prefix']."friends 
				WHERE friendname = '".mysql_real_escape_string($_SESSION['username'])."' 
				AND userid = '".$checkRoomID."'
				LIMIT 1") or die(mysql_error()); 

			//check room exists
			$friendExists = mysql_num_rows($tmp);
		}

		// if not in friends list, reload the room and show 'friends only' message

		if(!$roomExists || !$friendExists)
		{
			// default room
			// $_GET['rID'] = $CONFIG['defaultRoom'];

			// set previous room id
			$_SESSION['roomID'] = $_SESSION['prev_roomID'];

			// set session for room full (denied)
			$_SESSION['roomFriends'] = '1';

			// header redirect
			header("Status: 200");
			header("Location: index.php");
			die;
		}

		// posistion default doors
		$doorTop1='50';
		$doorLeft1='38';
		$doorHeight1='150';
		$doorWidth1='40';
		
		$doorTop2='1';
		$doorLeft2='1';
		$doorHeight2='1';
		$doorWidth2='1';
   
		$doorTop3='1';
		$doorLeft3='1';
		$doorHeight3='1';
		$doorWidth3='1'; 

		$doorVisible = '0'; 

		// doors lead to which room? 	
		$dOne='5';
		$dTwo='5';
		$dThree='5';

	}

	// set the roomID by session (if still active)

	if($_SESSION['roomID'])
	{
		$_GET['rID'] = $_SESSION['roomID'];
	}

	// get the room details

	if($_GET['rID'] >='1')
	{
		$tmp=mysql_query("
			SELECT *     
			FROM ".$CONFIG['mysql_prefix']."rooms 
			WHERE uroom ='".$_GET['rID']."' 
			LIMIT 1") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp)) 
		{
			$roomname = $got_data['roomname'];
			$uroom = $got_data['uroom'];		
			$background_url = $got_data['background_url'];
			$music_url = $got_data['music_url'];
			$enableMusic = $got_data['enableMusic'];

			$uXX = $got_data['uXX'];
			$uYY = $got_data['uYY'];
			$offsetuXX = $got_data['offsetuXX'];
			$offsetuYY = $got_data['offsetuYY'];

			$doorTop1 = $got_data['doorTop1'];
			$doorLeft1 = $got_data['doorLeft1'];
			$doorHeight1 = $got_data['doorHeight1'];
			$doorWidth1 = $got_data['doorWidth1'];

			$doorTop2 = $got_data['doorTop2'];
			$doorLeft2 = $got_data['doorLeft2'];
			$doorHeight2 = $got_data['doorHeight2'];
			$doorWidth2 = $got_data['doorWidth2'];

			$doorTop3 = $got_data['doorTop3'];
			$doorLeft3 = $got_data['doorLeft3'];
			$doorHeight3 = $got_data['doorHeight3'];
			$doorWidth3 = $got_data['doorWidth3'];

			$doorVisible = $got_data['doorVisible'];

			$dOne = $got_data['dOne'];
			$dTwo = $got_data['dTwo'];
			$dThree = $got_data['dThree'];

			// assign private room doors

			if($dOne == '-'){$dOne = "-".$_SESSION['userref'];}
			if($dTwo == '-'){$dTwo = "-".$_SESSION['userref'];}
			if($dThree == '-'){$dThree = "-".$_SESSION['userref'];}
		}

	}

	// get users DB avatar

	$tmp=mysql_query("
		SELECT avatar, avatara, avatarb, avatarc, gender, roomname 
		FROM ".$CONFIG['mysql_prefix']."user 
		WHERE username ='".$_SESSION['username']."'
		LIMIT 1") or die(mysql_error()); 

	while($got_data = mysql_fetch_array($tmp))
	{
		if(!$got_data['avatar'])
		{
			if($got_data['gender'] == '1')
			{
				// set default male avatar

				$_SESSION['avatarID'] = $CONFIG['avatar_male'];
			}

			if($got_data['gender'] == '2')
			{
				// set default female avatar

				$_SESSION['avatarID'] = $CONFIG['avatar_female'];
			}

			$uavatar = $_SESSION['avatarID'];

		}
		else
		{
			// assign session avatar
			$_SESSION['avatarID'] = $got_data['avatar'];

			$uavatar = $_SESSION['avatarID']; // full image

			if($_GET['updateAvatar']=='1')
			{
				$uavatar = $got_data['avatara'];
				$_SESSION['avatarID'] = $got_data['avatara'];
			}

			if($_GET['updateAvatar']=='2')
			{
				$uavatar = $got_data['avatarb'];
				$_SESSION['avatarID'] = $got_data['avatarb'];
			}

			if($_GET['updateAvatar']=='3')
			{
				$uavatar = $got_data['avatarc'];
				$_SESSION['avatarID'] = $got_data['avatarc'];
			}

		}

	}

	// get users login avatar and gender // $_POST['gender']

	if($CONFIG['cms_integration'] == '1' && $_SESSION['avatarchat_gender'] == '1' && !$_SESSION['avatarID'] || $CONFIG['cms_integration'] == '0' && $_POST['gender'] == '1' && !$_SESSION['avatarID'])
	{
		// set default male avatar

		$_SESSION['avatarID'] = $CONFIG['avatar_male'];

		$uavatar = $_SESSION['avatarID'];
	}

	if($CONFIG['cms_integration'] == '1' && $_SESSION['avatarchat_gender'] == '2' && !$_SESSION['avatarID'] || $CONFIG['cms_integration'] == '0' && $_POST['gender'] == '2' && !$_SESSION['avatarID'])
	{
		// set default female avatar

		$_SESSION['avatarID'] = $CONFIG['avatar_female'];

		$uavatar = $_SESSION['avatarID'];
	}

	if($_SESSION['avatarchat_gender'])
	{
		unset($_SESSION['avatarchat_gender']);
	}

	// assign some system variables

	$uwebcam = '0';
	$timeNow = date("U");

	// show user has left room message

	if($_SESSION['userroom'] && $_GET['do']!='logout')
	{
		// add exit message

		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('logout', '".$_SESSION['userref']."', '".$uid."', 'SYSTEM', '', '".mysql_real_escape_string($_SESSION['username'])." has left the room', '".$_SESSION['userroom']."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')";mysql_query($sql) or die(mysql_error());
	}

	// check user exists

	$updateVIP = '0';

	$userExists=mysql_query("SELECT roomMaxEnd, vipEnd, username, password, status FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string($_SESSION['username'])."' LIMIT 1") or die(mysql_error()); 
	$userFound = mysql_num_rows($userExists);

	while($i = mysql_fetch_array($userExists)) 
	{
		if($i['vipEnd'] < date("U"))
		{
			$updateVIP = '1';
		}

		if($i['roomMaxEnd'] < date("U"))
		{
			$updateMaxRoomUsers = '1';
		}

		$_SESSION['tmppass'] = ($i['password']);

		// check ban status

		if($i['status']>'0')
		{
			$errorID='4';

			include("templates/login.php");

			die;
		}
	}

	// get users IP

	$userIP = getIP();

	// check if IP has been banned

	$getBanIPs=mysql_query("SELECT userIP FROM ".$CONFIG['mysql_prefix']."user WHERE status >= '1'") or die(mysql_error()); 
	while($i = mysql_fetch_array($getBanIPs)) 
	{
		// check ban status

		if($userIP == $i['userIP'])
		{
			$errorID='4';

			include("templates/login.php");

			die;
		}
	}



 	// show friends that user has logged in

	if($_POST)
	{
		$tmp=mysql_query("
			SELECT DISTINCT friendname, room  
			FROM ".$CONFIG['mysql_prefix']."friends 
			WHERE username = '".$thisUser."' AND online = '1'
			") or die(mysql_error()); 

		while($fdata = mysql_fetch_array($tmp)) 
		{
			$sql = "
				INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) 
				VALUES ('login', '".$_SESSION['userref']."', '".$uid."', 'SYSTEM', '".$fdata['friendname']."', '".mysql_real_escape_string($_SESSION['username'])." is now online', '".$fdata['room']."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')
				";mysql_query($sql) or die(mysql_error());
		}

	}

	// if guests are not allowed to login, we set the userFound value to 1
	// this ensures we do a DB password check for non integrated versions

	if(!$CONFIG['allow_guests'] && !$CONFIG['cms_integration'])
	{
		$userFound = '0';
	}

	// if user doesnt exist, add to database

	if(!$userFound && $_POST['loginInfo'] == '1')
	{
		// insert user to DB

		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."user(userid, username, room, avatar, avatara, avatar_x, avatar_y, webcam, online_time, vip, roommax) VALUES ('".$uid."', '".$_SESSION['username']."', '".$uroom."', '".$uavatar."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$uwebcam."', '".$timeNow."', '".$CONFIG['vip_guests']."', '".$CONFIG['room_max']."')";mysql_query($sql) or die(mysql_error());

		// get users ID

		$tmp=mysql_query("
			SELECT id    
			FROM ".$CONFIG['mysql_prefix']."user 
			WHERE username ='".$_SESSION['username']."'
			LIMIT 1") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp))
		{
			//update roomID
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET userIP = '".$userIP."', myroomID = '-".$got_data['id']."' WHERE username = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());
		}

		// assign name

		$uname = $_SESSION['username'];

		// assign room

		$_SESSION['userroom'] = $uroom;

	}
	else
	{
		// user is trying to login with password, assume must be member?

		$userFound = '1';
	}

	// if user does exist but login password does not match database password

	if($userFound && $_SESSION['userpass']!=$_SESSION['tmppass'] && !empty($_SESSION['userpass']) ||  empty($_SESSION['userpass']) && $_POST['loginInfo'] == '2')
	{
		// login error, password incorrect

		$errorID = '2';

		// login failed

		unset($_SESSION['doLogin']);
		unset($_SESSION['userpass']);
		unset($_SESSION['tmppass']);
		unset($_SESSION['username']);

		include("templates/login.php");

		die;	
	}

	// if user does exist and login password is the same as database password

	if($userFound && $_SESSION['userpass']==$_SESSION['tmppass'])
	{
		// update VIP status

		if($updateVIP == '1')
		{
			$updateVIPstatus = "vip = '0', ";
		}

		// update room users

		if($updateMaxRoomUsers == '1')
		{
			$updateRoomUsers = "roommax = '5', ";
		}

		// update user online

		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET ".$updateRoomUsers." ".$updateVIPstatus." userIP = '".$userIP."', avatar = '".$uavatar."', room = '".$uroom."', online_time = '".$timeNow."', avatar_x = '".$uXX."', avatar_y = '".$uYY."' WHERE username = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

		// assign name

		$uname = $_SESSION['username'];

		// assign room

		$_SESSION['userroom'] = $uroom;

	}

	// check user exists for friends table

	$userExists=mysql_query("SELECT friendname FROM ".$CONFIG['mysql_prefix']."friends WHERE friendname = '".mysql_real_escape_string($_SESSION['username'])."' LIMIT 1") or die(mysql_error()); 
	$userFound = mysql_num_rows($userExists);

	if($userFound)
	{
		// update room for friends list
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET room = '".$uroom."', roomname ='".$roomname."', online = '1' WHERE friendname = '".mysql_real_escape_string($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());
	}

	// get user refid & check if VIP

	$tmp=mysql_query("
		SELECT id, vip, avatara, avatarb, avatarc    
		FROM ".$CONFIG['mysql_prefix']."user 
		WHERE username ='".$_SESSION['username']."'
		LIMIT 1") or die(mysql_error()); 

	while($got_data = mysql_fetch_array($tmp)) 
	{
		$uref = ($got_data['id']);
		$_SESSION['userref'] = ($got_data['id']);
		$isVIP = ($got_data['vip']);

		$avatara = $got_data['avatara'];$avatarID1='1';
		$avatarb = $got_data['avatarb'];$avatarID2='2';
		$avatarc = $got_data['avatarc'];$avatarID3='3';

		if(!$got_data['avatara']){$avatara = 'images/noavi.png';$avatarID1='0';}
		if(!$got_data['avatarb']){$avatarb = 'images/noavi.png';$avatarID2='0';}
		if(!$got_data['avatarc']){$avatarc = 'images/noavi.png';$avatarID3='0';}
	}

	// get last message id

	$tmp=mysql_query("
		SELECT id    
		FROM ".$CONFIG['mysql_prefix']."message  
		WHERE action IN ('login', 'logout', 'message', 'like', 'love', 'star')
		ORDER BY id ASC") or die(mysql_error()); 

	while($got_data = mysql_fetch_array($tmp)) 
	{
		$lastMessID = ($got_data['id']);
	}

	// add welcome message

	$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('login', '".$uref."', '".$uid."', 'SYSTEM', '', '".$_SESSION['username']." has entered the room', '".$uroom."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')";mysql_query($sql) or die(mysql_error());

	// get lastLogin for shop credits bonus

	if(!$CONFIG['enable_doppleme'])
	{
		$timeNow = date("U");

		$freeCredits = 0;

		createShopAccount($uref,$_SESSION['username']);

		$tmp=mysql_query("
			SELECT lastLogin    
			FROM ".$CONFIG['mysql_prefix']."shop_accounts  
			WHERE username =  '".$_SESSION['username']."'
			") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp)) 
		{
			$checkNewLogin = ($got_data['lastLogin']);
			$checkLastLogin = ($got_data['lastLogin']+86400); // +86400 = 24 hours

			if(date("U") > $checkLastLogin)
			{
				$freeCredits = rand($CONFIG['credits_free_login_min'],$CONFIG['credits_free_login_max']);
			}
	
			if(!$checkNewLogin)
			{
				$freeCredits = $CONFIG['credits_free_signup'];
			}

			if($freeCredits)
			{
				$creditsMessage = $_SESSION['username']." has won ".$freeCredits." shop credits, login daily to win more credits!";

				$sql = "UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
						SET lastLogin = '".$timeNow."', credits = credits + ".$freeCredits." 
						WHERE username = '".makeSafe($_SESSION['username'])."'";

				mysql_query($sql) or die(mysql_error());

				// add shop credit bonus message

				$sql = "
					INSERT INTO ".$CONFIG['mysql_prefix']."message
					(
						action, 
						refid, 
						userid, 
						username, 
						to_username, 
						message, 
						room, 
						avatar, 
						avatar_x, 
						avatar_y, 
						post_time
					) 
					VALUES 
					(
						'login', 
						'".$uref."',
						'".$uid."', 
						'SYSTEM', 
						'', 
						'".$creditsMessage."', 
						'".$uroom."', 
						'".$uavatar."', 
						'".$uXX."', 
						'".$uYY."', 
						'".$timeNow."'
					)";

				mysql_query($sql) or die(mysql_error());
			}
		}
	}

	// define local username color (Basic/VIP/Admin)
	// also edit 'js/userlist.php' for username colors

	// guest or basic member - green

	if($isVIP == '0')
	{
		$chatMemberLevel = '0';
		$showUsername = "<font color='#33ff66'>".$_SESSION['username']."</font>";

		// disable guest admin rights if '0' in config file
		if(!$CONFIG['guestrooms_admin'] && !in_array(strtolower($_SESSION['username']),$chatroom_mods))
		{
			// unset session

			unset($_SESSION['chat_moderator']);

			// update database

			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET adminID = '0' WHERE username = '".$_SESSION['username']."'";mysql_query($sql) or die(mysql_error());
		}

	}

	// VIP (paid member) - yellow

	if($isVIP == '1')
	{
		$chatMemberLevel = '1';
		$showUsername = "<font color='#ffff33'>".$_SESSION['username']."</font>";
	}

	// admin - red

	if($sAdmin)
	{
		$showUsername = "<font color='#ff0033'>".$_SESSION['username']."</font>";
	} 

	// create avatar item array
	$uavatar = explode("|", $uavatar);

	// start the show
	include("templates/main.php");

	// reset roomFull session
	$_SESSION['roomFull'] = '0';

	// reset roomFriends session
	$_SESSION['roomFriends'] = '0';

?>