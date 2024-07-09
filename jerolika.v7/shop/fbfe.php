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
				$purchaseResult = "<font color='red'>Üzgünüm,Paranız Yetmiyor.</font>";
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

				$purchaseResult = "<font color='green'>Başarıyla Satın Aldınız.Marketten Çıkıp F5 Yani Sayfayı Yenileyiniz !</font>";
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
 <style>.searchf{border:1px solid rgb(219,184,108);background:rgb(255,243,211);font-family:Trebuchet MS;padding:5px;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;color:rgb(202,160,67);outline:none!important;}.searchButton{position:absolute;background:url('images/searchbutton.png');border:none;outline:none!important;width:57px;height:22px;cursor:pointer;top:7px;left:130px;}.goLeft{position:absolute;left:3px;top:6px;cursor:pointer;}.goRight{position:absolute;right:3px;top:6px;cursor:pointer;}.searchb{border:1px solid rgb(180,180,180);background:rgb(241,241,241);font-family:Trebuchet MS;padding:5px;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;color:rgb(168,168,168);cursor:pointer;}.footer{position:absolute;z-index:1;background:#F8D15F;width:496px;height:40px;margin-top:-40px;}.searchForm{color:#C39E3F;border:1px solid #DCDCDC;background:#FFF;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;font-family:Trebuchet MS;padding:5px;outline:none!important;position:absolute;top:4px;height:16px;font-size:11px;}.resetButton{width:17px;height:16px;position:absolute;z-index:2;background:url('images/sifirla.png');top:348px;left:123px;}.pageNumbers{position:absolute;z-index:2;bottom:117px;left:234px;width:90px;height:22px;color:#C39E3F;border:1px solid #DCDCDC;background:#FFF;-webkit-border-radius:10px;-moz-border-radius:10px;border-radius:10px;text-align:center;padding-top:5px;font-family:Trebuchet MS;cursor:default;}.spanMini{position:absolute;top:4px;horizontal-align:middle;}</style>
<script language="javascript" type="text/javascript">
	<!--
	if(window.location == top.location)
	{
		window.location.href="../index.html";
	}
	// -->
	</script>
<script type="text/javascript" src="http://ajax.googleapis.com/ajax/libs/jquery/1.4.2/jquery.min.js"></script>
<script type="text/javascript" src="colortip-1.0/colortip-1.0-jquery.js"></script>
<script type="text/javascript" src="script.js"></script>
<link rel="stylesheet" type="text/css" href="colortip-1.0/colortip-1.0-jquery.css"/>
<body style="font-size: 11px;font-family:Tahoma;margin: 0px;" oncontextmenu="return false" ondragstart="return false">
<div style="background: url('images/fbfe_bg.png');width: 496px;height: 375px;">
<div style="position: absolute;z-index:2;margin-top: 338px;margin-left: 22px;">
<form name="search" method="post" action="fbfe.php">
<input type="text" class="searchForm" name="search_item" placeholder="Aranacak Ürünü Yaz"><input type="submit" class="searchButton" name="submit" value="">
</form></div>
<div style="float: right;margin-left: 325px;margin-top: 21px;position: absolute;width: 147px;word-wrap: break-word;"><font color="red">Fatih:</font> Hoşgeldin<br>
  Kahvaltılık Yiyecekler Bende !</div>
<div style="position: absolute;margin-left: 379px;margin-top: 233px;">
</div>
<table class="table" cellpadding="2" cellspacing="0" border="0" style="padding-top: 7px;">
<tr colspan="2">
<td valign="top" width="90%">
<table align='center' border='0'><tr><tr align=center><td align='center'><div id='itemurun' title='200 KO'><image src='../avatars/09.png'><br><a href='fbfe.php?purchase=1&itemID=175&cost=1270&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='250 KO'><image src='../avatars/male/kiyafet/217.png'><br><a href='fbfe.php?purchase=1&itemID=97952&cost=250&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='450 KO'><image src='../avatars/male/kiyafet/216.png'><br><a href='fbfe.php?purchase=1&itemID=97951&cost=450&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td></tr><td align='center'><div id='itemurun' title='300 KO'><image src='../avatars/male/kiyafet/215.png'><br><a href='fbfe.php?purchase=1&itemID=97950&cost=300&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='400 KO'><image src='../avatars/male/kiyafet/214.png'><br><a href='fbfe.php?purchase=1&itemID=97949&cost=400&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='700 KO'><image src='../avatars/male/kiyafet/213.png'><br><a href='fbfe.php?purchase=1&itemID=97948&cost=700&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td></tr><td align='center'><div id='itemurun' title='1500 KO'><image src='../avatars/male/kiyafet/212.png'><br><a href='fbfe.php?purchase=1&itemID=97947&cost=1500&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='750 KO'><image src='../avatars/male/kiyafet/211.png'><br><a href='fbfe.php?purchase=1&itemID=97946&cost=750&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td><td align='center'><div id='itemurun' title='900 KO'><image src='../avatars/male/kiyafet/210.png'><br><a href='fbfe.php?purchase=1&itemID=97945&cost=900&cat=10&r=0&search_item='><img src='images/buybtn.png' style='margin-top: -5px;margin-left: 3px;border:0px;'></a></div></td>
  </table>
</td>
</tr>
</td>
</tr>
</table>
</div>
<div class="footer"></div>
<div class="pageNumbers"><a href="fbfe.php?search_item=&amp;r=9"><img class="goLeft" src="images/go_left.png"></a> 1 / 1 <a href="fbfe.php?search_item=&amp;r=9"><img class="goRight" src="images/go_right.png"></a></div>
<script type="text/javascript">
//<![CDATA[
window.__CF=window.__CF||{};window.__CF.AJS={"vig_key":{"sid":"ef1dd5fea2b67d12bdc1e1249e271457"}};
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) { var CloudFlare=[{verbose:0,p:1375090658,byc:0,owlid:"cf",mirage:{responsive:0,lazy:0},mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/abv=2706741234/"},atok:"052c81f9ef599a0ab28e518fe65e1352",zone:"populerity.com",rocket:"0",apps:{"vig_key":{"sid":"ef1dd5fea2b67d12bdc1e1249e271457"}}}];CloudFlare.push({"apps":{"ape":"29b3e388d36e3045091e19675195ec98"}});var a=document.createElement("script"),b=document.getElementsByTagName("script")[0];a.async=!0;a.src="//ajax.cloudflare.com/cdn-cgi/nexp/abv=3609848800/cloudflare.min.js";b.parentNode.insertBefore(a,b);}}catch(e){};
//]]>
</script>
