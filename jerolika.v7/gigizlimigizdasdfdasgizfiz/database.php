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

// database management

	if($_GET['cp_t'] && $_GET['cp_action']){

		if(strtolower($_GET['cp_action'])=='drop'){

			echo "Action Not Permitted";
			die;

		}

		$sql = "".mysql_real_escape_string(remSpcChars($_GET['cp_action']))." TABLE ".mysql_real_escape_string(remSpcChars($_GET['cp_t']))."";
		mysql_query($sql) or die(mysql_error());

		if($_GET['cp_t'] == $CONFIG['mysql_prefix']."message" && $_GET['cp_action'] == 'TRUNCATE'){

			// add message to ensure mysql has at least 1 row of data
			$sql = "INSERT INTO `avatarchat_message` (`id`, `action`, `refid`, `userid`, `username`, `to_username`, `room`, `message`, `avatar`, `avatar_x`, `avatar_y`, `post_time`) VALUES
			(1, 'logout', '1', '3', 'SYSTEM', '', '3', 'Admin has left the room', '../images/avatar.png', '297', '189', '0')";
			mysql_query($sql) or die(mysql_error());

		}

		$cp_Update = '1';

		// header redirect
		// header("Status: 200");
		header("refresh: 2; url=database.php");

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

<tr><td colspan="2"><b>Database Management</b></td></tr>

<?php if($_SESSION['cp_admin_login'] != md5(md5($CONFIG['admin_pass']))){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><font color=red><b>Sorry, Access Denied</b></font><br><br>This section is for Administrators only.</td></tr>
	<tr><td colspan="2">&nbsp;</td></tr>
	</table>

<?php return; }?>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><font color="orange"><b>:: IMPORTANT</b><br>Truncate will delete all MySQL entries.</font></td></tr>

<?php if($cp_Update){?>

	<tr><td colspan="2">&nbsp;</td></tr>
	<tr><td colspan="2"><font color="green"><b>Success, MySQL Table Updated,<br><br>Please wait...</font></b></td></tr>

<?php }?>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>blocked</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."blocked") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>blocked&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>blocked&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>friends</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."friends") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>friends&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>friends&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>mail</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."mail") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>mail&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>mail&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>message</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."message") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>message&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>message&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>rooms</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."rooms") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td>- - -</td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>rooms&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>user</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."user") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>user&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>user&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>votes</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."votes") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>votes&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>votes&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>shop</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."shop") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>shop_accounts</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."shop_accounts") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop_accounts&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop_accounts&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>shop_payments</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."shop_payments") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop_payments&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>shop_payments&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>referrals</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."referrals") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>referrals&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>referrals&cp_action=OPTIMIZE">Update</a></td></tr>

<tr><td colspan="2">&nbsp;</td></tr>
<tr><td colspan="2"><b>MySQL Table - <?php echo $CONFIG['mysql_prefix'];?>profileviews</b></td></tr>

<?php
	$tmp=mysql_query("SELECT id FROM ".$CONFIG['mysql_prefix']."profileviews") or die(mysql_error()); 
	$cp_totalRows = mysql_num_rows($tmp);
?>

<tr><td>Total Entries:</td><td><?php echo $cp_totalRows;?></td></tr>
<tr><td>Truncate:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>profileviews&cp_action=TRUNCATE">Update</a></td></tr></td></tr>
<tr><td>Optimize:</td><td><a href="database.php?cp_t=<?php echo $CONFIG['mysql_prefix'];?>profileviews&cp_action=OPTIMIZE">Update</a></td></tr>



</table>

</body>
</html>
