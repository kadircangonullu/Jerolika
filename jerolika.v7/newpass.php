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

	// update password

	$update_pass = '';

	if($_POST && $_POST['update']=='1'){

		include("includes/db.php");
		include("includes/config.php");
		include("includes/functions.php");

		// make safe data

		$nickID = remSpcChars($_POST['nickCid']);
		$nickPass = remSpcChars($_POST['nickRef']);
		$nickEmail = remSpcChars($_POST['nickEmail']);

		// check username is in database

		$userExists=mysql_query("SELECT username FROM ".$CONFIG['mysql_prefix']."user WHERE password = '".mysql_real_escape_string($nickPass)."' AND id = '".mysql_real_escape_string($nickID)."' AND email ='".mysql_real_escape_string($nickEmail)."'") or die(mysql_error()); 
		$userFound = mysql_num_rows($userExists);

		if($userFound){

			// update password

			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET password = '".mysql_real_escape_string(md5(md5($_POST['newPass'])))."' WHERE password = '".mysql_real_escape_string($nickPass)."' AND id = '".mysql_real_escape_string($nickID)."' AND email ='".mysql_real_escape_string($nickEmail)."' ";mysql_query($sql) or die(mysql_error());

			$update_pass = '1'; // alls ok

		}else{

			$update_pass = '2'; // error

		}

	}

	// assign errors

	if($update_pass=='1'){$eMessage = 'Password Updated! - Please <a href="index.php">Login</a>';}
	if($update_pass=='2'){$eMessage = 'Error: User Not Found';}

	include("templates/newpass.php");

	die;

?>
