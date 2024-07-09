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

	if(!$_SESSION['username'])
	{
		header("Status: 200");
		header("Location: index.php");
		exit;
	}

// error reporting

	if($_REQUEST['search_item'] && @!_alpha_numeric($_REQUEST['search_item']) || $_REQUEST['search_item'] && @!$_REQUEST['search_item'][0]){

		die('Search Item Not AlphaNumeric');
	}

	if($_REQUEST['r'] && @!_numeric($_REQUEST['r']) || $_REQUEST['r'] && @!$_REQUEST['r'][0]){

		die('R Not Numeric');
	}

// delete item

	$itemDeleted = '';

	if($_REQUEST['del']=='1' && _numeric($_REQUEST['itemID']))
	{
		// delete item from user shop purchases
		$sql = "
			DELETE FROM ".$CONFIG['mysql_prefix']."shop_payments 
			WHERE purchase = '".makeSafe($_REQUEST['itemID'])."'
			AND username= '".$_SESSION['username']."'
			";
			mysql_query($sql) or die(mysql_error());

		$itemDeleted = '<b><font color="green">This item has now been deleted.</font></b>';	
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

// transfer credits

	$transfer_result = '0';
	$transfer_code = 'fail';

	if($_POST['transfer_credits'] && $_POST['transfer_username'])
	{
		// check credits are numeric

		if(_numeric($_POST['transfer_credits']))
		{
			// check username is valid
			if(!_alpha_numeric($_POST['transfer_username']))
			{
				// hmm, invalid characters in username? ;)
				// to be safe, lets say we cant find the user

				$userFound = '0';
			}
			else
			{
				// check user exists

				$userExists=mysql_query("
						SELECT username  
						FROM ".$CONFIG['mysql_prefix']."user 
						WHERE username = '".mysql_real_escape_string($_POST['transfer_username'])."' 
						LIMIT 1
						") or die(mysql_error()); 

				$userFound = mysql_num_rows($userExists);
			}

			if(strtolower($_POST['transfer_username']) == strtolower($_SESSION['username']))
			{
				$userFound = '0';
			}

			if($userFound)
			{
				// has user got enough credits to transfer?

				if($_SESSION['userCredits'] >= $_POST['transfer_credits'])
				{
					// transfer credits

					$sql="
						UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
						SET credits = credits + ".$_POST['transfer_credits']." 
						WHERE username ='".mysql_real_escape_string($_POST['transfer_username'])."' LIMIT 1";

					mysql_query($sql) or die(mysql_error());

					// update credits left for this user

					$sql="
						UPDATE ".$CONFIG['mysql_prefix']."shop_accounts 
						SET credits = credits - ".$_POST['transfer_credits']." 
						WHERE username ='".mysql_real_escape_string($_SESSION['username'])."' LIMIT 1";

					mysql_query($sql) or die(mysql_error());

					// update session

					$_SESSION['userCredits'] -= $_POST['transfer_credits'];

					// successful transfer

					$transfer_result = "Success, credits have been transfered!";
					$transfer_code = 'pass';
				}
				else
				{
					// not enough credits in account

					$transfer_result = 'You do not have enough credits for this transaction';
					$transfer_code = 'fail';
				}
	
			}
			else
			{
				if(strtolower($_POST['transfer_username']) == strtolower($_SESSION['username']))
				{
					// user is trying to transfer credits to themself

					$transfer_result = "You cannot transfer credits to yourself";
					$transfer_code = 'fail';
				}
				else
				{
					// username not found

					$transfer_result = 'Username cannot be found';
					$transfer_code = 'fail';
				}
			}

		}
		else
		{
			// invalid characters for credits
			// lets remind the user, credits should be a number

			$transfer_result = 'Credits must be a number';
			$transfer_code = 'fail';
		}

	}

// include header

	include("templates/header.php");

?>

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
	<b>:: <a href="index.php"><?php echo $CONFIG['chatroom_title'];?> - Virtual Shop</a> > <a href="account.php">My Account</a> <?php if($_REQUEST['transfer']){?> > <a href="account.php?transfer=1">Transfer Credits</a><?php }?></b>

	<br><br>

	<?php

	if($_SESSION['username'])
	{
		$shopWelcome = 'Hosgeldin '.$_SESSION['username'].', sen <b>'.$_SESSION['userCredits'].'</b> likaya sahipsin.</b> <a href="credits.php"></a>';
	}
	else
	{
		$shopWelcome = 'Welcome Guest, please login to purchase items.';
	}

	echo "".$shopWelcome."";

	?>

	<?php if(!$_REQUEST['transfer']){?>

		<br><br>

		<form name="search" method="post" action="index.php">
		<b>Search Shop Items</b>: <input type="text" name="search_item"><input type="submit" name="submit" value="Go!">
		</form>

		<br><br>

		<?php

		$wrapcols = 4;
		$limitResults  = 12;

		$r = $_REQUEST['r'];

		if(!$r)
		{
			$r = 0;
		}

		$tmp = "
			SELECT *      
			FROM ".$CONFIG['mysql_prefix']."shop_payments, ".$CONFIG['mysql_prefix']."shop 
			WHERE ".$CONFIG['mysql_prefix']."shop_payments.purchase = ".$CONFIG['mysql_prefix']."shop.id 
			AND ".$CONFIG['mysql_prefix']."shop_payments.username = '".$_SESSION['username']."'
			ORDER BY ".$CONFIG['mysql_prefix']."shop.id DESC 
			LIMIT ".$r.", ".$limitResults."  
			";

		$tmp = mysql_query($tmp) or die(mysql_error());

		$title="My Purchased Items";

		$result_rows = mysql_num_rows($tmp); 

		$row = mysql_fetch_array($tmp);

		$count=1;

		if($itemDeleted)
		{
			echo $itemDeleted."<br><br>";
		}

		if(!$result_rows)
		{
			echo "You have no items in your inventory. [<a href='index.php'>Lets Go Shopping!</a>]";
		}
		else
		{

			echo "<b>:: ".$title."</b>";
			echo "<br><br>";

			echo "<table width='100%' border='0'><tr>";
			do { 

				if($row['section'] == 2)
				{
					// backgrounds
					$imgWidth = '150';
					$imgHeight = '100';
					$info = 'copy &amp; paste the code below<br>into the Room Creator';
				}
				else
				{
					// avatars
					$imgWidth = '100';
					$imgHeight = '200';
				}

				if ($count==$wrapcols) { 

					$html="</tr><tr>"; 
					$count=0;

				}else{ 

					$html="";
				}

				echo "<td align='center' style='width:".$imgWidth."px;height:".$imgHeight."px;background: url(../".$row['image'].") top center no-repeat;'>"; 
				echo "<image src='../avatars/nopic.png' width='".$imgWidth."' height='".$imgHeight."'><br>"; 
				echo "<b>".$row['item']."</b><br>"; 
				echo $row['description']."<br>"; 
				echo "Credits: ".$row['cost']."<br>"; 
				echo "[<a href='account.php?del=1&itemID=".$row['id']."&search_item=".$_REQUEST['search_item']."&r=".$r."'>Delete Item</a>]<br>"; 
				echo "<br>"; 

				if($row['section'] == 2)
				{
					echo "<span style='font-size:10px;'>".$info."</span><br>";
					echo "<input style='text-align:center;width:160px;height:16px;border-style:solid;border-color:#666666;border-width:1px;background-color:#CCCCCC;' type='text' name='url' value='".$row['image']."'><br><br>"; 
				}

				echo"</td>";
 
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

		$tmp = mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop_payments
			WHERE username ='".$_SESSION['username']."'
			") or die (mysql_error());

		$num_rows = mysql_num_rows($tmp); 

		$last = $r - $limitResults;
		$next = $r + $limitResults;

		if($num_rows <= $limitResults)
		{
			echo "Displaying ".$num_rows." of " .$num_rows. " Results";
		}
		else
		{
			if($next > $num_rows)
			{
				$next = $num_rows;
			}

			echo "Displaying ".$next." of " .$num_rows. " Results";
		}

		echo "<br><br>";

		if($last >= 0)
		{
			echo "<a href='account.php?search_item=".$_REQUEST['search_item']."&r=".$last."'><< Last</a>";
		}

		if($last >= 0 && $next < $num_rows)
		{
			echo " | ";
		}

		if($next < $num_rows)
		{
			echo "<a href='account.php?search_item=".$_REQUEST['search_item']."&r=".$next."'>Next >></a>";
		}

		?>

	<?php }?>

	<?php if($_REQUEST['transfer']){?>

		<br><br>

		<form name="transfer" method="post" action="account.php?transfer=1">
		<b>Lika Dagitim Paneli</b>: <br>
		Bir admin burada lika verebilir
		<br><br>

		<?php 
			if($transfer_result)
			{

				if($transfer_code == 'pass')
				{
					echo "<span style='color:green'>";
				}
				else
				{
					echo "<span style='color:red'>";
				}
				
				echo $transfer_result;
				echo "</span>";
				echo "<br><br>";
			}
		?>

		Kisi Adi: <input type="text" name="transfer_username">
		Lika Miktari: <input type="text" name="transfer_credits"><input type="submit" name="submit" value="Yolla bakiyim!">
		</form>

		<br><br>

	<?php }?>

	<br><br>

	</td>
	</tr>
	</table>

	<table align="center" width="760px" cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="images/border.png" width="760px"></td></tr>
	</table>

	<?php include("templates/footer.php"); ?>