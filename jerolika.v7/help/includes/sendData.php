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

	// Send some headers to keep the user's browser from caching the response.
	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");

	// set time stamp

	$timeNow = date("U");

	// if no post, die

	if(!$_POST){

		die('access denied');

	}

	// if invalid post variables, die

	if($_POST && $_POST['uname'] && $_SESSION['username'] != $_POST['uname']){

		die('incorrect username');

	}

	if($_POST && $_POST['uaction'] && !_alpha_numeric($_POST['uaction'])){

		die('uaction not alphanumeric');

	}

	if($_POST && $_POST['uref'] && !_numeric($_POST['uref'])){

		die('uref not numeric');


	}

	if($_POST && $_POST['uid'] && !_numeric($_POST['uid'])){

		die('uid not numeric');

	}

	if($_POST && $_POST['to_uname'] && !_alpha_numeric($_POST['to_uname'])){

		die('to_name not alphanumeric');

	}

	if($_POST && $_POST['uroom'] && !is_numeric($_POST['uroom'])){

		die('uroom not numeric');

	}

	if($_POST && $_POST['uXX'] && !_numeric($_POST['uXX'])){

		die('uXX not numeric');

	}

	if($_POST && $_POST['uYY'] && !_numeric($_POST['uYY'])){

		die('uYY not numeric');

	}

	if($_POST && $_POST['unblock_uname'] && !_alpha_numeric($_POST['unblock_uname'])){

		die('unblock_uname not alphanumeric');

	}

	if($_POST && $_POST['ublock_uname'] && !_alpha_numeric($_POST['ublock_uname'])){

		die('ublock_uname not alphanumeric');

	}

	if($_POST && $_POST['umailID'] && !_numeric($_POST['umailID'])){

		die('umailID not numeric');

	}

	if($_POST && $_POST['uadd_uname'] && !_alpha_numeric($_POST['uadd_uname'])){

		die('uadd_uname not alphanumeric');

	}

	if($_POST && $_POST['uremfriendID'] && !_numeric($_POST['uremfriendID'])){

		die('uremfriendID not numeric');

	}

	if($_POST && $_POST['setX'] && !_numeric($_POST['setX'])){

		die('setX not anumeric');

	}

	if($_POST && $_POST['setY'] && !_numeric($_POST['setY'])){

		die('setY not numeric');

	}

	if($_POST && $_POST['newaccess'] && !_numeric($_POST['newaccess'])){

		die('newaccess not numeric');

	}

	if($_POST && $_POST['newname'] && !_alpha_numeric($_POST['newname'])){

		die('newname not alphanumeric');

	}

	if($_POST && $_POST['ublock_id'] && !_alpha_numeric($_POST['ublock_id'])){

		die('ublockID not alphanumeric');

	}

	if($_POST && $_POST['uvote'] && !_alpha_numeric($_POST['uvote'])){

		die('uvote not alphanumeric');

	}

	if($_POST && $_POST['uadd_uid'] && !_alpha_numeric($_POST['uadd_uid'])){

		die('uadd_uid not alphanumeric');

	}

	if($_POST && $_POST['roomBG'] && !chkIMG($_POST['roomBG'])){

		die('roomBG is not a valid image url - .jpg, .png, .gif');

	}

	if($_POST && $_POST['uavatar'] && !chkIMG($_POST['uavatar'])){

		die('uavatar is not a valid image url - .jpg, .png, .gif');

	}

	if($_POST && $_POST['uavIDs'] && !_numeric($_POST['uavIDs'])){

		die('uavIDs not numeric');

	}

	if($_POST && $_POST['umusic'] && chkURL($_POST['umusic'])){

		die('possible CSRF image attack');

	}

	// safe data
	$uaction = makeSafe($_POST['uaction']);
	$uref = makeSafe($_POST['uref']);
	$uid = makeSafe($_POST['uid']);
	$uname = makeSafe($_SESSION['username']);
	$to_uname = makeSafe($_POST['to_uname']);
	$uroom = makeSafe($_POST['uroom']);
	$uXX = makeSafe($_POST['uXX']);
	$uYY = makeSafe($_POST['uYY']);
	$unblock_uname = makeSafe($_POST['unblock_uname']);
	$ublock_uname = makeSafe($_POST['ublock_uname']);
	$umailID = makeSafe($_POST['umailID']);
	$uadd_uname = makeSafe($_POST['uadd_uname']);
	$uremfriendID = makeSafe($_POST['uremfriendID']);
	$setX = makeSafe($_POST['setX']);
	$setY = makeSafe($_POST['setY']);
	$newaccess = makeSafe($_POST['newaccess']);
	$avatarItems = makeSafe($_POST['avatarItems']);

	// shorten room name to 24 characters
	$newname = makeSafe($_POST['newname']);
	$newname = substr($newname, 0, 24);

	// remove underscore characters
	$ublock_id = $_POST['ublock_id'];
	$ublock_id = makeSafe(str_replace("_","",$ublock_id));

	$uvote = $_POST['uvote'];
	$uvote = makeSafe(str_replace("_","",$uvote));

	$uadd_uid = $_POST['uadd_uid'];
	$uadd_uid = makeSafe(str_replace("_","",$uadd_uid));

	// images
	$roomBG = makeSafe(strip_tags($_POST['roomBG']));
	$uavatar = makeSafe(strip_tags($_POST['uavatar']));

	// urls
	$umusic = makeSafe(remSpcChars(strip_tags($_POST['umusic'])));

	// message
	$umessage = makeSafe($_POST['umessage']);
	$umessage = str_replace("&#38;","&",$umessage);
	$umessage = htmlentities($umessage, ENT_QUOTES);
	$umessage = str_replace("&","&amp;",$umessage);

	// if we have reached here, alls ok, send to DB
	// assign mysql query for post data

	// update user room background
	if($_POST && $uaction=='updateBG'){

		// update database
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET myroomIMG = '".$roomBG."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// send data
	if($_POST && $uaction!='logout'){

		//insert message to DB
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('".$uaction."', '".$uref."', '".$uid."', '".$uname."', '".$to_uname."', '".$umessage."', '".$uroom."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')";mysql_query($sql) or die(mysql_error());

		//update avatars position
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatar_x = '".$uXX."', avatar_y = '".$uYY."', online_time = '".$timeNow."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// logout user
	if($_POST && $uaction=='logout'){

		//update avatars position
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatar_x = '".$uXX."', avatar_y = '".$uYY."', online_time = '0' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// block user
	if($_POST && $uaction=='block'){

		//insert message to DB
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."blocked(userid, username, blockid, blockname) VALUES ('".$uid."','".$uname."','".$ublock_id."','".$ublock_uname."')";mysql_query($sql) or die(mysql_error());

	}

	// unblock user
	if($_POST && $uaction=='unblock'){

		//remove user from blocked table
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."blocked WHERE blockname = '".$unblock_uname."' AND username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// vote love
	if($_POST && $uaction=='love'){

		//update vote count
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET lovepoints = lovepoints+'1' WHERE id = '".$uvote."'";mysql_query($sql) or die(mysql_error());

		//insert vote to table
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."votes(username, to_username, lovevote) VALUES ('".$uname."','".$to_uname."','1')";mysql_query($sql) or die(mysql_error());

		awardCredits($CONFIG['reward_heart'],'0'); 
	}

	// vote like (thumbs)
	if($_POST && $uaction=='like'){

		//update vote count
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET thumbpoints = thumbpoints+'1' WHERE id = '".$uvote."'";mysql_query($sql) or die(mysql_error());

		//insert vote to table
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."votes(username, to_username, thumbvote) VALUES ('".$uname."','".$to_uname."','1')";mysql_query($sql) or die(mysql_error());

		awardCredits($CONFIG['reward_thumb'].'0'); 
	}

	// vote star
	if($_POST && $uaction=='star'){

		//update vote count
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET starpoints = starpoints+'1' WHERE id = '".$uvote."'";mysql_query($sql) or die(mysql_error());

		//insert vote to table
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."votes(username, to_username, starvote) VALUES ('".$uname."','".$to_uname."','1')";mysql_query($sql) or die(mysql_error());

		awardCredits($CONFIG['reward_star'],'0'); 
	}

	// send mail
	if($_POST && $uaction=='sendmail'){

		// timestamp
		$today = date("F j, Y"); 

		//insert mail to DB
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."mail(userid, username, touserid, tousername, message, senttime, status) VALUES ('".$uid."','".$uname."','','".$to_uname."','".$umessage."','".$today."','new')";mysql_query($sql) or die(mysql_error());

	}

	// read mail
	if($_POST && $uaction=='readmail'){ 

		//mark as read
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."mail SET status = 'old' WHERE tousername = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// delete mail
	if($_POST && $uaction=='delmail'){

		//delete mail from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."mail WHERE id = '".$umailID."'";mysql_query($sql) or die(mysql_error());

	}

	// request friendship
	if($_POST && $uaction=='reqfriend'){

		//insert message to DB
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('".$uaction."', '".$uref."', '".$uid."', '".$uname."', '".$to_uname."', '".$umessage."', '".$uroom."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')";mysql_query($sql) or die(mysql_error());

	}

	// ignore friendship request
	if($_POST && $uaction=='ignfriend'){

		//delete request from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."message WHERE action = 'reqfriend' AND username='".$uadd_uname."' AND to_username='".$uname."'";mysql_query($sql) or die(mysql_error());

		//delete request from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."message WHERE action = 'accfriend' AND username='".$uname."' AND to_username='".$uadd_uname."'";mysql_query($sql) or die(mysql_error());
		
	}

	// accept friendship request
	if($_POST && $uaction=='accfriend'){

		//update user id
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET userid = '".$uref."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET friendid = '".$uref."' WHERE friendname = '".$uname."'";mysql_query($sql) or die(mysql_error());

		//delete request from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."message WHERE action = 'accfriend' AND username='".$uadd_uname."' AND to_username='".$uname."' OR action = 'accfriend' AND username='".$uname."' AND to_username=''";mysql_query($sql) or die(mysql_error());
		
	}

	// add friend
	if($_POST && $uaction=='addfriend'){

		//insert user and new friend to DB
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."friends(userid, username, friendid, friendname, room) VALUES ('".$uref."','".$uname."','".$uadd_uid."','".$uadd_uname."','".$uroom."')";mysql_query($sql) or die(mysql_error());
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."friends(userid, username, friendid, friendname, room) VALUES ('".$uadd_uid."','".$uadd_uname."','".$uref."','".$uname."','".$uroom."')";mysql_query($sql) or die(mysql_error());

		//insert accepted request message to DB
		$uaction = 'accfriend';
		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."message(action, refid, userid, username, to_username, message, room, avatar, avatar_x, avatar_y, post_time) VALUES ('".$uaction."', '".$uref."', '".$uid."', '".$uname."', '".$uadd_uname."', '".$umessage."', '".$uroom."', '".$uavatar."', '".$uXX."', '".$uYY."', '".$timeNow."')";mysql_query($sql) or die(mysql_error());

		//delete request from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."message WHERE action = 'reqfriend' AND username='".$uadd_uname."' AND to_username='".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// delete friend
	if($_POST && $uaction=='delfriend'){

		//delete friend from DB
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."friends WHERE userid = '".$uremfriendID."' AND friendname= '".$uname."' ";mysql_query($sql) or die(mysql_error());
		$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."friends WHERE friendid = '".$uremfriendID."' AND username= '".$uname."' ";mysql_query($sql) or die(mysql_error());

	}

	// ban user
	if($_POST && $uaction=='ban' && $_SESSION['chat_moderator']){

		//ban user
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET status = '1' WHERE id = '".$ublock_id."'";mysql_query($sql) or die(mysql_error());

	}

	// unban user
	if($_POST && $uaction=='unban' && $_SESSION['chat_moderator']){

		//unban user
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET status = '0' WHERE id = '".$ublock_id."'";mysql_query($sql) or die(mysql_error());

	}

	// kick user
	if($_POST && $uaction=='kick' && $_SESSION['chat_moderator']){

		// nothing is required and action is left empty
		// the 'kick' option forces the user to logout (or move to default room)
		// we could do something extra here at a later date :)		

	}

	// update avatar
	if($_POST && $uaction=='updateAvatar'){

		if($_POST['uavIDs'] == '1'){

			//update avatar
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatara = '".$uavatar."', avatar = '".$uavatar."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

		}

		if($_POST['uavIDs'] == '2'){

			//update avatar
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatarb = '".$uavatar."', avatar = '".$uavatar."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

		}

		if($_POST['uavIDs'] == '3'){

			//update avatar
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatarc = '".$uavatar."', avatar = '".$uavatar."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

		}

	}

	// update avatar outfit
	if($_POST && $uaction=='updateAvatar'){

		//update my avatar items
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET avatar = '".$avatarItems."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// update room name
	if($_POST && $uaction=='updateRName'){

		//update room name
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET roomname = '".$newname."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

		//update friends
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."friends SET roomname = '".$newname."' WHERE friendname = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// update music
	if($_POST && $uaction=='updateMusic'){

		//update music
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET music = '".$umusic."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// update posistion
	if($_POST && $uaction=='updateSPXY'){

		//update posistion
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET startX = '".$setX."', startY = '".$setY."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

	// update room access
	if($_POST && $uaction=='updateRAccess'){

		//update room access
		$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET roomaccess = '".$newaccess."' WHERE username = '".$uname."'";mysql_query($sql) or die(mysql_error());

	}

?>