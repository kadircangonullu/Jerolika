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

	// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/xml; charset=utf-8");

	// get to_uname

	$to_uname = $_GET['to_uname'];

	// check data is valid

	if(!$_GET['to_uname'][0] || !_alpha_numeric($_GET['to_uname'])){

		die("to_uname is not alphanumeric");

	}

	// get results to show

	$whichVote = '';

	$voteID = $_GET['voteID'];

	if(!$_GET['voteID'][0] || !is_numeric($_GET['voteID'])){

		die("voteID value is not numeric");

	}

	if($voteID=='1'){

		$whichVote = "lovevote";

	}

	if($voteID=='2'){

		$whichVote = "thumbvote";

	}

	if($voteID=='3'){

		$whichVote = "starvote";

	}

	// get users

	$xml = '<?xml version="1.0" ?><root>';

	// get data from users table

	$tmp="
	SELECT to_username      
	FROM ".$CONFIG['mysql_prefix']."votes 
	WHERE username = '".makeSafe($_SESSION['username'])."' 
	AND to_username = '".makeSafe($to_uname)."' 
	AND ".$whichVote." = '1'
	LIMIT 1 
	"; 

	$theresult=mysql_query($tmp);
	$voteResults = mysql_num_rows($theresult);

	// show results

	$xml .= '<uservote>';
	$xml .= '<gotpoints>' . $voteResults . '</gotpoints>';
	$xml .= '</uservote>';

	$xml .= '</root>';
	echo $xml;

?>