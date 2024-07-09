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
?>

<html>
<head>
<title>Avatar Creator</title>
<link type="text/css" rel="stylesheet" href="style.css"> 
<script language="javaScript" type="text/javascript" src="../js/XmlHttpRequest.js"></script>
<script language="javaScript" type="text/javascript" src="js/functions.js"></script>

<script language="javascript" type="text/javascript">
<!--

/*
*
* set gender arrays 
*
*/

var myGender=new Array();

	myGender[0]="male/base/whiteMaleBody.png";
	myGender[1]="female/base/whiteFemaleBody.png";

/*
*
* set male arrays 
*
*/

var myBase=new Array();
var myMouth=new Array();
var myEyes=new Array();
var myAccessories=new Array();
var myTops=new Array();
var myHair=new Array();
var myBeard=new Array();
var myBottoms=new Array();
var myShoes=new Array();

/*
*
* set female arrays 
*
*/

var myFBase=new Array();
var myFMouth=new Array();
var myFEyes=new Array();
var myFAccessories=new Array();
var myFTops=new Array();
var myFHair=new Array();
var myFBottoms=new Array();
var myFShoes=new Array();

/*
*
* set array values
*
*/

<?php

$mybase = 0; 
$myFbase = 0;
$mymouth = 0; 
$myFmouth = 0;
$myeyes = 0; 
$myFeyes = 0;
$myaccessories = 0; 
$myFaccessories = 0;
$mytops = 0; 
$myFtops = 0;
$myhair = 0; 
$myFhair = 0;
$mybeard = 0;
$mybottoms = 0; 
$myFbottoms = 0;
$myshoes = 0; 
$myFshoes = 0;

