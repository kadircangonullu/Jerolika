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

// include files

	include("../includes/session.php");
	include("../includes/db.php");
	include("../includes/config.php");
	include("../includes/functions.php");

// check login

	if(!isset($_SESSION['cp_isLoggedIN']) || isset($_SESSION['cp_isLoggedIN']) != md5(md5($CONFIG['cp_prefix']))){

		// header redirect
		// header("Status: 200");
		header("Location: index.php");
		die;

	}

// update the user details

	if($_POST['cp_username']){

		if(!empty($_POST['cp_password'])){

			$cp_add_password = "password = '".md5(md5($_POST['cp_password']))."',";

		}

		// delete image

		if($_POST['cp_delete_image']!='')
		{

			$sql = "
			UPDATE ".$CONFIG['mysql_prefix']."user
			SET 
			photo = 'nopic.jpg' 
			WHERE username = '".remSpcChars($_POST['cp_username'])."'";
			mysql_query($sql) or die(mysql_error());

			if(file_exists("../profiles/uploads/".$_POST['cp_photo'])){

				unlink("../profiles/uploads/".$_POST['cp_photo']);

			}

		}

		if($_POST['cp_reset_avatar_image'] == '1'){

			$_POST['cp_avatar'] = $CONFIG['avatar_male'];

		}

		if($_POST['cp_reset_avatar_image'] == '2'){

			$_POST['cp_avatar'] = $CONFIG['avatar_female'];

		}

		if($_POST['cp_vip'] == '1'){

			payByCredits('1','',$_POST['cp_username']);

		}

		// update user

		$sql = "
		UPDATE ".$CONFIG['mysql_prefix']."user
		SET 
		userid = '".remSpcChars($_POST['cp_userid'])."',
		username = '".remSpcChars($_POST['cp_username'])."',
		".$cp_add_password."
		gender = '".remSpcChars($_POST['cp_gender'])."',
		email = '".remSpcChars($_POST['cp_email'])."',
		status = '".remSpcChars($_POST['cp_status'])."',
		vip = '".remSpcChars($_POST['cp_vip'])."',
		adminID = '".remSpcChars($_POST['cp_adminID'])."',
		room = '".remSpcChars($_POST['cp_room'])."',
		myroomID = '".remSpcChars($_POST['cp_myroomID'])."',
		myroomIMG = '".remSpcChars($_POST['cp_myroomIMG'])."',
		roomname = '".remSpcChars($_POST['cp_roomname'])."',
		roomaccess = '".remSpcChars($_POST['cp_roomaccess'])."',
		roommax = '".remSpcChars($_POST['cp_roommax'])."',
		startX = '".remSpcChars($_POST['cp_startX'])."',
		startY = '".remSpcChars($_POST['cp_startY'])."',
		music = '".remSpcChars($_POST['cp_music'])."',
		avatar = '".remSpcChars($_POST['cp_avatar'])."',
		avatara = '".remSpcChars($_POST['cp_avatara'])."',
		avatarb = '".remSpcChars($_POST['cp_avatarb'])."',
		avatarc = '".remSpcChars($_POST['cp_avatarc'])."',
		lovepoints = '".remSpcChars($_POST['cp_lovepoints'])."',
		thumbpoints = '".remSpcChars($_POST['cp_thumbpoints'])."',
		starpoints = '".remSpcChars($_POST['cp_starpoints'])."',
		age = '".htmlspecialchars(makeSafe($_POST['cp_age']))."',
		location = '".htmlspecialchars(makeSafe($_POST['cp_location']))."',
		hobbies = '".htmlspecialchars(makeSafe($_POST['cp_hobbies']))."',
		aboutme = '".htmlspecialchars(makeSafe($_POST['cp_aboutme']))."' 
		WHERE username = '".mysql_real_escape_string(remSpcChars($_POST['cp_username']))."'";
		mysql_query($sql) or die(mysql_error());

		if(!empty($_POST['cp_credits']))
		{
			// update users shop credits
			$sql = "
				UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
				SET 
				credits = '".makeSafe($_POST['cp_credits'])."'
				WHERE username = '".mysql_real_escape_string(remSpcChars($_POST['cp_username']))."'

			";mysql_query($sql) or die(mysql_error());
		}

		$_GET['cp_username'] = $_POST['cp_username'];

		$cp_confirm = '1';

	}

