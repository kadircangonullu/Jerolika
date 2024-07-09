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

	// get results to show

	$searchFriendsID = $_GET['searchFriendsID'];

	if(!is_numeric($searchFriendsID)){

		die("value is not numeric");

	}

	// limit results

   	$t_results = 10;

	// get blocked users

	$xml = '<?xml version="1.0" ?><root>';

	$tmp=mysql_query("
	SELECT friendname, friendid, room, online, roomname  
	FROM ".$CONFIG['mysql_prefix']."friends 
	WHERE username = '".makeSafe($_SESSION['username'])."'
	ORDER BY online DESC
	LIMIT $searchFriendsID, $t_results   
	") or die(mysql_error()); 

	// show blocked users

	while($got_data = mysql_fetch_array($tmp)) {

		$xml .= '<getfriends>';
		$xml .= '<fid>' . ($got_data['friendid']) . '</fid>';
		$xml .= '<fname>' . ($got_data['friendname']) . '</fname>';
		$xml .= '<froom>' . ($got_data['room']) . '</froom>';
		$xml .= '<fonline>' . ($got_data['online']) . '</fonline>';

		if(!$got_data['roomname']){
			$xml .= '<froomname>My Private Room</froomname>';
		}else{
			$xml .= '<froomname>' . ($got_data['roomname']) . '</froomname>';
		}

		$xml .= '<froomname>' . ($got_data['roomname']) . '</froomname>';
		$xml .= '</getfriends>';

	}

	$xml .= '</root>';
	echo $xml;

?>