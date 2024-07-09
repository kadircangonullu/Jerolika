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


	/** convert smilies **/

	function convertSmilies(nSmilie){

		nSmilie = nSmilie.replace(":)","_s1_");
		nSmilie = nSmilie.replace(";)","_s2_");
		nSmilie = nSmilie.replace(":P","_s3_");
		nSmilie = nSmilie.replace("anan","_s4_");
		nSmilie = nSmilie.replace("sikerim","_s5_");
		nSmilie = nSmilie.replace(":(","_s6_");
		nSmilie = nSmilie.replace("mk.","_s7_");
		nSmilie = nSmilie.replace("|(","_s8_");
		nSmilie = nSmilie.replace("|x","_s9_");
		nSmilie = nSmilie.replace(":h","_s10_");
		nSmilie = nSmilie.replace("*R","_s11_");
		nSmilie = nSmilie.replace("8)","_s12_");
		nSmilie = nSmilie.replace("psygangnam","_s13_");
                                nSmilie = nSmilie.replace("pic","_s14_");
		// do not edit
		return nSmilie;

	}

	/** add smilies **/

	function addSmilies(nSmilie){

		nSmilie = nSmilie.replace(/_s1_/gi,"<img style='vertical-align:middle;' src='smilies/smile.gif'> ");
		nSmilie = nSmilie.replace(/_s2_/gi,"<img style='vertical-align:middle;' src='smilies/wink.gif'> ");
		nSmilie = nSmilie.replace(/_s3_/gi,"<img style='vertical-align:middle;' src='smilies/puh2.gif'> ");
		nSmilie = nSmilie.replace(/_s4_/gi,"<img style='vertical-align:middle;' src='smilies/ukk.gif'> ");
		nSmilie = nSmilie.replace(/_s5_/gi,"<img style='vertical-align:middle;' src='smilies/ukk.gif'> ");
		nSmilie = nSmilie.replace(/_s6_/gi,"<img style='vertical-align:middle;' src='smilies/sadley.gif'> ");
		nSmilie = nSmilie.replace(/_s7_/gi,"<img style='vertical-align:middle;' src='smilies/ukk.gif'> ");
		nSmilie = nSmilie.replace(/_s8_/gi,"<img style='vertical-align:middle;' src='smilies/frown.gif'> ");
		nSmilie = nSmilie.replace(/_s9_/gi,"<img style='vertical-align:middle;' src='smilies/frusty.gif'> ");
		nSmilie = nSmilie.replace(/_s10_/gi,"<img style='vertical-align:middle;' src='smilies/heart.gif'> ");
		nSmilie = nSmilie.replace(/_s11_/gi,"<img style='vertical-align:middle;' src='smilies/rolleyes.gif'> ");
		nSmilie = nSmilie.replace(/_s12_/gi,"<img style='vertical-align:middle;' src='smilies/shadey.gif'> ");
		nSmilie = nSmilie.replace(/_s13_/gi,"<img style='vertical-align:middle;' src='smilies/psy.png'> ");
		nSmilie = nSmilie.replace(/_s14_/gi,"<img style='vertical-align:middle;' src='ukk.gif'> ");
		

		// do not edit
		return nSmilie;

	}