// get the user details

	if($_GET['cp_username']){
		
		$tmp=mysql_query("
		SELECT *     
		FROM ".$CONFIG['mysql_prefix']."user 
		WHERE username ='".mysql_real_escape_string(remSpcChars($_GET['cp_username']))."' 
		LIMIT 1") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp)) {

			$cp_id = $got_data['id'];
			$cp_userid = $got_data['userid'];		
			$cp_username = $got_data['username'];
			$cp_userIP = $got_data['userIP'];
			$cp_gender = $got_data['gender'];
			$cp_email = $got_data['email'];
			$cp_status = $got_data['status'];
			$cp_vip = $got_data['vip'];
			$cp_adminID = $got_data['adminID'];
			$cp_room = $got_data['room'];
			$cp_myroomID = $got_data['myroomID'];
			$cp_myroomIMG = $got_data['myroomIMG'];
			$cp_roomname = $got_data['roomname'];
			$cp_roomaccess = $got_data['roomaccess'];
			$cp_roommax = $got_data['roommax'];
			$cp_startX = $got_data['startX'];
			$cp_startY = $got_data['startY'];
			$cp_music = $got_data['music'];
			$cp_avatar = $got_data['avatar'];
			$cp_avatara = $got_data['avatara'];
			$cp_avatarb = $got_data['avatarb'];
			$cp_avatarc = $got_data['avatarc'];
			$cp_lovepoints = $got_data['lovepoints'];
			$cp_thumbpoints = $got_data['thumbpoints'];
			$cp_starpoints = $got_data['starpoints'];
			$cp_online_time = $got_data['online_time'];
			$cp_age = $got_data['age'];
			$cp_location = $got_data['location'];
			$cp_hobbies = $got_data['hobbies'];
			$cp_aboutme = $got_data['aboutme'];
			$cp_photo = $got_data['photo'];

			// create avatar item array
			$uavatar = explode("|", $cp_avatar);

		}

	}

?>

