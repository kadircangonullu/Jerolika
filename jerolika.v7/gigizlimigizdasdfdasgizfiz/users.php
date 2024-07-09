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

// delete user

	if($_GET['cp_deleteUser'] && $_GET['cp_deleteUser_confirm']){

		mysql_query("DELETE FROM ".$CONFIG['mysql_prefix']."user WHERE username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."'") or die(mysql_error());
		mysql_query("DELETE FROM ".$CONFIG['mysql_prefix']."blocked WHERE username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."' OR blockname = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."'") or die(mysql_error());
		mysql_query("DELETE FROM ".$CONFIG['mysql_prefix']."friends WHERE username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."' OR friendname = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."'") or die(mysql_error());
		mysql_query("DELETE FROM ".$CONFIG['mysql_prefix']."mail WHERE username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."' OR tousername = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."'") or die(mysql_error());
		mysql_query("DELETE FROM ".$CONFIG['mysql_prefix']."votes WHERE username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."' OR to_username = '".mysql_real_escape_string(remSpcChars($_GET['cp_deleteUser']))."'") or die(mysql_error());

		$cp_userDeleted = 'l';
	}


// do search usernames

	if($_POST['cp_search_names'] || $_GET['cp_search_names']){

		if($_POST['cp_search_names']){

			$_GET['cp_search_names'] = $_POST['cp_search_names'];

		}

		$cp_getUsername = $_GET['cp_search_names'];

		$cp_doSearch = "WHERE username LIKE '%".mysql_real_escape_string(remSpcChars($cp_getUsername))."%'";

	}

// do search user online

	//set offline time
	$cp_userOffline = date("U")-30;

	if($_GET['cp_search_online']){

		$cp_doSearch = "WHERE online_time >='".$cp_userOffline."'";

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

<tr><td colspan="14"><b>User Management</b></td></tr>

<tr><td colspan="14">&nbsp;</td></tr>
<tr><td colspan="14">
<form method="post" name="search_users" action="users.php">
<b>Search Usernames:</b><input type="text" name="cp_search_names" value=""><input type="submit" name="submit" value="Find">
</form>
</td></tr>


<?php if($_GET['cp_deleteUser']){?>

<tr><td colspan="14">&nbsp;</td></tr>
<tr><td colspan="14"><font color="orange">Are you sure you want to delete <b><?php echo $_GET['cp_deleteUser'];?></b>? <a href="users.php?cp_deleteUser=<?php echo $_GET['cp_deleteUser'];?>&cp_deleteUser_confirm=1">[Yes]</a> <a href="users.php">[No]</a></font></td></tr>

<?php }?>

<?php if($cp_userDeleted){?>

<tr><td colspan="14">&nbsp;</td></tr>
<tr><td colspan="14"><font color="green">Username <b><?php echo $_GET['cp_deleteUser'];?></b> has been deleted.</font></td></tr>

<?php }?>

<?php 

// get users online

	$tmp=mysql_query("
	SELECT *     
	FROM ".$CONFIG['mysql_prefix']."user
	WHERE online_time >= '".$cp_userOffline."'  
	ORDER BY id DESC 
	") or die(mysql_error()); 

	$cp_totalOnline = mysql_num_rows($tmp);

	if($cp_totalOnline < 10){

		$cp_totalOnline = '0'.$cp_totalOnline;

	}

?>

<tr><td colspan="14">&nbsp;</td></tr>
<tr><td colspan="14"><b>Users Online: <font color=green><?php echo $cp_totalOnline;?></font></b> <a href="users.php?cp_search_online=1">[View All]</a></td></tr>

<tr><td colspan="14">&nbsp;</td></tr>
<tr><td colspan="14"><b>User Details</b></td></tr>

<?php

// get the user details

$cp_t_results = $CONFIG['user_results'];

if (!$_GET['cp_r']){

	$cp_r = '0';

}else{

	$cp_r = $_GET['cp_r'];

}

	$tmp=mysql_query("
	SELECT *     
	FROM ".$CONFIG['mysql_prefix']."user 
	".$cp_doSearch."
	ORDER BY id DESC 
	LIMIT $cp_r , $cp_t_results 
	") or die(mysql_error()); 

	$cp_totalRows = mysql_num_rows($tmp);

	if($cp_totalRows){

	?>

		<tr><td>ID</td><td>User ID</td><td>UserName</td><td align="center">UserIP</td><td>Status</td><td>Gender</td><td>Ban</td><td>VIP</td><td>Admin ID</td><td>In Room</td><td>Love Points</td><td>Thumb Points</td><td>Star Points</td><td>Delete</td></tr>

		<?php

		while($got_data = mysql_fetch_array($tmp)) {

			$cp_id = $got_data['id'];
			$cp_userid = $got_data['userid'];		
			$cp_username = $got_data['username'];
			$cp_userIP = $got_data['userIP'];
			$cp_gender = $got_data['gender'];
			$cp_status = $got_data['status'];
			$cp_vip = $got_data['vip'];
			$cp_adminID = $got_data['adminID'];
			$cp_room = $got_data['room'];
			$cp_lovepoints = $got_data['lovepoints'];
			$cp_thumbpoints = $got_data['thumbpoints'];
			$cp_starpoints = $got_data['starpoints'];
			$cp_online_time = $got_data['online_time'];

			if($cp_online_time > (date("U")-30)){

				$cp_isOnline = '<font color=green>Online</font>';

			}else{

				$cp_isOnline = '<font color=red>Offline</font>';

			}

			?>

			<tr><td><?php echo $cp_id;?></td><td align="center"><?php echo $cp_userid;?></td><td><a href="userEdit.php?cp_username=<?php echo $cp_username;?>" target="3"><?php echo $cp_username;?></a></td><td><?php echo $cp_userIP;?></td><td><?php echo $cp_isOnline;?></td><td align="center"><?php echo $cp_gender;?></td><td align="center"><?php echo $cp_status;?></td><td align="center"><?php echo $cp_vip;?></td><td align="center"><?php echo $cp_adminID;?></td><td align="center"><?php echo $cp_room;?></td><td align="center"><?php echo $cp_lovepoints;?></td><td align="center"><?php echo $cp_thumbpoints;?></td><td align="center"><?php echo $cp_starpoints;?></td><td align="center"><a href="users.php?cp_deleteUser=<?php echo $cp_username;?>">[x]</a></td></tr>
		
			<?php

		}

		?>

		<tr><td colspan="14">&nbsp;</td></tr>

		<?php

		if($_GET['cp_r'] > 0){

			$cp_prev = $_GET['cp_r'] - $cp_t_results;

		}

		if($_GET['cp_r'] <= 10){

			$cp_prev = '0';

		}

		$cp_next = $_GET['cp_r'] + $cp_t_results;

		?>

		<tr><td colspan="14" align="center"><a href="users.php?cp_r=<?php echo $cp_prev;?>&cp_search_names=<?php echo $_GET['cp_search_names'];?>&cp_search_online=<?php echo $_GET['cp_search_online'];?>"><< Previous</a> | <a href="users.php?cp_r=<?php echo $cp_next;?>&cp_search_names=<?php echo $_GET['cp_search_names'];?>&cp_search_online=<?php echo $_GET['cp_search_online'];?>">Next >></a></td></tr>

	<?php }else{?>

		<tr><td colspan="14">No results found...</td></tr>

	<?php }?>

</table>

</body>
</html>