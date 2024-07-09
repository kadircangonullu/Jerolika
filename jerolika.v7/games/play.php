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


	include("../includes/session.php");
	include("../includes/db.php");
	include("../includes/config.php");
	include("../includes/functions.php");

	// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");

	// if no session or not admin, die
	if(!$_SESSION['username'] && !$_SESSION['cp_isLoggedIN']){

		die('access denied');

	}

	// check game id is numeric
	if(!is_numeric($_GET['id'])){

		die('Invalid Game ID');

	}

	// get games data
	$tmp=mysql_query("SELECT * FROM ".$CONFIG['mysql_prefix']."games WHERE game_ID = '".makeSafe($_GET['id'])."'");
	while($i=mysql_fetch_array($tmp)) {

	?>

		<object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="<?php echo ($i['game_Width']);?>" height="<?php echo ($i['game_Height']);?>">
		<param name="movie" value="swf/<?php echo ($i['game_SwfFile']);?>" />
		<param name="quality" value="high" />
		<embed src="swf/<?php echo ($i['game_SwfFile']);?>" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="<?php echo ($i['game_Width']);?>" height="<?php echo ($i['game_Height']);?>"></embed>
		</object>

	<?php } ?>
