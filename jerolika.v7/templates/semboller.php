
<html>
<head>
<title>Jerolika</title>
<script type="text/javascript">
//<![CDATA[
window.__CF=window.__CF||{};window.__CF.AJS={"vig_key":{"sid":"ef1dd5fea2b67d12bdc1e1249e271457"}};
//]]>
</script>
<script type="text/javascript">
//<![CDATA[
try{if (!window.CloudFlare) { var CloudFlare=[{verbose:0,p:1385848832,byc:0,owlid:"cf",bag2:1,mirage2:0,oracle:0,paths:{cloudflare:"/cdn-cgi/nexp/acv=4125811108/"},atok:"38605ec7a6a431cc2f49efab2d772c86",petok:"089568f37b3f02d6443260e214a51baf-1385849348-1800",zone:"populerity.com",rocket:"0",apps:{"vig_key":{"sid":"ef1dd5fea2b67d12bdc1e1249e271457"}}}];CloudFlare.push({"apps":{"ape":"a5ad26d6a9ec69cc6cf321309181536e"}});var a=document.createElement("script"),b=document.getElementsByTagName("script")[0];a.async=!0;a.src="//ajax.cloudflare.com/cdn-cgi/nexp/acv=616370821/cloudflare.min.js";b.parentNode.insertBefore(a,b);}}catch(e){};
//]]>
</script>
<link type="text/css" rel="stylesheet" href="style2.css">
<script language="javaScript" type="text/javascript" src="../js/XmlHttpRequest.js"></script>
<script language="javaScript" type="text/javascript" src="js/functions2.js"></script>
<script language="javascript" type="text/javascript">
<!--
if(window.location == top.location)
{
	window.location.href="../index.html";
}
// -->
</script>
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

myHair[0]="male/hair/03.png";myFMouth[0]="female/nopic.png";

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
		var rbase = myBase[Math.floor(Math.random()*0)];
		var rmouth = myMouth[Math.floor(Math.random()*0)];
		var reyes = myEyes[Math.floor(Math.random()*0)];
		var rhair = myHair[Math.floor(Math.random()*1)];
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
		var rmouth = myFMouth[Math.floor(Math.random()*1)];
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
<body onload="initAvatar();" oncontextmenu="return false" ondragstart="return false" onselectstart="return false">
<div class="canta">
<div class="items"><div style="margin-top: -22px;">
<div title="Kaldir" class='item' onclick='changeItem("accessories","yok");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kaldir.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Mutlu" class='item' onclick='changeItem("accessories","mutlu");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/mutlu.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Mutsuz" class='item' onclick='changeItem("accessories","mutsuz");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/mutsuz.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Goz Kirp" class='item' onclick='changeItem("accessories","goz_kirp");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/goz_kirp.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Alayci" class='item' onclick='changeItem("accessories","alayci");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/alayci.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Gergin" class='item' onclick='changeItem("accessories","gergin");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/gergin.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Cekici" class='item' onclick='changeItem("accessories","flirty");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/flirty.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kahkaha" class='item' onclick='changeItem("accessories","lol");saveAvatar();'><img http://www.populerity.com/oyna/avatars/src='smileys/lol.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kizgin" class='item' onclick='changeItem("accessories","kizgin");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kizgin.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Sabit" class='item' onclick='changeItem("accessories","sabit");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/sabit.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Saskin" class='item' onclick='changeItem("accessories","saskin");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/saskin.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Aglayan" class='item' onclick='changeItem("accessories","aglayan");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/aglayan.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Hasta" class='item' onclick='changeItem("accessories","hasta");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/hasta.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Olu" class='item' onclick='changeItem("accessories","olu");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/olu.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kahraman" class='item' onclick='changeItem("accessories","kahraman");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kahraman.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Cool" class='item' onclick='changeItem("accessories","cool");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/cool.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Yonetmen" class='item' onclick='alert("Jerolika: Bu sembolu kullanabilmek icin Yonetmen olmalisin")'><img src='http://www.populerity.com/oyna/avatars/smileys/yonetmen.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Gazeteci" class='item' onclick='alert("Jerolika: Bu sembolu kullanabilmek icin Gazeteci olmalisin")'><img src='http://www.populerity.com/oyna/avatars/smileys/gazete.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Elmas" class='item' onclick='alert("Bu sembolü kullanabilmek için Elmas VIP olmalısın")'><img src='smileys/elmas.png' style="padding-top: 3px;padding-left: 3px;"></div><div title="Hediye" class='item' onclick='changeItem("accessories","hediye_paketi");saveAvatar();'><img src='http://www.populerity.com/oyun/smileys/hediye_paketi.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Gazeteci" class='item' onclick='alert("Jerolika: Bu sembolu kullanabilmek icin Admin olmalisin")'><img src='http://www.populerity.com/oyna/avatars/smileys/gazete.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kalp" class='item' onclick='changeItem("accessories","kalp");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kalp.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kirik Kalp" class='item' onclick='changeItem("accessories","kirik_kalp");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kirik_kalp.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Uyku" class='item' onclick='changeItem("accessories","uyku");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/uyku.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Seytan" class='item' onclick='changeItem("accessories","seytan");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/seytan.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Kurukafa" class='item' onclick='changeItem("accessories","kurukafa");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/kurukafa.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Firtina" class='item' onclick='changeItem("accessories","firtina");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/firtina.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Yonca" class='item' onclick='changeItem("accessories","yonca");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/yonca.png' style="padding-top: 3px;padding-left: 3px;"></div>
<div title="Sapka" class='item' onclick='changeItem("accessories","sapka");saveAvatar();'><img src='http://www.populerity.com/oyna/avatars/smileys/sapka.png' style="padding-top: 3px;padding-left: 3px;"></div>
</div></div><br>
<div class="savecanta" onclick="saveAvatar()"></div>
<div id="loading" class="loading"></div>
</div>
</body>
</html>