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


	/** get user room ID **/

	//Define XmlHttpRequest
	var getUserRoomIDReq = getXmlHttpRequestObject();

	//Gets the blocked users
	function getUserRoomID() {

		var nickName = document.getElementById('goUser').value;

		if (getUserRoomIDReq.readyState == 4 || getUserRoomIDReq.readyState == 0) {
			getUserRoomIDReq.open("GET", 'includes/userroomid.php?nickName='+nickName, true);
			getUserRoomIDReq.onreadystatechange = handlegetUserRoomID; 
			getUserRoomIDReq.send(null);
		}
	}

	//Function for handling the user room id

	function handlegetUserRoomID() {

		if (getUserRoomIDReq.readyState == 4) {

			var xmldoc = getUserRoomIDReq.responseXML;
			var getUserRoomID_nodes = xmldoc.getElementsByTagName("userroomdetails"); 
			gotUserRoomID = getUserRoomID_nodes.length;

			if(!gotUserRoomID){

				alert("Sorry, this username does not exist.");

			}

			for (i = 0; i < gotUserRoomID; i++) {

				var roomID_node = getUserRoomID_nodes[i].getElementsByTagName("uroomid");

				// load room
				loadRoom(roomID_node[0].firstChild.nodeValue);

			}

		}

	}