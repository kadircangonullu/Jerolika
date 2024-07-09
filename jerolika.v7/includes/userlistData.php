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


	include("session.php");
	include("db.php");
	include("config.php");
	include("functions.php");
	chkSession();

	// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/xml; charset=utf-8");

	// get room id

	if($_GET['roomID']){

		// assign roomID
		$roomID = $_GET['roomID'];

		// check value is numeric
		if(!is_numeric($_GET['roomID'])){

			die("value is not numeric");

		}

	}

	// get user points

	if($_GET['userPTS']){

		// assign userPTS
		$userPTS = $_GET['userPTS'];

		//check value is numeric
		if(!is_numeric($_GET['userPTS'])){

			die("value is not numeric");

		}

	}

	// update user points

	if(!$userPTS){

		$inc_userPTS = "AND ".$CONFIG['mysql_prefix']."user.username !='".makeSafe($_SESSION['username'])."'";

	}

	// set user as active

	$timeNow = date("U");

	// update room for friends list

	$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET room = '".makeSafe($roomID)."', online = '1' WHERE friendname = '".makeSafe($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

	// update user online

	$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET room = '".makeSafe($roomID)."', online_time = '".$timeNow."' WHERE username = '".makeSafe($_SESSION['username'])."'";mysql_query($sql) or die(mysql_error());

	// set time

	$inactiveTimeout = date("U")-300; // 5 mins

	// get users

	$xml = '<?xml version="1.0" ?><root>';

/**

	// get data from users table

	$tmp=mysql_query("
	SELECT id, userid, adminID, password, username, room, avatar, avatar_x, avatar_y, webcam, lovepoints, thumbpoints, starpoints, online_time, vip      
	FROM ".$CONFIG['mysql_prefix']."user 
	WHERE room = '".makeSafe($roomID)."'
	AND online_time !='0' 
	".$inc_userPTS."
	") or die(mysql_error());

**/ 

	// get data from users table

	$tmp=mysql_query("
	SELECT ".$CONFIG['mysql_prefix']."user.id, ".$CONFIG['mysql_prefix']."user.userid, ".$CONFIG['mysql_prefix']."user.adminID, ".$CONFIG['mysql_prefix']."user.password, ".$CONFIG['mysql_prefix']."user.username, ".$CONFIG['mysql_prefix']."user.room, ".$CONFIG['mysql_prefix']."user.avatar, ".$CONFIG['mysql_prefix']."user.avatar_x, ".$CONFIG['mysql_prefix']."user.avatar_y, ".$CONFIG['mysql_prefix']."user.webcam, ".$CONFIG['mysql_prefix']."user.lovepoints, ".$CONFIG['mysql_prefix']."user.thumbpoints, ".$CONFIG['mysql_prefix']."user.starpoints, ".$CONFIG['mysql_prefix']."user.online_time, ".$CONFIG['mysql_prefix']."user.vip, ".$CONFIG['mysql_prefix']."shop_accounts.credits       
	FROM ".$CONFIG['mysql_prefix']."user, ".$CONFIG['mysql_prefix']."shop_accounts  
	WHERE ".$CONFIG['mysql_prefix']."user.username = ".$CONFIG['mysql_prefix']."shop_accounts.username
	AND ".$CONFIG['mysql_prefix']."user.room = '".makeSafe($roomID)."'
	AND ".$CONFIG['mysql_prefix']."user.online_time !='0' 
	".$inc_userPTS."
	") or die(mysql_error()); 

	// show online users

	while($got_data = mysql_fetch_array($tmp)) {

		if($got_data['password']){

			$isGuest = '0'; 

		}else{

			$isGuest = '1';

		}

		if($got_data['adminID']=='2'){

			$isAdmin = '1'; 

		}else{

			$isAdmin = '0';

		}

		//set inactive users offline
		if($got_data['online_time'] < $inactiveTimeout){

			//update room for friends list
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET room = '".$got_data['room']."', online = '0' WHERE friendid = '".$got_data['id']."'";mysql_query($sql) or die(mysql_error());

			//update user online
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET room = '".$got_data['room']."', online_time = '0' WHERE id = '".$got_data['id']."'";mysql_query($sql) or die(mysql_error());
	
		}

		$xml .= '<userdetails>';
		$xml .= '<uids>_' . ($got_data['id']) . '_</uids>';
		$xml .= '<userids>' . ($got_data['userid']) . '</userids>';
		$xml .= '<usernames>' . ($got_data['username']) . '</usernames>';
		$xml .= '<useravatars>' . ($got_data['avatar']) . '</useravatars>';
		$xml .= '<useravatarx>' . ($got_data['avatar_x']) . '</useravatarx>';
		$xml .= '<useravatary>' . ($got_data['avatar_y']) . '</useravatary>';
		$xml .= '<userwebcams>' . ($got_data['webcam']) . '</userwebcams>';
		$xml .= '<ulove>' . ($got_data['lovepoints']) . '</ulove>';
		$xml .= '<ulike>' . ($got_data['thumbpoints']) . '</ulike>';
		$xml .= '<ustar>' . ($got_data['starpoints']) . '</ustar>';
		$xml .= '<ucredits>' . ($got_data['credits']) . '</ucredits>';
		$xml .= '<useronlines>' . ($got_data['online_time']) . '</useronlines>';
		$xml .= '<userguests>' . $isGuest . '</userguests>';
		$xml .= '<useradmins>' . $isAdmin . '</useradmins>';
		$xml .= '<uservip>' . ($got_data['vip']) . '</uservip>';
		$xml .= '</userdetails>';

	}

	$xml .= '</root>';
	echo $xml;

?>