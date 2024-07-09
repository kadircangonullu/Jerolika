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


	/** update audio **/

	//Define XmlHttpRequest
	var updateAUDIO = getXmlHttpRequestObject();

	//Send avatar details to database.
	function updateAUDIOUrl() {

		// get audio id
		var testAUDIOUrl = document.getElementById('newBM').value;

   		// check for white space (no url)
     		whSpc = new RegExp(/^\s+$/);

     		if (whSpc.test(testAUDIOUrl) || testAUDIOUrl=='' || testAUDIOUrl.search(/logout/i) != '-1') {
          		alert('invalid url');
          		return false;
     		}

		if(remoteAudio == 0){

			// local music streams

			if(testAUDIOUrl.search(/(http|ftp|https|www\.)/i) != '-1'){

				// music stream is remote url, show error 
				alert('Invalid Url');
				return false;
			}
		}

		var param = '?';

		param += '&uref=' + chatRef;
		param += '&uname=' + chatName;
		param += '&uid=' + chatID;
		param += '&uaction=updateMusic';
		param += '&umusic=' + testAUDIOUrl;

		// if ready to send message to DB
		if (updateAUDIO.readyState == 4 || updateAUDIO.readyState == 0) {

			updateAUDIO.open("POST", 'includes/sendData.php', true);
			updateAUDIO.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
			updateAUDIO.onreadystatechange = handleSendAudio;
			updateAUDIO.send(param);

		}

		// visual confirm
		confirmAction('cBackMusic');
			
	}

	//When our message has been sent, update our page.
	function handleSendAudio() {

		//Clear out the existing timer so we don't have 
		//multiple timer instances running.
		clearInterval(mTimer);

	}

	//Start audio stream (for user test purpose only)
	function testAUDIOUrl(){

		// get audio id
		var testAUDIOUrl = document.getElementById('newBM').value;

   		// check for white space (no url)
     		whSpc = new RegExp(/^\s+$/);

     		if (whSpc.test(testAUDIOUrl) || testAUDIOUrl=='' || testAUDIOUrl.search(/logout/i) != '-1') {
          		alert('invalid url');
          		return false;
     		}

		if(remoteAudio == 0){

			// local music streams

			if(testAUDIOUrl.search(/(http|ftp|https|www\.)/i) != '-1'){

				// music stream is remote url, show error 
				alert('Invalid Url');
				return false;
			}
		}

		// test audio url
		document.getElementById("AUDIOUrl").src=testAUDIOUrl;

	}

	//Check url extenstion
	function checkAudioEXT(str) {

		return str.substr(str.length-4);

	}