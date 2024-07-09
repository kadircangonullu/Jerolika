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

// if no session, die

if(!$_SESSION['username']){

	die('please login to access this page');

}

// pay via credits

$credit_info = '';

if($_GET['payment'] == 'credits')
{
	$credit_info = '<span style="color:red;">Sorry, you do not have enough credits. <br>[ <a href="shop/credits.php">Purchase Credits</a> ]</span>';

	if($_GET['option'] == '1' && $CONFIG['package_1_credits'] <= getCredits())
	{
		payByCredits('2',$_GET['option'],$_SESSION['username']);

		$credit_info = '<span style="color:green;">Thank you for your payment! <br>Your room users package has been upgraded.</span>';
	}

	if($_GET['option'] == '2'  && $CONFIG['package_2_credits'] <= getCredits())
	{
		payByCredits('2',$_GET['option'],$_SESSION['username']);

		$credit_info = '<span style="color:green;">Thank you for your payment! <br>Your room users package has been upgraded.</span>';
	}

	if($_GET['option'] == '3'  && $CONFIG['package_3_credits'] <= getCredits())
	{
		payByCredits('2',$_GET['option'],$_SESSION['username']);

		$credit_info = '<span style="color:green;">Thank you for your payment! <br>Your room users package has been upgraded.</span>';
	}

}

if($_POST && $_POST['packageID'] && is_numeric($_POST['packageID'])){

	if($_POST['packageID']=='1'){

		$packageID_cost = $CONFIG['package_1_cost'];
		$packageID_users = $CONFIG['package_1_users'];
	}

	if($_POST['packageID']=='2'){

		$packageID_cost = $CONFIG['package_2_cost'];
		$packageID_users = $CONFIG['package_2_users'];
	}

	if($_POST['packageID']=='3'){

		$packageID_cost = $CONFIG['package_3_cost'];
		$packageID_users = $CONFIG['package_3_users'];
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

	?>

	<body onLoad="document.upgradeRoom.submit();">

	<form action="<?php echo $paypal_url;?>/cgi-bin/webscr" method="post" name="upgradeRoom">

		<!-- set subscription -->
		<input type="hidden" name="cmd" value="_xclick-subscriptions">

		<!-- set payment details -->
		<input type="hidden" name="business" value="<?php echo $CONFIG['paypal_email'];?>">
		<input type="hidden" name="item_name" value="Upgrade Room (<?php echo $_SESSION['username'];?>) - <?php echo $packageID_users;?> Users">
		<input type="hidden" name="item_number" value="<?php echo $_POST['packageID'];?>">

		<!-- set the terms of the regular subscription. -->
		<input type="hidden" name="currency_code" value="<?php echo $CONFIG['currency_value'];?>">
		<input type="hidden" name="a3" value="<?php echo $packageID_cost;?>">
		<input type="hidden" name="p3" value="1">
		<input type="hidden" name="t3" value="M">

		<!-- misc data required by paypal -->
		<input type="hidden" name="src" value="1">
		<input type="hidden" name="sra" value="1">
		<input type="hidden" name="no_shipping" value="1">

		<!-- set IPN return url -->
		<input type="hidden" name="notify_url" value="<?php echo $CONFIG['chatroom_url'];?>/IPN/process.php">  

		<!-- custom value -->
		<input type="hidden" name="custom" value="<?php echo $_SESSION['username'];?>|<?php echo $packageID_cost;?>">  

	</form>

<?php die; }?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title><?php echo $CONFIG['chatroom_title']?></title>
<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CONFIG['brower_char'];?>" />

<style>
.body {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
background-image: url('images/logo.jpg');
background-repeat: repeat;
}

.table {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #333333;

}

a:link {text-decoration: none; color: #CCCCCC;}
a:visited {text-decoration: none; color: #CCCCCC;}
a:active {text-decoration: none; color: #CCCCCC;}
a:hover {text-decoration: underline; color: #CCCCCC;}
</style>

<script language="" type="">
<!--
function creditPayment(id)
{
	window.location = '?do=upgrade&payment=credits&option='+id;
}
// -->
</script>

</head>
<body class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<br>

<table class="table" align="center" width="450px" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="images/border.png"></td></tr>
</table>

<table class="table" align="center" width="450px" cellpadding="2" cellspacing="0" border="0">
<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" height="100" align="center"><td><img src="images/mini_logo.png"></td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" align="center"><td><b>Upgrade Your Room</b></td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>

<?php if($credit_info){?>
	<tr colspan="2" align="center"><td><?php echo $credit_info;?></td></tr>
	<tr colspan="2"><td>&nbsp;</td></tr>
<?php }?>

<tr colspan="2" align="center"><td>
<form action="index.php?do=upgrade" name="pID_1" method="post">
<b>Upgrade To <?php echo $CONFIG['package_1_users'];?> Room Users<br>
Cost: <?php echo $CONFIG['currency_sign'];?><?php echo $CONFIG['package_1_cost'];?> per month</b><br><br>
<input type="hidden" name="packageID" value="1">
<input type="image" src="images/paypal_subscribe.gif" alt="Subscribe" title="Subscribe">
<br>
</form>
</td></tr>
<tr colspan="2" align="center"><td><input type="checkbox" value="1" name="credits" onclick="creditPayment('1')">Pay With Your Credits! (cost: <?php echo $CONFIG['package_1_credits'];?> credits)</td></tr>

<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" align="center"><td>
<form action="index.php?do=upgrade" name="pID_2" method="post">
<b>Upgrade To <?php echo $CONFIG['package_2_users'];?> Room Users<br>
Cost: <?php echo $CONFIG['currency_sign'];?><?php echo $CONFIG['package_2_cost'];?> per month</b><br><br>
<input type="hidden" name="packageID" value="2">
<input type="image" src="images/paypal_subscribe.gif" alt="Subscribe" title="Subscribe">
<br>
</form>
</td></tr>
<tr colspan="2" align="center"><td><input type="checkbox" value="2" name="credits" onclick="creditPayment('2')">Pay With Your Credits! (cost: <?php echo $CONFIG['package_2_credits'];?> credits)</td></tr>

<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" align="center"><td>
<form action="index.php?do=upgrade" name="pID_3" method="post">
<b>Upgrade To <?php echo $CONFIG['package_3_users'];?> Room Users<br>
Cost: <?php echo $CONFIG['currency_sign'];?><?php echo $CONFIG['package_3_cost'];?> per month</b><br><br>
<input type="hidden" name="packageID" value="3">
<input type="image" src="images/paypal_subscribe.gif" alt="Subscribe" title="Subscribe">
<br>
</form>
</td></tr>
<tr colspan="2" align="center"><td><input type="checkbox" value="3" name="credits" onclick="creditPayment('3')">Pay With Your Credits! (cost: <?php echo $CONFIG['package_3_credits'];?> credits)</td></tr>

<tr colspan="2"><td>&nbsp;</td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>
<tr colspan="2" align="center"><td>NOTE: Payment by credits is for 30 days upgrade only. <br>To renew your room users you must remember <br>to make your payment every 30 days.</td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>
<tr colspan="2" align="center"><td>How do i cancel my subscription? - [<a href="https://www.paypal.com/helpcenter/main.jsp?cmd=_help&t=solutionTab&solutionId=11750" target="_blank">click here</a>]</td></tr>
<tr colspan="2" align="center"><td>Please allow up to 24 hours for your room to be upgraded.</td></tr>
</table>

<table class="table" align="center" width="450px" cellpadding="0" cellspacing="0" border="0">
<tr><td><img src="images/border.png"></td></tr>
</table>

</body>
</html>