// get items in shop

	$tmp=mysql_query("
		SELECT * 
		FROM ".$CONFIG['mysql_prefix']."shop_payments 
		WHERE username = '".mysql_real_escape_string($_SESSION['username'])."' 
		LIMIT 1") or die(mysql_error()); 

	$incPurchase = mysql_num_rows($tmp);

	if($incPurchase)
	{
		$tmp=mysql_query("
			SELECT DISTINCT ".$CONFIG['mysql_prefix']."shop.*  
			FROM ".$CONFIG['mysql_prefix']."shop , ".$CONFIG['mysql_prefix']."shop_payments
			WHERE ".$CONFIG['mysql_prefix']."shop.cost = '0' 
			AND ".$CONFIG['mysql_prefix']."shop.section !='2'
			OR ".$CONFIG['mysql_prefix']."shop.id = ".$CONFIG['mysql_prefix']."shop_payments.purchase 
			AND ".$CONFIG['mysql_prefix']."shop.section !='2' 
			AND ".$CONFIG['mysql_prefix']."shop_payments.username = '".mysql_real_escape_string($_SESSION['username'])."'
			");
	}
	else
	{
		$tmp=mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE cost = '0'
			AND section !='2';
			");
	}

	while($item=mysql_fetch_array($tmp)) 
	{
		// base

		if($item['section']=='3' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myBase['.$mybase.']="'.str_replace("avatars/","",$item['image']).'";';

			$mybase +=1;
		}

		if($item['section']=='3' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFBase['.$myFbase.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFbase +=1;
		}

		// mouth

		if($item['section']=='4' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myMouth['.$mymouth.']="'.str_replace("avatars/","",$item['image']).'";';

			$mymouth +=1;
		}

		if($item['section']=='4' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFMouth['.$myFmouth.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFmouth +=1;
		}

		// eyes

		if($item['section']=='5' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myEyes['.$myeyes.']="'.str_replace("avatars/","",$item['image']).'";';

			$myeyes +=1;
		}

		if($item['section']=='5' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFEyes['.$myFeyes.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFeyes +=1;
		}

		// accessories

		if($item['section']=='6' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myAccessories['.$myaccessories.']="'.str_replace("avatars/","",$item['image']).'";';

			$myaccessories +=1;
		}

		if($item['section']=='6' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFAccessories['.$myFaccessories.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFaccessories +=1;
		}

		// tops

		if($item['section']=='7' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myTops['.$mytops.']="'.str_replace("avatars/","",$item['image']).'";';

			$mytops +=1;
		}

		if($item['section']=='7' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFTops['.$myFtops.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFtops +=1;
		}

		// hair

		if($item['section']=='8' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myHair['.$myhair.']="'.str_replace("avatars/","",$item['image']).'";';

			$myhair +=1;
		}

		if($item['section']=='8' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFHair['.$myFhair.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFhair +=1;
		}

		// beards

		if($item['section']=='9' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myBeard['.$mybeard.']="'.str_replace("avatars/","",$item['image']).'";';

			$mybeard +=1;
		}

		// bottoms

		if($item['section']=='10' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myBottoms['.$mybottoms.']="'.str_replace("avatars/","",$item['image']).'";';

			$mybottoms +=1;
		}

		if($item['section']=='10' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFBottoms['.$myFbottoms.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFbottoms +=1;
		}

		// shoes

		if($item['section']=='11' && strlen(strstr($item['image'],'avatars/female'))==0)
		{
			echo 'myShoes['.$myshoes.']="'.str_replace("avatars/","",$item['image']).'";';

			$myshoes +=1;
		}

		if($item['section']=='11' && strlen(strstr($item['image'],'avatars/female'))>0)
		{
			echo 'myFShoes['.$myFshoes.']="'.str_replace("avatars/","",$item['image']).'";';

			$myFshoes +=1;
		}


	}

?>


/*
*
* show my current avatar
*
*/
<?php
	$guestUser = 1;

	$tmp=mysql_query("
		SELECT * 
		FROM ".$CONFIG['mysql_prefix']."user 
		WHERE username = '".$_SESSION['username']."'
		LIMIT 1
		");

	while($avatarItems=mysql_fetch_array($tmp)) 
	{
		$avatar = str_replace("avatars/","",$avatarItems['avatar']);
		$avatar = explode("|", $avatar);

		$guestUser = 0;
	}

?>

var guestUser = <?php echo $guestUser;?>;
var avatarName = '<?php echo $_SESSION['username'];?>';
var igender = '<?php echo $avatar[0];?>';
var ibase = '<?php echo $avatar[1];?>';
var imouth = '<?php echo $avatar[6];?>';
var ieyes = '<?php echo $avatar[3];?>';
var ihair = '<?php echo $avatar[4];?>';
var iaccessories = '<?php echo $avatar[9];?>';
var itops = '<?php echo $avatar[8];?>';
var ibeard = '<?php echo $avatar[5];?>';
var ibottoms = '<?php echo $avatar[2];?>';
var ishoes = '<?php echo $avatar[7];?>';

/*
*
* initialize avatar
*
*/

function initAvatar()
{
	if(guestUser)
	{
		gender = 2;
		randomAvatar();
	}
	else
	{
		initMe();
	}
}

/*
*
* generate random avatar
*
*/

function randomAvatar()
{
	if(gender==1)
	{
		var rgender = gender;
		var rbase = myBase[Math.floor(Math.random()*<?php echo $mybase;?>)];
		var rmouth = myMouth[Math.floor(Math.random()*<?php echo $mymouth;?>)];
		var reyes = myEyes[Math.floor(Math.random()*<?php echo $myeyes;?>)];
		var rhair = myHair[Math.floor(Math.random()*<?php echo $myhair;?>)];
		var raccessories = 'nopic.png';
		var rtops = myTops[Math.floor(Math.random()*<?php echo $mytops;?>)];
		var rbeard = 'nopic.png';
		var rbottoms = myBottoms[Math.floor(Math.random()*<?php echo $mybottoms;?>)];
		var rshoes = myShoes[Math.floor(Math.random()*<?php echo $myshoes;?>)];
	}

	if(gender==2)
	{
		var rgender = gender;
		var rbase = myFBase[Math.floor(Math.random()*<?php echo $myFbase;?>)];
		var rmouth = myFMouth[Math.floor(Math.random()*<?php echo $myFmouth;?>)];
		var reyes = myFEyes[Math.floor(Math.random()*<?php echo $myFeyes;?>)];
		var rhair = myFHair[Math.floor(Math.random()*<?php echo $myFhair;?>)];
		var raccessories = 'nopic.png';
		var rtops = myFTops[Math.floor(Math.random()*<?php echo $myFtops;?>)];
		var rbeard = 'nopic.png';
		var rbottoms = myFBottoms[Math.floor(Math.random()*<?php echo $myFbottoms;?>)];
		var rshoes = myFShoes[Math.floor(Math.random()*<?php echo $myFshoes;?>)];
	}


	setGender(rgender, rbase, rmouth, reyes, rhair, raccessories, rtops, rbeard, rbottoms, rshoes);
}

//-->
</script>

</head>
<body class="body" onload="initAvatar()">

<div id="avatar" class="avatar">

	<span class="span"><img id="base" src="nopic.png"></span>
	<span class="span"><img id="bottoms" src="nopic.png"></span>
	<span class="span"><img id="eyes" src="nopic.png"></span>
	<span class="span"><img id="hair" src="nopic.png"></span>
	<span class="span"><img id="beard" src="nopic.png"></span>
	<span class="span"><img id="mouth" src="nopic.png"></span>
	<span class="span"><img id="shoes" src="nopic.png"></span>
	<span class="span"><img id="tops" src="nopic.png"></span>
	<span class="span"><img id="accessories" src="nopic.png"></span>
	<span class="span"><img id="trans" src="male/background/trans.png"></span>

</div>

<div id="itemWin" class="itemWin"></div>

<span class="mini" style="top:205px;left:25px;" onclick="initMale()"><div class="minitext">Male</div></span>
<span class="mini" style="top:205px;left:86px;" onclick="initFemale()"><div class="minitext">Female</div></span>

<div id="menu">

	
<div id="menu">
<span class="menu" style="top: 95px;left: 323px;" onclick="showItems(&#39;bottoms&#39;)"><img src="pantolon.png"></span>
<span class="menu" style="top: 55px;left: 475px;" onclick="showItems(''hair'')"><img src="sac.png"></span>
<span class="menu" style="top: 95px;left: 475px;" onclick="showItems(&#39;mouth&#39;)"><img src="sapka(1).png"></span>
<span class="menu" style="top: 135px;left: 475px;" onclick="showItems(&#39;eyes&#39;)"><img src="maske.png"></span>
<span class="menu" style="top: 135px;left: 323px;" onclick="showItems(&#39;shoes&#39;)"><img src="ayakkabi.png"></span>
<span class="menu" style="top: 55px;left: 323px;" onclick="showItems(&#39;tops&#39;)"><img src="tshirt.png"></span>
<span class="menu" style="top: 55px;left: 173px;" onclick="showItems(&#39;accessories&#39;)"><img src="aksesuar.png"></span>
<span class="menu" style="top: 95px;left: 173px;" onclick="showItems(&#39;base&#39;)"><img src="karakter.png"></span>
<span class="menu" style="top: 135px;left: 173px;" onclick="showItems(&#39;beard&#39;)"><img src="sembol.png"></span>
</div>
<span class="button" style="top:448px;left:264px;" onclick="saveAvatar()"><img src="save.png"></span>
<span class="button" style="top:448px;left:361px;" onclick="closeAvatarCreator()"><img src="cancel.png"></span>
<div id="loading" class="loading"></div>





<script type="text/javascript">if(window.Event)document.captureEvents(Event.MOUSEUP);function nocontextmenu(){event.cancelBubble=true,event.returnValue=false;return false;}function norightclick(e){if(window.Event){if(e.which==2||e.which==3)return false;}else if(event.button==2||event.button==3){event.cancelBubble=true,event.returnValue=false;return false;}}if(document.layers)document.captureEvents(Event.MOUSEDOWN);document.oncontextmenu=nocontextmenu;document.onmousedown=norightclick;document.onmouseup=norightclick;function notaccept(e){return false;}document.onmousedown=notaccept;document.onselectstart=new Function("return false");</script></body></html>

</div>

<span class="button" style="top:448px;left:305px;" onclick="closeAvatarCreator()"><div class="buttontext">Cancel</div></span>
<span class="button" style="top:448px;left:430px;" onclick="undo()"><div class="buttontext">Undo</div></span>
<span class="button" style="top:448px;left:555px;" onclick="saveAvatar()"><div class="buttontext">Save</div></span>

<div id="loading" class="loading"></div>

</body>
</html>