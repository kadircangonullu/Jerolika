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

	$roomID = $_GET['roomID'];
	$last = (isset($_GET['last']) && $_GET['last'] != '') ? $_GET['last'] : 0;

	if(!is_numeric($roomID) || !is_numeric($last)){

		die("value is not numeric");

	}

	// get blocked users

	$get_blocked=mysql_query("
	SELECT blockname 
	FROM ".$CONFIG['mysql_prefix']."blocked 
	WHERE username = '".makeSafe($_SESSION['username'])."'
	") or die(mysql_error()); 

	$found_blocked = mysql_num_rows($get_blocked);

	if($found_blocked){

		while($got_blocked = mysql_fetch_array($get_blocked)) {

			$blocked_users[] = "'".($got_blocked['blockname'])."' ";

		}

		$_blocked = implode(',', $blocked_users);

		$include_block = "AND username NOT IN ($_blocked)";

	}

	// get users

	$xml = '<?xml version="1.0" ?><root>';

	$tmp=mysql_query("
	SELECT id,action,refid,userid,username,to_username,room,message,avatar,avatar_x,avatar_y,post_time 
	FROM ".$CONFIG['mysql_prefix']."message 

	WHERE room ='".makeSafe($roomID)."'
	AND action IN ('login', 'logout', 'message', 'like', 'love', 'star', 'block', 'unblock', 'ban', 'reqfriend', 'accfriend', 'rejfriend', 'kick', 'interaction') 
	AND to_username =  '".makeSafe($_SESSION['username'])."'
	AND id > '".makeSafe($last)."'
 	".$include_block."  
 
	OR room ='".makeSafe($roomID)."'
	AND action IN ('login', 'logout', 'message', 'like', 'love', 'star', 'block', 'unblock', 'ban', 'reqfriend', 'accfriend', 'rejfriend', 'kick', 'interaction') 
	AND to_username = ''
	AND username != '".makeSafe($_SESSION['username'])."'
	AND id > '".makeSafe($last)."'
 	".$include_block." 

	OR to_username = '".makeSafe($_SESSION['username'])."' 
	AND action IN ('login', 'logout', 'message', 'like', 'love', 'star', 'block', 'unblock', 'ban', 'reqfriend', 'accfriend', 'rejfriend', 'kick', 'interaction') 
	AND id > '".makeSafe($last)."'
 	".$include_block." 

	") or die(mysql_error()); 

	// show online users

	while($got_data = mysql_fetch_array($tmp)) {

		if(!$got_data['id']){$got_data['id']='-';}
		if(!$got_data['action']){$got_data['action']='-';}
		if(!$got_data['refid']){$got_data['refid']='-';}
		if(!$got_data['userid']){$got_data['userid']='-';}
		if(!$got_data['username']){$got_data['username']='-';}
		if(!$got_data['to_username']){$got_data['to_username']='-';}
		if(!$got_data['room']){$got_data['room']='-';}
		if(!$got_data['message']){$got_data['message']='-';}
		if(!$got_data['avatar']){$got_data['avatar']='-';}
		if(!$got_data['avatar_x']){$got_data['avatar_x']='-';}
		if(!$got_data['avatar_y']){$got_data['avatar_y']='-';}
		if(!$got_data['post_time']){$got_data['post_time']='-';}

		$xml .= '<usermessage>';
		$xml .= '<uid>' . ($got_data['id']) . '</uid>';
		$xml .= '<uaction>' . ($got_data['action']) . '</uaction>';
		$xml .= '<urefid>' . ($got_data['refid']) . '</urefid>';
		$xml .= '<userid>' . ($got_data['userid']) . '</userid>';
		$xml .= '<uname>' . ($got_data['username']) . '</uname>';
		$xml .= '<utoname>' . ($got_data['to_username']) . '</utoname>';
		$xml .= '<uroom>' . ($got_data['room']) . '</uroom>';
		$xml .= '<umessage>' . ($got_data['message']) . '</umessage>';
		$xml .= '<uavatar>' . ($got_data['avatar']) . '</uavatar>';
		$xml .= '<uavatarx>' . ($got_data['avatar_x']) . '</uavatarx>';
		$xml .= '<uavatary>' . ($got_data['avatar_y']) . '</uavatary>';
		$xml .= '<utime>' . ($got_data['post_time']) . '</utime>';
		$xml .= '</usermessage>';

	}

	$xml .= '</root>';
	echo $xml;
?>