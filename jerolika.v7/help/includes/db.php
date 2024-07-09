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

// set the error reporting level
// http://uk.php.net/error_reporting
error_reporting(E_ALL & ~E_NOTICE);

// set on screen error reporting
ini_set("display_errors", 0);

// set log error reporting
ini_set("log_errors", 1);

// file to save error messages
ini_set("error_log", "error_log.txt");

// connect to MySQL database
include("conn.php");

@mysql_connect($CONFIG['mysql_host'], $CONFIG['mysql_user'], $CONFIG['mysql_pass']) 
or die("ERROR: Cannot Connect To Database.");
 
@mysql_select_db($CONFIG['mysql_db'])
or die("ERROR: Cannot connect to Database.");

?>