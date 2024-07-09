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

// if no session, die

	if(!$_SESSION['username']){

		die('please login to access this page');

	}

// is test mode?

	if($CONFIG['paypal_sandbox_mode'])
	{
		$paypal_url = 'https://www.sandbox.paypal.com';
	}
	else
	{
		$paypal_url = 'https://www.paypal.com';
	}

// if post

	if($_POST && $_POST['vCredits'] && is_numeric($_POST['vCredits'])){

		// cost of total credits
		$totalCost = (($_POST['vCredits'] / $CONFIG['credits_package']) * $CONFIG['credits_cost']);

		?>

		<body onLoad="document.buyCredits.submit();">

		<form action="<?php echo $paypal_url;?>/cgi-bin/webscr" method="post" name="buyCredits">

			<!-- set payment details -->
			<input type="hidden" name="cmd" value="_xclick">
			<input type="hidden" name="business" value="<?php echo $CONFIG['paypal_email'];?>">
			<input type="hidden" name="currency_code" value="<?php echo $CONFIG['currency_value'];?>">
			<input type="hidden" name="item_name" value="<?php echo $_POST['vCredits'];?> Credits (<?php echo $_SESSION['username'];?>)">
			<input type="hidden" name="item_number" value="credits">
			<input type="hidden" name="amount" value="<?php echo $totalCost;?>">

			<!-- set IPN return url -->
			<input type="hidden" name="notify_url" value="<?php echo $CONFIG['chatroom_url'];?>/IPN/process.php">  

			<!-- custom value -->
			<input type="hidden" name="custom" value="<?php echo $_SESSION['username'];?>|<?php echo $_POST['vCredits'];?>">  

		</form>

		<?php 

		die; 
	}

// no credits error

	$creditsError = '';

	if($_POST && !is_numeric($_POST['vCredits']))
	{
		$creditsError = 'Please enter a credit amount';
	}

// include header

	include("templates/header.php");

?>

	<table class="table" align="center" width="760" cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="images/border.png" width="760"></td></tr>
	</table>

	<table class="table" align="center" width="760" cellpadding="2" cellspacing="0" border="0">
	<tr colspan="2"><td>&nbsp;</td></tr>

	<tr colspan="2" height="100" align="center"><td><img src="../images/mini_logo.png"></td></tr>
	<tr colspan="2"><td>
	<b>:: <a href="index.php"><?php echo $CONFIG['chatroom_title'];?> - Virtual Shop</a> > <a href="account.php">My Account</a> > <a href="credits.php">Purchase Credits</a></b>
	</td></tr>

	<tr colspan="2"><td>&nbsp;</td></tr>

	<?php
	if($creditsError)
	{
		echo "<tr align='center' colspan='2'><td><font color='red'>".$creditsError."</font></td></tr>";	
	}
	?>

	<tr colspan="2" align="center"><td>
	<form action="credits.php" name="purchaseForm" method="post">
	Enter total credits you would like to purchase,<br><br>
	Credits: <input type="text" name="vCredits" value=""> (eg. 100)<br><br>
	<input type="image" src="../images/paypal_buynow.gif" alt="Subscribe" title="Subscribe">
	<br><br>
	Conversion Rate: <?php echo $CONFIG['credits_package'];?> Credits = <?php echo $CONFIG['credits_cost']." ".$CONFIG['currency_value'];?>
	</form>
	</td></tr>

	<tr colspan="2" height="80"><td>&nbsp;</td></tr>
	<tr colspan="2" align="center"><td>Please allow up to 24 hours for your account to be updated.</td></tr>
	</table>

	<table class="table" align="center" width="760" cellpadding="0" cellspacing="0" border="0">
	<tr><td><img src="images/border.png" width="760"></td></tr>
	</table>

	</body>
	</html>

	<?php include("templates/footer.php"); ?>