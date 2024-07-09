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

	// get blocked users

	$xml = '<?xml version="1.0" ?><root>';

	$tmp=mysql_query("
	SELECT id, username, userid, tousername, message, senttime, status 
	FROM ".$CONFIG['mysql_prefix']."mail 
	WHERE tousername = '".makeSafe($_SESSION['username'])."'
	ORDER BY id DESC LIMIT 10 
	") or die(mysql_error()); 

	while($got_data = mysql_fetch_array($tmp)) {

		$xml .= '<mailinbox>';
		$xml .= '<mid>' . ($got_data['id']) . '</mid>';
		$xml .= '<muserid>' . ($got_data['userid']) . '</muserid>';
		$xml .= '<musername>' . ($got_data['username']) . '</musername>';
		$xml .= '<mtousername>' . ($got_data['tousername']) . '</mtousername>';
		$xml .= '<mmessage>' . ($got_data['message']) . '</mmessage>';
		$xml .= '<mtime>' . ($got_data['senttime']) . '</mtime>';
		$xml .= '<mstatus>' . ($got_data['status']) . '</mstatus>';
		$xml .= '</mailinbox>';

	}

	$xml .= '</root>';

	echo $xml;

?>