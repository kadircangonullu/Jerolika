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

?>

	<html> 
	<head>
	<title></title>
	<!-- <meta http-equiv="X-UA-Compatible" content="IE=7"/> -->
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="templates/style.css">

	<!--[if IE 6]>
	<style type="text/css">
	/* some css fixes for IE browsers */
	html {overflow-y:hidden;}
	body {overflow-y:auto;}
	#bg {position:absolute; z-index:-1;}
	#content {position:static;}
	</style>
	<![endif]-->

	<!--[if IE 7]>
	<link type="text/css" rel="stylesheet" href="templates/style_ie7.css">
	<![endif]-->

	<!--[if IE 8]>
	<link type="text/css" rel="stylesheet" href="templates/style_ie8.css">
	<![endif]-->

	<script language="javascript" type="text/javascript">
	<!--
	if(window.location == top.location)
	{
		window.location.href="index.html";
	}
	// -->
	</script>

	<script language="javascript" type="text/javascript">
	<!--

	var mTimer;
	var uTimer;
	var fTimer;

	//system settings
	var refreshUsers = 10000; // 10 secs 
	var refreshMessages = 3000; // 3 secs 
	var refreshMails = 30000; // 30 secs 
	var showUserChat = 5000; // 5 secs

	//user details
	var chatName = '<?php echo $_SESSION['username'];?>';
	var chatID = '<?php echo $uid;?>';
	var chatRef = <?php echo $uref;?>;
	var chatProfileID = '<?php echo $CONFIG['profile_id'];?>';
	var chatProfileUrl = '<?php echo $CONFIG['profile_url'];?>';
	var chatAdmin = '<?php echo $sAdmin;?>';
	var chatMemberLevel = <?php echo $chatMemberLevel;?>;
	var room = <?php echo $uroom;?>;
	var messageID = <?php echo $lastMessID;?>;
	var enableDoppleMe = 0;
	var remoteBg = <?php echo $CONFIG['remoteBackgrounds'];?>;
	var remoteAudio = <?php echo $CONFIG['remoteMusic'];?>;

	//init object
	var x = <?php echo $uXX;?>; //Start Pos - left
	var y = <?php echo $uYY;?>; //Start Pos - top
	var xx = <?php echo $offsetuXX;?>; //Start Pos - left
	var yy = <?php echo $offsetuYY;?>; //Start Pos - top
	var dest_x = <?php echo $uXX;?>;  //End Pos - left
	var dest_y = <?php echo $uYY;?>;  //End Pos - top
	var denyMove = 0;
	var moveAvatar = 1;
	var hideSplash = <?php echo $showSplashPage;?>;

	//init doors
	var doorTop1 = <?php echo $doorTop1;?>;
	var doorLeft1 = <?php echo $doorLeft1;?>;
	var doorHeight1 = <?php echo $doorHeight1;?>;
	var doorWidth1 = <?php echo $doorWidth1;?>;

	var doorTop2 = <?php echo $doorTop2;?>;
	var doorLeft2 = <?php echo $doorLeft2;?>;
	var doorHeight2 = <?php echo $doorHeight2;?>;
	var doorWidth2 = <?php echo $doorWidth2;?>;

	var doorTop3 = <?php echo $doorTop3;?>;
	var doorLeft3 = <?php echo $doorLeft3;?>;
	var doorHeight3 = <?php echo $doorHeight3;?>;
	var doorWidth3 = <?php echo $doorWidth3;?>;

	//init options
	var kickRoom = '<?php echo $CONFIG['kickRoom'];?>';
	var doorVisible = <?php echo $doorVisible;?>;
	var roomFull = '<?php echo $_SESSION['roomFull'];?>';
	var roomFriends = '<?php echo $_SESSION['roomFriends'];?>';

	var _fontLogout = '#990000';
	var _fontLogin = '#006633';
	var _fontSelf = '#003366';
	var _fontIAction = '#663366';

	var _maxMessages = 35;
	var _url = '<?php echo $CONFIG['chatroom_url'];?>';
	var _ver = '<?php echo $CONFIG['version'];?>';

	//-->
	</script>

	<script type="text/javascript" src="js/preload.js"></script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.8.3/jquery.min.js"></script> 
