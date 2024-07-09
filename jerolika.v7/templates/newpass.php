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

?>

	<html> 
	<head>
	<title>Avatar Chat</title>
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
	<link type="text/css" rel="stylesheet" href="templates/style.css">

	</head>

	<body bgcolor="#000000" class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

	<div id="loginscreen" class="loginscreen">

		<form name="updatepass" action="newpass.php" method="post">

			<div id="infobox" class="infobox">

				Reset My Password

				<br>

				<span class="smalltext">
				To reset your password, enter a new password below.
				</span>

				<br>

				<table style="color: #FFFFFF;">
				<input type="hidden" name="update" value="1">
				<input type="hidden" name="nickCid" value="<?php echo $cid;?>">
				<input type="hidden" name="nickRef" value="<?php echo $ref;?>">
				<input type="hidden" name="nickEmail" value="<?php echo $email;?>">

				<?php if($update_pass){ ?>

					<tr><td colspan="2"><span style="color: #FF0000"><?php echo $eMessage;?></span></td></tr>

				<?php }else{ ?>

					<tr><td colspan="2">&nbsp;</td></tr>

				<?php } ?>

				<tr><td>New Password:</td><td><input class="input" type="password" name="newPass"></td></tr>
				<tr><td>&nbsp;</td><td><input type="image" src="templates/login/confirm.gif" height="24" width="132" border="0" alt="Confirm Details"></td></tr>
				</table>

			</div>
		</form>

	</div>

	</body>
	</html>