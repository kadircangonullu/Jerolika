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
	var mailReq = getXmlHttpRequestObject();

	var totalMailMessages = 0;

	//Gets the mail for this user
	function getMail() {

		// if inbox window is hidden
		if(document.getElementById('myinbox').style.visibility != 'visible'){

			// reset messages
			document.getElementById('myinbox').innerHTML = '';

			if (mailReq.readyState == 4 || mailReq.readyState == 0) {
				mailReq.open("GET", 'includes/mail.php', true);
				mailReq.onreadystatechange = gotMail; 
				mailReq.send(null);
			}

		}

		totalMailMessages = 0;
			
	}

	//Function for handling the mail
	function gotMail() {

		if (mailReq.readyState == 4) {

			var xmldoc = mailReq.responseXML;
			var allUsers_nodes = xmldoc.getElementsByTagName("mailinbox"); 
			var n_messages = allUsers_nodes.length;

			for (i = 0; i < n_messages; i++) {

				var mID_node = allUsers_nodes[i].getElementsByTagName("mid");
				var mUserID_node = allUsers_nodes[i].getElementsByTagName("muserid");
				var mUsername_node = allUsers_nodes[i].getElementsByTagName("musername");
				var mTousername_node = allUsers_nodes[i].getElementsByTagName("mtousername");
				var mMessage_node = allUsers_nodes[i].getElementsByTagName("mmessage");
				var mTime_node = allUsers_nodes[i].getElementsByTagName("mtime");
				var mStatus_node = allUsers_nodes[i].getElementsByTagName("mstatus");
		
				// show message
				showM(mID_node[0].firstChild.nodeValue, mUserID_node[0].firstChild.nodeValue, mUsername_node[0].firstChild.nodeValue, mTousername_node[0].firstChild.nodeValue, mMessage_node[0].firstChild.nodeValue, mTime_node[0].firstChild.nodeValue, mStatus_node[0].firstChild.nodeValue);
				

			}

			// check for new messages
			gTimer = setTimeout('getMail();',refreshMails);
			gTimer = 0;
		}

	}

	//Function for displaying the mail
	function showM(mID,mUserID,mUsername,mTousername,mMessage,mTime,mStatus){

		// unescape message

		mMessage = unescape(mMessage);

		mMessage = mMessage.replace(/</gi,"&#60;" );
		mMessage = mMessage.replace(/>/gi,"&#62;" );
		mMessage = mMessage.replace(/'/gi,"&#39;" );
		mMessage = mMessage.replace(/"/gi,"&#34;" );
		mMessage = mMessage.replace(/%/gi,"&#37;" );

		if(!document.getElementById("mail_"+mID)){

			//create div
			var ni = document.getElementById('myinbox');
			var newdiv = document.createElement('div');
			newdiv.setAttribute("id","mail_"+mID);
			newdiv.className='mymessages';

			if(mStatus=='new'){

				newdiv.innerHTML = "<img style='vertical-align:middle;' src=images/email.png>&nbsp;Gönderen: "+mUsername+"<br>Tarih: "+mTime+"<br><br>"+mMessage+"<br><br>";

				// update mail count
				totalMailMessages += 1;

				// show flashing icon
				document.getElementById("mailButton").style.backgroundImage ="url('images/newemail.gif')";

			}else{

				newdiv.innerHTML = "<img style='vertical-align:middle;' src=images/oldemail.png>&nbsp;Gönderen: "+mUsername+"<br>Tarih: "+mTime+"<br><br>"+mMessage+"<br><br>";

			}

			newdiv.innerHTML += "[<a href='javascript:void(0);' onClick=\"hideM('"+mID+"');\">Mesajý Sil</a>] ";
			newdiv.innerHTML += "[<a href='javascript:void(0);' onClick=\"replyM('"+mUsername+"','"+mMessage+"');\">Mesajý Cevapla</a>]<br>";
			ni.appendChild(newdiv);

			// show total messages
			document.getElementById('mailButton').innerHTML = totalMailMessages;
		}

	}


	//Reply to mail
	var setReplyMess = '';
	function replyM(rUser,rMessage){

		document.getElementById('sendmail').style.visibility = 'visible';
		document.getElementById('send_to').value = rUser;

		// toggle icon
		toggleStyle(this, 'sendmail', 'sendmailButton');

	}

	//Delete the mail
	function hideM(divmID){

		if(document.getElementById("mail_"+divmID)){

			// update mail count
			totalMailMessages = Number(totalMailMessages) - 1;

			// show total messages
			document.getElementById('mailButton').innerHTML = totalMailMessages;

			var d = document.getElementById('myinbox');
			var olddiv = document.getElementById("mail_"+divmID);
			d.removeChild(olddiv);

			dOldMail(divmID);

		}

	}

	//Define XmlHttpRequest
	var delMailReq = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function dOldMail(delMID) {

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&uaction=delmail';
		param += '&uroom=' + room;
		param += '&umessage=';
		param += '&uXX=' + dest_x;
		param += '&uYY=' + dest_y;
		param += '&umailID=' + delMID;

		// if ready to send message to DB
		if (delMailReq.readyState == 4 || delMailReq.readyState == 0) {

			delMailReq.open("POST", 'includes/sendData.php', true);
			delMailReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			delMailReq.onreadystatechange = handleSendDelMail;
			delMailReq.send(param);

		}
				
	}

	//When our message has been sent, update our page.
	function handleSendDelMail() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}

	//Define XmlHttpRequest
	var readMailReq = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function readOldMail() {

		// if inbox window is visible
		if(document.getElementById('myinbox').style.visibility != 'hidden'){

			var param = '?';

			param += '&uref=' + chatRef;
			param += '&uname=' + chatName;
			param += '&uid=' + chatID;
			param += '&uaction=readmail';
			param += '&uroom=' + room;
			param += '&umessage=';
			param += '&uXX=' + dest_x;
			param += '&uYY=' + dest_y;

			// if ready to send message to DB
			if (readMailReq.readyState == 4 || readMailReq.readyState == 0) {

				readMailReq.open("POST", 'includes/sendData.php', true);
				readMailReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				readMailReq.onreadystatechange = handleSendReadMail;
				readMailReq.send(param);

			}

		}
				
	}

	//When our message has been sent, update our page.
	function handleSendReadMail() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}