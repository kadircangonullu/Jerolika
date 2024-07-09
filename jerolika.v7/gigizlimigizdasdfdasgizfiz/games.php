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

	// check gameid is numeric

	if($_GET['cp_update_gameID'] && !is_numeric($_GET['cp_update_gameID'])){

		die('update_games value is not numeric');

	}

	if($_POST['cp_game_ID'] && !is_numeric($_POST['cp_game_ID'])){

		die('update_games value is not numeric');

	}

	// update game

	$cp_games_confirm = '0';

	if($_POST && is_numeric($_POST['cp_game_ID'])){

		$sql = "
		UPDATE ".$CONFIG['mysql_prefix']."games 
		SET 
		game_SwfFile = '".htmlspecialchars(makeSafe($_POST['cp_game_swfFile']), ENT_QUOTES)."',
		game_Name = '".htmlspecialchars(makeSafe($_POST['cp_game_Name']), ENT_QUOTES)."',
		game_Thumb = '".htmlspecialchars(makeSafe($_POST['cp_game_Thumb']), ENT_QUOTES)."',
		game_Width = '".htmlspecialchars(makeSafe($_POST['cp_game_Width']), ENT_QUOTES)."',
		game_Height = '".htmlspecialchars(makeSafe($_POST['cp_game_Height']), ENT_QUOTES)."',
		game_Desc = '".htmlspecialchars(makeSafe($_POST['cp_game_Desc']), ENT_QUOTES)."' 
		WHERE game_ID = '".makeSafe($_POST['cp_game_ID'])."'";
		mysql_query($sql) or die(mysql_error());

		$_GET['cp_update_gameID'] = $_POST['cp_game_ID'];

		$cp_games_confirm = '1';

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

<?php if(!$_GET['cp_update_gameID']){?>

	<table class="table">
	<tr><td colspan="4"><b>Games Arcade</b></td></tr>
	<tr><td colspan="4">&nbsp;</td></tr>

	<tr><td width="10">ID</td><td width="70">Game</td><td>Description</td><td width="70" align="center">&nbsp;</td></tr>

	<?php

	// define loop
	$cols = 5; // set columns 
	$l = 1; // sets loop for columns 

	// get games data
	$tmp=mysql_query("SELECT * FROM ".$CONFIG['mysql_prefix']."games");
	while($i=mysql_fetch_array($tmp)) 
	{

		$new_Width = $i['game_Width'] + 18;
		$new_Height = $i['game_Height'] + 18
		
		?>

		<tr>
		<td width="10">
			<?php echo $i['game_ID'];?>
		</td>
		<td width="70">
			<a href="javascript:void(0);" onClick="window.open('../games/play.php?id=<?php echo ($i['game_ID']);?>','play_game','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=<?php echo $new_Width;?>,height=<?php echo $new_Height;?>,left=380,top=120');return false;">
			<img src="../games/images/<?php echo ($i['game_Thumb']);?>" width="70" height="60" alt="<?php echo htmlspecialchars($i['game_Desc']);?>" title="<?php echo htmlspecialchars($i['game_Desc']);?>">
		</a>
		</td>
		<td>
			<?php echo htmlentities($i['game_Desc']);?>
		</td>
		<td width="70" align="center">

			[<a href="games.php?cp_update_gameID=<?php echo $i['game_ID'];?>">Edit</a>]

		</td>
		</tr>

	<?php } ?>

	</table>
	<br><br>

<?php } ?>

<?php if($_GET['cp_update_gameID']){

	// get games data
	$tmp=mysql_query("SELECT * FROM ".$CONFIG['mysql_prefix']."games WHERE game_ID = '".makeSafe($_GET['cp_update_gameID'])."'");
	while($i=mysql_fetch_array($tmp)) 
	{

		$cp_game_ID = $i['game_ID'];
		$cp_game_swfFile = $i['game_SwfFile'];
		$cp_game_Name = $i['game_Name'];
		$cp_game_Thumb = $i['game_Thumb'];
		$cp_game_Width = $i['game_Width'];
		$cp_game_Height = $i['game_Height'];
		$cp_game_Desc = $i['game_Desc'];


		// make adjustments for popup window
		$new_Width = $i['game_Width'] + 18;
		$new_Height = $i['game_Height'] + 18;

	}

?>

	<table class="table">
	<form action="games.php" method="post" name="cp_games_form"></td></tr>
	<input type="hidden" name="cp_game_ID" value="<?php echo $cp_game_ID;?>">

	<tr><td colspan="3"><b>Edit Games Arcade</b></td></tr>
	<tr><td colspan="3">&nbsp;</td></tr>

	<?php if($cp_games_confirm){?>

		<tr><td colspan="3"><font color="green">Success, Game has been updated.</font></b></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>

	<?php }?>

	<tr><td colspan="3">

		<a href="javascript:void(0);" onClick="window.open('../games/play.php?id=<?php echo $cp_game_ID;?>','play_game','toolbar=0,location=0,directories=0,status=0,menubar=0,scrollbars=0,resizable=1,width=<?php echo $new_Width;?>,height=<?php echo $new_Height;?>,left=380,top=120');return false;">
		<img src="../games/images/<?php echo $cp_game_Thumb;?>" width="70" height="60" alt="<?php echo htmlspecialchars($cp_game_Desc);?>" title="<?php echo htmlspecialchars($cp_game_Desc);?>">

	</td></tr>

	<tr><td colspan="3">&nbsp;</td></tr>

	<tr><td>Game ID:</td><td colspan="2"><?php echo $cp_game_ID?></td></tr>
	<tr><td>Game Name:</td><td colspan="2"><input type="text" name="cp_game_Name" value="<?php echo $cp_game_Name;?>"></td></tr>
	<tr><td>Game Desc:</td><td colspan="2"><textarea rows="3" cols="20" name="cp_game_Desc"><?php echo $cp_game_Desc;?></textarea></td></tr>
	<tr><td>Screen Width:</td><td colspan="2"><input type="text" name="cp_game_Width" value="<?php echo $cp_game_Width;?>">px</td></tr>
	<tr><td>Screen Height:</td><td colspan="2"><input type="text" name="cp_game_Height" value="<?php echo $cp_game_Height;?>">px</td></tr>
	<tr><td>Game Image:</td><td colspan="2"><input type="text" name="cp_game_Thumb" value="<?php echo $cp_game_Thumb;?>"> Folder: <i>games/images/</i></td></tr>
	<tr><td>SWF Url:</td><td colspan="2"><input type="text" name="cp_game_swfFile" value="<?php echo $cp_game_swfFile;?>"> Folder: <i>games/swf/</i></td></tr>
	<tr><td>&nbsp;</td><td colspan="2"><input type="submit" name="cp_game_update" value="Update"></td></tr>

	</form>
	</table>

<?php } ?>

<br><br>


</body>
</html>