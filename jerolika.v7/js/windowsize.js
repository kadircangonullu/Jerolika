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


var mWidth = 0, mHeight = 0;

// get the browser window size
function doWindowSize() {

  	if( typeof( window.innerWidth ) == 'number' ) {

    		//Non-IE
    		mWidth = window.innerWidth;
			mHeight = window.innerHeight;

  	} else if( document.documentElement && ( document.documentElement.clientWidth || document.documentElement.clientHeight ) ) {

    		//IE 6+ in 'standards compliant mode'
    		mWidth = document.documentElement.clientWidth;
    		mHeight = document.documentElement.clientHeight;

  	} else if( document.body && ( document.body.clientWidth || document.body.clientHeight ) ) {

    		//IE 4 compatible
    		mWidth = document.body.clientWidth;
    		mHeight = document.body.clientHeight;

  	}

	// set the control panel width
	document.getElementById('controlpanel').style.width = (mWidth - 12) + "px";

	// focus on messagebar
	document.getElementById('message').focus();

	// re-calculate on window resize
	window.onresize = function() {doWindowSize();}

}

// detect browser version
var ie7 = (document.all && !window.opera && window.XMLHttpRequest) ? true : false;