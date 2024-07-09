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

	// if no session, die

	if(!$_SESSION['username']){

		die('access denied');

	}

	// get results to show

	$searchModUsersID = $_GET['searchModUsersID'];

	if(!is_numeric($searchModUsersID)){

		die("searchModUsersID value is not numeric");

	}

	// get room id

	$roomID = $_GET['roomID'];

	if(!is_numeric($roomID)){

		die("room value is not numeric");

	}

	//limit results
    	$t_results = 10;

	//active users
	$activeNow = date("U")-300; // 300 = 5 mins

	// get users

	$xml = '<?xml version="1.0" ?><root>';

	// get data from users table

	$tmp=mysql_query("
	SELECT id, username, room, status, adminID     
	FROM ".$CONFIG['mysql_prefix']."user
	WHERE room = ".$roomID." 
	AND online_time >= '".$activeNow."' 
	ORDER BY status ASC, username ASC 
	LIMIT $searchModUsersID, $t_results   
	") or die(mysql_error()); 

	// show online users

	while($got_data = mysql_fetch_array($tmp)) {

		$xml .= '<userdetails>';
		$xml .= '<uids>_' . ($got_data['id']) . '_</uids>';
		$xml .= '<usernames>' . ($got_data['username']) . '</usernames>';
		$xml .= '<userstatus>' . ($got_data['status']) . '</userstatus>';
		$xml .= '<useradmin>' . ($got_data['adminID']) . '</useradmin>';
		$xml .= '<userroom>' . ($got_data['room']) . '</userroom>';
		$xml .= '</userdetails>';

	}

	$xml .= '</root>';
	echo $xml;

?>