
<!-- saved from url=(0036)http://blackko.net/avatars/index.php -->
<html><head><meta http-equiv="Content-Type" content="text/html; charset=UTF-8">
<title>Avatar Creator</title>
<link type="text/css" rel="stylesheet" href="./Avatar Creator_files/style.css"> 
<script language="javaScript" type="text/javascript" src="./Avatar Creator_files/XmlHttpRequest.js"></script>
<script language="javaScript" type="text/javascript" src="./Avatar Creator_files/functions.js"></script>

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

myBase[0]="male/kiyafet/base.png";myEyes[0]="male/eyes/nopic.png";myBeard[0]="smileys/lol.png";myBeard[1]="smileys/uyku.png";myBeard[2]="smileys/hediye_paketi.png";myBeard[3]="smileys/firtina.png";myBeard[4]="smileys/olu.png";myBeard[5]="smileys/sapka.png";myBeard[6]="smileys/mutlu.png";

/*
*
* show my current avatar
*
*/

var guestUser = 1;
var avatarName = '';
var igender = '';
var ibase = '';
var imouth = '';
var ieyes = '';
var ihair = '';
var iaccessories = '';
var itops = '';
var ibeard = '';
var ibottoms = '';
var ishoes = '';

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
		var rbase = myBase[Math.floor(Math.random()*1)];
		var rmouth = myMouth[Math.floor(Math.random()*0)];
		var reyes = myEyes[Math.floor(Math.random()*1)];
		var rhair = myHair[Math.floor(Math.random()*0)];
		var raccessories = 'nopic.png';
		var rtops = myTops[Math.floor(Math.random()*0)];
		var rbeard = 'nopic.png';
		var rbottoms = myBottoms[Math.floor(Math.random()*0)];
		var rshoes = myShoes[Math.floor(Math.random()*0)];
	}

	if(gender==2)
	{
		var rgender = gender;
		var rbase = myFBase[Math.floor(Math.random()*0)];
		var rmouth = myFMouth[Math.floor(Math.random()*0)];
		var reyes = myFEyes[Math.floor(Math.random()*0)];
		var rhair = myFHair[Math.floor(Math.random()*0)];
		var raccessories = 'nopic.png';
		var rtops = myFTops[Math.floor(Math.random()*0)];
		var rbeard = 'nopic.png';
		var rbottoms = myFBottoms[Math.floor(Math.random()*0)];
		var rshoes = myFShoes[Math.floor(Math.random()*0)];
	}


	setGender(rgender, rbase, rmouth, reyes, rhair, raccessories, rtops, rbeard, rbottoms, rshoes);
}

//-->
</script>
</head>
<body class="body" onload="initAvatar()" oncontextmenu="return false" ondragstart="return false">
<div id="avatar" class="avatar">
<span class="span"><img id="base" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="bottoms" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="eyes" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="shoes" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="tops" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="hair" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="beard" src="./Avatar Creator_files/yok.png"></span>
<span class="span"><img id="mouth" src="./Avatar Creator_files/undefined"></span>
<span class="span"><img id="accessories" src="./Avatar Creator_files/nopic.png"></span>
<span class="span"><img id="trans" src="./Avatar Creator_files/trans.png"></span>
</div>
<div id="itemWin" class="itemWin"></div>
<div id="menu">
<span class="menu" style="top: 95px;left: 323px;" onclick="showItems(&#39;bottoms&#39;)"><img src="./Avatar Creator_files/pantolon.png"></span>
<span class="menu" style="top: 55px;left: 475px;" onclick="showItems(&#39;hair&#39;)"><img src="./Avatar Creator_files/sac.png"></span>
<span class="menu" style="top: 95px;left: 475px;" onclick="showItems(&#39;mouth&#39;)"><img src="./Avatar Creator_files/sapka.png"></span>
<span class="menu" style="top: 135px;left: 475px;" onclick="showItems(&#39;eyes&#39;)"><img src="./Avatar Creator_files/maske.png"></span>
<span class="menu" style="top: 135px;left: 323px;" onclick="showItems(&#39;shoes&#39;)"><img src="./Avatar Creator_files/ayakkabi.png"></span>
<span class="menu" style="top: 55px;left: 323px;" onclick="showItems(&#39;tops&#39;)"><img src="./Avatar Creator_files/tshirt.png"></span>
<span class="menu" style="top: 55px;left: 173px;" onclick="showItems(&#39;accessories&#39;)"><img src="./Avatar Creator_files/aksesuar.png"></span>
<span class="menu" style="top: 95px;left: 173px;" onclick="showItems(&#39;base&#39;)"><img src="./Avatar Creator_files/karakter.png"></span>
<span class="menu" style="top: 135px;left: 173px;" onclick="showItems(&#39;beard&#39;)"><img src="./Avatar Creator_files/sembol.png"></span>
</div>
<span class="button" style="top:448px;left:264px;" onclick="saveAvatar()"><img src="./Avatar Creator_files/save.png"></span>
<span class="button" style="top:448px;left:361px;" onclick="closeAvatarCreator()"><img src="./Avatar Creator_files/cancel.png"></span>
<div id="loading" class="loading"></div>





<script type="text/javascript">if(window.Event)document.captureEvents(Event.MOUSEUP);function nocontextmenu(){event.cancelBubble=true,event.returnValue=false;return false;}function norightclick(e){if(window.Event){if(e.which==2||e.which==3)return false;}else if(event.button==2||event.button==3){event.cancelBubble=true,event.returnValue=false;return false;}}if(document.layers)document.captureEvents(Event.MOUSEDOWN);document.oncontextmenu=nocontextmenu;document.onmousedown=norightclick;document.onmouseup=norightclick;function notaccept(e){return false;}document.onmousedown=notaccept;document.onselectstart=new Function("return false");</script></body></html>