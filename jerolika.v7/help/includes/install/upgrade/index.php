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

if ($_POST && $_POST['i']=='1'){

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
<b>Avatar Chat - Upgrade 2.x.x to 3.0.0</b>
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

<?php if ($_POST && $_POST['i']=='1'){?>

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

			<?php
				// update users table

				$sql = "ALTER TABLE  `avatarchat_user` 
					ADD  `vipStart` VARCHAR( 100 ) NOT NULL DEFAULT '0' AFTER  `vip` ,
					ADD  `vipEnd` VARCHAR( 100 ) NOT NULL DEFAULT '0' AFTER  `vipStart` ,
					ADD  `vipsubscrid` VARCHAR( 50 ) NOT NULL DEFAULT '0' AFTER  `vipEnd`,
					ADD  `roomMaxStart` VARCHAR( 100 ) NOT NULL DEFAULT  '0' AFTER  `roommax` ,
					ADD  `roomMaxEnd` VARCHAR( 100 ) NOT NULL DEFAULT  '0' AFTER  `roomMaxStart` ,
					ADD  `roommaxsubscrid` VARCHAR( 50 ) NOT NULL DEFAULT  '0' AFTER  `roomMaxEnd`";

				mysql_query($sql);

				$sql = "ALTER TABLE  `avatarchat_user` 
					CHANGE  `avatar`  `avatar` 
					VARCHAR( 1000 ) 
					CHARACTER SET latin1 
					COLLATE latin1_swedish_ci 
					NOT NULL";

				mysql_query($sql);

			?>

			
			<?php
				$sql = "TRUNCATE TABLE  `avatarchat_shop`";mysql_query($sql);
				$sql = "TRUNCATE TABLE  `avatarchat_shop_payments`";mysql_query($sql);

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
				$sql = "INSERT INTO `avatarchat_shop` VALUES (78, 'Female White Flip Flops', 'avatars/female/shoes/whiteFlipFlops.png', 'Female White Flip Flops', '0', '1', '11')";

			
				if(mysql_query($sql)) echo "&#187; Shop Items Installed - <font color=\"#33FF00\"><b>INSTALLED</b></font>";
				else echo "&#187; Shop Items Installed - <font color=\"#FF0000\"><b>FAIL</b></font>";
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
		&copy; Copyright <?php echo date("Y");?> <a href="/" target="_blank">Pro Chat Rooms</a> All Rights Reserved.
	</td>
	</tr>
	</table>

</body>
</html>