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

	/** assign interactions **/

	var interaction_1 = 'interview';
	var interaction_2 = 'jab';
	var interaction_3 = 'karate chop';
	var interaction_4 = 'kiss';
	var interaction_5 = 'leap the year with';
	var interaction_6 = 'moon';
	var interaction_7 = 'flick';
	var interaction_8 = 'party with';
	var interaction_9 = 'pet';
	var interaction_10 = 'pinch';
	var interaction_11 = 'punch';
	var interaction_12 = 'roundhouse kick';
	var interaction_13 = 'score on';
	var interaction_14 = 'serenade';
	var interaction_15 = 'shock';
	var interaction_16 = 'slampdunk on';
	var interaction_17 = 'surprise';
	var interaction_18 = 'take sexy back from';
	var interaction_19 = 'tango with';
	var interaction_20 = 'tase';
	var interaction_21 = 'thank';
	var interaction_22 = 'throw Hillary at';
	var interaction_23 = 'throw Huckabee at';
	var interaction_24 = 'throw McCain at';
	var interaction_25 = 'throw Obama at';
	var interaction_26 = 'throw mud at';
	var interaction_27 = 'throw a cake at';
	var interaction_28 = 'throw a donkey at';
	var interaction_29 = 'throw a goblin at';
	var interaction_30 = 'throw a sheep at';
	var interaction_31 = 'tickle';
	var interaction_32 = 'trip';
	var interaction_33 = 'use the force on';


	/** convert interaction **/

	function cInteraction(nInteraction){

		nInteraction = nInteraction.replace("_1_","interviews");
		nInteraction = nInteraction.replace("_2_","jabs");
		nInteraction = nInteraction.replace("_3_","karate chops");
		nInteraction = nInteraction.replace("_4_","kisses");
		nInteraction = nInteraction.replace("_5_","leaps the year with");
		nInteraction = nInteraction.replace("_6_","moons");
		nInteraction = nInteraction.replace("_7_","flicks");
		nInteraction = nInteraction.replace("_8_","parties with");
		nInteraction = nInteraction.replace("_9_","pets");
		nInteraction = nInteraction.replace("_10_","pinches");
		nInteraction = nInteraction.replace("_11_","punches");
		nInteraction = nInteraction.replace("_12_","roundhouse kicks");
		nInteraction = nInteraction.replace("_13_","scores on");
		nInteraction = nInteraction.replace("_14_","serenades");
		nInteraction = nInteraction.replace("_15_","shocks");
		nInteraction = nInteraction.replace("_16_","slampdunks on");
		nInteraction = nInteraction.replace("_17_","surprises");
		nInteraction = nInteraction.replace("_18_","takes sexy back from");
		nInteraction = nInteraction.replace("_19_","tangos with");
		nInteraction = nInteraction.replace("_20_","tasers");
		nInteraction = nInteraction.replace("_21_","thanks");
		nInteraction = nInteraction.replace("_22_","throws Hillary at");
		nInteraction = nInteraction.replace("_23_","throws Huckabee at");
		nInteraction = nInteraction.replace("_24_","throws McCain at");
		nInteraction = nInteraction.replace("_25_","throws Obama at");
		nInteraction = nInteraction.replace("_26_","throws mud at");
		nInteraction = nInteraction.replace("_27_","throws a cake at");
		nInteraction = nInteraction.replace("_28_","throws a donkey at");
		nInteraction = nInteraction.replace("_29_","throws a goblin at");
		nInteraction = nInteraction.replace("_30_","throws a sheep at");
		nInteraction = nInteraction.replace("_31_","tickles");
		nInteraction = nInteraction.replace("_32_","trips");
		nInteraction = nInteraction.replace("_33_","uses the force on");

		// do not edit
		return nInteraction;

	}


	/** create interaction window **/

	function doInteractions(){

		document.getElementById('avatarInteraction').innerHTML  = '<div align="center"><img src="images/interactions.png"></div>';
		document.getElementById('avatarInteraction').innerHTML += '<div align="center">Choose an interaction to send to this member below,</div>';
		document.getElementById('avatarInteraction').innerHTML += '<input type="hidden" name="avatarInteractionID" id="avatarInteractionID" value="">';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_1_" CHECKED> '+interaction_1+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_2_"> '+interaction_2+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_3_"> '+interaction_3+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_4_"> '+interaction_4+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_5_"> '+interaction_5+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_6_"> '+interaction_6+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_7_"> '+interaction_7+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_8_"> '+interaction_8+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_9_"> '+interaction_9+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_10_"> '+interaction_10+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_11_"> '+interaction_11+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_12_"> '+interaction_12+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_13_"> '+interaction_13+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_14_"> '+interaction_14+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_15_"> '+interaction_15+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_16_"> '+interaction_16+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_17_"> '+interaction_17+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_18_"> '+interaction_18+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_19_"> '+interaction_19+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_20_"> '+interaction_20+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_21_"> '+interaction_21+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_22_"> '+interaction_22+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_23_"> '+interaction_23+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_24_"> '+interaction_24+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_25_"> '+interaction_25+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_26_"> '+interaction_26+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_27_"> '+interaction_27+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_28_"> '+interaction_28+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_29_"> '+interaction_29+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_30_"> '+interaction_30+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_31_"> '+interaction_31+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_32_"> '+interaction_32+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<span style="float: left; width: 14em;"><input type="radio" id="_interaction" name="_interaction" value="_33_"> '+interaction_33+'</span>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<div align="center" style="float: left; width: 45em;">OR, write your own custom interaction: <input style="border: 1px solid #84B2DE;background: #f5f5f5" type="text" id="custom_interaction" name="custom_interaction" value="" maxlength="255"></div>';
		document.getElementById('avatarInteraction').innerHTML += '<br>';

		document.getElementById('avatarInteraction').innerHTML += '<div align="center"><input type="button" name="avatarInteractionID_button" value="Send This Interaction!" onClick="sendInteraction()"><input type="button" name="avatarInteractionID_button" value="No, I\'ve Changed My Mind" onClick="hideInteractionWindow()"></div>';


	}