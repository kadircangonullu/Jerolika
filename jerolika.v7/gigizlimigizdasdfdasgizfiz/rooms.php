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

// delete room

	$del_error = '';

	if($_POST['cp_rID'] && $_POST['cp_delRoom'] == '1'){

		if($_POST['cp_rID'] >=6){

			// delete room

			$sql = "DELETE FROM ".$CONFIG['mysql_prefix']."rooms WHERE id='".mysql_real_escape_string($_POST['cp_rID'])."'"; mysql_query($sql) or die(mysql_error());
			
			$del_error ="<span style='color: green;'>Success, room has been deleted!</span>";

		}
		else
		{

			// admin is trying to delete default rooms
			// oops, we dont want that to happen!

			$del_error ="<span style='color: red;'>You cannot delete default rooms</span>";
		}
		
	}

// add new room

	$roomCreated = '';

	if($_GET['cp_addRoom']){

		// add new room details

		$sql = "INSERT INTO ".$CONFIG['mysql_prefix']."rooms
			(
				roomname,
				background_url,
				music_url,
				enableMusic,
				uXX,
				uYY,
				offsetuXX,
				offsetuYY,
				doorTop1,
				doorLeft1,
				doorHeight1,
				doorWidth1,
				doorTop2,
				doorLeft2,
				doorHeight2,
				doorWidth2,
				doorTop3,
				doorLeft3,
				doorHeight3,
				doorWidth3,
				doorVisible,
				dOne,
				dTwo,
				dThree
			) 
			VALUES 
			(
				'New Room',
				'templates/coffee/background.jpg',
				'music/index.php',
				'0',
				'297',
				'189',
				'277',
				'169',
				'20',
				'40',
				'150',
				'40',
				'70',
				'755',
				'180',
				'40',
				'1',
				'133',
				'65',
				'40',
				'1',
				'1',
				'5',
				'2'
			)";

		mysql_query($sql) or die(mysql_error());

		// get new room ID

		$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."rooms ORDER BY id DESC LIMIT 1") or die(mysql_error()); 
		while($i = mysql_fetch_array($tmp)) 
		{
			// assign new room ID
			$sql = "UPDATE ".$CONFIG['mysql_prefix']."rooms SET uroom = '".mysql_real_escape_string($i['id'])."' WHERE id = '".mysql_real_escape_string($i['id'])."'";mysql_query($sql) or die(mysql_error());
			
			// load new room for editing
			$_GET['cp_rID']  = $i['id'];

			// show room created
			$roomCreated = "Success, room has been created!";
		}
	}

// update the room details

	if($_POST['cp_rID']){

		$sql = "
		UPDATE ".$CONFIG['mysql_prefix']."rooms 
		SET 
		roomname = '".remSpcChars($_POST['cp_roomname'])."',
		uroom = '".remSpcChars($_POST['cp_uroom'])."',
		background_url = '".remSpcChars($_POST['cp_background_url'])."',
		music_url = '".remSpcChars($_POST['cp_music_url'])."',
		enableMusic = '".remSpcChars($_POST['cp_enableMusic'])."',
		uXX = '".remSpcChars($_POST['cp_uXX'])."',
		uYY = '".remSpcChars($_POST['cp_uYY'])."',
		offsetuXX = '".remSpcChars($_POST['cp_offsetuXX'])."',
		offsetuYY = '".remSpcChars($_POST['cp_offsetuYY'])."',
		doorTop1 = '".remSpcChars($_POST['cp_doorTop1'])."',
		doorLeft1 = '".remSpcChars($_POST['cp_doorLeft1'])."',
		doorHeight1 = '".remSpcChars($_POST['cp_doorHeight1'])."',
		doorWidth1 = '".remSpcChars($_POST['cp_doorWidth1'])."',
		doorTop2 = '".remSpcChars($_POST['cp_doorTop2'])."',
		doorLeft2 = '".remSpcChars($_POST['cp_doorLeft2'])."',
		doorHeight2 = '".remSpcChars($_POST['cp_doorHeight2'])."',
		doorWidth2 = '".remSpcChars($_POST['cp_doorWidth2'])."',
		doorTop3 = '".remSpcChars($_POST['cp_doorTop3'])."',
		doorLeft3 = '".remSpcChars($_POST['cp_doorLeft3'])."',
		doorHeight3 = '".remSpcChars($_POST['cp_doorHeight3'])."',
		doorWidth3 = '".remSpcChars($_POST['cp_doorWidth3'])."',
		doorVisible = '".remSpcChars($_POST['cp_doorVisible'])."',
		dOne = '".remSpcChars($_POST['cp_dOne'])."',
		dTwo = '".remSpcChars($_POST['cp_dTwo'])."',
		dThree = '".remSpcChars($_POST['cp_dThree'])."' 
		WHERE uroom = '".mysql_real_escape_string(remSpcChars($_POST['cp_rID']))."'";
		mysql_query($sql) or die(mysql_error());

		$_GET['cp_rID'] = $_POST['cp_rID'];

		$cp_confirm = '1';

	}

