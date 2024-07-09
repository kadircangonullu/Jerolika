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

if ($_POST && $_POST['i']=='3'){

	$sFile = "../../includes/conn.php";
	$fh = @fopen($sFile, 'w') or die("CHMOD the file 'db.php' to 777 during installation.");

	$str="<?php \n";
	$str.="$";
	$str.="CONFIG['mysql_host'] ='".$_POST['C_HOST']."'; \n";
	$str.="$";
	$str.="CONFIG['mysql_user'] ='".$_POST['C_USER']."'; \n";
	$str.="$";
	$str.="CONFIG['mysql_pass'] ='".$_POST['C_PASS']."'; \n";
	$str.="$";
	$str.="CONFIG['mysql_db'] ='".$_POST['C_DATA']."'; \n";
	$str.="$";
	$str.="CONFIG['mysql_prefix'] = 'avatarchat_'; \n";
	$str.=" ?>";

	fwrite($fh, $str);
	fclose($fh);

	$mysql_check = '0';
	$mysql_check_failed = '0';

	$mysql_check = @mysql_connect($_POST['C_HOST'], $_POST['C_USER'], $_POST['C_PASS']); 

	if(!$mysql_check){

		$mysql_check_failed = '1';

	}

}

if ($_POST && $_POST['i']=='4'){

	include("../../includes/db.php");
}

include("../../includes/config.php");

?>

