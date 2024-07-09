var topLevel=100;function toggleBox(szDivID)
{if(document.layers)
{if(document.layers[szDivID].visibility=="visible")
{document.layers[szDivID].visibility="hidden";}
else
{document.layers[szDivID].zIndex=topLevel++;document.layers[szDivID].visibility="visible";}}
else if(document.getElementById)
{var obj=document.getElementById(szDivID);if(obj.style.visibility=="visible")
{obj.style.visibility="hidden";}
else
{obj.style.zIndex=topLevel++;obj.style.visibility="visible";}}
else if(document.all)
{if(document.all[szDivID].style.visibility=="visible")
{document.all[szDivID].style.visibility="hidden";}
else
{document.all[szDivID].style.zIndex=topLevel++;document.all[szDivID].style.visibility="visible";}}
if(topLevel>30000)
{topLevel=10;}}
function grayOut(vis,options){var options=options||{};var zindex=options.zindex||31000;var opacity=options.opacity||80;var opaque=(opacity/100);var bgcolor=options.bgcolor||'#000000';var dark=document.getElementById('darkenScreenObject');if(!dark){var tbody=document.getElementsByTagName("body")[0];var tnode=document.createElement('div');tnode.style.position='absolute';tnode.style.top='0px';tnode.style.left='0px';tnode.style.overflow='hidden';tnode.style.display='none';tnode.id='darkenScreenObject';tbody.appendChild(tnode);dark=document.getElementById('darkenScreenObject');}
if(vis){if(document.body&&(document.body.scrollWidth||document.body.scrollHeight)){var pageWidth=document.body.scrollWidth+'px';var pageHeight=document.body.scrollHeight+'px';}else if(document.body.offsetWidth){var pageWidth=document.body.offsetWidth+'px';var pageHeight=document.body.offsetHeight+'px';}else{var pageWidth='100%';var pageHeight='100%';}
dark.style.opacity=opaque;dark.style.MozOpacity=opaque;dark.style.filter='alpha(opacity='+opacity+')';dark.style.zIndex=zindex;dark.style.backgroundColor=bgcolor;dark.style.width=pageWidth;dark.style.height=pageHeight;dark.style.display='block';denyMove='1';}else{dark.style.display='none';denyMove='0';}}
function showRooms(){document.getElementById('myrooms').style.visibility="visible";}
function showKadir(){document.getElementById('mKadir').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideKadir()',5000);moveAvatar='0';}
function hideKadir(){toggleBox('mKadir');grayOut(false);moveAvatar='0';}
function showTahsin(){document.getElementById('mTahsin').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideTahsin()',5000);moveAvatar='0';}
function hideTahsin(){toggleBox('mTahsin');grayOut(false);moveAvatar='0';}
function showBotMessage(){document.getElementById('mBot').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideBotMessage()',5000);moveAvatar='0';}
function hideBotMessage(){toggleBox('mBot');grayOut(false);moveAvatar='0';}
function showAyse(){document.getElementById('mAyse').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideAyse()',5000);moveAvatar='0';}
function hideAyse(){toggleBox('mAyse');grayOut(false);moveAvatar='0';}
function showDilenci(){document.getElementById('mDilenci').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideDilenci()',5000);moveAvatar='0';}
function hideDilenci(){toggleBox('mDilenci');grayOut(false);moveAvatar='0';}
function showLaz(){document.getElementById('mLaz').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideLaz()',5000);moveAvatar='0';}
function hideLaz(){toggleBox('mLaz');grayOut(false);moveAvatar='0';}
function showOzge(){document.getElementById('mOzge').style.visibility='visible';sesstimeoutID=window.clearTimeout(mytimeoutID);;sesstimeoutID=window.setTimeout('hideOzge()',5000);moveAvatar='0';}
function hideOzge(){toggleBox('mOzge');grayOut(false);moveAvatar='0';}
function showDalgic(){document.getElementById('questDalgic').style.visibility='visible';moveAvatar='0';}
function hideDalgic(){toggleBox('questDalgic');grayOut(false);moveAvatar='0';}
function showShopBakkal(){document.getElementById('shopBakkal').style.visibility='visible';moveAvatar='0';}
function hideShopBakkal(){toggleBox('shopBakkal');grayOut(false);moveAvatar='0';}
function showShopStand(){document.getElementById('shopStand').style.visibility='visible';moveAvatar='0';}
function hideShopStand(){toggleBox('shopStand');grayOut(false);moveAvatar='0';}
function showBiletBuy(){document.getElementById('shopBilet').style.visibility='visible';moveAvatar='0';}
function hideBiletBuy(){toggleBox('shopBilet');grayOut(false);moveAvatar='0';}
function showCanta(){document.getElementById('divCanta').style.visibility='visible';moveAvatar='0';}
function showBoatlist(){document.getElementById('boats').style.visibility='visible';moveAvatar='0';}
function hideBoatlist(){toggleBox('boats');grayOut(false);moveAvatar='0';}
function hideCanta(){toggleBox('divCanta');grayOut(false);moveAvatar='0';}
function showWelcome(){if(hideSplash=='1'){grayOut(false);moveAvatar='0';document.getElementById('splashpage').style.visibility="visible";}}
function hideWelcome(){if(hideSplash=='1'){document.getElementById('splashpage').style.visibility="hidden";grayOut(false);moveAvatar='0';}}
var sendmailStyle=false,blocklistStyle=false,locklistStyle=false,emaillistStyle=false,friendslistStyle=false,myplaceStyle=false,speakerStyle=false,changeroomStyle=false,towerStyle=false;var tDiv='';function toggleStyle(image,styleName,tDiv){var pressed=false;switch(styleName){case"sendmail":pressed=sendmailStyle=!sendmailStyle;break;case"block":pressed=blocklistStyle=!blocklistStyle;break;case"lock":pressed=locklistStyle=!locklistStyle;break;case"email":pressed=emaillistStyle=!emaillistStyle;break;case"group":pressed=friendslistStyle=!friendslistStyle;break;case"myplace":pressed=myplaceStyle=!myplaceStyle;break;case"speaker":pressed=speakerStyle=!speakerStyle;break;case"changeroom":pressed=changeroomStyle=!changeroomStyle;break;case"tower":pressed=towerStyle=!towerStyle;break;}
var newBGimage="images/"+ styleName+(pressed?".down":"")+".png";document.getElementById(tDiv).style.backgroundImage="url('"+newBGimage+"')";}
function hideSysMess(){document.getElementById('sysmess').style.visibility='hidden';}
function showVIP(){document.getElementById('upgradeVIP').style.visibility='visible';}
function hideVIP(){toggleBox('upgradeVIP');grayOut(false);moveAvatar='0';}
function showGames(){document.getElementById('playGames').style.visibility='visible';moveAvatar='0';}
function hideGames(){toggleBox('playGames');grayOut(false);moveAvatar='0';}
function showTower(){document.getElementById('gotoUsers').style.visibility='visible';moveAvatar='0';}
function hideTower(){toggleBox('gotoUsers');grayOut(false);moveAvatar='0';}
function showSmileys(){document.getElementById('avatarSmiley').style.visibility='visible';moveAvatar='0';}
function hideSmileys(){toggleBox('avatarSmiley').style.visibility='hidden';moveAvatar='0';}
function showKO(){document.getElementById('avatarKo').style.visibility='visible';moveAvatar='0';}
function hideKO(){toggleBox('avatarKo').style.visibility='hidden';moveAvatar='0';}
function showVip(){document.getElementById('avatarVip').style.visibility='visible';moveAvatar='0';}
function hideVip(){toggleBox('avatarVip').style.visibility='hidden';moveAvatar='0';}
function showAvatarCreator(){document.getElementById('avatarCreator').style.visibility='visible';moveAvatar='0';}
function hideAvatarCreator(){editAvatar=1;loadRoom(room);document.getElementById('avatarCreator').style.visibility='hidden';grayOut(false);moveAvatar='0';}
function showNewsPaper(){document.getElementById('newsPaper').style.visibility='visible';moveAvatar='0';}
function hideNewsPaper(){toggleBox('newsPaper');grayOut(false);moveAvatar='0';}
var musicOFF=0;var newStream=0;function playStream(stream){if(musicOFF==0){newStream='music/index.php';musicOFF=1;moveAvatar='0';}else{newStream=stream;musicOFF=0;moveAvatar='0';}
document.getElementById("AUDIOUrl").src=newStream;}
function cursorPos(){document.getElementById('startPosistion').innerHTML="<b>X:</b> "+dest_x+" <b>Y:</b> "+dest_y;}
function _door1(_dy_,_dx_,_dh_,_dw_,_dv_){document.getElementById("doorone").style.top=_dy_+'px';document.getElementById("doorone").style.left=_dx_+'px';document.getElementById("doorone").style.height=_dh_+'px';document.getElementById("doorone").style.width=_dw_+'px';if(_dv_){document.getElementById("doorone").style.border="";document.getElementById("doorone").style.color="";document.getElementById("doorone").innerHTML="";}}
function _door2(_dy_,_dx_,_dh_,_dw_,_dv_){document.getElementById("doortwo").style.top=_dy_+'px';document.getElementById("doortwo").style.left=_dx_+'px';document.getElementById("doortwo").style.height=_dh_+'px';document.getElementById("doortwo").style.width=_dw_+'px';if(_dv_){document.getElementById("doortwo").style.border="";document.getElementById("doortwo").style.color="";document.getElementById("doortwo").innerHTML="";}}
function _door3(_dy_,_dx_,_dh_,_dw_,_dv_){document.getElementById("doorthree").style.top=_dy_+'px';document.getElementById("doorthree").style.left=_dx_+'px';document.getElementById("doorthree").style.height=_dh_+'px';document.getElementById("doorthree").style.width=_dw_+'px';if(_dv_){document.getElementById("doorthree").style.border="";document.getElementById("doorthree").style.color="";document.getElementById("doorthree").innerHTML="";}}
function shop(){window.open('shop/','shop');}
function newUrl(url,id){window.open(url,id);}