// get the room details

	if($_GET['cp_rID'] >='1'){

		$tmp=mysql_query("
		SELECT *     
		FROM ".$CONFIG['mysql_prefix']."rooms 
		WHERE uroom ='".mysql_real_escape_string(remSpcChars($_GET['cp_rID']))."' 
		LIMIT 1") or die(mysql_error()); 

		while($got_data = mysql_fetch_array($tmp)) {

			$cp_roomname = $got_data['roomname'];
			$cp_uroom = $got_data['uroom'];		
			$cp_background_url = $got_data['background_url'];
			$cp_music_url = $got_data['music_url'];
			$cp_enableMusic = $got_data['enableMusic'];

			$cp_uXX = $got_data['uXX'];
			$cp_uYY = $got_data['uYY'];
			$cp_offsetuXX = $got_data['offsetuXX'];
			$cp_offsetuYY = $got_data['offsetuYY'];

			$cp_doorTop1 = $got_data['doorTop1'];
			$cp_doorLeft1 = $got_data['doorLeft1'];
			$cp_doorHeight1 = $got_data['doorHeight1'];
			$cp_doorWidth1 = $got_data['doorWidth1'];

			$cp_doorTop2 = $got_data['doorTop2'];
			$cp_doorLeft2 = $got_data['doorLeft2'];
			$cp_doorHeight2 = $got_data['doorHeight2'];
			$cp_doorWidth2 = $got_data['doorWidth2'];

			$cp_doorTop3 = $got_data['doorTop3'];
			$cp_doorLeft3 = $got_data['doorLeft3'];
			$cp_doorHeight3 = $got_data['doorHeight3'];
			$cp_doorWidth3 = $got_data['doorWidth3'];

			$cp_doorVisible = $got_data['doorVisible'];

			$cp_dOne = $got_data['dOne'];
			$cp_dTwo = $got_data['dTwo'];
			$cp_dThree = $got_data['dThree'];

		}

	}

?>

<html> 
<head>
<title>Avatar Chat - Admin Area</title>
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.body {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
}
.table {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
}
a:link {text-decoration: none; color: #CCCCCC;}
a:visited {text-decoration: none; color: #CCCCCC;}
a:active {text-decoration: none; color: #CCCCCC;}
a:hover {text-decoration: underline; color: #CCCCCC;}
</style>

</head>
<body class="body">

<table class="table">
<form action="rooms.php" method="post" name="cp_room_form"></td></tr>
<input name="cp_rID" type="hidden" value="<?php echo $_GET['cp_rID'];?>">

<?php if($_SESSION['cp_admin_login'] != md5(md5($CONFIG['admin_pass']))){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><font color=red><b>Sorry, Access Denied</b></font><br><br>This section is for Administrators only.</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	</table>

<?php return; }?>

<tr><td colspan="2"><b>Default Room Management</b> - <b><a href="rooms.php?cp_addRoom=1">[Create Room]</a></b></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>

<tr><td colspan="2"><b>Select Room:

<?php

	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."rooms") or die(mysql_error()); 
	while($i = mysql_fetch_array($tmp)) 
	{
		echo '<a href="rooms.php?cp_rID='.$i['id'].'">'.$i['id'].'</a> | ';
	}

?>

<?php if($cp_confirm && !$del_error){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2" style="color:green;"><b>Success, Room Details Updated...</b></td></tr>

<?php }?>

<?php if($roomCreated){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2" style="color:green;"><b><?php echo $roomCreated;?></b></td></tr>

<?php }?>

<?php if($del_error){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><b><?php echo $del_error;?></b></td></tr>

<?php }?>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Room Options</b></td></tr>

<tr><td>Room Name:</td><td><input name="cp_roomname" type="text" value="<?php echo $cp_roomname;?>" maxlength="24"></td></tr></td></tr>
<tr><td>Room ID:</td><td><input name="cp_uroom" type="text" value="<?php echo $cp_uroom;?>" maxlength="3"></td></tr>
<tr><td>Background Url:</td><td><input name="cp_background_url" type="text" value="<?php echo $cp_background_url;?>" maxlength="255"></td></tr>
<tr><td>Music Url:</td><td><input name="cp_music_url" type="text" value="<?php echo $cp_music_url;?>" maxlength="255"></td></tr>
<tr><td>Enable Music:</td><td><input name="cp_enableMusic" type="text" value="<?php echo $cp_enableMusic;?>" maxlength="1"> 1 On, 0 Off</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Avatar Start Position</b></td></tr>

<tr><td>Start X Pos</td><td><input name="cp_uXX" type="text" value="<?php echo $cp_uXX;?>" maxlength="3">px</td></tr>
<tr><td>Start Y Pos</td><td><input name="cp_uYY" type="text" value="<?php echo $cp_uYY;?>" maxlength="3">px</td></tr>
<tr><td>Speech X Offset</td><td><input name="cp_offsetuXX" type="text" value="<?php echo $cp_offsetuXX;?>" maxlength="3">px</td></tr>
<tr><td>Speech Y Offset</td><td><input name="cp_offsetuYY" type="text" value="<?php echo $cp_offsetuYY;?>" maxlength="3">px</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Door Positions</b></td></tr>

<tr><td>Door 1 - Top</td><td><input name="cp_doorTop1" type="text" value="<?php echo $cp_doorTop1;?>" maxlength="3">px</td></tr>
<tr><td>Door 1 - Left</td><td><input name="cp_doorLeft1" type="text" value="<?php echo $cp_doorLeft1;?>" maxlength="3">px</td></tr>
<tr><td>Door 1 - Height</td><td><input name="cp_doorHeight1" type="text" value="<?php echo $cp_doorHeight1;?>" maxlength="3">px</td></tr>
<tr><td>Door 1 - Width</td><td><input name="cp_doorWidth1" type="text" value="<?php echo $cp_doorWidth1;?>" maxlength="3">px</td></tr>
<tr><td>Door 2 - Top</td><td><input name="cp_doorTop2" type="text" value="<?php echo $cp_doorTop2;?>" maxlength="3">px</td></tr>
<tr><td>Door 2 - Left</td><td><input name="cp_doorLeft2" type="text" value="<?php echo $cp_doorLeft2;?>" maxlength="3">px</td></tr>
<tr><td>Door 2 - Height</td><td><input name="cp_doorHeight2" type="text" value="<?php echo $cp_doorHeight2;?>" maxlength="3">px</td></tr>
<tr><td>Door 2 - Width</td><td><input name="cp_doorWidth2" type="text" value="<?php echo $cp_doorWidth2;?>" maxlength="3">px</td></tr>
<tr><td>Door 3 - Top</td><td><input name="cp_doorTop3" type="text" value="<?php echo $cp_doorTop3;?>" maxlength="3">px</td></tr>
<tr><td>Door 3 - Left</td><td><input name="cp_doorLeft3" type="text" value="<?php echo $cp_doorLeft3;?>" maxlength="3">px</td></tr>
<tr><td>Door 3 - Height</td><td><input name="cp_doorHeight3" type="text" value="<?php echo $cp_doorHeight3;?>" maxlength="3">px</td></tr>
<tr><td>Door 3 - Width</td><td><input name="cp_doorWidth3" type="text" value="<?php echo $cp_doorWidth3;?>" maxlength="3">px</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Visible Doorways</b> (for testing purposes only)</td></tr>

<tr><td>Enable Door Frames</td><td><input name="cp_doorVisible" type="text" value="<?php echo $cp_doorVisible;?>" maxlength="1"> 1 On, 0 Off</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>Doors Exit To Which Room Number?*</b></td></tr>

<tr><td>Door 1</td><td><input name="cp_dOne" type="text" value="<?php echo $cp_dOne;?>" maxlength="3"></td></tr>
<tr><td>Door 2</td><td><input name="cp_dTwo" type="text" value="<?php echo $cp_dTwo;?>" maxlength="3"></td></tr>
<tr><td>Door 3</td><td><input name="cp_dThree" type="text" value="<?php echo $cp_dThree;?>" maxlength="3"></td></tr>
<tr><td colspan="2">*Use only - (minus sign) to exit user to their private room.</td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td><b>Delete Room?</b></td><td><input type="checkbox" name="cp_delRoom" value="1"> (tick)</td></tr>
<tr><td colspan="2">&nbsp;</td></tr>
<tr><td>&nbsp;</td><td><input name="submit" type="submit" value="Update Room"></td></tr>

</form>
</table>

</body>
</html>
