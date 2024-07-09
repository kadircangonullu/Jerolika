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
	$credit_info = '<span style="color:red;">Uzgunum bakiyenizde yeterli lika yokmus.<br> <a href="shop/credits.php"></a> </span>';

	if($CONFIG['vip_credits'] <= getCredits())
	{
		payByCredits('1','1',$_SESSION['username']);

		$credit_info = '<span style="color:green;">Tebrikler, artik elmas kart sahibisiniz.<br>VIP card ozelliklerini kullanmaya baslayabilirsiniz.</span>';
	}

}

// pay via paypal

if($_POST && $_POST['vipID'] && is_numeric($_POST['vipID'])){

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

	<body onLoad="document.upgradeUsr.submit();">

	<form action="<?php echo $paypal_url;?>/cgi-bin/webscr" method="post" name="upgradeUsr">

		<blockquote>
		  <p>
		    <!-- set subscription -->
		    <input type="hidden" name="cmd" value="_xclick-subscriptions">
		    
		    <!-- set payment details -->
		    <input type="hidden" name="business" value="<?php echo $CONFIG['paypal_email'];?>">
		    <input type="hidden" name="item_name" value="Upgrade VIP">
		    <input type="hidden" name="item_number" value="vip">
		    
		    <!-- set the terms of the regular subscription. -->
		    <input type="hidden" name="currency_code" value="<?php echo $CONFIG['currency_value'];?>">
		    <input type="hidden" name="a3" value="<?php echo $CONFIG['vip_membership'];?>">
		    <input type="hidden" name="p3" value="1">
		    <input type="hidden" name="t3" value="M">
		    
		    <!-- misc data required by paypal-->
		    <input type="hidden" name="src" value="1">
		    <input type="hidden" name="sra" value="1">
		    <input type="hidden" name="no_shipping" value="1">
		    
		    <!-- set IPN return url -->
		    <input type="hidden" name="notify_url" value="<?php echo $CONFIG['chatroom_url'];?>/IPN/process.php">  
		    
		    <!-- custom value -->
		    <input type="hidden" name="custom" value="<?php echo $_SESSION['username'];?>|<?php echo $CONFIG['vip_membership'];?>">  
		    
	      </p>
	  </blockquote>
	</form>

<?php die; }?>

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Strict//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-strict.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<title>VIP CARD</title>
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
function creditPayment()
{
	window.location = '?do=vip&payment=credits';
}
// -->
</script>

</head>
<body class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">
<br>
<table class="table" align="center" width="450px" cellpadding="2" cellspacing="0" border="0">
  <tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" height="100" align="center"><td><img src="images/mini_logo.png" alt="" width="596" height="149" /></td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" align="center">
  <td><b>Diamond VIP Card</b></td></tr>
<tr colspan="2"><td>&nbsp;</td></tr>

<tr colspan="2" align="center"><td>
<form action="Greenleos/templates/index.php?do=vip" name="vipID_1" method="post">
  <p>Ozellikler</p>
  <p>Birine Mesaj atma<br>
    Ev ziyareti yapma<br>
    Ýsminin sari gozukmesi<br>
    Yakinda gelecek olan diamond clube uye olma<br>
  </p>
</form>
</td></tr>
<tr colspan="2" align="center">
  <td><p><img src="images/card.png" alt="" width="89" height="56" /></p>
    <p>SATIN AL(10.000 LIKA)
      <input type="checkbox" value="1" name="credits" onClick="creditPayment()" />
  </p></td></tr>
<tr colspan="2"><td></td></tr>

<?php if($credit_info){?>
	<tr colspan="2" align="center"><td><?php echo $credit_info;?></td></tr>
	<tr colspan="2"><td>&nbsp;</td></tr>
<?php }?>

<tr colspan="2"><td>&nbsp;</td></tr>
<tr colspan="2" align="center"><td>&nbsp;</td></tr>

<tr colspan="2" height="80"><td>&nbsp;</td></tr>
<tr colspan="2" align="center"><td></td></tr>
</table>
	</html>