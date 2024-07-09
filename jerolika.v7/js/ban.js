/**

 Author: ReadLika
 Software: Sanalika PvP'si
 Url: http://readlika.tr.gp/
 ReadLika Bütün Haklari Saklidir (2012-2013)

 Avatar Chat and all of its source code/files are protected by Copyright Laws. 
 The license for Avatar Chat permits you to install this software on a single domain only (.com, .co.uk, .org, .net, etc.). 
 Each additional installation requires an additional software licence, please contact us for more information.
 You may NOT remove the copyright information and credits for Avatar Chat unless you have been granted permission. 
 Avatar Chat is NOT free software - For more details http://www.prochatrooms.com/software_licence.php

**/


	/** show all users **/

	//set total results
	var searchModUsersID = '0';

	//Define XmlHttpRequest
	var modUserReq = getXmlHttpRequestObject();

	//Gets the blocked users
	function modUsers() {
		if (modUserReq.readyState == 4 || modUserReq.readyState == 0) {
			modUserReq.open("GET", 'includes/ban.php?searchModUsersID='+searchModUsersID+'&roomID='+room, true);
			modUserReq.onreadystatechange = handleModUsers; 
			modUserReq.send(null);
		}

		document.getElementById('modpanel').innerHTML = "";
			
	}

	//Function for handling the blocked users

	var b_users=0;

	function handleModUsers() {

		if (modUserReq.readyState == 4) {

			var xmldoc = modUserReq.responseXML;
			var allUsers_nodes = xmldoc.getElementsByTagName("userdetails"); 
			b_users = allUsers_nodes.length;

			if(Number(b_users) == 0){

				searchModUsersID = Number(searchModUsersID) - 10;

				modUsers();
			}

			for (i = 0; i < b_users; i++) {

				var modID_node = allUsers_nodes[i].getElementsByTagName("uids");
				var modName_node = allUsers_nodes[i].getElementsByTagName("usernames");
				var modStatus_node = allUsers_nodes[i].getElementsByTagName("userstatus");
				var modAdmin_node = allUsers_nodes[i].getElementsByTagName("useradmin");
				var modRoom_node = allUsers_nodes[i].getElementsByTagName("userroom");
		
				// show users
				showModUsers(modID_node[0].firstChild.nodeValue,modName_node[0].firstChild.nodeValue,modStatus_node[0].firstChild.nodeValue,modRoom_node[0].firstChild.nodeValue,modAdmin_node[0].firstChild.nodeValue);

			}

		}

	}

	//function for prev options
	function searchModUsersPrev() {

		if(searchModUsersID > 0){

			searchModUsersID = Number(searchModUsersID)-10;

			modUsers();

		}

	}

	//function for next options
	function searchModUsersNext() {

		searchModUsersID = Number(searchModUsersID)+10;

		modUsers();

	}

	//Function for displaying the blocked users

	function showModUsers(mID,mName,mStatus,mRoom,mAdmin){

		// create prev | next links
		if(!document.getElementById("mod_page")){

			//create div
			var ni = document.getElementById('modpanel');
			var newdiv = document.createElement('div');
			newdiv.setAttribute("id","mod_page");
			newdiv.className='';
			newdiv.innerHTML = "<div style='padding: 2px;'>";

			if(b_users != 0 && searchModUsersID !=0){

				newdiv.innerHTML += "<a href='javascript:void(0);' onClick='searchModUsersPrev();'><img border='0' src='images/back.png'></a>&nbsp;";

			}

			if(b_users >= 10){

				newdiv.innerHTML += "<a href='javascript:void(0);' OnClick='searchModUsersNext();'><img border='0' src='images/forward.png'></a>";

			}

			newdiv.innerHTML += "</div>";

			ni.appendChild(newdiv);

		}


		if(!document.getElementById("mod_"+mID)){

			//create div
			var ni = document.getElementById('modpanel');
			var newdiv = document.createElement('div');
			newdiv.setAttribute("id","mod_"+mID);
			newdiv.className='';

			newdiv.innerHTML = "<div style='padding: 2px;'>";

			if(chatAdmin==1){ // super admin

				if(mStatus==0){ // kick - ban

					newdiv.innerHTML += "<img style='vertical-align:middle;' src=images/unlock.png> "+mName+" [<a href='javascript:void(0);' onClick=\"doKickUser('"+mID+"','"+mName+"','"+mRoom+"','1','"+mAdmin+"')\" title='Kick' alt='Kick'>Kick</a>]&nbsp;[<a href='javascript:void(0);' onClick=\"doModUser('"+mID+"','"+mName+"','"+mRoom+"','1','"+mAdmin+"')\" title='Ban' alt='Ban'>Ban</a>]";

				}

				if(mStatus==1){ // kick - banned

					newdiv.innerHTML += "<img style='vertical-align:middle;' src=images/lock.png> "+mName+" [<a href='javascript:void(0);' onClick=\"doKickUser('"+mID+"','"+mName+"','"+mRoom+"','1','"+mAdmin+"')\" title='Kick' alt='Kick'>Kick</a>]&nbsp;[<a href='javascript:void(0);' onClick=\"doModUser('"+mID+"','"+mName+"','"+mRoom+"','0','"+mAdmin+"')\" title='Unban' alt='Unban'>Unban</a>]";

				}

			}

			if(chatAdmin==0){ // user room admin - show kick only

					newdiv.innerHTML += "<img style='vertical-align:middle;' src=images/unlock.png> "+mName+" [<a href='javascript:void(0);' onClick=\"doKickUser('"+mID+"','"+mName+"','"+mRoom+"','1','"+mAdmin+"')\" title='Kick' alt='Kick'>Kick</a>]";

			}

			newdiv.innerHTML += "</div>";

			ni.appendChild(newdiv);

		}

	}

	/** ban/unban users **/

	//Define XmlHttpRequest
	var banReq = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function doModUser(mUid,mUname,mURoom,mAction,mUAdmin) {

		if(mUname.toLowerCase() == chatName.toLowerCase()){

			alert('You cannot ban yourself!');
			return false;

		}

		if(mUAdmin == '2'){

			alert('You cannot ban admins');
			return false;

		}

		var mActionTxt='';

		if(mAction == 0){

			mAction = 'unban';
			mActionTxt = 'unbanned';

		}else{

			mAction = 'ban';
			mActionTxt = 'banned';

		}

		//show message
		document.getElementById('sysmess').style.visibility='visible';
		document.getElementById('sysmess').innerHTML = "You have "+mActionTxt+" "+mUname+"<br>";

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&to_uname=' + mUname;
		param += '&ublock_id=' + mUid;
		param += '&uaction=' + mAction;
		param += '&uroom=' + mURoom;
		param += '&umessage=' + mActionTxt;
		param += '&uXX=' + dest_x;
		param += '&uYY=' + dest_y;

		// if ready to send message to DB
		if (banReq.readyState == 4 || banReq.readyState == 0) {

			banReq.open("POST", 'includes/sendData.php', true);
			banReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			banReq.onreadystatechange = handleModBan;
			banReq.send(param);

		}

		// set display message timeout
		sesstimeoutID = window.clearTimeout(mytimeoutID);;
		sesstimeoutID = window.setTimeout('hideSysMess()',5000);
				
	}

	/** kick users **/

	//Define XmlHttpRequest
	var kickReq = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function doKickUser(mUid,mUname,mURoom,mAction,mUAdmin) {

		if(mUname.toLowerCase() == chatName.toLowerCase()){

			alert('You cannot kick yourself!');
			return false;

		}

		if(mUAdmin == '2'){

			alert('You cannot kick admins');
			return false;

		}

		//show message
		document.getElementById('sysmess').style.visibility='visible';
		document.getElementById('sysmess').innerHTML = "You have kicked "+mUname+"<br>";

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&to_uname=' + mUname;
		param += '&ublock_id=' + mUid;
		param += '&uaction=kick';
		param += '&uroom=' + mURoom;
		param += '&umessage=kicked';
		param += '&uXX=' + dest_x;
		param += '&uYY=' + dest_y;

		// if ready to send message to DB
		if (kickReq.readyState == 4 || kickReq.readyState == 0) {

			kickReq.open("POST", 'includes/sendData.php', true);
			kickReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			kickReq.onreadystatechange = handleModBan;
			kickReq.send(param);

		}

		//toggle icon
		toggleStyle(this,'lock','modButton')

		//hide blockuser list
		document.getElementById('modpanel').style.visibility='hidden';

		// refresh blocked users
		modUsers();

		// set display message timeout
		sesstimeoutID = window.clearTimeout(mytimeoutID);
		sesstimeoutID = window.setTimeout('hideSysMess()',5000);
				
	}

	//When our message has been sent, update our page.
	function handleModBan() {

		// refresh blocked users
		modUsers();

	}