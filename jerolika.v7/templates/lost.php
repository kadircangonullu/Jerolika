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
	<title><?php echo $CONFIG['chatroom_title'];?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CONFIG['brower_char'];?>" />
	<link type="text/css" rel="stylesheet" href="templates/style.css">

	<script language="javascript" type="text/javascript">
	<!--
	if(window.location == top.location){
		window.location.href="index.html";
	}
	// -->
	</script>

	</head>

	<body class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

	<div id="loginscreen" class="loginscreen">

		<form name="login" action="index.php" method="post">

			<div id="infobox" class="infobox">

				Resend My Login Details

				<br>

				<table class="mediumtext">
				<input type="hidden" name="do" value="password">

				<?php if($create_pass){ ?>

					<tr><td colspan="2"><span style="color: #FF0000"><?php echo $eMessage;?></span></td></tr>

				<?php }else{ ?>

					<tr><td colspan="2">&nbsp;</td></tr>

				<?php } ?>

				<tr><td width="125">Your Username:</td><td><input class="input" type="text" name="nickName" value="<?php echo $_POST['nickName'];?>"></td></tr>
				<tr><td>Your Email:</td><td><input class="input" type="text" name="nickEmail" value="<?php echo $_POST['nickEmail'];?>"></td></tr>
				<tr><td>&nbsp;</td><td><input type="image" src="templates/login/lost.gif" height="24" width="132" border="0" alt="Resend Details"></td></tr>
				<tr><td>&nbsp;</td><td><span class="smalltext"><span class="link"><a href="index.php">... i've remembered my login details!</a><br><a href="index.php?do=register">... i will create a new account!</a></span></span></td></tr>
				</table>

				<br>
				<br>

				<span class="smalltext">
				Fill in your username and email address and we will send you<br>your login details shortly. If you think you remember your<br>password you can return to the login page. Otherwise you<br>can create a new account.
				</span>

			</div>

		</form>

	</div>

	</body>
	</html>