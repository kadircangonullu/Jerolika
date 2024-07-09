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


	/** update background **/

	//Define XmlHttpRequest
	var updateTBG = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function updateUserBG() {

		// get the BG url
			var doBGUrl = document.getElementById('newBG').value;

   		// check for white space (no url)
     		whSpc = new RegExp(/^\s+$/);

     		if (whSpc.test(doBGUrl) || doBGUrl=='' || doBGUrl=='http://' || doBGUrl.search(/logout/i) != '-1') {
          		alert('invalid url');
          		return false;
     		}

		if(remoteBg == 0){

			// local backgrounds

			if(doBGUrl.search(/(http|ftp|https|www\.)/i) != '-1'){

				// image is remote url, show error 
				alert('Invalid Url');
				return false;
			}
		}

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&uaction=updateBG';
		param += '&roomBG=' + doBGUrl;

		// if ready to send message to DB
		if (updateTBG.readyState == 4 || updateTBG.readyState == 0) {

			updateTBG.open("POST", 'includes/sendData.php', true);
			updateTBG.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			updateTBG.onreadystatechange = handleSendBlock;
			updateTBG.send(param);

			// reload room
			loadRoom('-' + chatRef);

			// visual confirm
			confirmAction('cBackUrl');

		}
			
	}

	//When our message has been sent, update our page.
	function handleSendBlock() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}

	//Test new background
	function loadBGTest(){

		// get new background url
		var doBGUrl = document.getElementById('newBG').value;

   		// check for white space (no url)
     		whSpc = new RegExp(/^\s+$/);

     		if (whSpc.test(doBGUrl) || doBGUrl=='' || doBGUrl=='http://' || doBGUrl.search(/logout/i) != '-1') {

          		alert('invalid url');
          		return false;

		}

		// check url ends in an image extenstion
		var imgType = checkEXT(doBGUrl);

		if(imgType.toLowerCase()!='.jpg' && imgType.toLowerCase()!='.gif' && imgType.toLowerCase()!='.png'){

          		alert('invalid image type, use .jpg, .gif or .png only');
          		return false;

		}

		if(remoteBg == 0){

			// local backgrounds

			if(doBGUrl.search(/(http|ftp|https|www\.)/i) == '-1'){

				// load image
				document.getElementById("_roomBG_").src = doBGUrl;
			}else{

				// image is remote url, show error 
				alert('Invalid Url');
				return false;
			}

		}else{

			// remote backgrounds, load image
			document.getElementById("_roomBG_").src = doBGUrl;
		}

	}

	//Check url extenstion
	function checkEXT(str) {

		return str.substr(str.length-4);

	}

	/** update start posistion **/

	//Define XmlHttpRequest
	var updateSP = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function updateUserSP() {

		// get new X value
		var newSXY = document.getElementById('newStartX').value;

		// get new Y value
		var newSPY = document.getElementById('newStartY').value;

		// check for alphanumeric characters only
		var regex=/^[0-9]+$/;

		if(!regex.test(newSXY) || !regex.test(newSPY)){

			alert("both X and Y values must be numeric")
			return false;

		}

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&uaction=updateSPXY';
		param += '&setX=' + newSXY;
		param += '&setY=' + newSPY;

		// if ready to send message to DB
		if (updateSP.readyState == 4 || updateSP.readyState == 0) {

			updateSP.open("POST", 'includes/sendData.php', true);
			updateSP.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			updateSP.onreadystatechange = handleSendSP;
			updateSP.send(param);

			// set reload room timeout
			sesstimeoutID = window.clearTimeout(mytimeoutID);;
			sesstimeoutID = window.setTimeout('loadRoom(room)',500);

			// visual confirm
			confirmAction('cAvatarStart');

		}
			
	}

	//When our message has been sent, update our page.
	function handleSendSP() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}

	/** change room name **/

	//Define XmlHttpRequest
	var updateRoomName = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function updateURoomName() {

		// get avatar id
		var testRoomname = document.getElementById('newRoomName').value;

		// check for alphanumeric and spaces characters only
		var regex=/^[0-9a-zA-Z\s]+$/;

		if(regex.test(testRoomname)){

			var param = '?';

			param += '&uref=' + chatRef;
			param += '&uname=' + chatName;
			param += '&uid=' + chatID;
			param += '&uaction=updateRName';
			param += '&newname=' + testRoomname;

			// if ready to send message to DB
			if (updateRoomName.readyState == 4 || updateRoomName.readyState == 0) {

				updateRoomName.open("POST", 'includes/sendData.php', true);
				updateRoomName.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				updateRoomName.onreadystatechange = handleSendBlock;
				updateRoomName.send(param);

				// reload room
				loadRoom('-' + chatRef);

				// visual confirm
				confirmAction('cRoomName');

			}

		}else{

			// error 
			alert('Invalid Room Name - Alphanumeric characters only [0-9A-Za-z]');
			return false;

		}
			
	}

	/** change room access **/

	//Define XmlHttpRequest
	var updateRoomAccess = getXmlHttpRequestObject();

	//Add a message to the chat server.
	function updateURoomAccess() {

		// get avatar id
		var newRoomAccess = document.getElementById('roomAccess').value;

		// check for numeric characters only
		var regex=/^[0-9]/;

		if(regex.test(newRoomAccess)){

			var param = '?';

			param += '&uref=' + chatRef;
			param += '&uname=' + chatName;
			param += '&uid=' + chatID;
			param += '&uaction=updateRAccess';
			param += '&newaccess=' + newRoomAccess;

			// if ready to send message to DB
			if (updateRoomAccess.readyState == 4 || updateRoomAccess.readyState == 0) {

				updateRoomAccess.open("POST", 'includes/sendData.php', true);
				updateRoomAccess.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				updateRoomAccess.onreadystatechange = handleSendBlock;
				updateRoomAccess.send(param);

				// reload room
				loadRoom('-' + chatRef);

				// visual confirm
				confirmAction('cRoomAccess');

			}

		}else{

			// error 
			alert('Invalid Room Access');
			return false;

		}
			
	}

	// show visual update confirm

	var hdiv;

	function confirmAction(sdiv){

		// assign value for hiding tick
		hdiv = sdiv;

		// show confirm image
		document.getElementById(sdiv).innerHTML = "<img src=images/check.png align=absmiddle height=20 width=20>";

		setTimeout("hideconfirmAction()",1000);
	}

	// hide visual update confirm
	function hideconfirmAction(){

		// show confirm image
		document.getElementById(hdiv).innerHTML = "";
	}