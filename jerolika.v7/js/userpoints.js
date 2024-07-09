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


	//Define XmlHttpRequest
	var updatePTSReq = getXmlHttpRequestObject();

	//Gets the users points
	function updateUserPoints() {
		if (updatePTSReq.readyState == 4 || updatePTSReq.readyState == 0) {
			updatePTSReq.open("GET", 'includes/userlistData.php?roomID='+room+'&userPTS=1', true);
			updatePTSReq.onreadystatechange = handlePointsRequest; 
			updatePTSReq.send(null);
		}
			
	}

	//Function for handling the users points
	function handlePointsRequest() {

		if (updatePTSReq.readyState == 4) {

			var xmldoc = updatePTSReq.responseXML;
			var allUsers_nodes = xmldoc.getElementsByTagName("userdetails"); 
			var n_users = allUsers_nodes.length;

			for (i = 0; i < n_users; i++) {

				var user_node = allUsers_nodes[i].getElementsByTagName("usernames");
				var love_node = allUsers_nodes[i].getElementsByTagName("ulove");
				var like_node = allUsers_nodes[i].getElementsByTagName("ulike");
				var star_node = allUsers_nodes[i].getElementsByTagName("ustar");
				var credits_node = allUsers_nodes[i].getElementsByTagName("ucredits");

				if(love_node[0].firstChild.nodeValue >= 999){

					love_node[0].firstChild.nodeValue = 999;

				}

				if(like_node[0].firstChild.nodeValue >= 999){

					like_node[0].firstChild.nodeValue = 999;

				}

				if(star_node[0].firstChild.nodeValue >= 999){

					star_node[0].firstChild.nodeValue = 999;

				}

				if(document.getElementById('userdetails').style.visibility=='visible'){

					//assign points
					document.getElementById('lovepts').innerHTML = love_node[0].firstChild.nodeValue;
					document.getElementById('likepts').innerHTML = like_node[0].firstChild.nodeValue;
					document.getElementById('starpts').innerHTML = star_node[0].firstChild.nodeValue;

				}

				if(chatName.toLowerCase() == user_node[0].firstChild.nodeValue.toLowerCase()){

					//assign points
					document.getElementById('loveButton').innerHTML = love_node[0].firstChild.nodeValue;
					document.getElementById('likeButton').innerHTML = like_node[0].firstChild.nodeValue;
					document.getElementById('giftButton').innerHTML = star_node[0].firstChild.nodeValue;
					document.getElementById('creditsButton').innerHTML = credits_node[0].firstChild.nodeValue;

				}

			}

			//Clear out the existing timer so we don't have 
			//multiple timer instances running.
			clearInterval(uTimer);

			uTimer = '0';

		}

	}