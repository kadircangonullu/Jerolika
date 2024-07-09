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
var sendReq = getXmlHttpRequestObject();

var thisDiv = '';

// set movement rate
var interval = 10; //Move 10px per request

function hideSpeech(){

	document.getElementById("_a_myMessage").style.visibility='hidden';
	document.getElementById("l_myMessage").style.visibility='hidden';
	document.getElementById("r_myMessage").style.visibility='hidden';

}

function moveImage(DivID) {

	//check if movement is allowed

	if(denyMove == '1'){

		return false;
	}

	//Keep on moving the image till the target is achieved

	if(x<dest_x) x = x + interval; 
	if(y<dest_y) y = y + interval;
	if(x>dest_x) x = x - interval; 
	if(y>dest_y) y = y - interval;

	//Default pos
	var posShowX = 20;
	var posShowXX = 15;

	//Reverse speech bubble if user is too far right

	if(x > 400){

		// move speech bubble left 
		posShowX = 20 - document.getElementById(DivID+"myMessage").clientWidth;

		// set padding
		document.getElementById(DivID+"myMessage").style.paddingLeft="10px";
		document.getElementById(DivID+"myMessage").style.paddingRight="0px";

		// reverse speech bubble
		var doRe = 1;

		// assign xx value
		posShowXX = 5;

	}else{

		// set padding
		document.getElementById(DivID+"myMessage").style.paddingLeft="0px";
		document.getElementById(DivID+"myMessage").style.paddingRight="10px";

		// default speech bubble
		var doRe = 0;

	}
	
	//Move the speech bubble

	yy = y - 50;
	xx = x + posShowX;

	document.getElementById(DivID+"myMessage").style.left = xx+'px';
	document.getElementById(DivID+"myMessage").style.top  = yy+'px';
	document.getElementById(DivID+"myMessage").style.height = '34px';
	document.getElementById(DivID+"myMessage").style.background="url(images/sp2.png)";

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

	setRightSpeech = document.getElementById(DivID+"myMessage").clientWidth;

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

	// move avater

	document.getElementById(DivID+"myAvatar").style.top  = y+'px';
	document.getElementById(DivID+"myAvatar").style.left = x+'px';

	if ((x+interval < dest_x) || (y+interval < dest_y) || (x-interval > dest_x) || (y-interval > dest_y)) {

	/**

		** defines the 4 way movement for character images
		** characters front, back, right and left (in sequence)
		** this feature may be introduced in future versions ;)

		if((y+interval < dest_y)){

			// show down image
			document.getElementById("image").src = "avatar/man/down.gif";

		}

		if((y-interval > dest_y)){

			// show up image
			document.getElementById("image").src = "avatar/man/up.gif";

		}

		if((x+interval < dest_x)){

			// show left image
			document.getElementById("image").src = "avatar/man/right.gif";

		}

		if((x-interval > dest_x)){

			// show right image
			document.getElementById("image").src = "avatar/man/left.gif";

		}

	**/

		//Keep on calling this function every 100 microsecond 
		//till the target location is reached

		thisDiv = DivID;

		window.setTimeout('moveImage(thisDiv)',100);

	}

}

//Send action to the database.
function moveAvatarIMG() {

	if(moveAvatar == '0' || denyMove == '1'){

		return false;

	}

	var param = '?';

	param += '&uroom=' + room;
	param += '&uname=' + chatName;
	param += '&uid=' + chatID;
	param += '&uaction=move';
	param += '&uXX=' + dest_x;
	param += '&uYY=' + dest_y;

	// if ready to send message to DB
	if (sendReq.readyState == 4 || sendReq.readyState == 0) {

		sendReq.open("POST", 'includes/sendData.php', true);
		sendReq.setRequestHeader('Content-Type','application/x-www-form-urlencoded');
		sendReq.onreadystatechange = handleSendXY;
		sendReq.send(param);

	}
				
}

//When our message has been sent, update our page.
function handleSendXY() {

	//Clear out the existing timer so we don't have 
	//multiple timer instances running.
	clearInterval(mTimer);


}

// function IE
function showit() {

	if(document.getElementById('userdetails').style.visibility!='visible'){

		if(document.getElementById('sendmail').style.visibility!='visible'){

			//document.getElementById('message').focus();

		}

		var DivCpHeight = 10 + document.getElementById("controlpanel").offsetHeight;
		var DivAvHeight = DivCpHeight + document.getElementById("_a_myAvatar").offsetHeight;

		if(event.y < (mHeight - DivAvHeight)){

			dest_x_prev = dest_x; // save previous posistion
			dest_y_prev = dest_y; // save previous posistion

			dest_x = event.x; // set new pos X
			dest_y = event.y; // set new pos Y

			// assign edges of screen (800x600)
			if(dest_x < 10) {dest_x = 10;}
			if(dest_y < 30) {dest_y = 30;}
			if(dest_x > 740) {dest_x = 740;}
			if(dest_y > 460) {dest_y = 460;}

			// assign out of bounds areas
			if(dest_x > 640 && dest_y < 60) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			// assign out of bounds welcome splash
			if(moveAvatar == 0) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			// assign out of bounds for chat window
			if(document.getElementById('chatoptions').style.visibility!='hidden' && (dest_x < 300 && dest_y > 430)) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			moveAvatar = '1';

			//hide system message
			//document.getElementById('sysmess').style.visibility='hidden';

			//move image
			moveImage('_a_');

			//send avatar data
			moveAvatarIMG();

		}

	}

	// check room pos

	if(room== '-'+chatRef){
	
		cursorPos();

	}

}

// function all other browsers
function showitMOZ(e){

	if(document.getElementById('userdetails').style.visibility!='visible'){

		if(document.getElementById('sendmail').style.visibility!='visible'){

			//document.getElementById('message').focus();

		}

		var DivCpHeight = 10 + document.getElementById("controlpanel").offsetHeight;
		var DivAvHeight = DivCpHeight + document.getElementById("_a_myAvatar").offsetHeight;
	
		if(e.pageY < (mHeight - DivAvHeight)){

			dest_x_prev = dest_x; // save previous posistion
			dest_y_prev = dest_y; // save previous posistion
	
			dest_x = e.pageX; // set new pos X
			dest_y = e.pageY; // set new pos Y

			// assign edges of screen (800x600)
			if(dest_x < 10) {dest_x = 10;}
			if(dest_y < 30) {dest_y = 30;}
			if(dest_x > 740) {dest_x = 740;}
			if(dest_y > 460) {dest_y = 460;}

			// assign out of bounds areas
			if(dest_x > 670 && dest_y < 70) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			// assign out of bounds welcome splash
			if(moveAvatar == 0) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			// assign out of bounds for chat window
			if(document.getElementById('chatoptions').style.visibility!='hidden' && (dest_x < 300 && dest_y > 430)) {

				dest_x = dest_x_prev; // use previous posistions
				dest_y = dest_y_prev; // use previous posistions
			
			}

			moveAvatar = '1';

			//hide system message
			//document.getElementById('sysmess').style.visibility='hidden';
		
			// move image
			moveImage('_a_');

			//send avatar data
			moveAvatarIMG();
		}

	}

	// check room pos

	if(room== '-'+chatRef){
	
		cursorPos();

	}

}

// capture ONCLICK
if (!document.all) {

	window.captureEvents(Event.CLICK);
	window.onclick=showitMOZ;


} else {

	document.onclick=showit;

}