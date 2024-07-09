/**
* 
*  Author: Pro Chatrooms
*  Software: Avatar Chat
*  Url: http://www.prochatrooms.com
*  Copyright 2007-2010 All Rights Reserved
* 
*  Avatar Chat and all of its source code/files are protected by Copyright Laws. 
*  The license for Avatar Chat permits you to install this software on a single domain only (.com, .co.uk, .org, .net, etc.). 
*  Each additional installation requires an additional software licence, please contact us for more information.
*  You may NOT remove the copyright information and credits for Avatar Chat unless you have been granted permission. 
*  Avatar Chat is NOT free software - For more details http://www.prochatrooms.com/software_licence.php
* 
**/


/*
*
* set variables
*
*/

var i=0;
var iLoop = 1;
var undoitemID;

/*
*
* initiate my avatar 
*
*/

function initMe()
{
	setGender(
			igender, 
			ibase, 
			imouth, 
			ieyes,
			ihair, 
			iaccessories, 
			itops, 
			ibeard, 
			ibottoms, 
			ishoes
		);
}

/*
*
* initiate male avatar 
*
*/

function initMale()
{
	setGender(
			'1',  
			myGender[0], 
			myMouth[1], 
			myEyes[0], 
			myHair[4], 
			'nopic.png', 
			'nopic.png', 
			'nopic.png', 
			'nopic.png', 
			'nopic.png'
	);

}

/*
*
* initiate female avatar 
*
*/

function initFemale()
{
	setGender(
			'2',  
			myGender[1], 
			myFMouth[1], 
			myFEyes[0], 
			myFHair[1], 
			'nopic.png', 
			'nopic.png', 
			'nopic.png', 
			'nopic.png', 
			'nopic.png'
		);

}

/*
*
* show items 
*
*/

function showItems(itemID)
{
	iLoop = 0;

	document.getElementById('itemWin').innerHTML = '';

	if(itemID=='beard' && gender==2)
	{
		document.getElementById('itemWin').innerHTML = '<span class="notice">This Feature Is Not Available</span>';
	}

	if(gender==1)
	{

		if(itemID=='base')
		{
			var doLength = myBase.length-1;
		}

		if(itemID=='mouth')
		{
			var doLength = myMouth.length-1;
		}

		if(itemID=='eyes')
		{
			var doLength = myEyes.length-1;
		}

		if(itemID=='accessories')
		{
			var doLength = myAccessories.length-1;
		}

		if(itemID=='tops')
		{
			var doLength = myTops.length-1;
		}

		if(itemID=='hair')
		{
			var doLength = myHair.length-1;
		}

		if(itemID=='beard')
		{
			var doLength = myBeard.length-1;
		}

		if(itemID=='bottoms')
		{
			var doLength = myBottoms.length-1;
		}

		if(itemID=='shoes')
		{
			var doLength = myShoes.length-1;
		}

	}

	if(gender==2)
	{

		if(itemID=='base')
		{
			var doLength = myFBase.length-1;
		}

		if(itemID=='mouth')
		{
			var doLength = myFMouth.length-1;
		}

		if(itemID=='eyes')
		{
			var doLength = myFEyes.length-1;
		}

		if(itemID=='accessories')
		{
			var doLength = myFAccessories.length-1;
		}

		if(itemID=='tops')
		{
			var doLength = myFTops.length-1;
		}

		if(itemID=='hair')
		{
			var doLength = myFHair.length-1;
		}

		if(itemID=='bottoms')
		{
			var doLength = myFBottoms.length-1;
		}

		if(itemID=='shoes')
		{
			var doLength = myFShoes.length-1;
		}

	}

	for (i = 0; i <= doLength; i++)
	{
		if(gender==1)
		{
			if(itemID=='base')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("base","'+myBase[i]+'")\'><img src='+myBase[i]+'></span>';
			}

			if(itemID=='mouth')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("mouth","'+myMouth[i]+'")\'><img src='+myMouth[i]+'></span>';
			}

			if(itemID=='eyes')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("eyes","'+myEyes[i]+'")\'><img src='+myEyes[i]+'></span>';
			}

			if(itemID=='accessories')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("accessories","'+myAccessories[i]+'")\'><img src='+myAccessories[i]+'></span>';
			}

			if(itemID=='tops')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("tops","'+myTops[i]+'")\'><img src='+myTops[i]+'></span>';
			}

			if(itemID=='hair')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("hair","'+myHair[i]+'")\'><img src='+myHair[i]+'></span>';
			}

			if(itemID=='beard')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("beard","'+myBeard[i]+'")\'><img src='+myBeard[i]+'></span>';
			}

			if(itemID=='bottoms')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("bottoms","'+myBottoms[i]+'")\'><img src='+myBottoms[i]+'></span>';
			}

			if(itemID=='shoes')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("shoes","'+myShoes[i]+'")\'><img src='+myShoes[i]+'></span>';
			}

		}

		if(gender==2)
		{

			if(itemID=='base')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("base","'+myFBase[i]+'")\'><img src='+myFBase[i]+'></span>';
			}

			if(itemID=='mouth')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("mouth","'+myFMouth[i]+'")\'><img src='+myFMouth[i]+'></span>';
			}

			if(itemID=='eyes')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("eyes","'+myFEyes[i]+'")\'><img src='+myFEyes[i]+'></span>';
			}

			if(itemID=='accessories')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("accessories","'+myFAccessories[i]+'")\'><img src='+myFAccessories[i]+'></span>';
			}

			if(itemID=='tops')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("tops","'+myFTops[i]+'")\'><img src='+myFTops[i]+'></span>';
			}

			if(itemID=='hair')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("hair","'+myFHair[i]+'")\'><img src='+myFHair[i]+'></span>';
			}

			if(itemID=='bottoms')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("bottoms","'+myFBottoms[i]+'")\'><img src='+myFBottoms[i]+'></span>';
			}

			if(itemID=='shoes')
			{
				document.getElementById('itemWin').innerHTML += '<span class=\'item\' onmouseover="this.className=\'itemhighlite\'" onmouseout="this.className=\'item\'" onclick=\'changeItem("shoes","'+myFShoes[i]+'")\'><img src='+myFShoes[i]+'></span>';
			}

		}

		iLoop += 1;

		if(iLoop >= 4)
		{
			document.getElementById('itemWin').innerHTML += '<br />';

			iLoop = 0;

		}

	}

}

