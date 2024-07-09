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


	//Define XmlHttpRequest
	var receiveULReq = getXmlHttpRequestObject();

	//Update user
	var updateUser = '';

	//Gets the usersonline
	function getUsersOnline() {
		if (receiveULReq.readyState == 4 || receiveULReq.readyState == 0) {
			receiveULReq.open("GET", 'includes/userlistData.php?roomID='+room, true);
			receiveULReq.onreadystatechange = handleUsersOnline; 
			receiveULReq.send(null);
		}
			
	}

	//Function for handling the users online
	function handleUsersOnline() {

		if (receiveULReq.readyState == 4) {

			var xmldoc = receiveULReq.responseXML;
			var allUsers_nodes = xmldoc.getElementsByTagName("userdetails"); 
			var n_users = allUsers_nodes.length;

			for (i = 0; i < n_users; i++) {

				var uids_node = allUsers_nodes[i].getElementsByTagName("uids");
				var userid_node = allUsers_nodes[i].getElementsByTagName("userids");
				var user_node = allUsers_nodes[i].getElementsByTagName("usernames");
				var avatar_node = allUsers_nodes[i].getElementsByTagName("useravatars");
				var avatarx_node = allUsers_nodes[i].getElementsByTagName("useravatarx");
				var avatary_node = allUsers_nodes[i].getElementsByTagName("useravatary");
				var webcam_node = allUsers_nodes[i].getElementsByTagName("userwebcams");
				var isguest_node = allUsers_nodes[i].getElementsByTagName("userguests");
				var isadmin_node = allUsers_nodes[i].getElementsByTagName("useradmins");
				var isvip_node = allUsers_nodes[i].getElementsByTagName("uservip");

				var love_node = allUsers_nodes[i].getElementsByTagName("ulove");
				var like_node = allUsers_nodes[i].getElementsByTagName("ulike");
				var star_node = allUsers_nodes[i].getElementsByTagName("ustar");

				var online_node = allUsers_nodes[i].getElementsByTagName("useronlines");

				showUsers(uids_node[0].firstChild.nodeValue, userid_node[0].firstChild.nodeValue, user_node[0].firstChild.nodeValue, avatar_node[0].firstChild.nodeValue, avatarx_node[0].firstChild.nodeValue, avatary_node[0].firstChild.nodeValue, webcam_node[0].firstChild.nodeValue, online_node[0].firstChild.nodeValue, love_node[0].firstChild.nodeValue, like_node[0].firstChild.nodeValue, star_node[0].firstChild.nodeValue, isguest_node[0].firstChild.nodeValue, isadmin_node[0].firstChild.nodeValue, isvip_node[0].firstChild.nodeValue);

			}

			uTimer = setTimeout('getUsersOnline();',refreshUsers);

			//Clear out the existing timer so we don't have 
			//multiple timer instances running.
			//clearInterval(uTimer);

			uTimer = '0';

		}

	}

	//show users avatars
	function showUsers(dUid,dUserid, dUname,dAvatar,dAvatarx,dAvatary,dWebcam,dOffline,dlove,dlike,dstar,dGuest,dAdmin,dVip){

		// do user offline
		if(dOffline < '1'){

			hideUsers(dUid);	

		}else{

			// create new user avatar

			dAvatar = dAvatar.split("|");

			if(!document.getElementById(dUid)){

				var isSTATUS = '';

				// VIP - yellow

				var isSTATUS = '<font color=#ffff33>' + dUname + '</font>';

				// Guest - green

				if(dVip !=1){

					var isSTATUS = '<font color=#33ff66>' + dUname + '</font>';

				}

				// Admin - red

				if(dAdmin==1){

					var isSTATUS = '<font color=#ff0033>' + dUname + '</font>';

				}

				//create div
				var ni = document.getElementById('chatscreen');
				var newdiv = document.createElement('div');
				newdiv.setAttribute("id",dUid);
				newdiv.className='';
				newdiv.innerHTML  = "<div id='l"+dUid+"myMessage' class='myMessage' style='top: "+dAvatary+"px; left: "+dAvatarx+"px;'></div>";
				newdiv.innerHTML += "<div id='"+dUid+"myMessage' class='myMessage' style='top: "+dAvatary+"px; left: "+dAvatarx+"px;'></div>";
				newdiv.innerHTML += "<div id='r"+dUid+"myMessage' class='myMessage' style='top: "+dAvatary+"px; left: "+dAvatarx+"px;'></div>";

				newdiv.innerHTML += "<div id='"+dUid+"myAvatar' class='myAvatar' style='top: "+dAvatary+"px; left: "+dAvatarx+"px; position:absolute; width:53px; height:75px; cursor:pointer;'><center><span style='cursor:pointer;' onclick=showUserDetails('"+dUid+"','"+dUname+"','"+dAvatary+"','"+dAvatarx+"','"+dAdmin+"');><b>"+isSTATUS+"</b></span><br><span class=\"span\"><img id=\"base\" src=\""+dAvatar[1]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"bottoms\" src=\""+dAvatar[2]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"eyes\" src=\""+dAvatar[3]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"hair\" src=\""+dAvatar[4]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"beard\" src=\""+dAvatar[5]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"mouth\" src=\""+dAvatar[6]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"shoes\" src=\""+dAvatar[7]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"tops\" src=\""+dAvatar[8]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"accessories\" src=\""+dAvatar[9]+"\" height=\"75\" width=\"53\"></span><span class=\"span\"><img id=\"trans\" src=\"avatars/nopic.png\" height=\"75\" width=\"53\" onclick=showUserDetails('"+dUid+"','"+dUname+"','"+dAvatary+"','"+dAvatarx+"','"+dAdmin+"');></span></center></div>";
				ni.appendChild(newdiv);

				document.getElementById('l'+dUid+'myMessage').style.visibility="hidden";
				document.getElementById(''+dUid+'myMessage').style.visibility="hidden";
				document.getElementById('r'+dUid+'myMessage').style.visibility="hidden";

			}

		}

		//Get users avatar posistion
		if(document.getElementById(dUid+'myAvatar')){

			// get the existing avatar div pos
			var _x = document.getElementById(dUid+"myAvatar").offsetLeft; // x axis
			var _y = document.getElementById(dUid+"myAvatar").offsetTop; // y axis
			
			// create buffer
			if(dAvatarx < (_x-30) || dAvatarx > (_x+30) || dAvatary < (_y-30) || dAvatary > (_y+30)){

				moveUImage(dUid,dAvatary,dAvatarx,_x,_y);

			}

		}



	}

	//Move the users avatar to new posistion
	function moveUImage(dUid,dAvatary,dAvatarx,_x,_y) {

		//Keep on moving the image till the target is achieved

		if(_x<dAvatarx) _x = _x + interval; 
		if(_y<dAvatary) _y = _y + interval;
		if(_x>dAvatarx) _x = _x - interval; 
		if(_y>dAvatary) _y = _y - interval;

		//Update the avatar

		document.getElementById(dUid+"myAvatar").style.top  = _y+'px';
		document.getElementById(dUid+"myAvatar").style.left = _x+'px';

		// add padding

		document.getElementById(dUid+"myMessage").style.padding="4px";

		//Default pos
		var _posShowX = 20;
		var _posShowXX = 15;

		//Reverse speech bubble if user is too far right

		if(_x > 400){

			// move speech bubble left 
			_posShowX = 20 - document.getElementById(dUid+"myMessage").clientWidth;

			// set padding
			document.getElementById(dUid+"myMessage").style.paddingLeft="10px";
			document.getElementById(dUid+"myMessage").style.paddingRight="0px";

			// reverse speech bubble
			var _doRe = 1;

			// assign xx value
			_posShowXX = 5;

		}else{

			// set padding
			document.getElementById(dUid+"myMessage").style.paddingLeft="0px";
			document.getElementById(dUid+"myMessage").style.paddingRight="10px";

			// default speech bubble
			var _doRe = 0;

		}

		//Assign the speech bubble posistioning

		_yy = _y - 50;
		_xx = _x + _posShowX;

		//Update the speech bubble location

		document.getElementById(dUid+"myMessage").style.paddingTop="11px";
		document.getElementById(dUid+"myMessage").style.paddingRight="10px";
		document.getElementById(dUid+"myMessage").style.left = _xx+'px';
		document.getElementById(dUid+"myMessage").style.top  = _yy+'px';
		document.getElementById(dUid+"myMessage").style.height = '30px';
		document.getElementById(dUid+"myMessage").style.background="url(images/sp2.png)";

		//assign left div

		_yyy = _y - 50;
		_xxx = _xx - _posShowXX;

		document.getElementById('l'+dUid+'myMessage').style.left = _xxx+'px';
		document.getElementById('l'+dUid+'myMessage').style.top  = _yyy+'px';

		if(_doRe==0){
			document.getElementById('l'+dUid+'myMessage').style.height = '48px';
			document.getElementById('l'+dUid+'myMessage').style.width = '16px';
			document.getElementById('l'+dUid+'myMessage').style.background="url(images/sp1.png)";
		}else{
			document.getElementById('l'+dUid+'myMessage').style.height = '43px';
			document.getElementById('l'+dUid+'myMessage').style.width = '6px';
			document.getElementById('l'+dUid+'myMessage').style.background="url(images/sp3rev.png)";
		}

		// assign right div

		//set posistion for right speech bubble
		setRightSpeech = document.getElementById(dUid+"myMessage").clientWidth;

		_yyyy = _y - 50;
		_xxxx = _xx + setRightSpeech;

		document.getElementById('r'+dUid+'myMessage').style.left = _xxxx+'px';
		document.getElementById('r'+dUid+'myMessage').style.top  = _yyyy+'px';

		if(_doRe==0){
			document.getElementById('r'+dUid+'myMessage').style.height = '43px';
			document.getElementById('r'+dUid+'myMessage').style.width = '6px';
			document.getElementById('r'+dUid+'myMessage').style.background="url(images/sp3.png)";
		}else{
			document.getElementById('r'+dUid+'myMessage').style.height = '48px';
			document.getElementById('r'+dUid+'myMessage').style.width = '16px';
			document.getElementById('r'+dUid+'myMessage').style.background="url(images/sp1rev.png)";
		}

		if ((_x+interval < dAvatarx) || (_y+interval < dAvatary) || (_x-interval > dAvatarx) || (_y-interval > dAvatary)) {

			//Keep on calling this function every 100 microsecond 
			//till the target location is reached

			avatarDiv = dUid;
			avatary = dAvatary;
			avatarx = dAvatarx;
			_x_ = _x;
			_y_ = _y;

			window.setTimeout('moveUImage(avatarDiv,avatary,avatarx,_x_,_y_)',100);

		}

	}

	//Remove inactive users
	function hideUsers(divUID){

		if(document.getElementById(divUID)){

			var d = document.getElementById('chatscreen');
			var olddiv = document.getElementById(divUID);
			d.removeChild(olddiv);

		}

	}

	//show user details (options window)
	function showUserDetails(dUid,dUser,dY,dX,dAdmin){

		//set this user details
		updateUser = dUser;

		//update votes
		updateUserPoints();

		// get the existing avatar div pos
		var dx = document.getElementById(dUid+"myAvatar").offsetLeft; // x axis
		var dy = document.getElementById(dUid+"myAvatar").offsetTop; // y axis

		if(dx<600){

			var dXX = Number(dx) + 50;

		}else{

			var dXX = Number(dx) - 210;

		}
		
		//build aboutme box
		document.getElementById('userdetails').style.left = dXX+'px';
		document.getElementById('userdetails').style.top  = dy+'px';
		document.getElementById('userdetails').style.padding="2px";

		

		document.getElementById('userdetails').style.left='684px';document.getElementById('userdetails').style.top='295px';document.getElementById('userdetails').style.padding="2px";document.getElementById('userdetails').innerHTML="<span class='userinfo' onClick=\"toggleBox('userdetails')\"><img src='images/pm01.png' style='float: right;margin-right: 2px;margin-top: 2px;'></span><iframe src='templates/userdata.php?user="+dUser+"' scrolling='no' style='border: 0px;width: 72px;height: 84px;margin-left: 19px;margin-top: 2px;margin-bottom: -86px;'></iframe><div style='margin-top: 93px;'><center>"+dUser+"</center></div><br>";if(chatProfileID=='0'){var userProfileUrl=chatProfileUrl+dUser;}else{var userProfileUrl=chatProfileUrl+dUid.replace(/_/gi,"");}
document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"toggleBox('userdetails');reqFriend('"+dUid+"','"+dUser+"')\"><img id='useradd' style='cursor:pointer;vertical-align:middle;padding-top:4px;margin-top: 1px;margin-left: 5px;' title='arkadaslara ekle' src=images/puser_add.png></span>";var getThisUserID="-"+dUid.replace(/_/gi,"");if(getThisUserID==room||dAdmin>0){document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"alert('bir hata olustu')\"><img id='z' style='vertical-align:middle;padding-top:4px;margin-top: 1px;margin-left: -11px;' title='engelle' src=images/pblock.png></span>";}else{document.getElementById('userdetails').innerHTML+="<span class='userinfo' ('"+dUid+"','"+dUser+"')\"><img id='block' style='vertical-align:middle;padding-top:4px;margin-top: 1px;margin-left: -11px;' title='engelle' src=images/pblock.png></span>";}
if(chatMemberLevel==1){document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"doWhisper('"+dUser+"')\"><img id='pchat' style='cursor:pointer;vertical-align:middle;padding-top:4px;margin-left: 62px;margin-top: -45px;' title='fisilda' src=images/pprivate_chat.png></span>";}else{document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"showVIP();\"><img id='pchat' style='cursor:pointer;vertical-align:middle;padding-top:4px;margin-left: 62px;margin-top: -45px;' title='fisilda' src=images/pprivate_chat.png></span>";}
document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"window.open('"+userProfileUrl+"','"+dUid+"')\"><img id='profile' style='cursor:pointer;vertical-align:middle;padding-top: 6px;margin-top: -21px;margin-left: 5px;' title='profiline git' src=images/pzoom.png></span>";document.getElementById('userdetails').innerHTML+="<span class='userinfo' onClick=\"sendVote('love', '"+dUid+"','"+dUser+"');toggleBox('userdetails');\"><img id='love' style='cursor:pointer;vertical-align:middle;padding-top:4px;width: 21px;height: 19px;margin-top: -14px;margin-left: -11px;' src=images/heart_add.png></span>";if(toWhisper!=dUser){document.getElementById('pchat').src="images/pprivate_chat.png";}else{}
dest_x=document.getElementById("_a_myAvatar").offsetLeft;dest_y=document.getElementById("_a_myAvatar").offsetTop;toggleBox('userdetails');moveAvatar='0';}
function hideUserDetails(){} {

		//document.getElementById('userdetails').style.visibility='hidden';

	}

	//show interaction window
	function showInteractionWindow(toUser){

		// reset custom interaction
		document.getElementById('custom_interaction').value ="";

		// grey out bg
		grayOut(true);
		
		// show indow
		document.getElementById('avatarInteraction').style.visibility="visible";		

		// assign to user name
		document.getElementById('avatarInteractionID').value = toUser;

		// pause avatar
		moveAvatar = '0';

	}

	//hide avatar interaction window
	function hideInteractionWindow(){

		// ungrey background
		grayOut(false);

		// hide window
		document.getElementById('avatarInteraction').style.visibility="hidden";

		// unset interaction message
		document.getElementById('message').value = "";

		// pause avatar
		moveAvatar = '0';

	}

	//send avatar interaction

	var isSystemMessage = '0';
	function sendInteraction(){

		var interactionToUser = document.getElementById('avatarInteractionID').value;

		for (var i=0; i < document.doInteraction._interaction.length; i++){

   			if (document.doInteraction._interaction[i].checked){

      				var iAction = cInteraction(document.doInteraction._interaction[i].value);
      			}
   		}

   		// check for custom interaction
     		whSpc = new RegExp(/^\s+$/);

     		if (document.getElementById('custom_interaction').value && whSpc.test(document.getElementById('custom_interaction').value)) {
          		alert('invalid interaction');
          		return false;
     		}

		if(document.getElementById('custom_interaction').value){

			var iAction = document.getElementById('custom_interaction').value;

		}

		// do interaction message
		document.getElementById('message').value = "** "+chatName+" "+iAction+" "+interactionToUser+"! **";

		// set system message
		isSystemMessage = '1';

		// send message
		showTxt();

		// hide window
		hideInteractionWindow();

		// pause avatar
		moveAvatar = '0';

	}

	//whisper to user

	var toWhisper = '';
	var sessionWhisper = '0';
	var inWhisper = '';

	function doWhisper(toUser){

		toWhisper = toUser;

		//change private chat icon
		//document.getElementById('pchat').src="images/private_chat_on.png";

		//hide aboutme
		document.getElementById('userdetails').style.visibility='hidden';

		//create private window
		createPChatWindow("_"+chatName.toLowerCase()+toWhisper.toLowerCase()+"_",toWhisper.toLowerCase());

		// hide any open chat windows

		activeChatWindow();

		showChatWindow("_"+chatName.toLowerCase()+toWhisper.toLowerCase()+"_",toWhisper.toLowerCase());


	}

	//Logout user
	function logOut() {

		//redirect to index
		window.location = "?do=logout";

	}

	//Load room
	function loadRoom(theRoom) {

		if(room == theRoom && editAvatar != 1){

			grayOut(false);

			document.getElementById('myrooms').style.visibility="hidden";

			// pause avatar
			moveAvatar = '0';

			// rest editAvatar
			editAvatar = 0;

			return false;

		}

		// pause avatar
		moveAvatar = '0';

		//redirect to index
		window.location = "?rID="+theRoom;

	}

	//Get Avatar
	function getAvatar() {

		//redirect to avatar creator
		window.open ("http://www.doppleme.com/","doppleme");

	}