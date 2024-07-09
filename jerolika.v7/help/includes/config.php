<?php

/**

 Author: Pro Chatrooms
 Software: Avatar Chat
 Url: http://avatarsohbet.blogspot.com/
 Copyright 2007-2010 All Rights Reserved

 Avatar Chat and all of its source code/files are protected by Copyright Laws. 
 The license for Avatar Chat permits you to install this software on a single domain only (.com, .co.uk, .org, .net, etc.). 
 Each additional installation requires an additional software licence, please contact us for more information.
 You may NOT remove the copyright information and credits for Avatar Chat unless you have been granted permission. 
 Avatar Chat is NOT free software - For more details http://avatarsohbet.blogspot.com/

**/

// General Settings

$CONFIG['chatroom_title'] = 'Jerolika';
$CONFIG['chatroom_url'] = 'http://www.jerolikagameeee.com.nu/';
$CONFIG['admin_email'] = 'jerolika@hotmail.com';

// Control Panel Login Details

$CONFIG['admin_name'] = 'umut'; // admin username
$CONFIG['admin_pass'] = '123456789u'; // admin password
$CONFIG['mods_name'] = '41stix41'; // moderators username
$CONFIG['mods_pass'] = 'alperyaman95'; // moderators password

// Chat Room Moderators (array)
// use lowercase characters only eg. bob not Bob

$chatroom_mods=array("uwud", "83rk4y", "41stix41", "");

// Control Panel Security

$CONFIG['cp_prefix'] = 'abc123'; // enter unique word/characters/etc

// Paypal Email

$CONFIG['paypal_email'] = 'admin@yoursite.com';

// Paypal IPN Test Mode
// used for testing payments only
// https://www.sandbox.paypal.com

$CONFIG['paypal_sandbox_mode'] = '0';

// Shop Credits
// eg. 100000 credits = $1
// eg. 10000000000 credits = $10

$CONFIG['credits_package'] = '10000'; // credits
$CONFIG['credits_cost'] = '1'; // cost per xxx credits (see above)
$CONFIG['credits_free_signup'] = '4000'; // free credits on signup
$CONFIG['credits_free_login_min'] = '1500'; // free credits per daily login (min)
$CONFIG['credits_free_login_max'] = '2000'; // free credits per daily login (max)

// Reward Credits
// these are free credits awarded for user actions

$CONFIG['reward_profile'] = '3'; // credits (each profile viewed)
$CONFIG['reward_heart'] = '250'; // credits (each heart sent)
$CONFIG['reward_thumb'] = '1'; // credits (each thumb sent)
$CONFIG['reward_star'] = '1'; // credits (each star sent)

// CMS Integration

$CONFIG['cms_integration'] = '0'; // 1 yes, 0 no

// CMS - Profile Integration

$CONFIG['profile_id'] = '0'; // 0 Name, 1 ID
$CONFIG['profile_url'] = 'profiles/?id=';

// Misc Settings

$CONFIG['allow_guests'] = '1'; // allow guests to login - 0 No, 1 Yes
$CONFIG['vip_guests'] = '0'; // for new guest logins - enter 0 to pay for VIP or 1 for free VIP
$CONFIG['vip_free'] = '0'; // for new member registrations - enter 0 to pay for VIP or 1 for free VIP
$CONFIG['guestrooms_admin'] = '0'; // allow guests to admin their own rooms - 0 No, 1 Yes
$CONFIG['membersrooms_guests'] = '1'; // allow guests to access other members rooms - 0 No, 1 Yes
$CONFIG['room_max'] = '5'; // default users allowed in private rooms
$CONFIG['defaultRoom'] = '3'; // default room, user first login
$CONFIG['kickRoom'] = '3'; // users who are kicked go to this room
$CONFIG['user_results'] = '50'; // user results per page (admin area)
$CONFIG['chat_results'] = '50'; // transcript results per page (admin area)
$CONFIG['splashpage'] = '1'; // show splashpage - 0 Off, 1 On

// Remote Url Settings

$CONFIG['remoteBackgrounds'] = '0'; // allow users to link to remote backgrounds - 0 No, 1 Yes
$CONFIG['remoteMusic'] = '1'; // allow users to link to remote music streams - 0 No, 1 Yes

// Profile Settings

$CONFIG['min_age'] = '18'; // min age for profile
$CONFIG['max_age'] = '100'; // max age for profile
$CONFIG['myImg_size'] = '100000'; // max file size for image uploads (1000 = 1KB)

// Currency

$CONFIG['currency_value'] = 'USD'; // currency (USD|GBP|EUR|CAD|JPY)
$CONFIG['currency_sign'] = '&#036;'; // currency sign (ascii format only, eg: £ = &#163;, $ = &#036;)

// Membership Upgrades

$CONFIG['vip_membership'] = '1'; // VIP membership per month
$CONFIG['vip_credits'] = '10000'; // VIP membership per month

// Room Upgrades (users/cost)

$CONFIG['package_1_users'] = '25'; // max room users
$CONFIG['package_1_cost'] = '10'; // cost per month
$CONFIG['package_1_credits'] = '1000'; // credits per month

$CONFIG['package_2_users'] = '50'; // max room users
$CONFIG['package_2_cost'] = '20'; // cost per month
$CONFIG['package_2_credits'] = '1500'; // credits per month

$CONFIG['package_3_users'] = '100'; // max room users
$CONFIG['package_3_cost'] = '40'; // cost per month
$CONFIG['package_3_credits'] = '3000'; // credits per month

// Referral Credits
// Awarded to members for inviting their friends
$CONFIG['referral_award'] = '50'; // credits

// Default Local Avatars

$CONFIG['avatar_male'] = '1|avatars/male/base/whiteMaleBody.png|avatars/male/bottoms/distressedRelaxed.png|avatars/male/eyes/maleBlueEyes.png|avatars/male/hair/SpikyLightBrownHair.png|avatars/nopic.png|avatars/male/mouth/maleSmile.png|avatars/male/shoes/grayConverse.png|avatars/male/tops/blackVNeck.png|avatars/nopic.png';
$CONFIG['avatar_female'] = '2|avatars/female/base/whiteFemaleBody.png|avatars/female/bottoms/lightFlowerJeans.png|avatars/female/eyes/nopic.png|avatars/female/hair/nopic.png|avatars/nopic.png|avatars/female/mouth/blondePonytail.png|avatars/female/shoes/pinkSandals.png|avatars/female/tops/loveTee.png|avatars/nopic.png';

// Browser Charset

$CONFIG['brower_char'] = 'UTF-8';

// Version - Do Not Edit

$CONFIG['version'] = '3.0.0';

?>