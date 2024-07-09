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


	/** update avatar **/

	//Define XmlHttpRequest
	var updateAvi_ = getXmlHttpRequestObject();

	var editAvatar = 0;

	//Send avatar details to database.
	function updateAvatar() {

		// get avatar id
		var testAviID = document.getElementById('newAvatarID').value;

		// get avatar id
		var testAviID_s = document.getElementById('newAvatarID_slot').value;

		// check for alphanumeric characters only
		var regex=/^[0-9A-Z]+$/; // or use [0-9A-Za-z]

		// check for numeric characters only
		var regex_s=/^[0-9]+$/;

		if(regex.test(testAviID) && regex_s.test(testAviID_s)){

			var param = '?';

			param += '&uref=' + chatRef;
			param += '&uname=' + chatName;
			param += '&uid=' + chatID;
			param += '&uaction=updateAvatar';
			param += '&uavIDs=' + testAviID_s;
			param += '&uavatar=/images'+testAviID+'/avatar.png';

			// if ready to send message to DB
			if (updateAvi_.readyState == 4 || updateAvi_.readyState == 0) {

				updateAvi_.open("POST", 'includes/sendData.php', true);
				updateAvi_.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				updateAvi_.onreadystatechange = handleSendAvi_;
				updateAvi_.send(param);

			}

			// change the edit avatar value to 1
			// this allows us to reload the room
			// after the avatar has been updated
			editAvatar = 1;

			// reload room
			sesstimeoutID = window.clearTimeout(mytimeoutID);;
			sesstimeoutID = window.setTimeout('loadRoom(room)',500);

		}else{

			// error 
			alert('Invalid DoppleMe Key');
			return false;

		}
			
	}

	//When our message has been sent, update our page.
	function handleSendAvi_() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}

/**

	//Show new avatar (for user test purpose only)
	function testAvatar(){

		// pause avatar
		moveAvatar = '0';

		// get avatar id
		var testAviID = document.getElementById('newAvatarID').value;

		// get avatar id
		var testAviID_s = document.getElementById('newAvatarID_slot').value;

		// check for numeric characters only
		var regex_s=/^[0-9]+$/;

		// check for alphanumeric characters only
		var regex=/^[0-9A-Z]+$/;

		if(regex.test(testAviID) && regex_s.test(testAviID_s)){

			// show test avatar
			document.getElementById('exAvatar_'+testAviID_s).innerHTML = '<img src="/images'+testAviID+'/avatar.png" />';

		}else{

			// error 
			alert('Invalid DoppleMe Key');
			return false;

		}

	}

**/

	//Show new avatar (for user test purpose only)
	function testAvatarUrl(){

		// pause avatar
		moveAvatar = '0';

		// get avatar url
		var testAviUrl = document.getElementById('newAvatarUrl').value;

		// get avatar id
		var testAviID_s = document.getElementById('newAvatarUrl_slot').value;

		// check url ends in an image extenstion
		var imgType = checkEXT(testAviUrl);

		if(imgType.toLowerCase()!='.jpg' && imgType.toLowerCase()!='.gif' && imgType.toLowerCase()!='.png'){

          		alert('invalid image type, use .jpg, .gif or .png only');
          		return false;

		}

		if(testAviUrl.search(/logout/i) != '-1'){

          		alert('Invalid Avatar Url');
          		return false;

		}

		if(enableDoppleMe == 1){

			// check for valid url format
			var regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

			if(regex.test(testAviUrl)){

				// show test avatar
				document.getElementById('exAvatar_'+testAviID_s).innerHTML = '<img src="'+testAviUrl+'" height="120" width="60"/>';

			}else{

				// error 
				alert('Invalid Avatar Url');
				return false;
			}
		}

		if(enableDoppleMe == 0){

			// check avatar image is local path, not remote

			if(testAviUrl.search(/(http|ftp|https|www\.)/i) == '-1'){

				// show test avatar
				document.getElementById('exAvatar_'+testAviID_s).innerHTML = '<img src="'+testAviUrl+'" height="120" width="60"/>';

			}else{

				// image is remote url, show error 
				alert('Invalid Avatar Url');
				return false;
			}

		}

	}

	//Send avatar details to database.
	function updateAvatarUrl() {

		// get avatar url
		var testAviUrl = document.getElementById('newAvatarUrl').value;

		// get avatar id
		var testAviUrl_s = document.getElementById('newAvatarUrl_slot').value;

		// check url ends in an image extenstion
		var imgType = checkEXT(testAviUrl);

		if(imgType.toLowerCase()!='.jpg' && imgType.toLowerCase()!='.gif' && imgType.toLowerCase()!='.png'){

          		alert('invalid image type, use .jpg, .gif or .png only');
          		return false;

		}

		if(testAviUrl.search(/logout/i) != '-1'){

          		alert('Invalid Avatar Url');
          		return false;

		}

		var sendAvatarData = 0;

		if(enableDoppleMe == 1){

			// check for valid url format
			var regex = /(ftp|http|https):\/\/(\w+:{0,1}\w*@)?(\S+)(:[0-9]+)?(\/|\/([\w#!:.?+=&%@!\-\/]))?/;

			if(regex.test(testAviUrl)){

				sendAvatarData = 1;

			}else{

				// error 
				alert('Invalid Avatar Url');
				return false;
			}
		}

		if(enableDoppleMe == 0){

			// check avatar image is local path, not remote

			if(testAviUrl.search(/(http|ftp|https|www\.)/i) == '-1'){

				sendAvatarData = 1;

			}else{

				// image is remote url, show error 
				alert('Invalid Avatar Url');
				return false;
			}

		}

		if(sendAvatarData == 1){

			var param = '?';

			param += '&uref=' + chatRef;
			param += '&uname=' + chatName;
			param += '&uid=' + chatID;
			param += '&uaction=updateAvatar';
			param += '&uavIDs=' + testAviUrl_s;
			param += '&uavatar='+ testAviUrl;

			// if ready to send message to DB
			if (updateAvi_.readyState == 4 || updateAvi_.readyState == 0) {

				updateAvi_.open("POST", 'includes/sendData.php', true);
				updateAvi_.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
				updateAvi_.onreadystatechange = handleSendAvi_;
				updateAvi_.send(param);

			}

			// change the edit avatar value to 1
			// this allows us to reload the room
			// after the avatar has been updated
			editAvatar = 1;

			// reload room
			sesstimeoutID = window.clearTimeout(mytimeoutID);;
			sesstimeoutID = window.setTimeout('loadRoom(room)',500);

			// reset
			sendAvatarData = 0;

		}
			
	}

	// function reload avatar
	function reloadAvatar(theAvatar){

		// empty

	}
