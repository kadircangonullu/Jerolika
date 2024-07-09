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
<form action="chatTranscripts.php" method="post" name="cp_room_form"></td></tr>
<input name="cp_room" type="hidden" value="<?php echo $_GET['cp_room'];?>">

<tr><td colspan="9"><b>Chat Transcripts Management</b></td></tr>

<tr><td colspan="9">&nbsp;</td></tr>
<tr><td colspan="9"><b>Select Room: 

<?php

	$tmp=mysql_query("
	SELECT id     
	FROM ".$CONFIG['mysql_prefix']."rooms  
	ORDER BY id ASC
	") or die(mysql_error()); 

	while($room = mysql_fetch_array($tmp)) {

		echo '<a href="chatTranscripts.php?cp_room='.$room['id'].'">'.$room['id'].'</a> | ';

	}

?>

</b></td></tr>

<tr><td colspan="9">&nbsp;</td></tr>

<?php

$cp_t_results = $CONFIG['chat_results'];

if (!$_GET['cp_r']){

	$cp_r = '0';

}else{

	$cp_r = $_GET['cp_r'];

}

// get the room details

	if(is_numeric($_GET['cp_room'])){

		$tmp=mysql_query("
		SELECT *     
		FROM ".$CONFIG['mysql_prefix']."message 
		WHERE room ='".mysql_real_escape_string(remSpcChars($_GET['cp_room']))."'
		ORDER BY id DESC
		LIMIT $cp_r , $cp_t_results  
		") or die(mysql_error()); 

		$cp_totalRows = mysql_num_rows($tmp);


		if($cp_totalRows){

		?>

			<tr><td><b>ID</b></td><td><b>Date</b></td><td><b>Room</b></td><td><b>Action</b></td><td><b>Ref ID</b></td><td><b>User ID</b></td><td><b>Username</b></td><td><b>To Username</b></td><td><b>Message</b></td></tr>

			<?php

			while($got_data = mysql_fetch_array($tmp)) {

				$cp_id = $got_data['id'];
				$cp_action = $got_data['action'];		
				$cp_refid = $got_data['refid'];
				$cp_userid = $got_data['userid'];
				$cp_username = $got_data['username'];
				$cp_to_username = $got_data['to_username'];
				$cp_room = $got_data['room'];
				$cp_message = $got_data['message'];
				$cp_post_time = $got_data['post_time'];

				if($cp_post_time){

					$cp_post_time = date ("d M Y H:i:s", $cp_post_time);

				}else{

					$cp_post_time = '&nbsp;&nbsp;- - -&nbsp;&nbsp;';

				}

				if($cp_username=='SYSTEM'){

					$cp_username = '(info)';

				}else{

					$cp_username = '<a href="userEdit.php?cp_username='.$cp_username.'" target="3">'.$cp_username.'</a>';

				}

				?>

				<tr><td><?php echo $cp_id;?></td><td><?php echo $cp_post_time;?></td><td align="center"><?php echo $cp_room;?></td><td><?php echo $cp_action;?></td><td align="center"><?php echo $cp_refid;?></td><td align="center"><?php echo $cp_userid;?></td><td><?php echo $cp_username;?></td><td><?php echo $cp_to_username;?></td><td><?php echo $cp_message;?></td></tr>

			<?php 

			}

			?>

			<tr><td colspan="9">&nbsp;</td></tr>

			<?php

			if($_GET['cp_r'] > 0){

				$cp_prev = $_GET['cp_r'] - $cp_t_results;

			}

			if($_GET['cp_r'] <= 10){

				$cp_prev = '0';

			}

			$cp_next = $_GET['cp_r'] + $cp_t_results;

			?>

			<tr><td colspan="9" align="center"><a href="chatTranscripts.php?cp_room=<?php echo $_GET['cp_room'];?>&cp_r=<?php echo $cp_prev;?>"><< Previous</a> | <a href="chatTranscripts.php?cp_room=<?php echo $_GET['cp_room'];?>&cp_r=<?php echo $cp_next;?>">Next >></a></td></tr>

		<?php }else{?>

			<tr><td colspan="9">No results found...</td></tr>

		<?php }?>

	<?php }?>

</table>

</body>
</html>
