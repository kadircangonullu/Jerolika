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

	// check users session is set
	function chkSession(){

		if(!$_SESSION['username'][0] || !$_SESSION['username'] || !_alpha_numeric($_SESSION['username'])){

			die('session is not set');

		}

	}

	// make safe data for messages
	function makeSafe($str){

		return @mysql_real_escape_string($str);

	}

	// remove special characters
	function remSpcChars($str){

		// remove special characters
		$remove_chars=array("'","\"","<",">","+","(",")","%");

		return str_replace($remove_chars, "", $str);

	}

	// check for alphanumeric characters
	function _alpha_numeric($str){ 

		return (@strspn($str, "abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ0123456789_-") == strlen($str)); 

	}

	// check for numeric characters
	function _numeric($str){ 

		return (@strspn($str, "0123456789") == strlen($str)); 

	}

	// check string is image
	function chkIMG($str){

		// check if CSRF attempt
		if(preg_match("/logout/i", $str)){

			die('possible CSRF image attack');

		}

		// allowed extensions
		$img_ext=array(".gif", ".png", ".jpg");

		// get last 4 characters of image string
		$lastChars = substr($str, -4);

		return in_array(strtolower($lastChars),$img_ext);

	}

	// check music url for CSRF
	function chkURL($str){

		// check if CSRF attempt
		return preg_match("/logout/i", $str);

	}

	// register user
	function regUser($nickName, $nickPass, $nickEmail, $nickGender){

		include("conn.php");
		include("config.php");

		// shorten POST username/password to 16 characters
		// helps to prevent mailicious remote post

		$nickName = substr($nickName, 0, 16);
		$nickPass = substr($nickPass, 0, 16);

		// shorten POST gender to 1 character
		// helps to prevent mailicious remote post

		$nickGender = substr($nickGender, 0, 1);

		// check username is alphanumeric and underscores only (char min 3, max 16)

		$valid_name = _alpha_numeric($nickName);

		if(!$valid_name || strlen($nickName) < 3 || strlen($nickName) > 16){	

			// set error message

			$new_reg = '3'; // invalid username

			return $new_reg;

			die;

		}

		// is password more than 3 characters and less than 16?

		if(strlen($nickPass) < 3 || strlen($nickPass) > 16){

			// set error message

			$new_reg = '4'; // invalid password length

			return $new_reg;

			die;
		}

		// check if email is formatted correctly

		if(!preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $nickEmail)){

			// set error message

			$new_reg = '5'; // invalid email

			return $new_reg;

			die;

		}  

		// email is valid, make safe data and add user

		$nickName = remSpcChars($nickName);
		$nickEmail = remSpcChars($nickEmail);
		$nickGender = remSpcChars($nickGender);
		$enc_nickPass = md5(md5($nickPass));

		// check username is in database

		$userExists=mysql_query("SELECT username FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string($nickName)."' LIMIT 1") or die(mysql_error()); 
		$userFound = mysql_num_rows($userExists);

		if(!$userFound){

			// register new user
			$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."user(username, password, email, gender, vip, userIP, room, roommax) VALUES ('".mysql_real_escape_string($nickName)."', '".mysql_real_escape_string($enc_nickPass)."', '".mysql_real_escape_string($nickEmail)."', '".mysql_real_escape_string($nickGender)."', '".$CONFIG['vip_free']."', '".getIP()."', '".$CONFIG['defaultRoom']."', '".$CONFIG['room_max']."')";mysql_query($sql) or die(mysql_error()); 

			$new_reg = '1';

		}

		// if username is in database, check if theres a password assigned

		if($new_reg != '1'){

			$userExists=mysql_query("SELECT username FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string($nickName)."' AND password!='' LIMIT 1") or die(mysql_error()); 
			$userFound = mysql_num_rows($userExists);

			if(!$userFound){

				//update user, add password and update gender
				$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET room = '".$CONFIG['defaultRoom']."', userIP = '".getIP()."', password = '".mysql_real_escape_string($enc_nickPass)."', email = '".mysql_real_escape_string($nickEmail)."', gender = '".mysql_real_escape_string($nickGender)."', vip = '".$CONFIG['vip_free']."' WHERE username = '".mysql_real_escape_string($nickName)."'";mysql_query($sql) or die(mysql_error());

				$new_reg = '1';

			}

		}

		// if is new user, add room id and send welcome message

		if($new_reg == '1'){

			//create users myroomID
			$tmp=mysql_query("
			SELECT id    
			FROM ".$CONFIG['mysql_prefix']."user 
			WHERE username ='".mysql_real_escape_string($nickName)."'") or die(mysql_error()); 

			while($got_data = mysql_fetch_array($tmp)) {

				//update roomID
				$sql = "UPDATE ".$CONFIG['mysql_prefix']."user SET myroomID = '-".$got_data['id']."' WHERE username = '".mysql_real_escape_string($nickName)."'";mysql_query($sql) or die(mysql_error());
			}

			// create shop account
			createShopAccount($got_data['id'],$nickName);

			// send welcome mail
			sendUserMail($nickName, $nickEmail, $nickPass, '0');

		}

		// user is currently in database and has password assigned 

		if($new_reg != '1'){

			$new_reg = '2'; // error, user is already registered

		}

		// if referral, add data to referral table
		doReferral($nickName);

		return $new_reg;

	}


	// add referral
	function doReferral($referralName){

		include("conn.php");
		include("config.php");

		// check new user hasnt already been referred by this member
		// this prevents users abusing the referral system (do IP check)

		$userExists=mysql_query("SELECT username FROM ".$CONFIG['mysql_prefix']."referrals WHERE username = '".mysql_real_escape_string($_SESSION['referralID'])."' AND joinIP = '".getIP()."' LIMIT 1") or die(mysql_error()); 
		$userFound = mysql_num_rows($userExists);

		if(!$userFound)
		{
			// add to referral table
			$timeNow = date("U");
			$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."referrals(username, referred, joinIP, joindate) VALUES ('".mysql_real_escape_string($_SESSION['referralID'])."', '".mysql_real_escape_string($referralName)."', '".getIP()."', '".$timeNow."')";mysql_query($sql) or die(mysql_error()); 

			// award credits to user who referred new user
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."shop_accounts SET credits = credits + '".$CONFIG['referral_award']."' WHERE username = '".mysql_real_escape_string($_SESSION['referralID'])."'";mysql_query($sql) or die(mysql_error());

			// send email
			sendNewReferralEmail($referralName);

		}		

	}

	// send email to user who referred new member
	function sendNewReferralEmail($referred){

			include("conn.php");
			include("config.php");

			// get referrers details
			$tmp=mysql_query("
			SELECT email     
			FROM ".$CONFIG['mysql_prefix']."user 
			WHERE username ='".mysql_real_escape_string($_SESSION['referralID'])."' LIMIT 1") or die(mysql_error()); 

			while($got_data = mysql_fetch_array($tmp)) {

				define("C_REFMAIL1","New Referral");
				define("C_REFMAIL2","Hello");
				define("C_REFMAIL3","Congratulations! You have referred a new member to ".$CONFIG['chatroom_title'].". Their nickname is ".$referred.".");
				define("C_REFMAIL4","You have earned yourself ".$CONFIG['referral_award']." free credits!");
				define("C_REFMAIL5","Refer more friends and earn ".$CONFIG['referral_award']." free credits for every new member who joins! Copy and paste the link below and send to your friends,");
				define("C_REFMAIL6","Many thanks");

				$subject = $CONFIG['chatroom_title']." - ".C_REFMAIL1;
				$body = C_REFMAIL2." ".$_SESSION['referralID'].",\n\n".C_REFMAIL3."\n\n ".C_REFMAIL4."\n\n".C_REFMAIL5."\n".$CONFIG['chatroom_url']."invite.php?ref=".$_SESSION['referralID']."\n\n".C_REFMAIL6.",\n".$CONFIG['chatroom_title']."\n".$CONFIG['chatroom_url'];

				$headers  = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/plain; charset=".$CONFIG['brower_char']."\n";
				$headers .= "X-Priority: 3\n";
				$headers .= "X-MSMail-Priority: Normal\n";
				$headers .= "X-Mailer: php\n";
				$headers .= "From: \"".$CONFIG['chatroom_title']."\" <".$CONFIG['admin_email'].">\n";

				mail($got_data['email'], $subject, $body, $headers);

			}

	}
	

	// send email
	function sendUserMail($nickName, $nickEmail, $nickPass, $newPass){

		include("conn.php");
		include("config.php");

		// shorten POST username to 16 characters
		// helps to prevent mailicious remote post

		$nickName = substr($nickName, 0, 16);

		// check username is alphanumeric and underscores only

		$valid_name = _alpha_numeric($nickName);

		if(!$valid_name || strlen($nickName) < 3 || strlen($nickName) > 16){	

			// set error message

			$new_reg = '3'; // invalid username

			return $new_reg;

			die;

		}

		// check if email is formatted correctly

		if(!preg_match( "/^([a-zA-Z0-9])+([a-zA-Z0-9\._-])*@([a-zA-Z0-9_-])+([a-zA-Z0-9\._-]+)+$/", $nickEmail)){

			// set error message

			$new_reg = '4'; // invalid email

			return $new_reg;

			die;

		}

		// make safe data

		$nickName = remSpcChars($nickName);
		$nickEmail = remSpcChars($nickEmail);

		// check username is in database

		$userExists=mysql_query("SELECT password FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string($nickName)."' AND email = '".mysql_real_escape_string($nickEmail)."'") or die(mysql_error()); 
		$userFound = mysql_num_rows($userExists);

		if($userFound){

			// get users details

			$tmp=mysql_query("
			SELECT id, username, password, email     
			FROM ".$CONFIG['mysql_prefix']."user 
			WHERE username ='".mysql_real_escape_string($nickName)."'") or die(mysql_error()); 

			while($got_data = mysql_fetch_array($tmp)) {

				// send mail

				if($newPass == '1'){ // send update password email

					define("C_MAILUPASS1","Login Details");
					define("C_MAILUPASS2","Hello");
					define("C_MAILUPASS3","Either you or someone pretending to be you has requested to update your login password.");
					define("C_MAILUPASS4","Please click the link below to update your login password");
					define("C_MAILUPASS5","If you do not want to update your login password, please delete this email.");
					define("C_MAILUPASS6","Many thanks");

					$subject = $CONFIG['chatroom_title']." - ".C_MAILUPASS1;
					$body = C_MAILUPASS2." ".$got_data['username'].",\n\n".C_MAILUPASS3."\n\n".C_MAILUPASS4.",\n\n".$CONFIG['chatroom_url']."/newpass.php?cid=".$got_data['id']."&ref=".$got_data['password']."&email=".$got_data['email']."\n\n".C_MAILUPASS6.",\n".$CONFIG['chatroom_title']."\n".$CONFIG['chatroom_url'];

				}else{ 	// send welcome email

					define("C_MAIL1","Login Details");
					define("C_MAIL2","Hello");
					define("C_MAIL3","Here are your");
					define("C_MAIL4","login details");
					define("C_MAIL5","Username");
					define("C_MAIL6","Password");
					define("C_MAIL7","Please keep your login details safe at all times.");
					define("C_MAIL8","Many thanks");
					define("C_MAIL9","Refer your friends and earn ".$CONFIG['referral_award']." free credits for every new member who joins! Copy and paste the link below and send to your friends,");

					$subject = $CONFIG['chatroom_title']." - ".C_MAIL1;
					$body = C_MAIL2." ".$got_data['username'].",\n\n".C_MAIL3." ".$CONFIG['chatroom_title']." ".C_MAIL4.",\n\n".C_MAIL5.": ".$got_data['username']."\n".C_MAIL6.": ".$nickPass."\n\n".C_MAIL7."\n\n".C_MAIL9."\n".$CONFIG['chatroom_url']."invite.php?ref=".$got_data['username']."\n\n".C_MAIL8.",\n".$CONFIG['chatroom_title']."\n".$CONFIG['chatroom_url'];

				}

				$headers  = "MIME-Version: 1.0\n";
				$headers .= "Content-type: text/plain; charset=".$CONFIG['brower_char']."\n";
				$headers .= "X-Priority: 3\n";
				$headers .= "X-MSMail-Priority: Normal\n";
				$headers .= "X-Mailer: php\n";
				$headers .= "From: \"".$CONFIG['chatroom_title']."\" <".$CONFIG['admin_email'].">\n";

				mail($got_data['email'], $subject, $body, $headers);

			}

			$result = '1'; // mail sent

		}

		if(!$userFound){

			$result = '2'; // no matches

		}

		return $result;

	}

	// get users IP

	function getIP(){

		$IP = $_SERVER['REMOTE_ADDR'];

		return $IP;

	}

	// create shop account function

	function createShopAccount($id,$nickName){

		include("conn.php");
		include("config.php");

		// do we have a shop account for this user?

		$tmp=mysql_query("
			SELECT lastLogin    
			FROM ".$CONFIG['mysql_prefix']."shop_accounts  
			WHERE username =  '".mysql_real_escape_string($nickName)."'
			") or die(mysql_error()); 

		// nope user not found, so create an entry, 
		// this is only done once (the first ever login)
		// for future logins, we can skip this stage

		if(!mysql_num_rows($tmp))
		{
			// add user

			$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."shop_accounts 
				(
					`id` ,
					`username` ,
					`credits` ,
					`lastLogin`
				)
				VALUES 
				(
					'".$id."' ,  
					'".mysql_real_escape_string($nickName)."',  
					'',  
					''
				)";mysql_query($sql);
		}

	}

	// award credits
	function awardCredits($amount, $profile)
	{
		include("conn.php");
		include("config.php");

		// profile view

		if($profile != '0')
		{
			$amount = '0';

			$expireTime = date("U")-86400; // 24 hours

			// has user already viewed this profile within $expireTime

			$profileViewed=mysql_query("
						SELECT username 
						FROM ".$CONFIG['mysql_prefix']."profileviews 
						WHERE username  = '".mysql_real_escape_string($_SESSION['username'])."' 
						AND viewed = '".mysql_real_escape_string($profile)."' 
						AND visited > '".$expireTime."'
						") or die(mysql_error()); 

			$result = mysql_num_rows($profileViewed);

			if(!$result)
			{
				// add profile view to db

				$timeNow = date("U");	

				$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."profileviews 
					(
						`username` ,
						`viewed` ,
						`visited`
					)
					VALUES 
					(
						'".mysql_real_escape_string($_SESSION['username'])."' ,  
						'".mysql_real_escape_string($profile)."',  
						'".$timeNow."' 
					)";mysql_query($sql);

				$amount = $CONFIG['reward_profile'];
			}

		}

		if($amount > 0)
		{
			// award credit(s)

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
				SET credits = credits + ".$amount." 
				WHERE username ='".mysql_real_escape_string($_SESSION['username'])."' LIMIT 1";

			mysql_query($sql) or die(mysql_error());
		}

		// delete any profile views older then $expireTime

		$sql="
			DELETE FROM ".$CONFIG['mysql_prefix']."profileviews 
			WHERE visited < '".$expireTime."'";

		mysql_query($sql) or die(mysql_error());

	}

	// get credits

	function getCredits(){

		include("conn.php");
		include("config.php");

		// get referrers details
		$tmp=mysql_query("
		SELECT credits     
		FROM ".$CONFIG['mysql_prefix']."shop_accounts 
		WHERE username ='".mysql_real_escape_string($_SESSION['username'])."' LIMIT 1") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp)) 
		{
			return $got_data['credits'];
		}

	}

	// pay by credits

	function payByCredits($option,$packageid,$nickname){

		include("conn.php");
		include("config.php");

		$startDate = date("U");
		$endDate = date("U")+2678400;

		if($option == 1)
		{
			// update VIP status

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."user 
				SET vip = '1', vipStart = '".$startDate."', vipEnd = '".$endDate."' 
				WHERE username ='".mysql_real_escape_string($nickname)."' LIMIT 1";

			mysql_query($sql) or die(mysql_error());

		}

		if($option == 2)
		{
			// update room users package 

			if($packageid == '1'){$roomUsers = $CONFIG['package_1_users'];}
			if($packageid == '2'){$roomUsers = $CONFIG['package_2_users'];}
			if($packageid == '3'){$roomUsers = $CONFIG['package_3_users'];}

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."user 
				SET roommax = '".$roomUsers."', roomMaxStart = '".$startDate."', roomMaxEnd = '".$endDate."' 
				WHERE username ='".mysql_real_escape_string($nickname)."' LIMIT 1";

			mysql_query($sql) or die(mysql_error());

		}

		// update users credits

		$sql="
			UPDATE ".$CONFIG['mysql_prefix']."shop_accounts     
			SET credits = credits - ".$CONFIG['vip_credits']." 
			WHERE username ='".mysql_real_escape_string($nickname)."' LIMIT 1";

		mysql_query($sql) or die(mysql_error());

	}

	// paypal IPN

	function payByPaypal($option,$packageid,$nickname,$subscribeID){

		include("conn.php");
		include("config.php");

		$startDate = date("U");
		$endDate = date("U")+2678400;

		if($option == '1')
		{
			// update VIP status

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."user 
				SET vipsubscrid = '".$subscribeID."', vip = '1', vipStart = '".$startDate."', vipEnd = '".$endDate."' 
				WHERE username ='".mysql_real_escape_string($nickname)."'
				OR vipsubscrid = '".$subscribeID."' 
				LIMIT 1";

			mysql_query($sql) or die(mysql_error());

		}

		if($option == '2')
		{
			// update room users package 

			if($packageid == '1'){$roomUsers = $CONFIG['package_1_users'];}
			if($packageid == '2'){$roomUsers = $CONFIG['package_2_users'];}
			if($packageid == '3'){$roomUsers = $CONFIG['package_3_users'];}

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."user 
				SET roommaxsubscrid = '".$subscribeID."', roommax = '".$roomUsers."', roomMaxStart = '".$startDate."', roomMaxEnd = '".$endDate."' 
				WHERE username ='".mysql_real_escape_string($nickname)."' 
				OR roommaxsubscrid = '".$subscribeID."' 
				LIMIT 1";

			mysql_query($sql) or die(mysql_error());

		}

		if($option == '3')
		{
			// update users credits

			$sql="
				UPDATE ".$CONFIG['mysql_prefix']."shop_accounts     
				SET credits = credits + ".$packageid." 
				WHERE username ='".mysql_real_escape_string($nickname)."' LIMIT 1";

			mysql_query($sql) or die(mysql_error());

		}

	}

	// cancel paypal payment
	function payByPaypalCancel($subscribeID)
	{
		include("conn.php");
		include("config.php");

		// get details

		$tmp=mysql_query("
			SELECT roommaxsubscrid, vipsubscrid    
			FROM ".$CONFIG['mysql_prefix']."user  
			WHERE roommaxsubscrid = '".$subscribeID."'  
			OR vipsubscrid = '".$subscribeID."' 
			LIMIT 1") or die(mysql_error()); 

		while($i = mysql_fetch_array($tmp)) 
		{
			// reset room users

			if($i['roommaxsubscrid']==$subscribeID)
			{
				$sql="
					UPDATE ".$CONFIG['mysql_prefix']."user 
					SET roommaxsubscrid = '0', roommax = '5', roomMaxStart = '0', roomMaxEnd = '0' 
					WHERE roommaxsubscrid = '".$subscribeID."' 
					LIMIT 1";

				mysql_query($sql) or die(mysql_error());
			}

			if($i['vipsubscrid ']==$subscribeID)
			{
				// reset VIP status

				$sql="
					UPDATE ".$CONFIG['mysql_prefix']."user 
					SET vipsubscrid = '0', vip = '0', vipStart = '0', vipEnd = '0' 
					WHERE vipsubscrid = '".$subscribeID."' 
					LIMIT 1";

				mysql_query($sql) or die(mysql_error());
			}
		}		
	}

?>