<html> 
<head>
<title>Avatar Chat - Version <?php echo $CONFIG['version'];?> - Installation - Powered By Pro Chat Rooms</title>
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.body {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
background-image: url('../../images/logo.jpg');
background-repeat: repeat;
}
.table {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #333333;
border-style:dashed;
border-width:1px;
}
a:link {text-decoration: none; color: #CCCCCC;}
a:visited {text-decoration: none; color: #CCCCCC;}
a:active {text-decoration: none; color: #CCCCCC;}
a:hover {text-decoration: underline; color: #CCCCCC;}
</style>

</head>
<body class="body">

<table align="center" width="100%" border="0" class="table">
<tr><td align=center>
<b>Avatar Chat - Version <?php echo $CONFIG['version'];?> - Installation</b>
</td></tr></table>

<!-- install - step 1 -->

<?php if (!$_POST){?>

	<script language="JavaScript">
	<!--
	function formCheck(form) {
	if (!(install_licence.licence.checked)) {alert( "Please agree to the software licence. ");return false ;}
	}
	// -->
	</script>

	<br>

	<table width="100%" align="center">
	<tr>
	<td align=center>
		<table cellpadding="10" width="420" border=0 class="table">
		<tr>
		<td align=center width="60">
			<img src="images/help.png" align="absmiddle">
		</td>
		<td align="center">
			<form OnSubmit="return formCheck(this)" action="index.php" method="post" name="install_licence">
				<br>
				<br>
				<b>Welcome to the Avatar Chat installation.</b>
				<br>
				<br>
				<input type="checkbox" name="licence" onClick="document.install_licence['submit'].disabled =(document.install_licence['submit'].disabled)? false : true">
				I have read and agree to the <a href="/" target="_blank">software licence</a>.
				<br>
				<br>
				<input type="hidden" name="i" value="1">
				<input type="submit" id="submit" name="submitthis" value="Proceed >>>" class="user_buttons_large" disabled>
			</form>
			<br>
			<br>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

<?php }?>

<!-- install - step 2 -->

<?php if ($_POST && $_POST['i']=='1'){

	$chmod_test_failed = 0;
	$chmod_test = @chmod('../../includes/db.php', 0775);

	if (!$chmod_test) {
 		$chmod_test_failed = '1';
	}

	$fwrite_test_failed = '0';
	$fwrite_test = @fopen ('../../includes/db.php', 'r');

	if (!$fwrite_test) {
 		$fwrite_test_failed = '1';
	}

	fclose($fwrite_test);

?>

	<br>

	<table width="100%" align="center">
	<tr>
	<td align=center>
		<table cellpadding="10" width="420" border=0 class="table">
		<tr>
		<td align=center width="60">
			<img src="images/help.png" align="absmiddle">
		</td>
		<td align="center">
			<br>
			<br>
			<b>Pre-Check Installation Results</b>
			<br>
			<br>
			<div align="left">

				CHMOD Permissions - <?php if($chmod_test_failed){echo "<font color=red>FAILED</font>";}else{echo "<font color=green>PASS</font>";}?><br>

				<?php if($chmod_test_failed){?>
					<br>You will need to CHMOD the following folders to 755, 775 or 777 (depending on your servers settings).<br>
					<br>&#187; <i>avatarchat/includes/conn.php</i>
					<br>&#187; <i>avatarchat/profiles/uploads</i>
				<?php }?>


				<?php if($chmod_test_failed || $fwrite_test_failed){?><br><br><?php }?>

				FWRITE Permissions - <?php if($fwrite_test_failed){echo "<font color=red>FAILED</font>";}else{echo "<font color=green>PASS</font>";}?><br>

				<?php if($fwrite_test_failed){?>
					<br>Proceed to the next step and enter your MySQL details. You will then be instructed to copy and paste your MYSQL information into the file 'includes/conn.php' file.
				<?php }?>
			</div>
			<br>
			<br>
			<form action="index.php" method="post" name="cont_2">
				<input type="hidden" name="i" value="2">
				<input type="submit" name="submit" value="Proceed >>>" class="user_buttons_large">
			</form>
			<br>
			<br>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>
<?php }?>

<!-- install - step 2 -->

<?php if ($_POST && $_POST['i']=='2'){?>

	<script language="JavaScript">
	<!--
	function formCheck(form) {
		if (install.C_HOST.value == "") {alert( "Please enter your MySQL host name. ");return false ;}
		if (install.C_USER.value == "") {alert( "Please enter your MySQL user name. ");return false ;}
		// if (install.C_PASS.value == "") {alert( "Please enter your MySQL password. ");return false ;}
		if (install.C_DATA.value == "") {alert( "Please enter your MySQL database name. ");return false ;}
		if (install.C_PATH.value == "") {alert( "Please enter your document path. ");return false ;}
	}
	// -->
	</script>

	<br>

	<table width="100%" align="center">
	<tr>
	<td align=center>
		<table cellpadding="10" width="400" border=0 class="table">
		<tr>
		<td align=center width="60">
			<img src="images/help.png" align="absmiddle">
		</td>
		<td align="center">
			<br>
			<br>
			<b>MySQL Database Information</b>
			<br>
			<br>
			<form OnSubmit="return formCheck(this)" action="index.php" method="post" name="install">
				<table width="100%" align="center" style="font-family: Arial, Verdana;font-size: 12px;font-style: normal;">
				<tr><td>MySQL Host Name</td><td><input type="text" name="C_HOST" value=""></td></tr>
				<tr><td>MySQL Username</td><td><input type="text" name="C_USER" value=""></td></tr>
				<tr><td>MySQL Password</td><td><input type="text" name="C_PASS" value=""></td></tr>
				<tr><td>MySQL Database</td><td><input type="text" name="C_DATA" value=""></td></tr>
				</table>
				<br>
				<br>
				<input type="hidden" name="i" value="3">
				<input type="submit" name="submit" value="Confirm Details" class="user_buttons_large">
			</form>
			<br>
			<br>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

<?php }?>

<!-- install - step 3 -->

<?php if ($_POST && $_POST['i']=='3'){?>

	<br>

	<table width="100%" align="center">
	<tr>
	<td align=center>
		<table cellpadding="10" width="400" border=0 class="table">
		<tr>
		<td align=center width="60">
			<img src="images/help.png" align="absmiddle">
		</td>
		<td align="center">
			<br>
			<br>
			<b>MySQL Information Saved</b>
			<br>
			<br>
			<?php 

				if($mysql_check_failed){

					echo "Click the 'Highlight Code' button then right click and select copy. Paste the code into the file 'includes/conn.php'.";

				}else{

					echo "The file 'includes/conn.php' has been created.<br><br>Click on the button below to install the MySQL tables and complete the installation.";

				};

			?>

			<?php if($mysql_check_failed){?>

				<br><br>
				<form name="copy">
					<textarea name="text_area" rows="10" cols=95" style="background-color: #F5F5F5;"><?php echo $str;?></textarea>
					<div align="left">
						<input class="user_buttons_large" type="button" value="Highlight Code" onClick="javascript:this.form.text_area.focus();this.form.text_area.select();">
					</div>
				</form>
				<br><br>
				After you have saved the file, click on the button below to install the MySQL tables and complete the installation.

			<?php }?>

			<br>
			<br>
			<form action="index.php" method="post" name="cont_4">
				<input type="hidden" name="i" value="4">
				<input type="submit" name="submit" value="Continue" class="user_buttons_large">
			</form>
			<br>
			<br>
		</td>
		</tr>
		</table>
	</td>
	</tr>
	</table>

<?php }?>

<!-- install - step 4 -->

<?php if ($_POST && $_POST['i']=='4'){?>

	<br>

	<table width="100%" align="center">
	<tr>
	<td align=center>
		<table cellpadding="10" width="500" border=0 class="table">
		<tr>
		<td align=center width="60">
			<img src="images/help.png" align="absmiddle">
		</td>
	<td align="center">
		<table width=500 border=0 border=0 style="font-family: Arial, Verdana;font-size: 12px;font-style: normal;">
		<tr><td><b>Congratulations, you have completed the Avatar Chat installation.<br><br>Below is your MySQL Table Installation Report.</b><br><br></td></tr>
		<tr><td><b>Install Results</b></td></tr>
		<tr><td>

			<?php

				$sql = "DROP TABLE IF EXISTS `avatarchat_blocked`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_friends`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_games`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_mail`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_message`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_profileviews`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_referrals`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_rooms`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_shop`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_shop_accounts`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_shop_payments`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_user`";mysql_query($sql);
				$sql = "DROP TABLE IF EXISTS `avatarchat_votes`";mysql_query($sql);

			?>
			
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_blocked` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`userid` varchar(64) NOT NULL DEFAULT '0',
  						`username` varchar(250) NOT NULL,
  						`blockid` varchar(64) NOT NULL DEFAULT '',
  						`blockname` varchar(250) NOT NULL,
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_blocked - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_blocked - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_friends` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`userid` varchar(64) NOT NULL DEFAULT '0',
  						`username` varchar(250) NOT NULL,
  						`friendid` varchar(64) NOT NULL,
  						`friendname` varchar(250) NOT NULL,
  						`room` varchar(64) NOT NULL,
  						`roomname` varchar(32) NOT NULL,
  						`online` varchar(3) NOT NULL DEFAULT '1',
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

				if(mysql_query($sql)) echo "&#187; avatarchat_friends - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_friends - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_games` (
  						`game_ID` bigint(20) NOT NULL AUTO_INCREMENT,
  						`game_SwfFile` varchar(200) NOT NULL DEFAULT '',
  						`game_Name` varchar(100) NOT NULL DEFAULT '',
  						`game_Thumb` varchar(200) NOT NULL DEFAULT '',
  						`game_Width` varchar(8) NOT NULL DEFAULT '',
  						`game_Height` varchar(8) NOT NULL DEFAULT '',
  						`game_Desc` varchar(100) NOT NULL DEFAULT '',
  						UNIQUE KEY `game_ID` (`game_ID`)
						) ENGINE=InnoDB  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_games - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_games - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>

		</td></tr>
		<tr><td>

			<?php

				$sql = "INSERT INTO `avatarchat_games` (`game_ID`, `game_SwfFile`, `game_Name`, `game_Thumb`, `game_Width`, `game_Height`, `game_Desc`) VALUES
						(1, '3FootNinja.swf', '3 Foot Ninja', 'ninjasmallicon.gif', '400', '300', 'Cool online fighting game, great fun'),
						(2, 'alienattackwm.swf', 'Alien', 'aliensmallicon.gif', '400', '300', '\"DEFEND THE BASE\" from evil aliens!'),
						(3, 'baseballonefile.swf', 'Baseball', 'baseballsmallicon.gif', '400', '300', 'Have a nice relaxing game of baseball online!'),
						(4, 'battleships.swf', 'Battleships', 'battleshipssmallicon.gif', '400', '300', 'Come and play the classic game of battleships'),
						(5, 'trapshoot.swf', 'Trap Shot', 'trapshootsmallicon.gif', '400', '300', 'PULL!!! go on.. shoot those clay pigeons'),
						(6, 'stressgame.swf', 'Stress Game', 'paintsmallicon.gif', '400', '300', 'Take your stress out on these little smilie faces.'),
						(7, 'bug.swf', 'Bug on a wire', 'bugsmallicon.gif', '400', '300', 'Run along the wire for as long as you can'),
						(8, 'tennis.swf', 'Tennis Ace', 'acesmallicon.jpg', '400', '300', 'Like tennis?? You will love this game!'),
						(9, 'samuraiwm.swf', 'Samurai Warrior', 'samuraismallicon.jpg', '400', '300', 'A tekken style beat ''em up.'),
						(10, 'mars_stand_miniclip.swf', 'Mars Mission', 'missionsmallicon.gif', '400', '300', 'Cool alien invaders game, great fun!')";

				if(mysql_query($sql)) echo "&#187; avatarchat_games_pack - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_games_pack - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_mail` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`userid` varchar(64) NOT NULL DEFAULT '0',
  						`username` varchar(250) NOT NULL,
  						`touserid` varchar(64) NOT NULL DEFAULT '',
  						`tousername` varchar(250) NOT NULL,
  						`message` text NOT NULL,
  						`senttime` varchar(64) NOT NULL,
  						`status` varchar(3) NOT NULL,
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_mail - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_mail - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_message` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`action` varchar(64) NOT NULL,
  						`refid` varchar(100) NOT NULL,
  						`userid` varchar(64) NOT NULL DEFAULT '0',
  						`username` varchar(64) NOT NULL,
  						`to_username` varchar(64) NOT NULL,
  						`room` varchar(50) NOT NULL DEFAULT '',
  						`message` text,
  						`avatar` varchar(100) NOT NULL DEFAULT '',
  						`avatar_x` varchar(10) NOT NULL,
  						`avatar_y` varchar(10) NOT NULL,
  						`post_time` varchar(50) NOT NULL,
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";

				if(mysql_query($sql)) echo "&#187; avatarchat_message - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_message - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>

		</td></tr>
		<tr><td>

			<?php

				$sql = "INSERT INTO `avatarchat_message` (`id`, `action`, `refid`, `userid`, `username`, `to_username`, `room`, `message`, `avatar`, `avatar_x`, `avatar_y`, `post_time`) VALUES
						(1, 'logout', '1', '3', 'SYSTEM', '', '3', 'Admin has left the room', '../../images/avatar.png', '297', '189', '0')";

				if(mysql_query($sql)) echo "&#187; avatarchat_message_entries - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_message_entries - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>

			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_profileviews` (
  						`id` int(11) NOT NULL auto_increment,
  						`username` varchar(250) NOT NULL,
  						`viewed` varchar(250) NOT NULL,
  						`visited` varchar(25) NOT NULL default '0',
  						PRIMARY KEY  (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_profileviews - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_profileviews - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>

			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_referrals` (
  						`id` int(11) NOT NULL auto_increment,
  						`username` varchar(250) NOT NULL,
  						`referred` varchar(250) NOT NULL,
  						`joinIP` varchar(250) NOT NULL,
  						`joindate` varchar(250) NOT NULL,
  						KEY `id` (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_referrals - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_referrals - <font color=\"#FF0000\"><b>FAIL</b></font>";
			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_rooms` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`roomname` varchar(24) NOT NULL,
  						`uroom` varchar(3) NOT NULL,
  						`background_url` varchar(255) NOT NULL,
  						`music_url` varchar(255) NOT NULL,
  						`enableMusic` varchar(3) NOT NULL,
  						`uXX` varchar(3) NOT NULL,
  						`uYY` varchar(3) NOT NULL,
  						`offsetuXX` varchar(3) NOT NULL,
  						`offsetuYY` varchar(3) NOT NULL,
  						`doorTop1` varchar(3) NOT NULL,
  						`doorLeft1` varchar(3) NOT NULL,
  						`doorHeight1` varchar(3) NOT NULL,
  						`doorWidth1` varchar(3) NOT NULL,
  						`doorTop2` varchar(3) NOT NULL,
  						`doorLeft2` varchar(3) NOT NULL,
  						`doorHeight2` varchar(3) NOT NULL,
  						`doorWidth2` varchar(3) NOT NULL,
  						`doorTop3` varchar(3) NOT NULL,
  						`doorLeft3` varchar(3) NOT NULL,
  						`doorHeight3` varchar(3) NOT NULL,
  						`doorWidth3` varchar(3) NOT NULL,
  						`doorVisible` varchar(3) NOT NULL,
  						`dOne` varchar(3) NOT NULL,
  						`dTwo` varchar(3) NOT NULL,
  						`dThree` varchar(3) NOT NULL,
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM  DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_rooms - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_rooms - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>

		</td></tr>
		<tr><td>

			<?php

				$sql = "INSERT INTO `avatarchat_rooms` (`id`, `roomname`, `uroom`, `background_url`, `music_url`, `enableMusic`, `uXX`, `uYY`, `offsetuXX`, `offsetuYY`, `doorTop1`, `doorLeft1`, `doorHeight1`, `doorWidth1`, `doorTop2`, `doorLeft2`, `doorHeight2`, `doorWidth2`, `doorTop3`, `doorLeft3`, `doorHeight3`, `doorWidth3`, `doorVisible`, `dOne`, `dTwo`, `dThree`) VALUES
						(1, 'The Club', '1', 'templates/club/background.jpg', 'music/index.php', '0', '260', '180', '240', '160', '50', '20', '150', '40', '70', '765', '180', '40', '1', '1', '1', '1', '0', '4', '3', '1'),
						(2, 'The Beach', '2', 'templates/beach/background.jpg', 'music/index.php', '0', '400', '350', '380', '330', '500', '330', '40', '200', '110', '740', '80', '60', '1', '1', '1', '1', '0', '3', '3', '2'),
						(3, 'The Coffee Bar', '3', 'templates/coffee/background.jpg', 'music/index.php', '0', '297', '189', '277', '169', '20', '40', '150', '40', '70', '755', '180', '40', '1', '133', '65', '40', '0', '1', '5', '2'),
						(4, 'The Alley', '4', 'templates/alley/background.jpg', 'music/index.php', '0', '500', '231', '480', '211', '1', '1', '1', '1', '70', '660', '180', '60', '1', '1', '1', '1', '0', '4', '1', '4'),
						(5, 'The Park', '5', 'templates/park/background.jpg', 'music/index.php', '0', '380', '350', '360', '330', '500', '330', '40', '200', '70', '755', '40', '40', '1', '1', '1', '1', '0', '3', '-', '5')";

				if(mysql_query($sql)) echo "&#187; avatarchat_rooms_entries - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_rooms_entries - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>

		</td></tr>
		<tr><td>

			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_shop` (
  					`id` int(11) NOT NULL auto_increment,
  					`item` varchar(250) NOT NULL,
  					`image` varchar(250) NOT NULL,
  					`description` varchar(250) NOT NULL,
  					`cost` varchar(250) NOT NULL,
  					`featured` varchar(3) NOT NULL,
  					`section` varchar(250) NOT NULL,
  					KEY `id` (`id`)
					) ENGINE=MyISAM AUTO_INCREMENT=82 DEFAULT CHARSET=latin1 AUTO_INCREMENT=82";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_shop - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_shop - <font color=\"#FF0000\"><b>FAIL</b></font>";

				$sql = "INSERT INTO `avatarchat_shop` VALUES (79, 'White Male Body', 'avatars/male/base/whiteMaleBody.png', 'White Male Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (80, 'Tan Female Body', 'avatars/female/base/tanFemaleBody.png', 'Tan Female Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (81, 'White Female Body', 'avatars/female/base/whiteFemaleBody.png', 'White Female Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (7, 'Club', 'backgrounds/club.jpg', 'Club', '1', '1', '2')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (8, 'Black Male Body', 'avatars/male/base/blackMaleBody.png', 'Black Male Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (9, 'Tan Male Body', 'avatars/male/base/tanMaleBody.png', 'Tan Male Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (11, 'Male Grin', 'avatars/male/mouth/maleGrin.png', 'Male Grin', '0', '1', '4')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (12, 'Male Smile', 'avatars/male/mouth/maleSmile.png', 'Male Smile', '0', '1', '4')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (13, 'Male Blue Eyes', 'avatars/male/eyes/maleBlueEyes.png', 'Male Blue Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (14, 'Male Blue Heavy Eyes', 'avatars/male/eyes/maleBlueHeavyEyes.png', 'Male Blue Heavy Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (15, 'Male Brown Eyes', 'avatars/male/eyes/maleBrownEyes.png', 'Male Brown Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (16, 'Male Brown Heavy Eyes', 'avatars/male/eyes/maleBrownHeavyEyes.png', 'Male Brown Heavy Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (17, 'Male Green Eyes', 'avatars/male/eyes/maleGreenEyes.png', 'Male Green Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (18, 'Male Green Heavy Eyes', 'avatars/male/eyes/maleGreenHeavyEyes.png', 'Male Green Heavy Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (19, 'Male Aviators', 'avatars/male/accessories/maleAviators.png', 'Male Aviators', '0', '1', '6')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (20, 'Male Black V Neck', 'avatars/male/tops/blackVNeck.png', 'Male Black V Neck', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (21, 'Male Blue Graphic T', 'avatars/male/tops/blueGraphicT.png', 'Male Blue Graphic T', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (22, 'Male Gray Dress Button Up', 'avatars/male/tops/grayDressButtonUp.png', 'Male Gray Dress Button Up', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (23, 'Male Green Track Jacket', 'avatars/male/tops/greenTrackJacket.png', 'Male Green Track Jacket', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (24, 'Male White Button Up', 'avatars/male/tops/whiteButtonUp.png', 'Male White Button Up', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (25, 'Male Long Black Hair', 'avatars/male/hair/longBlackHair.png', 'Male Long Black Hair', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (26, 'Male Long Brown Hair', 'avatars/male/hair/longBrownHair.png', 'Male Long Brown Hair', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (27, 'Male Short Black Hair', 'avatars/male/hair/shortBlackHair.png', 'Male Short Black Hair', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (28, 'Male Short Blonde Hair', 'avatars/male/hair/shortBlondeHair.png', 'Male Short Blonde Hair', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (29, 'Male Spiky Light Brown Hair', 'avatars/male/hair/SpikyLightBrownHair.png', 'Male Spiky Light Brown Hair', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (30, 'Male Brown Beard', 'avatars/male/beard/brownBeard.png', 'Male Brown Beard', '0', '1', '9')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (31, 'Male Soul Patch', 'avatars/male/beard/soulPatch.png', 'Male Soul Patch', '0', '1', '9')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (32, 'Male Black Slacks', 'avatars/male/bottoms/blackSlacks.png', 'Male Black Slacks', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (33, 'Male Dark Skinny Jeans', 'avatars/male/bottoms/darkSkinnyJean.png', 'Male Dark Skinny Jeans', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (34, 'Male Detail Skinny Jeans', 'avatars/male/bottoms/detailSkinnyJean.png', 'Male Detail Skinny Jeans', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (35, 'Male Distressed Relaxed', 'avatars/male/bottoms/distressedRelaxed.png', 'Male Distressed Relaxed', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (36, 'Male Tan Cargo', 'avatars/male/bottoms/tanCargo.png', 'Male Tan Cargo', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (37, 'Male Black Dress Shoes', 'avatars/male/shoes/blackDressShoe.png', 'Male Black Dress Shoes', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (38, 'Male Brown Casual Shoes', 'avatars/male/shoes/brownCasual.png', 'Male Brown Casual Shoes', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (39, 'Male Gray Converse', 'avatars/male/shoes/grayConverse.png', 'Male Gray Converse', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (40, 'Male Flip Flops', 'avatars/male/shoes/maleFlipFlops.png', 'Male Flip Flops', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (41, 'Male White Sneakers', 'avatars/male/shoes/whiteSneakers.png', 'Male White Sneakers', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (42, 'Black Female Body', 'avatars/female/base/blackFemaleBody.png', 'Black Female Body', '0', '1', '3')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (45, 'Female Grin', 'avatars/female/mouth/femaleGrin.png', 'Female Grin', '0', '1', '4')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (46, 'Female Smile', 'avatars/female/mouth/femaleSmile.png', 'Female Smile', '0', '1', '4')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (47, 'Blue Female Eyes', 'avatars/female/eyes/blueFemaleEyes.png', 'Blue Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (48, 'Blue Heavy Female Eyes', 'avatars/female/eyes/blueHeavyFemaleEyes.png', 'Blue Heavy Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (49, 'Brown Female Eyes', 'avatars/female/eyes/brownFemaleEyes.png', 'Brown Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (50, 'Brown Heavy Female Eyes', 'avatars/female/eyes/brownHeavyFemaleEyes.png', 'Brown Heavy Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (51, 'Green Female Eyes', 'avatars/female/eyes/greenFemaleEyes.png', 'Green Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (52, 'Green Heavy Female Eyes', 'avatars/female/eyes/greenHeavyFemaleEyes.png', 'Green Heavy Female Eyes', '0', '1', '5')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (53, 'Female Sunglasses', 'avatars/female/accessories/femaleSunglasses.png', 'Female Sunglasses', '0', '1', '6')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (54, 'Female Gold Bracelet', 'avatars/female/accessories/goldBracelet.png', 'Female Gold Bracelet', '0', '1', '6')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (55, 'Female Pearls', 'avatars/female/accessories/pearls.png', 'Female Pearls', '0', '1', '6')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (56, 'Female Turquoise Necklace', 'avatars/female/accessories/turquoise_necklace.png', 'Female Turquoise Necklace', '0', '1', '6')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (57, 'Female Blue Turtleneck', 'avatars/female/tops/blueTurtleneck.png', 'Female Blue Turtleneck', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (58, 'Female Gold Button Up', 'avatars/female/tops/goldButtonup.png', 'Female Gold Button Up', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (59, 'Female Green Stripe Tank Top', 'avatars/female/tops/greenStripeTank.png', 'Female Green Stripe Tank Top', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (60, 'Female Love Tee', 'avatars/female/tops/loveTee.png', 'Female Love Tee', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (61, 'Female Red Dress Top', 'avatars/female/tops/redDressTop.png', 'Female Red Dress Top', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (62, 'Female White Tank Top', 'avatars/female/tops/whiteTank.png', 'Female White Tank Top', '0', '1', '7')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (63, 'Female Black Ponytail', 'avatars/female/hair/blackPonytail.png', 'Female Black Ponytail', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (64, 'Female Blonde Ponytail', 'avatars/female/hair/blondePonytail.png', 'Female Blonde Ponytail', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (65, 'Female Curly Medium Brown', 'avatars/female/hair/curlyMediumBrown.png', 'Female Curly Medium Brown', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (66, 'Female Long Straight Black', 'avatars/female/hair/longStraightBlack.png', 'Female Long Straight Black', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (67, 'Female Long Straight Blonde', 'avatars/female/hair/longStraightBlonde.png', 'Female Long Straight Blonde', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (68, 'Female Red Long', 'avatars/female/hair/redLong.png', 'Female Red Long', '0', '1', '8')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (69, 'Female Black Dress Skirt', 'avatars/female/bottoms/blackDressSkirt.png', 'Female Black Dress Skirt', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (70, 'Female Dark Flower Jeans', 'avatars/female/bottoms/darkFlowerJeans.png', 'Female Dark Flower Jeans', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (71, 'Female Khaki Skirt', 'avatars/female/bottoms/khakiSkirt.png', 'Female Khaki Skirt', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (72, 'Female Light Flower Jeans', 'avatars/female/bottoms/lightFlowerJeans.png', 'Female Light Flower Jeans', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (73, 'Female White Shorts', 'avatars/female/bottoms/whiteShorts.png', 'Female White Shorts', '0', '1', '10')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (74, 'Female Brown Shoes', 'avatars/female/shoes/brownShoes.png', 'Female Brown Shoes', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (75, 'Female Green Sandals', 'avatars/female/shoes/greenSandals.png', 'Female Green Sandals', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (76, 'Female Pink Sandals', 'avatars/female/shoes/pinkSandals.png', 'Female Pink Sandals', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (77, 'Female Red Heels', 'avatars/female/shoes/redHeels.png', 'Female Red Heels', '0', '1', '11')";mysql_query($sql);
				$sql = "INSERT INTO `avatarchat_shop` VALUES (78, 'Female White Flip Flops', 'avatars/female/shoes/whiteFlipFlops.png', 'Female White Flip Flops', '0', '1', '11')";mysql_query($sql);

			?>
		
		</td></tr>
		<tr><td>

			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_shop_accounts` (
  						`id` int(11) NOT NULL auto_increment,
  						`username` varchar(250) NOT NULL,
  						`credits` varchar(250) NOT NULL,
  						`lastLogin` varchar(100) NOT NULL,
  						KEY `id` (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_shop_accounts - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_shop_accounts - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>
		
		</td></tr>
		<tr><td>

			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_shop_payments` (
  						`id` int(11) NOT NULL auto_increment,
  						`username` varchar(250) NOT NULL,
  						`purchase` varchar(250) NOT NULL,
  						`credits` varchar(250) NOT NULL,
  						KEY `id` (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_shop_payments - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_shop_payments - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_user` (
  						`id` int(11) NOT NULL auto_increment,
  						`userid` varchar(64) NOT NULL default '0',
  						`username` varchar(16) NOT NULL,
  						`password` varchar(32) NOT NULL,
  						`userIP` varchar(32) NOT NULL,
  						`gender` varchar(3) NOT NULL default '0',
  						`email` varchar(255) NOT NULL,
  						`status` varchar(1) NOT NULL default '0',
  						`vip` varchar(3) NOT NULL default '0',
  						`vipStart` varchar(100) NOT NULL default '0',
  						`vipEnd` varchar(100) NOT NULL default '0',
  						`vipsubscrid` varchar(50) NOT NULL default '0',
  						`adminID` varchar(3) NOT NULL default '0',
  						`room` varchar(50) NOT NULL default '',
  						`myroomID` varchar(250) NOT NULL,
  						`myroomIMG` varchar(250) NOT NULL default 'templates/default/background.jpg',
  						`roomaccess` varchar(3) NOT NULL default '1',
  						`roomname` varchar(32) NOT NULL,
  						`roommax` varchar(4) NOT NULL default '5',
  						`roomMaxStart` varchar(100) NOT NULL default '0',
  						`roomMaxEnd` varchar(100) NOT NULL default '0',
  						`roommaxsubscrid` varchar(50) NOT NULL default '0',
  						`startX` varchar(3) NOT NULL default '100',
  						`startY` varchar(3) NOT NULL default '180',
  						`music` varchar(255) NOT NULL default 'music/index.php',
  						`avatar` varchar(1000) NOT NULL,
  						`avatara` varchar(250) NOT NULL,
  						`avatarb` varchar(250) NOT NULL,
  						`avatarc` varchar(250) NOT NULL,
  						`avatar_x` varchar(10) NOT NULL,
  						`avatar_y` varchar(10) NOT NULL,
  						`webcam` varchar(3) NOT NULL default '0',
  						`lovepoints` varchar(100) NOT NULL default '0',
  						`thumbpoints` varchar(100) NOT NULL default '0',
  						`starpoints` varchar(100) NOT NULL default '0',
  						`age` varchar(3) NOT NULL,
  						`location` varchar(255) NOT NULL,
  						`hobbies` varchar(255) NOT NULL,
  						`aboutme` text NOT NULL,
  						`photo` varchar(255) NOT NULL default 'nopic.jpg',
  						`online_time` varchar(50) NOT NULL default '0',
  						PRIMARY KEY  (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_user - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_user - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>
		
		</td></tr>
		<tr><td>
		
			<?php

				$sql = "CREATE TABLE IF NOT EXISTS `avatarchat_votes` (
  						`id` int(11) NOT NULL AUTO_INCREMENT,
  						`username` varchar(250) NOT NULL,
  						`to_username` varchar(250) NOT NULL,
  						`lovevote` varchar(3) NOT NULL DEFAULT '0',
  						`thumbvote` varchar(3) NOT NULL DEFAULT '0',
  						`starvote` varchar(3) NOT NULL DEFAULT '0',
  						PRIMARY KEY (`id`)
						) ENGINE=MyISAM DEFAULT CHARSET=latin1 AUTO_INCREMENT=1";
			
				if(mysql_query($sql)) echo "&#187; avatarchat_votes - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; avatarchat_votes - <font color=\"#FF0000\"><b>FAIL</b></font>";

			?>
		
		</td></tr>

		<tr><td>&nbsp;</td></tr>
		<tr><td><b>Important!</b></td></tr>
		<tr><td>If all tables have successfully installed, please delete the folder '<b>install</b>'.</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><b>General Settings</b></td></tr>
		<tr><td>Open the file <b>'includes/config.php'</b> with your text editor.</td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><b>Admin Details</b></td></tr>
		<tr><td>Username: admin</td></tr>
		<tr><td>Password: adminpass</td></tr>
		<tr><td>Login: <a href="../../admincp/index.php" target="_blank">Click Here</a></td></tr>
		<tr><td>&nbsp;</td></tr>
		<tr><td><b>Thank you for choosing the Avatar Chat software.</b></td></tr>
		</table>
	</td>
	</tr>
	</table>

<?php }?>

	<br>

	<table align="center" width="100%" border="0" class="table">
	<tr>
	<td align=center>
		If you require support during the installation process, please contact us.<br>
	</td>
	</tr>
	<tr>
	<td align=center>
		&copy; Copyright 2007 - <?php echo date("Y");?> <a href="/" target="_blank">Pro Chat Rooms</a> All Rights Reserved.
	</td>
	</tr>
	</table>

</body>
</html>