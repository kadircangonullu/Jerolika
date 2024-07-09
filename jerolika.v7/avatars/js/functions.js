var i=0;var iLoop=1;var undoitemID;function initMe()
{setGender(igender,ibase,imouth,ieyes,ihair,iaccessories,itops,ibeard,ibottoms,ishoes);}
function initMale()
{setGender('1',myGender[0],myMouth[1],myEyes[0],myHair[4],'nopic.png','nopic.png','nopic.png','nopic.png','nopic.png');}
function initFemale()
{setGender('2',myGender[1],myFMouth[1],myFEyes[0],myFHair[1],'nopic.png','nopic.png','nopic.png','nopic.png','nopic.png');}
function showItems(itemID)
{iLoop=0;document.getElementById('itemWin').innerHTML='';if(itemID=='beard'&&gender==2)
{document.getElementById('itemWin').innerHTML=' ';}
if(gender==1)
{if(itemID=='base')
{var doLength=myBase.length-1;}
if(itemID=='mouth')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("mouth","nopic.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myMouth.length-1;}
if(itemID=='accessories')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("accessories","nopic.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myAccessories.length-1;}
if(itemID=='eyes')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("eyes","nopic.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myEyes.length-1;}
if(itemID=='tops')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("tops","nopic.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myTops.length-1;}
if(itemID=='hair')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("hair","nopic.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myHair.length-1;}
if(itemID=='beard')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("beard","male/beard/yok.png")\'><img src=\'smileys/kaldir.png\' style=\'width: 32px;height: 34px;\'></span>';var doLength=myBeard.length-1;}
if(itemID=='bottoms')
{var doLength=myBottoms.length-1;}
if(itemID=='shoes')
{var doLength=myShoes.length-1;}}
if(gender==2)
{if(itemID=='base')
{var doLength=myFBase.length-1;}
if(itemID=='mouth')
{var doLength=myFMouth.length-1;}
if(itemID=='eyes')
{var doLength=myFEyes.length-1;}
if(itemID=='accessories')
{var doLength=myFAccessories.length-1;}
if(itemID=='tops')
{var doLength=myFTops.length-1;}
if(itemID=='hair')
{var doLength=myFHair.length-1;}
if(itemID=='bottoms')
{var doLength=myFBottoms.length-1;}
if(itemID=='shoes')
{var doLength=myFShoes.length-1;}}
for(i=0;i<=doLength;i++)
{if(gender==1)
{if(itemID=='base')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("base","'+myBase[i]+'")\'><img src='+myBase[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='mouth')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("mouth","'+myMouth[i]+'")\'><img src='+myMouth[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='eyes')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("eyes","'+myEyes[i]+'")\'><img src='+myEyes[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='accessories')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("accessories","'+myAccessories[i]+'")\'><img src='+myAccessories[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='tops')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("tops","'+myTops[i]+'")\'><img src='+myTops[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='hair')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("hair","'+myHair[i]+'")\'><img src='+myHair[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='beard')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("beard","'+myBeard[i]+'")\'><img src='+myBeard[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='bottoms')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("bottoms","'+myBottoms[i]+'")\'><img src='+myBottoms[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='shoes')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("shoes","'+myShoes[i]+'")\'><img src='+myShoes[i]+' style=\'width: 32px;height: 34px;\'></span>';}}
if(gender==2)
{if(itemID=='base')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("base","'+myFBase[i]+'")\'><img src='+myFBase[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='mouth')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("mouth","'+myFMouth[i]+'")\'><img src='+myFMouth[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='eyes')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("eyes","'+myFEyes[i]+'")\'><img src='+myFEyes[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='accessories')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("accessories","'+myFAccessories[i]+'")\'><img src='+myFAccessories[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='tops')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("tops","'+myFTops[i]+'")\'><img src='+myFTops[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='hair')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("hair","'+myFHair[i]+'")\'><img src='+myFHair[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='bottoms')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("bottoms","'+myFBottoms[i]+'")\'><img src='+myFBottoms[i]+' style=\'width: 32px;height: 34px;\'></span>';}
if(itemID=='shoes')
{document.getElementById('itemWin').innerHTML+='<span class=\'item\' onclick=\'changeItem("shoes","'+myFShoes[i]+'")\'><img src='+myFShoes[i]+' style=\'width: 32px;height: 34px;\'></span>';}}
iLoop+=1;if(iLoop>=11)
{document.getElementById('itemWin').innerHTML+='<br><br><div style="margin-bottom: 14px;"></div>';iLoop=0;}}}
function undo()
{if(undoitemID=='base'||undoitemID=='eyes')
{return false;}
document.getElementById(undoitemID).src='nopic.png';}
function changeItem(span,path)
{undoitemID=span;if(span=='base'&&path=='nopic.png'||span=='eyes'&&path=='nopic.png')
{return false;}
if(span=='base')
{ibase=path;}
if(span=='mouth')
{imouth=path;}
if(span=='eyes')
{ieyes=path;}
if(span=='hair')
{ihair=path;}
if(span=='accessories')
{iaccessories=path;}
if(span=='tops')
{itops=path;}
if(span=='beard')
{ibeard=path;}
if(span=='bottoms')
{ibottoms=path;}
if(span=='shoes')
{ishoes=path;}
document.getElementById(span).src=path;}
function setGender(genderID,mybase,mymouth,myeyes,myhair,myaccessories,mytops,mybeard,mybottoms,myshoes)
{if(genderID==1)
{gender=1;changeItem("beard",mybeard);}
if(genderID==2)
{gender=2;changeItem("beard",'yok.png');}
changeItem("base",mybase);changeItem("mouth",mymouth);changeItem("eyes",myeyes);changeItem("hair",myhair);changeItem("accessories",myaccessories);changeItem("tops",mytops);changeItem("bottoms",mybottoms);changeItem("shoes",myshoes);document.getElementById('itemWin').innerHTML=' ';}
var saveReq=getXmlHttpRequestObject();function saveAvatar()
{if(guestUser)
{document.getElementById('itemWin').innerHTML='<span class="notice" style="color:#FF4848">Oops, giris yapmadin dostum!</span>';return false;}
var param="?uname="+avatarName+"&uaction=updateAvatar&avatarItems="+gender+"|avatars/"+ibase+"|avatars/"+ibottoms+"|avatars/"+ieyes+"|avatars/"+ihair+"|avatars/"+ibeard+"|avatars/"+imouth+"|avatars/"+ishoes+"|avatars/"+itops+"|avatars/"+iaccessories;if(saveReq.readyState==4||saveReq.readyState==0)
{saveReq.open("POST",'../includes/sendData.php',true);saveReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');saveReq.onreadystatechange=handleSaveChat;saveReq.send(param);}}
function doReload()
{parent.window.location=parent.document.location.href;}
function handleSaveChat()
{var t=setTimeout("doReload();",1000);document.getElementById('loading').style.visibility='visible';}
function closeAvatarCreator(){parent.document.getElementById('avatarCreator').style.visibility='hidden';parent.grayOut(false);}