<script src='http://www.weebly.com/uploads/1/5/7/6/15762290/karyagdirma-toplist24.js' type='text/javascript'></script>
	<script type="text/javascript" src="js/XmlHttpRequest.js"></script>
	<script type="text/javascript" src="js/windowsize.js"></script>
	<script type="text/javascript" src="js/movement.js"></script>
	<script type="text/javascript" src="js/smilies.js"></script>
	<script type="text/javascript" src="js/badwords.js"></script>
	<script type="text/javascript" src="js/sendData.js"></script>
	<script type="text/javascript" src="js/userlist.js"></script>
	<script type="text/javascript" src="js/getdata.js"></script>
	<script type="text/javascript" src="js/display.js"></script>
	<script type="text/javascript" src="js/blockuser.js"></script>
	<script type="text/javascript" src="js/userpoints.js"></script>
	<script type="text/javascript" src="js/usermail.js"></script>
	<script type="text/javascript" src="js/userfriends.js"></script>
	<script type="text/javascript" src="js/ban.js"></script>
	<script type="text/javascript" src="js/interactions.js"></script>
	<script type="text/javascript" src="js/changeBG.js"></script>
	<script type="text/javascript" src="js/changeAVI.js"></script>
	<script type="text/javascript" src="js/changeAUDIO.js"></script>
	<script type="text/javascript" src="js/changeROOM.js"></script>

	</head>

	<body id="body" class="body" onkeydown="getMoveKeyPress(event);" onkeyup="sendMoveKeyPress(event);" onLoad="doWindowSize();getUsersOnline();updateUserPoints();getMessages();hideSpeech();getMail();moveImage('_a_');showWelcome();createChatTabs('chatbox','');activeChatWindow();hidetextOptions();_door1(doorTop1,doorLeft1,doorHeight1,doorWidth1,doorVisible);_door2(doorTop2,doorLeft2,doorHeight2,doorWidth2,doorVisible);_door3(doorTop3,doorLeft3,doorHeight3,doorWidth3,doorVisible);checkRoomStatus();doInteractions();" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

	<div id="bg" style="background-image: url('<?php echo $background_url;?>');">

		<div id="chatscreen" class="chatscreen" style="background-image: url('<?php echo $background_url;?>');">
			<div id="l_myMessage" class="myMessage"></div>
			<div id="_a_myMessage" class="myMessage"></div>
			<div id="r_myMessage" class="myMessage"></div>
			<div style="left:<?php echo $uXX;?>px;top:<?php echo $uYY;?>px;width:70px;cursor:pointer;" id="_a_myAvatar" class="myAvatar" onClick="newUrl('<?php echo $CONFIG['profile_url'].$_SESSION['username'];?>','myprofile')">

				<b><?php echo $showUsername;?></b>
				<br>

					<span class="span"><img id="base" src="<?php echo $uavatar[1];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="bottoms" src="<?php echo $uavatar[2];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="eyes" src="<?php echo $uavatar[3];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="hair" src="<?php echo $uavatar[4];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="beard" src="<?php echo $uavatar[5];?>" border="0" height="30" width="30"></span>
					<span class="span"><img id="mouth" src="<?php echo $uavatar[6];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="shoes" src="<?php echo $uavatar[7];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="tops" src="<?php echo $uavatar[8];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="accessories" src="<?php echo $uavatar[9];?>" border="0" height="75" width="53"></span>
					<span class="span"><img id="trans" src="avatars/male/background/trans.png" border="0" height="75" width="53"></span>

			</div>
		</div>

		<div id="controlpanel" class="controlPanel">
			<form name="sendMessage" onSubmit="return blockSubmit();">
			<input class="messageBar" id="message" type="text" name="message" autocomplete="off" onKeyPress="return submitenter(this,event);" maxlength="100">
			<input class="sendButton" type="image" name="submit" src="images/go.png" width="24" height="24">
			</form>
		</div>

		<div id="sendmail" class="sendmail">
			<form name="sendeMail">	
			Kisi Adi: 
			  <input id="send_to" class="send_to" type="text" name="send_to" value=""><br>
			<textarea id="send_mail_mess" class="send_mail_mess" name="send_mail_mess" cols="20" rows="4" value=""  maxlength="250"></textarea><br>
			<input name="submit" type="button" class="mysendButton" onClick="sendUserMail()" value="Gonder">	
			</form>	
		</div>

		<div id="myrooms" class="myrooms">
			<img name="map" src="images/map.jpg" width="646" height="330" border="0" id="map" usemap="#m_map" alt="" />
			<map name="m_map" id="m_map">


			<div align="right"><a href="javascript:grayOut(false);toggleBox('myrooms');">KAPAT</a> <a href="javascript:logOut()"></a> &#187;</div>
		</div>

		<div id="chatboxButton" class="chatboxButton"></div>

		<div title="Harita" alt="View Map" id="mapButton" class="mapButton" onClick="grayOut(true);showRooms();"><img src="images/pm04.png" style="padding-top:7px;" width="30" height="33"></div>

		<div title="Cikis" alt="Logout" id="logoutButton" class="logoutButton" onClick="logOut();"><img src="images/logout.png" style="padding-top:7px;" width="23" height="30"></div>

		<div title="Market" alt="Shop" id="shopButton" class="shopButton" onClick="shop();"><img src="images/shop.png" style="padding-top:7px;" width="26" height="24"></div>

		<div title="Gorevler" alt="Play Games" id="playgamesButton" class="playgamesButton" onClick="grayOut(true);showGames();"><img src="images/games.png" style="padding-top:7px;" width="34" height="54"></div>

		<div title="Mesaj Kutum" alt="My Inbox" id="mailButton" class="mailButton" onClick="<?php if(!$chatMemberLevel){echo "grayOut(true);showVIP();";}else{echo "toggleBox('myinbox');toggleStyle(this,'email','mailButton');readOldMail();getMail();";}?>">0</div>

		<div title="Telefon" alt="Send Message" id="sendmailButton" class="sendmailButton" onClick="<?php if(!$chatMemberLevel){echo "grayOut(true);showVIP();";}else{echo "toggleBox('sendmail');toggleStyle(this,'sendmail','sendmailButton');";}?>"></div>

		<div title="LIKA" alt="Credit Points" id="creditsButton" class="creditsButton"></div>

		<div title="Saglik Puani" alt="Love Points" id="loveButton" class="loveButton"></div>

		<div title="My Like Points" alt="Like Points" id="likeButton" class="likeButton"></div>

		<div title="Yildiz Puani" alt="Star Points" id="giftButton" class="giftButton"></div>

		<div title="Karakterimi Duzenle" alt="Edit My Avatar" id="avatarButton" class="avatarButton" onClick="grayOut(true);showAvatarCreator();">

			<span class="spanMini"><img id="base" src="<?php echo $uavatar[1];?>" border="0" height="0" width="0"></span>
			<span class="spanMini"><img id="bottoms" src="<?php echo $uavatar[2];?>" border="0" height="0" width="0"></span>
			<span class="spanMini"><img id="eyes" src="<?php echo $uavatar[3];?>" border="0" height="75" width="53"></span>
			<span class="spanMini"><img id="hair" src="<?php echo $uavatar[4];?>" border="0" height="75" width="53"></span>
			<span class="spanMini"><img id="beard" src="<?php echo $uavatar[5];?>" border="0" height="10" width="0"></span>
			<span class="spanMini"><img id="mouth" src="<?php echo $uavatar[6];?>" border="0" height="75" width="53"></span>
			<span class="spanMini"><img id="shoes" src="<?php echo $uavatar[7];?>" border="0" height="0" width="0"></span>
			<span class="spanMini"><img id="tops" src="<?php echo $uavatar[8];?>" border="0" height="0" width="0"></span>
			<span class="spanMini"><img id="accessories" src="<?php echo $uavatar[9];?>" border="0" height="0" width="0"></span>
			<span class="spanMini"><img id="trans" src="avatars/male/background/trans.png" border="0" height="0" width="0"></span>
	
		</div>

		<div title="Engelledigim Kisiler" alt="Blocked Users" id="blockButton" class="blockButton" onClick="getBlockedUsers();toggleBox('blocklist');toggleStyle(this,'block','blockButton');"></div>

		<div title="Arkadaslar" alt="My Friends" id="friendsButton" class="friendsButton" onClick="showFriends();toggleBox('myfriends');toggleStyle(this,'group','friendsButton');"></div>

		<?php if($isVIP == '0' && $CONFIG['membersrooms_guests'] || $isVIP == '1' || $sAdmin == '1'){?>
			<div title="Visit Users" alt="Visit Users" id="towerButton" class="towerButton" onClick="grayOut(true);showTower();"></div>
		<?php }?>

		<?php if($uroom < '0' || $enableMusic){?>
			<div title="Turn Music On/Off" alt="Turn Music On/Off" id="speakerButton" class="speakerButton" onClick="playStream('<?php echo $music_url;?>');toggleStyle(this,'speaker','speakerButton');"></div>
		<?php }?>

		<?php if($uroom == '-'.$uref){?>
			<div title="My Room Settings" alt="My Room Settings" id="myplaceButton" class="myplaceButton" onClick="<?php if(!$chatMemberLevel){echo "grayOut(true);showVIP();";}else{echo "toggleBox('myplace');toggleStyle(this,'myplace','myplaceButton');";}?>"></div>
			<div id="startPosistion" class="startPosistion"></div>
		<?php }?>

		<div id="chatoptions" class="chatoptions"></div>

		<div id="chattab" class="chattab"></div>

		<div id="chatbox" class="chatbox"></div>

		<div id="blocklist" class="blocklist"></div>

		<div id="userdetails" class="userdetails" onblur="hideUserDetails()"></div>

		<div id="myinbox" class="myinbox"></div>

		<div id="myfriends" class="myfriends"></div>

		<div id="myplace" class="myplace">

			<div style="padding:2px;">
				<img src="images/myplace.png"> <b>Oda Adi</b><br>
				<input id="newRoomName" class="newRoomName" type="text" name="newRoomName" value="<?php echo $roomname;?>" size="18" maxlength="">
				<input type="button" name="update_RN" value="Update" onClick="updateURoomName();">
				<span id="cRoomName"></span>
				<br>
			</div>
			<div style="padding:2px;">
				<img src="images/group.png"> <b>Eriþim</b><br>
				<select id="roomAccess">
				<option value="0" <?php if($room_access=='0'){?>SELECTED<?php }?>/>Allow Everyone
				<option value="1" <?php if($room_access=='1'){?>SELECTED<?php }?>/>Friends Only
				</select>
				<input type="button" name="update_roomAccess" value="Update" onClick="updateURoomAccess();">
				<span id="cRoomAccess"></span>
				<br>
			</div>
			<div style="padding:2px;"></div>
			<div style="padding:2px;"></div>
			<div style="padding:2px;">
				<img src="images/start.png"> <b>Karakterin Baþladýðý Yer</b><br>
				<b>X:</b><input id="newStartX" class="newStartXY" type="text" name="startX" value="<?php echo $uXX;?>" size="3" maxlength="3">
				<b>Y:</b><input id="newStartY" class="newStartXY" type="text" name="startY" value="<?php echo $uYY;?>" size="3" maxlength="3">
				<input type="button" name="show_XY" value="Test" onClick="toggleBox('startPosistion');cursorPos();">
				<input type="button" name="update_newstartXY" value="Update" onClick="updateUserSP();">	
				<span id="cAvatarStart"></span>
			</div>
			<div style="padding-top:10px;">
				<img src="images/upgradeRoom.png" align="absmiddle"> <b>Maksimum Misafir: <?php echo $max_room_users;?></b> [<a href="?do=upgrade" target="_blank">Yükselt</a>]	
			</div>
		</div>

		<div id="splashpage" class="splashpage"  style="cursor:pointer;" onClick="hideWelcome();"></div>

		<div id="sysmess" class="sysmess" onClick="hideSysMess();"></div>

		<div id="doorone" class="door" onClick="loadRoom('<?php echo $dOne;?>');" onMouseOver="toggleStyle(this,'changeroom','doorone');" onMouseOut="toggleStyle(this,'changeroom','doorone');" ></div>
		<div id="doortwo" class="door"  onClick="loadRoom('<?php echo $dTwo;?>');" onMouseOver="toggleStyle(this,'changeroom','doortwo');" onMouseOut="toggleStyle(this,'changeroom','doortwo');"></div>
		<div id="doorthree" class="door" onClick="loadRoom('<?php echo $dThree;?>');" onMouseOver="toggleStyle(this,'changeroom','doorthree');" onMouseOut="toggleStyle(this,'changeroom','doorthree');"></div>

		<div id="upgradeVIP" class="upgradeVIP">

			<div align="center"><img src="images/upgradetovip.png"><br><br></div>

			<div style="padding-left:50px;">
				<b>Eger VIP olursan bircok ozellik senle olacaktir!</b>
			</div>

			<div align="center">.- [<a href="?do=vip" target="_blank">Hadi AL!</a>]<br><br><br>
			  (<a href="javascript:hideVIP();">Kapat</a>)</div>
		</div>

		<div id="gotoUsers" class="gotoUsers">

			<div align="center"><img src="images/private_rooms.png"><br><br></div>

			<div style="padding-left:45px;"><br><br>
				Adi:
				  <input id="goUser" class="goUser" type="text" name="goUser" value="" size="20" maxlength="16">
				<input type="button" name="update_goUser" value="Git" onClick="getUserRoomID();">
				<br><br>
			</div>

			<div align="center"><br>
			(<a href="javascript:hideTower();">Kapat</a>)</div>
		</div>

		<div id="avatarCreator" class="avatarCreator">

			<iframe id="myframe" src="avatars/index.php" style="height:500px;width:700px;scroll:none;background-color:transparent;border-style:none;">
				<p>Your browser does not support iframes.</p>
			</iframe>
		</div>

		<div id="playGames" class="playGames">

			<div align="center">Henuz bir gorev yok!</div>

			<div align="center">
				<table align="center">
				<tr>

				<?php

				// define loop
				$cols = 5; // set columns 
				$l = 1; // sets loop for columns 

				// get games data
				$tmp=mysql_query("SELECT * FROM ".$CONFIG['mysql_prefix']."games");
				while($i=mysql_fetch_array($tmp)) 
				{

					$new_Width = $i['game_Width'] + 18;
					$new_Height = $i['game_Height'] + 18;
		
					?>

					<td width="70">

						
						</a>
					</td>

					<?php 

					// create loop
					if($l == $cols)
					{
						echo "</tr></tr>";
					}

					// update count
					$l+=1;

				} ?>

				</tr>
				</table>
				<br>
				(<a href="javascript:hideGames()">Kapat</a>)
			</div>
			</div>
		</div>

	</div>

	<form name="doInteraction">
	<div id="avatarInteraction" class="avatarInteraction"></div>
	</form>

	<?php if($_SESSION['chat_moderator']){?>
		<div title="Admin Controls" alt=Admin Controls" id="modButton" class="modButton" onClick="modUsers();toggleBox('modpanel');toggleStyle(this,'lock','modButton');"></div>
		<div id="modpanel" class="modpanel"></div>
	<?php }?>

	<iframe id="AUDIOUrl" src="<?php echo $music_url;?>" height="100" width="100" style="padding-top:600px;"></iframe>

	<!--  
		DO NOT REMOVE THIS COPYRIGHT NOTICE UNLESS PERMISSION HAS BEEN GRANTED
		(C)2009/2011 - Avatar Chat
	// -->

	</body>
	</html>