<html> 
<head>
<title>Avatar Chat - Admin Area</title>
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.body 
{
	color: #CCCCCC;
	font-family: Verdana, Arial;
	font-size: 12px;
	font-style: normal;
	background-color: #000000;
}
.table 
{
	color: #CCCCCC;
	font-family: Verdana, Arial;
	font-size: 12px;
	font-style: normal;
	background-color: #000000;
}
.spanMini
{
	position:absolute;
}
a:link {text-decoration: none; color: #CCCCCC;}
a:visited {text-decoration: none; color: #CCCCCC;}
a:active {text-decoration: none; color: #CCCCCC;}
a:hover {text-decoration: underline; color: #CCCCCC;}
</style>

</head>
<body class="body">

<table class="table" border="0">
<form action="userEdit.php" method="post" name="cp_userEdit_form"></td></tr>
<input name="cp_username" type="hidden" value="<?php echo $_GET['cp_username'];?>">

<tr><td colspan="2"><b>Edit User Management</b></td></tr>

<?php 

	if($cp_online_time > (date("U")-30)){

		$cp_isOnline = '<font color=green>Online</font>';

	}else{

		$cp_isOnline = '<font color=red>Offline</font>';

	}

?>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Username: <?php echo $cp_username;?></b></td></tr>
<tr><td colspan="2"><b>Currently: <?php echo $cp_isOnline;?></b></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>User Details</b></td></tr>
<tr><td>ID:</td><td><?php echo $cp_id;?></td></tr></td></tr>
<tr><td>User ID:</td><td><input name="cp_userid" type="text" value="<?php echo $cp_userid;?>"></td></tr>
<tr><td>UserName:</td><td><input name="cp_username" type="text" value="<?php echo $cp_username;?>" maxlength="16"></td></tr>
<tr><td>Password:</td><td><input name="cp_password" type="text" value="" maxlength="32"> (leave blank if no change)</td></tr>
<tr><td>UserIP:</td><td><?php echo $cp_userIP;?></td></tr>
<tr><td>Gender:</td><td><input name="cp_gender" type="text" value="<?php echo $cp_gender;?>" maxlength="1"> 0 Default, 1 Male, 2 Female</td></tr>
<tr><td>Email:</td><td><input name="cp_email" type="text" value="<?php echo $cp_email;?>" maxlength="255"></td></tr>

<tr><td>Age:</td><td><input name="cp_age" type="text" value="<?php echo $cp_age;?>" maxlength="3"></td></tr>
<tr><td>Location:</td><td><input name="cp_location" type="text" value="<?php echo $cp_location;?>" maxlength="255"></td></tr>
<tr><td>Hobbies:</td><td><input name="cp_hobbies" type="text" value="<?php echo $cp_hobbies;?>" maxlength="255"></td></tr>
<tr><td>About Me:</td><td><textarea rows="10" cols="40" name="cp_aboutme"><?php echo $cp_aboutme;?></textarea></td></tr>

<tr><td>Ban:</td><td><input name="cp_status" type="text" value="<?php echo $cp_status;?>" maxlength="1"> 0 No, 1 Yes</td></tr>
<tr><td>VIP:</td><td><input name="cp_vip" type="text" value="<?php echo $cp_vip;?>" maxlength="1"> 0 Free, 1 VIP</td></tr>

<tr><td>Shop Credits:</td><td>

	<?php

	// get users credits
	$tmp=mysql_query("
			SELECT credits 
			FROM ".$CONFIG['mysql_prefix']."shop_accounts 
			WHERE username = '".$cp_username."'
			");

	while($i=mysql_fetch_array($tmp)) 
	{
		echo '<input name="cp_credits" type="text" value="'.$i['credits'].'">';
	}

	?>

</td></tr>

<tr><td>Admin ID:</td><td><input name="cp_adminID" type="text" value="<?php echo $cp_adminID;?>" maxlength="1"> 0 Not Admin, 1 Room Admin, 2 Staff Admin</td></tr>
<tr><td>In Room:</td><td><input name="cp_room" type="text" value="<?php echo $cp_room;?>" maxlength="3"></td></tr>

<?php if(file_exists('../profiles/index.php')){?>

	<input name="cp_photo" type="hidden" value="<?php echo $cp_photo;?>">

	<tr><td>Photo:</td><td><a href="../profiles/uploads/<?php echo $cp_photo;?>" target="_blank"><img src="../profiles/uploads/<?php echo $cp_photo;?>" height="90" width="120" border="0"></a></td></tr>
	<tr><td>&nbsp;</td><td><input type="checkbox" name="cp_delete_image"> Delete Image</td></tr>

<?php }?>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Private Room</b> (<a href="chatTranscripts.php?cp_room=<?php echo $cp_myroomID;?>" target="3">click to view transcripts</a>)</td></tr>

<tr><td>Room ID:</td><td><input name="cp_myroomID" type="text" value="<?php echo $cp_myroomID;?>" maxlength="3"></td></tr>
<tr><td>Room Image:</td><td><input name="cp_myroomIMG" type="text" value="<?php echo $cp_myroomIMG;?>" maxlength="255"></td></tr>
<tr><td>Room Name:</td><td><input name="cp_roomname" type="text" value="<?php echo $cp_roomname;?>" maxlength="24"></td></tr>
<tr><td>Room Access:</td><td><input name="cp_roomaccess" type="text" value="<?php echo $cp_roomaccess;?>" maxlength="24"> 0 All, 1 Friends Only</td></tr>
<tr><td>Max Users:</td><td><input name="cp_roommax" type="text" value="<?php echo $cp_roommax;?>" maxlength="24"> Total Users Allowed In Room</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Avatar Start Posistion</b></td></tr>

<tr><td>Start X:</td><td><input name="cp_startX" type="text" value="<?php echo $cp_startX;?>" maxlength="3">px</td></tr>
<tr><td>Start Y:</td><td><input name="cp_startY" type="text" value="<?php echo $cp_startY;?>" maxlength="3">px</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Music Stream</b></td></tr>

<tr><td>Music Url:</td><td><input name="cp_music" type="text" value="<?php echo $cp_music;?>" maxlength="255"></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Avatar Image</b></td></tr>

<tr><td>Current:</td><td height="200" valign="top">

	<span class="spanMini"><img src="../<?php echo $uavatar[1];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[2];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[3];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[4];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[5];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[6];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[7];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[8];?>"></span>
	<span class="spanMini"><img src="../<?php echo $uavatar[9];?>"></span>
	<span class="spanMini"><img src="../avatars/male/background/trans.png"></span>

	<input name="cp_avatar" type="hidden" value="<?php echo $cp_avatar;?>">

</td></tr>

<tr><td>&nbsp;</td><td><input type="radio" name="cp_reset_avatar_image" value="1"> Reset Male Avatar</td></tr>
<tr><td>&nbsp;</td><td><input type="radio" name="cp_reset_avatar_image" value="2"> Reset Female Avatar</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>User Points</b></td></tr>

<tr><td>Love Points</td><td><input name="cp_lovepoints" type="text" value="<?php echo $cp_lovepoints;?>" maxlength="3"> Max 999</td></tr>
<tr><td>Thumb Points</td><td><input name="cp_thumbpoints" type="text" value="<?php echo $cp_thumbpoints;?>" maxlength="3"> Max 999</td></tr>
<tr><td>Star Points</td><td><input name="cp_starpoints" type="text" value="<?php echo $cp_starpoints;?>" maxlength="3"> Max 999</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Update User"></td></tr>

</form>
</table>

</body>
</html>
