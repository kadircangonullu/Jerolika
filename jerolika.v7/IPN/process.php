<?php

// set PHP error reporting
error_reporting(E_ERROR | E_WARNING | E_PARSE);

// include files
include("../includes/config.php");

// read the post from PayPal system and add 'cmd'
$req = 'cmd=_notify-validate';

foreach ($_POST as $key => $value) 
{
	$value = urlencode(stripslashes($value));
	$req .= "&$key=$value";
}

// post back to PayPal system to validate
$header = "POST /cgi-bin/webscr HTTP/1.0\r\n";
$header .= "Content-Type: application/x-www-form-urlencoded\r\n";
$header .= "Content-Length: " . strlen($req) . "\r\n\r\n";

// paypal or sandbox url?
if($CONFIG['paypal_sandbox_mode'])
{
	$fp = fsockopen ('ssl://www.sandbox.paypal.com', 443, $errno, $errstr, 30);
}
else
{
	$fp = fsockopen ('ssl://www.paypal.com', 443, $errno, $errstr, 30);
}

// assign posted variables to local variables
$item_name = $_POST['item_name'];
$item_number = $_POST['item_number'];
$payment_status = $_POST['payment_status'];
$payment_amount = $_POST['mc_gross'];
$payment_currency = $_POST['mc_currency'];
$txn_id = $_POST['txn_id'];
$receiver_email = $_POST['receiver_email'];
$payer_email = $_POST['payer_email'];

$custom = $_POST['custom'];
$custom = explode("|", $custom);

// set default payment status
$result = 'fail';

if (!$fp) 
{
	// HTTP ERROR
} 
else 
{
	fputs ($fp, $header . $req);
	while (!feof($fp)) 
	{
		$res = fgets ($fp, 1024);
		if (strcmp ($res, "VERIFIED") == 0) 
		{
			// check the payment_status is Completed
			if(
				$_POST['payment_status'] == 'Completed' &&
				$_POST['receiver_email'] == $CONFIG['paypal_email'] &&
				$_POST['mc_currency'] == $CONFIG['currency_value']
			)
			{
				$result = 'pass';
				$reason = 'SUCCESS';
			}

			if($result == 'pass')
			{
				// include files
				include("../includes/conn.php");
				include("../includes/db.php");
				include("../includes/functions.php");

				// purchase credits
				if($_POST['item_number'] == 'credits')
				{
					payByPaypal('3',$custom[1],$custom[0],'');
				}

				// upgrade to VIP
				if($_POST['item_number'] == 'vip')
				{
					payByPaypal('1','1',$custom[0],$_POST['subscr_id']);
				}

				// upgrade room users
				if($_POST['item_number'] == '1' || $_POST['item_number'] == '2' || $_POST['item_number'] == '3')
				{
					payByPaypal('2',$_POST['item_number'],$custom[0],$_POST['subscr_id']);
				}

				// cancel payment

				if($_POST['txn_type'] == 'subscr_cancel')
				{
					payByPaypalCancel($_POST['subscr_id']);
				}

			}
			else
			{
				$result = 'fail';
				$reason = 'INCORRECT POST VALUES';
			}

		}
		else if (strcmp ($res, "INVALID") == 0) 
		{
			$result = 'fail';
			$reason = 'INVALID CALLBACK';
		}

	}

	fclose ($fp);

	// log error and test payments

	if($result == 'fail' || $CONFIG['paypal_sandbox_mode']) 
	{
		// create data string

		$stringData  ="IPN Result: ".$result." (".$reason.")\n";
		$stringData .="Item Name: ".$_POST['item_name']."\n";
		$stringData .="Item Number: ".$_POST['item_number']."\n";
		$stringData .="Payment Status: ".$_POST['payment_status']."\n";
		$stringData .="MC Gross: ".$_POST['mc_gross']."\n";
		$stringData .="MC Currency: ".$_POST['mc_currency']."\n";
		$stringData .="TXN ID: ".$_POST['txn_id']."\n";
		$stringData .="Receiver Email: ".$_POST['receiver_email']."\n";
		$stringData .="Payer Email: ".$_POST['payer_email']."\n";
		$stringData .="Username: ".$_POST['custom']."\n";
		$stringData .="Subscr ID: ".$_POST['subscr_id']."\n";
		$stringData .="TXN Type: ".$_POST['txn_type']."\n";

		// save to log file

		$myFile = "log.txt";
		$fh = fopen($myFile, 'w') or die("can't open file");
		fwrite($fh, $stringData);
		fclose($fh);
	}

}


?>
