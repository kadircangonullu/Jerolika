<?php

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

?>

	<html> 
	<head>
	<title><?php echo $CONFIG['chatroom_title'];?></title>
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<meta http-equiv="Content-Type" content="text/html; charset=<?php echo $CONFIG['brower_char'];?>" />
	<link type="text/css" rel="stylesheet" href="templates/style.css">
	<style type="text/css">
	.body #loginscreen form #infobox .mediumtext tr td {
	font-size: 14px;
	color: #000;
}
    .body #loginscreen form #infobox .mediumtext tr td .smalltext {
	color: #936;
}
    </style>
	<script language="javascript" type="text/javascript">
	<!--
	if(window.location == top.location){

		window.location.href="index.html";
	}

	function showTip(id)
	{
		if(id==1)
		{
			var tipLang = 'Kullanici Adini yazmak zorundasin';
		}
		if(id==2)
		{
			var tipLang = 'Sifren 3-16 karakter arasinda olmali';
		}
		if(id==3)
		{
			var tipLang = 'E mail adresini yazmak zorundasin';
		}

		document.getElementById('showTip').innerHTML  =	tipLang;	
	}
	// -->
	</script>

	</head>

	<body class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

	<div id="loginscreen" class="loginscreen">

		<form name="login" action="index.php" method="post">

			<div id="infobox" class="infobox"><br>

				<table class="mediumtext">
				<input type="hidden" name="do" value="register">

				<?php if($reg){ ?>

					<tr><td colspan="3"><span style="color: #FF0000"><?php echo $eMessage;?></span></td></tr>

				<?php }else{ ?>

					<tr><td colspan="3" id="showTip" class="smalltext">&nbsp;</td></tr>

				<?php } ?>

				<tr>
				  <td>Kullanici Adi:</td><td><input class="input" type="text" name="nickName" value="<?php echo $_POST['nickName'];?>" maxlength="16" onFocus="showTip('1')"></td><td>&nbsp;</td></tr>
				<tr>
				  <td>Sifre:</td><td><input class="input" type="password" name="nickPass" maxlength="16" onFocus="showTip('2')"></td><td>&nbsp;</td></tr>
				<tr>
				  <td>E-posta adresiniz:</td><td><input class="input" type="text" name="nickEmail" value="<?php echo $_POST['nickEmail'];?>" maxlength="100" onFocus="showTip('3')"></td><td>&nbsp;</td></tr>
				<tr>
				  <td>Cinsiyet:</td><td colspan="2">
				<input type="radio" name="gender" value="1" checked> 
				<span class="smalltext">Bay</span>&nbsp;
				<input type="radio" name="gender" value="2"> 
				<span class="smalltext">Bayan</span>
				</td></tr>
				<tr><td>&nbsp;</td><td colspan="2"><input type="image" src="templates/login/register.gif" height="24" width="132" border="0" alt="Register Details"></td></tr>
				<tr><td>&nbsp;</td>
				<td colspan="2">&nbsp;</td></tr>
				</table>
			</div>

		</form>

	</div>

	</html>
<script language="javascript" type="text/javascript">
<!--
function bookmarkthis(title,url) {
if (window.sidebar) { // Firefox için
window.sidebar.addPanel(title, url, "");
} else if (document.all) { // IE ve chorome  için
window.external.AddFavorite(url, title);
} else if (window.opera && window.print) { // Opera için
var elem = document.createElement('a');
elem.setAttribute('href',url);
elem.setAttribute('title',title);
elem.setAttribute('rel','sidebar');
elem.click();
}
}
//-->
</script>
</head>
<body oncontextmenu="return false" onselectstart="return false" ondragstart="return false">