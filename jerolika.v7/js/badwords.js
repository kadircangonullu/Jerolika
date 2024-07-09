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


	/** assign badwords **/

	function filterBadword(nBadword){

		nBadword = nBadword.replace(/amk/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/oç/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/sikdir/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/pic/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/piç/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/mk/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/anani/gi,"Uygunsuz Kelime");
		nBadword = nBadword.replace(/sikdir git/gi,"Uygunsuz Kelime");		
		// do not edit
		return nBadword;

	}
