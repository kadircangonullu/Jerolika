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
var sendReq = getXmlHttpRequestObject();

var setRightSpeech;
var mytimeoutID;

//Show message to this user
function showTxt(){

	// hide speech bubble
	hideSpeech();

	// clear previous message
	document.getElementById('_a_myMessage').value = '';

	// show new message
	var doMessage = document.getElementById('message').value;

   	// check for white space (no message)
     	whSpc = new RegExp(/^\s+$/);

     	if (whSpc.test(doMessage) || doMessage=='') {
          	alert('Mesaj Yazmadiniz');
          	return false;
     	}

	doMessage = doMessage.replace(/&/,"&#38;");

	var mLength=document.getElementById('message').value.split("").length;
	for (i = 0; i < mLength; i++) {

		doMessage = doMessage.replace(/</,"&#60;");
		doMessage = doMessage.replace(/>/,"&#62;");
		doMessage = doMessage.replace(/'/,"&#39;");
		doMessage = doMessage.replace(/"/,"&#34;");
		doMessage = doMessage.replace(/%/,"&#37;");

	}

	// add smilies

	var mLength=document.getElementById('message').value.split("").length;
	for (i = 0; i < mLength; i++) {

		// convert smilie
		doMessage = convertSmilies(doMessage);
	}

	// badword filter
	doMessage = filterBadword(doMessage);

	// send message to database
	sendChatText(doMessage);

	// add smilies in message
	doMessage = addSmilies(doMessage);

	// show message to user
	document.getElementById('_a_myMessage').innerHTML = doMessage;

	// set padding for speech bubble
	document.getElementById("_a_myMessage").style.paddingTop="11px";

	// clear message box, ready for next message
	document.getElementById('message').value = '';

	//unset message
	doMessage='';

	// set display message timeout
	mytimeoutID = window.clearTimeout(mytimeoutID);;
	mytimeoutID = window.setTimeout('hideSpeech()',showUserChat);

	//Default pos
	var posShowX = 20;
	var posShowXX = 15;

	//Reverse speech bubble if user is too far right

	if(x > 400){

		// move speech bubble left 
		posShowX = 20 - document.getElementById("_a_myMessage").clientWidth;

		// set padding
		document.getElementById("_a_myMessage").style.paddingLeft="0px";
		document.getElementById("_a_myMessage").style.paddingRight="0px";

		// reverse speech bubble
		var doRe = 1;

		// assign xx value
		posShowXX = 5;

	}else{

		// set padding
		document.getElementById("_a_myMessage").style.paddingLeft="0px";
		document.getElementById("_a_myMessage").style.paddingRight="10px";

		// default speech bubble
		var doRe = 0;

	}
	
	//Move the speech bubble

	yy = y - 50;
	xx = x + posShowX;

	document.getElementById("_a_myMessage").style.left = xx+'px';
	document.getElementById("_a_myMessage").style.top  = yy+'px';
	document.getElementById("_a_myMessage").style.height = '38px'; // 34
	document.getElementById("_a_myMessage").style.background="url(images/sp2.png)";

	//assign left div

	yyy = y - 50;
	xxx = xx - posShowXX;

	document.getElementById("l_myMessage").style.left = xxx+'px';
	document.getElementById("l_myMessage").style.top  = yyy+'px';

	if(doRe==0){

		// default
		document.getElementById("l_myMessage").style.height = '48px';
		document.getElementById("l_myMessage").style.width = '16px';
		document.getElementById("l_myMessage").style.background="url(images/sp1.png)";

	}else{

		document.getElementById("l_myMessage").style.height = '43px';
		document.getElementById("l_myMessage").style.width = '6px';
		document.getElementById("l_myMessage").style.background="url(images/sp3rev.png)";

	}

	//set posistion for right speech bubble

	setRightSpeech = document.getElementById("_a_myMessage").clientWidth;

	// assign right div

	yyyy = y - 50;
	xxxx = xx + setRightSpeech;

	document.getElementById("r_myMessage").style.left = xxxx+'px';
	document.getElementById("r_myMessage").style.top  = yyyy+'px';

	if(doRe==0){

		// default
		document.getElementById("r_myMessage").style.height = '43px';
		document.getElementById("r_myMessage").style.width = '6px';
		document.getElementById("r_myMessage").style.background="url(images/sp3.png)";

	}else{

		document.getElementById("r_myMessage").style.height = '48px';
		document.getElementById("r_myMessage").style.width = '16px';
		document.getElementById("r_myMessage").style.background="url(images/sp1rev.png)";

	}

	//show speech bubble
	document.getElementById("_a_myMessage").style.visibility='visible';
	document.getElementById("l_myMessage").style.visibility='visible';
	document.getElementById("r_myMessage").style.visibility='visible';

}

//Add a message to the chat server.
var dest_x_prev = 0;
var dest_y_prev = 0;
function sendChatText(message) {

	// use previous X/Y posistion
	// prevents user from moving

	if(dest_x_prev){
		dest_x = dest_x_prev;
		dest_y = dest_y_prev;
	}

	// link emails
	// message = message.replace(/([\w.-]+@[\w.-]+\.[\w]+)/gi, '<a href="mailto:$1">$1</a>');

	// link urls
	// message = message.replace(/(http[s]?:\/\/[\S]+)/gi, '<a href="$1" target="_blank">$1</a>');

	var param = '?';

	param += '&uroom=' + room;
	param += '&umessage=' + escape(message);
	param += '&uref=' + chatRef;
	param += '&uname=' + chatName;
	param += '&to_uname=' + toWhisper;
	param += '&uid=' + chatID;

	if(isSystemMessage=='0'){

		param += '&uaction=message';

	}else{

		param += '&uaction=interaction';

	}

	param += '&uXX=' + dest_x;
	param += '&uYY=' + dest_y;

	// if ready to send message to DB
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {

		sendReq.open("POST", 'includes/sendData.php', true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleSendChat;
		sendReq.send(param);

	}

	//add message to chatbox

	if(toWhisper==''){

		var toWhisperName='-';

	}else{

		var toWhisperName=toWhisper;
	}

	if(isSystemMessage == '0'){

		showMessages('message',parseInt(messageID)+1,chatName,toWhisperName,message,'_'+chatRef+'_','','');

	}else{

		showMessages('interaction',parseInt(messageID)+1,chatName,toWhisperName,message,'_'+chatRef+'_','','');

	}

	// empty whisper
	// toWhisper='';

	// reset system message
	isSystemMessage = '0';
				
}

//Add vote to the chat server.

//Define XmlHttpRequest
var gPTSReq = getXmlHttpRequestObject();

var voteID = '';

function sendVote(vAction, vID, vtoUser) {

	//format vote message
	if(vAction=='love'){vMessage = " Sana heart.png Puani Yolladi ";voteID = 1;}
	if(vAction=='like'){vMessage = " Sana thumbs_up.png Puani Yolladi ";voteID = 2;}
	if(vAction=='star'){vMessage = " Sana star.png Puani Yolladi ";voteID = 3;}

	//Check if user has already voted
	function getUserPoints() {
		if (gPTSReq.readyState == 4 || gPTSReq.readyState == 0) {
			gPTSReq.open("GET", 'includes/votes.php?voteID='+voteID+'&to_uname='+vtoUser, true);
			gPTSReq.onreadystatechange = handleGPointsRequest; 
			gPTSReq.send(null);
		}
			
	}

	getUserPoints();

	//Function for handling the points request
	function handleGPointsRequest() {

		if (gPTSReq.readyState == 4) {

			var xmldoc = gPTSReq.responseXML;
			var allUsers_nodes = xmldoc.getElementsByTagName("uservote"); 
			var n_votes = allUsers_nodes.length;

			for (i = 0; i < n_votes; i++) {

				var user_points = allUsers_nodes[i].getElementsByTagName("gotpoints");

				if(user_points[0].firstChild.nodeValue == 1){

					//show system message
					document.getElementById('sysmess').style.visibility='visible';
					document.getElementById('sysmess').innerHTML = "Zaten Puan Yollamýþsýn";

					// set display message timeout
					sesstimeoutID = window.clearTimeout(mytimeoutID);;
					sesstimeoutID = window.setTimeout('hideSysMess()',5000);

				}else{

					// send vote

					var param = '?';

					param += '&uroom=' + room;
					param += '&umessage='+chatName+escape(vMessage)+vtoUser;
					param += '&uref=' + chatRef;
					param += '&uname=' + chatName;
					param += '&uid=' + chatID;
					param += '&to_uname=' + vtoUser;
					param += '&uXX=' + dest_x;
					param += '&uYY=' + dest_y;
					param += '&uaction='+vAction;
					param += '&uvote='+vID;

					// if ready to send message to DB
					if (gPTSReq.readyState == 4 || gPTSReq.readyState == 0) {

						gPTSReq.open("POST", 'includes/sendData.php', true);
						gPTSReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
						gPTSReq.onreadystatechange = handleSendChat;
						gPTSReq.send(param);

					}

					//show system message
					document.getElementById('sysmess').style.visibility='visible';
					document.getElementById('sysmess').innerHTML = "Puan Yollama Baþarýlý";

					// set display message timeout
					sesstimeoutID = window.clearTimeout(mytimeoutID);;
					sesstimeoutID = window.setTimeout('hideSysMess()',5000);

					//add message to chatbox
					showMessages(vAction,parseInt(messageID)+1,chatName,'-',chatName+vMessage+vtoUser,'_'+chatRef+'_','','');

					// update points
					updateUserPoints();

				}

			}

		}

	}

}

//Send mail to server.

function sendUserMail() {

		//format vote message
		var sendMailUser = document.getElementById("send_to").value;
		var sendMailMessage = document.getElementById("send_mail_mess").value;

   		// check for white space (no message)
     		whSpc = new RegExp(/^\s+$/);

     		if (sendMailUser=='' || sendMailMessage=='' || whSpc.test(sendMailUser) || whSpc.test(sendMailMessage)) {
          		alert('no name and/or message');
          		return false;
     		}

     		if (chatName.toLowerCase() == sendMailUser.toLowerCase()) {
          		alert('cannot send message to yourself');
          		return false;
     		}

		// check for alphanumeric and underscores

     		vCharCheck = new RegExp(/^[A-Za-z0-9_]+$/);

     		if (!vCharCheck.test(sendMailUser)) {
          		alert('username must contain alphanumeric and underscore characters only');
          		return false;
     		}

		var mLength=document.getElementById('send_to').value.split("").length;
		for (i = 0; i < mLength; i++) {

			sendMailMessage = sendMailMessage.replace(/</,"&#60;");
			sendMailMessage = sendMailMessage.replace(/>/,"&#62;");
			sendMailMessage = sendMailMessage.replace(/'/,"&#39;");
			sendMailMessage = sendMailMessage.replace(/"/,"&#34;");
			sendMailMessage = sendMailMessage.replace(/%/,"&#37;");
			sendMailMessage = sendMailMessage.replace(/\n/," ");

		}

		var mLength=document.getElementById('send_mail_mess').value.split("").length;
		for (i = 0; i < mLength; i++) {

			sendMailMessage = sendMailMessage.replace(/</,"&#60;");
			sendMailMessage = sendMailMessage.replace(/>/,"&#62;");
			sendMailMessage = sendMailMessage.replace(/'/,"&#39;");
			sendMailMessage = sendMailMessage.replace(/"/,"&#34;");
			sendMailMessage = sendMailMessage.replace(/%/,"&#37;");
			sendMailMessage = sendMailMessage.replace(/\n/," ");

		}

		var param = '?';

		param += '&umessage=' + escape(sendMailMessage);
		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&to_uname=' + sendMailUser;
		param += '&uaction=sendmail';
		param += '&uXX=' + dest_x;
		param += '&uYY=' + dest_y;		

		// if ready to send message to DB
		if (sendReq.readyState == 4 || sendReq.readyState == 0) {

			sendReq.open("POST", 'includes/sendData.php', true);
			sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			sendReq.onreadystatechange = handleSendChat;
			sendReq.send(param);

		}

		//reset mail data
		document.getElementById("send_to").value = '';
		document.getElementById("send_mail_mess").value = '';

		//show system message
		document.getElementById('sysmess').style.visibility='visible';
		document.getElementById('sysmess').innerHTML = "Mesajýnýz Ýletildi";

		// set display message timeout
		sesstimeoutID = window.clearTimeout(mytimeoutID);;
		sesstimeoutID = window.setTimeout('hideSysMess()',5000);

}
		
//When our message has been sent, update our page.
function handleSendChat() {

	//Clear out the existing timer so we don't have 
	//multiple timer instances running.
	clearInterval(mTimer);

}

// function for form submit
function blockSubmit() {

	showTxt();
	return false;
}

// function for submitting via enter key
function submitenter(myfield,e){

	var keycode;

	if (window.event) keycode = window.event.keyCode;
	else if (e) keycode = e.which;
	else return true;

	if (keycode == 13){

		showTxt();
		return false;

	}

	else return true;

}