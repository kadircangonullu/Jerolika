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

// error reporting

	if($_REQUEST['search_item'] && @!_alpha_numeric($_REQUEST['search_item']) || $_REQUEST['search_item'] && @!$_REQUEST['search_item'][0]){

		die('Search Item Not AlphaNumeric');
	}

	if($_REQUEST['r'] && @!_numeric($_REQUEST['r']) || $_REQUEST['r'] && @!$_REQUEST['r'][0]){

		die('R Not Numeric');
	}

// buy item

	$purchaseResult = '';

	if($_REQUEST['purchase'])
	{
		// check user has enough credits
		$tmp=mysql_query("
				SELECT credits 
				FROM ".$CONFIG['mysql_prefix']."shop_accounts 
				WHERE username = '".$_SESSION['username']."'
				");

		while($i=mysql_fetch_array($tmp)) 
		{
			if($i['credits'] < $_REQUEST['cost'])
			{
				$purchaseResult = "<font color='red'>Uzgunum, yeterince likaniz yok.</font>";
			}
			else
			{
				// add purchase to database
				$sql = "
					INSERT INTO ".$CONFIG['mysql_prefix']."shop_payments
					(
						username,
						purchase, 
						credits			
					) 
					VALUES 
					(
						'".htmlspecialchars(makeSafe($_SESSION['username']), ENT_QUOTES)."',
						'".htmlspecialchars(makeSafe($_REQUEST['itemID']), ENT_QUOTES)."',
						'".htmlspecialchars(makeSafe($_REQUEST['cost']), ENT_QUOTES)."'
					)

				";mysql_query($sql) or die(mysql_error());


				// update credits
				$sql = "
					UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
					SET 
					credits = credits - ".makeSafe($_REQUEST['cost'])."
					WHERE username = '".makeSafe($_SESSION['username'])."'

				";mysql_query($sql) or die(mysql_error());

				$purchaseResult = "<font color='green'>Tebrikler, satin aldiniz</font>";
			}
		}

	}

// get users credits

	$tmp=mysql_query("
			SELECT credits 
			FROM ".$CONFIG['mysql_prefix']."shop_accounts 
			WHERE username = '".$_SESSION['username']."'
			");

	while($i=mysql_fetch_array($tmp)) 
	{
		$_SESSION['userCredits'] = $i['credits'];
	}

// include header

	include("templates/header.php");

?>
<title>Market</title>

<table class="table" align="center" width="760px" cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="images/border.png" width="760px"></td></tr>
	</table>

	<table class="table" align="center" width="760px" cellpadding="2" cellspacing="0" border="0">
	<tr colspan="2"><td>&nbsp;</td></tr>
	<tr colspan="2">
	<td valign="top" width="10%" align="center"><img src="../images/mini_logo.png" border="0"></td>
	</tr>
	<tr colspan="2">
	<td valign="top" width="90%">
	<b> <a href="index.php"><?php echo $CONFIG['chatroom_title'];?> - Jerolika market</a></b>

	<?php

	if($_SESSION['username'])
	{
		echo '<a href="account.php"></a>]&nbsp;[<a href="account.php?transfer=1"></a>';
	}

	?>

	<br><br>

	<?php

	if($_SESSION['username'])
	{

		$shopWelcome = 'Hosgeldin '.$_SESSION['username'].', senin <b>'.$_SESSION['userCredits'].'</b> likan var.</b> [<a href="credits.php"></a>]';
	}
	else
	{
		$shopWelcome = 'Hosgeldin ziyaretci, lutfen [<a href="../index.php">giris</a>] butona basarak giris yapin.';
	}

	echo "".$shopWelcome."";

	?>

	<br><br>

	<br><br>

	<?php if($purchaseResult){echo "<b>".$purchaseResult."</b><br><br>";}?>

	<?php

	$wrapcols = 6;
	$limitResults  = 12;

	$r = $_REQUEST['r'];

	if(!$r){
		$r = 0;
	}

	if(!$_REQUEST['search_item']){

		$tmp = mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE featured ='1' 
			ORDER BY id DESC 
			LIMIT ".$r.", ".$limitResults." 
			") or die (mysql_error());

		$title="Esyalar :";

	}

	if($_REQUEST['search_item']){

		$tmp = mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE description LIKE '%".makeSafe($_REQUEST['search_item'])."%'
			OR item LIKE '%".makeSafe($_REQUEST['search_item'])."%' 
			ORDER BY id DESC 
			LIMIT ".$r.", ".$limitResults."  
			") or die (mysql_error());

		$title="Search Results";

	} 

	$result_rows = mysql_num_rows($tmp); 

	$row = mysql_fetch_array($tmp);

	$count=1;

	echo "<b> ".$title."</b>";
	echo "<br><br>";

	if(!$result_rows)
	{
		echo "Su anlik markette esya yok.";
	}
	else
	{
		echo "<table align='center' border='0'><tr>";
		do { 

			if($row['section'] == 2)
			{
				// backgrounds
				$imgWidth = '150';
				$imgHeight = '100';
			}
			else
			{
				// avatars
				$imgWidth = '100';
				$imgHeight = '200';
			}

			if ($count==$wrapcols) { 

				$html="</tr><tr align=center>"; 
				$count=0;

			}else{ 
				$html="";
			}

			echo "<td align='center' style='width:".$imgWidth."px;height:".$imgHeight."px;background: url(../".$row['image'].") top center no-repeat;'>"; 
			echo "<image src='../avatars/nopic.png' width='".$imgWidth."' height='".$imgHeight."'><br>"; 
			echo "<b>".$row['item']."</b><br>"; 
			echo $row['description']."<br>"; 
			echo "Lika: ".$row['cost']."<br>"; 
			echo "[<a href='index.php?purchase=1&itemID=".$row['id']."&cost=".$row['cost']."&r=".$r."&search_item=".$_REQUEST['search_item']."'>Satin al</a>]"; 
			echo "<br><br></td>";
 
			echo $html;

			$count++;
		}

		while ($row = mysql_fetch_array($tmp));
		echo "</table>";
	}

	?>

	</td>
	</tr>
	<tr colspan="2">
	<td valign="top" width="90%" align="center">

	<br><br>

	<?php 

	if(!$_REQUEST['search_item']){

		$tmp = mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE featured ='1'
			") or die (mysql_error());

	}

	if($_REQUEST['search_item']){

		$tmp = mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE description LIKE '%".makeSafe($_REQUEST['search_item'])."%'
			") or die (mysql_error());
	}

	$num_rows = mysql_num_rows($tmp); 

	$last = $r - $limitResults;
	$next = $r + $limitResults;

	if($num_rows <= $limitResults){

		echo "Displaying ".$num_rows." of " .$num_rows. " Results";

	}else{

		if($next > $num_rows){$next = $num_rows;}

		echo "".$next."/" .$num_rows. "";
	}

	echo "<br><br>";


	if($last >= 0){

		echo "<a href='index.php?search_item=".$_REQUEST['search_item']."&r=".$last."'><< Geri</a>";
	}

	if($last >= 0 && $next < $num_rows){

		echo " | ";
	}

	if($next < $num_rows){

		echo "<a href='index.php?search_item=".$_REQUEST['search_item']."&r=".$next."'>Ileri >></a>";
	}

	?>

	<br><br>

	</td>
	</tr>
	</table>

	<table align="center" width="760px" cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="images/border.png" width="760px"></td></tr>
	</table>

	<?php include("templates/footer.php"); ?>