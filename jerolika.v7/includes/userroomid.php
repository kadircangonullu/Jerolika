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

	// check data is valid

	if(!$_GET['nickName'][0] || !_alpha_numeric($_GET['nickName'])){

		die("username is invalid");

	}

	// get results

	$xml = '<?xml version="1.0" ?><root>';

	// get data from users table

	$tmp=mysql_query("
	SELECT myroomID     
	FROM ".$CONFIG['mysql_prefix']."user
	WHERE username = '".makeSafe($_GET['nickName'])."' 
	LIMIT 1 
	") or die(mysql_error()); 

	// show online users

	while($got_data = mysql_fetch_array($tmp)) {

		$xml .= '<userroomdetails>';
		$xml .= '<uroomid>' . ($got_data['myroomID']) . '</uroomid>';
		$xml .= '</userroomdetails>';

	}

	$xml .= '</root>';
	echo $xml;

?>