/*
*
* undo last action 
*
*/

function undo()
{
	if(
		undoitemID == 'base' || 
		undoitemID == 'eyes' || 
		undoitemID == 'mouth'  
	)
	{
		return false;
	}

	document.getElementById(undoitemID).src = 'nopic.png';
}

/*
*
* change item 
*
*/

function changeItem(span,path)
{
	undoitemID = span;	

	if(
		span == 'base' && path == 'nopic.png' || 
		span == 'eyes' && path == 'nopic.png' || 
		span == 'mouth' && path == 'nopic.png' 
	)
	{
		return false;
	}

	if(span == 'base')
	{
		ibase = path;
	}

	if(span == 'mouth')
	{
		imouth = path;
	}

	if(span == 'eyes')
	{
		ieyes = path;
	}

	if(span == 'hair')
	{
		ihair = path;
	}

	if(span == 'accessories')
	{
		iaccessories = path;
	}

	if(span == 'tops')
	{
		itops = path;
	}

	if(span == 'beard')
	{
		ibeard = path;
	}

	if(span == 'bottoms')
	{
		ibottoms = path;
	}

	if(span == 'shoes')
	{
		ishoes = path;
	}

	document.getElementById(span).src = path;
}

/*
*
* set avatar gender
*
*/

function setGender(genderID, mybase, mymouth, myeyes, myhair, myaccessories, mytops, mybeard, mybottoms, myshoes)
{
	if(genderID==1)
	{
		gender = 1;
		changeItem("beard",mybeard);
	}

	if(genderID==2)
	{
		gender = 2;
		changeItem("beard",'nopic.png');
	}

	changeItem("base",mybase);
	changeItem("mouth",mymouth);
	changeItem("eyes",myeyes);
	changeItem("hair",myhair);
	changeItem("accessories",myaccessories);
	changeItem("tops",mytops);
	changeItem("bottoms",mybottoms);
	changeItem("shoes",myshoes);

	document.getElementById('itemWin').innerHTML  = '<span class="notice">Create Your Avatar! When Your Done Click "Save".<br><br>Need More Outfits? - <a href="../shop/index.php" target="_blank">Lets Go Shopping!</a></span>';
}

/*
*
* save avatar
*
*/

//Define XmlHttpRequest
var saveReq = getXmlHttpRequestObject();

function saveAvatar()
{
	if(guestUser)
	{
		document.getElementById('itemWin').innerHTML  = '<span class="notice" style="color:#FF4848">Oops, you need to be logged in to save your avatar!<br><br>Not a member? - <a href="../index.php">Register FREE Now!</a></span>';
		return false;
	}

	var param = "?uname="+avatarName+"&uaction=updateAvatar&avatarItems="+gender+"|avatars/"+ibase+"|avatars/"+ibottoms+"|avatars/"+ieyes+"|avatars/"+ihair+"|avatars/"+ibeard+"|avatars/"+imouth+"|avatars/"+ishoes+"|avatars/"+itops+"|avatars/"+iaccessories;

	// if ready to send data to DB
	if (saveReq.readyState == 4 || saveReq.readyState == 0) 
	{
		saveReq.open("POST", '../includes/sendData.php', true);
		saveReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		saveReq.onreadystatechange = handleSaveChat;
		saveReq.send(param);
	}
}

function doReload()
{
	// reload parent window
	parent.window.location = parent.document.location.href;
}

//When our message has been sent, update our page.
function handleSaveChat() 
{
	var t = setTimeout("doReload();",1000);

	// show loading image
	document.getElementById('loading').style.visibility='visible';
}

//Close Avatar Creator window
function closeAvatarCreator(){

	// close the window
	parent.document.getElementById('avatarCreator').style.visibility='hidden';

	// remove grey out
	parent.grayOut(false);
}


