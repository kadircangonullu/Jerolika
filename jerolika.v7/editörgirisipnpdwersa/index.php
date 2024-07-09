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

// install file is present

	if(file_exists("../install/index.php")){

		die("Please delete the 'install' folder to continue.");
	}

// software licence is not found

	if(!file_exists("../software_licence.txt")){

		die("Please upload the 'software_licence.txt' file.");
	}

// include files

	include("../includes/session.php");
	include("../includes/db.php");
	include("../includes/config.php");
	include("../includes/functions.php");

	unset($_SESSION['cp_isLoggedIN']);
	unset($_SESSION['cp_admin_login']);
	unset($_SESSION['cp_mods_login']);

// do logout 

	if($_GET['cp_do'] == 'logout'){

		// header redirect
		// header("Status: 200");
		header("Location: index.php");
		die;

	}

// do POST login

	if($_POST){

		$cp_login_error = '1';

// do security check

		if(strtolower($_POST['cp_security_code']) != strtolower($_POST['cp_login_security_code'])){

			$cp_security_error='1';

		}

// do admin login

		if(!$cp_security_error && $CONFIG['admin_name'] == $_POST['cp_adminname'] && $CONFIG['admin_pass'] == $_POST['cp_password']){

			// set session
			$_SESSION['cp_isLoggedIN'] = md5(md5($CONFIG['cp_prefix']));
			$_SESSION['cp_admin_login'] = md5(md5($CONFIG['admin_pass']));

			// header redirect
			// header("Status: 200");
			header("Location: controlpanel.php");
			die;

		}

// do moderator login

		if(!$cp_security_error && in_array(strtolower($_POST['cp_adminname']), $chatroom_mods) && $CONFIG['mods_pass'] == $_POST['cp_password']){

			// set session
			$_SESSION['cp_isLoggedIN'] = md5(md5($CONFIG['cp_prefix']));
			$_SESSION['cp_mods_login'] = md5(md5($CONFIG['mods_pass']));

			// header redirect
			// header("Status: 200");
			header("Location: controlpanel.php");
			die;

		}

	}

// set security code for login

	function generateCode($length = 6){

    		$chars = "abcdefghjkmnpqrstvwxyzABCDEFGHJKLMNPRQSTUVWXYZ23456789";
    		$code = "";
    		while (strlen($code) < $length){

        		$code .= $chars[mt_rand(0, strlen($chars))];
    		}
    		return $code;
	}

	$cp_security_code = generateCode();

?>


<html> 
<head>
<title>Avatar Chat - Admin Area (Powered by Pro Chat Rooms)</title>
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.body {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
background-image: url('../images/logo.jpg');
background-repeat: repeat;
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

<script language="javascript" type="text/javascript">
<!--
if(window.location != top.location){
	window.location.href="index.php";
}
// -->
</script>

</head>
<body class="body">

<br><br><br><br><br><br><br><br>

<form method="post" action="index.php" name="login">
<input type="hidden" name="cp_doLogin" value="1">
<input type="hidden" name="cp_security_code" value="<?php echo $cp_security_code; ?>" />
<table class="table" align="center" border="0">
<tr><td colspan="2"><b>Administration Login.</b></td></tr>

<?php if ($cp_login_error){ ?>

	<tr><td colspan="2"><font color=red>Error: Incorrect Login Details</font></td></tr>

<?php } ?>

<?php if ($cp_security_error){ ?>

	<tr><td colspan="2"><font color=red>Error: Incorrect Security Code</font></td></tr>

<?php } ?>

<tr><td>Username:</td><td><input type="text" name="cp_adminname" value="" maxlength="64"></td></tr>
<tr><td>Password:</td><td><input type="password" name="cp_password" value="" maxlength="64"></td></tr>
<tr><td>Enter Code:</td><td><input type="text" name="cp_login_security_code" size="6" maxlength="6">&nbsp;<b style="padding:2px;background-color:#333333;"><?php echo $cp_security_code; ?></b></td></tr>
<tr><td>&nbsp;</td><td><input type="submit" name="submit" value="Login"></td></tr>
</table>
</form>

<!-- 
DO NOT REMOVE THE COPYRIGHT NOTICE LINE BELOW UNLESS YOUR LICENCE TYPE PERMITS THIS.
REMOVAL OF THE COPYRIGHT INFORMATION WITHOUT PERMISSION WILL TERMINATE YOUR LICENCE.
--> 

<br>
<div align="center">
&copy;<?php echo date("Y"); ?> All Rights Reserved<br>Avatar Chat - Version: <?php echo $CONFIG['version']; ?><br>Powered By Pro Chat Rooms
</div>

</body>
</html>