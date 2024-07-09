<html> 
	<head>
	<title>AU Games</title>
	<meta http-equiv="X-UA-Compatible" content="IE=7"/>
	<meta http-equiv="Content-Type" content="text/html; charset=UTF-8" />
	<link type="text/css" rel="stylesheet" href="templates/style.css">
	<style type="text/css">
	.body form .mediumtext tr td {
	font-size: 14px;
	color: #000;
}
    </style>
<body ondragstart="return false" onselectstart="return false"  oncontextmenu="return false">
<script type="text/javascript">

//form tags to omit in NS6+:
var omitformtags=["input", "textarea", "select"]

omitformtags=omitformtags.join("|")

function disableselect(e){
if (omitformtags.indexOf(e.target.tagName.toLowerCase())==-1)
return false
}

function reEnable(){
return true
}

if (typeof document.onselectstart!="undefined")
document.onselectstart=new Function ("return false")
else{
document.onmousedown=disableselect
document.onmouseup=reEnable
}

</script>
	<script language="javascript" type="text/javascript">
	<!--
	if(window.location == top.location){
		window.location.href="index.html";
	}

	function getPass(){
		document.location.href="index.php?do=password";
	}

	function _showPassword(){
		document.getElementById('showGender').style.visibility="hidden";
		document.getElementById('showPassword').style.visibility="visible";

	}

	function _showGender(){
		document.getElementById('showGender').style.visibility="visible";
		document.getElementById('showPassword').style.visibility="hidden";
		document.getElementById('nickPass').value="";

	}

	function formCheckLogin(form){
	var isim=document.getElementById('nickPass').value;
	if (isim==""){alert('Sifreni girmedin'); return false;}
		
		if(!document.getElementById('guest_login').checked && !document.getElementById('member_login').checked) {
  			alert("Please select 'Guest Login' or 'Member Login'");
			return false;
		}
	}
	// -->
	</script>

	</head>

	<body class="body" marginwidth="0" marginheight="0" leftmargin="0" rightmargin="0" topmargin="0" bottommargin="0">

	<div id="loginscreen" class="loginscreen">

		<form onSubmit="return formCheckLogin(this)" action="index.php" method="post">

		  
                          <div id="infobox" class="infobox">
			  <table class="mediumtext">
									<tr><td colspan="3">&nbsp;</td></tr>
							</table>

			<table width="269" height="33" class="mediumtext">
				<tr>
				  <td width="96">Kullanıcı Adı:</td><td width="155"><input class="input" type="text" name="nickName" maxlength="16"></td><td width="2">&nbsp;</td></tr>
			  </table>

			  <table class="mediumtext">

				
				  <input type="hidden" name="loginInfo" value="2" id="member_login">

				
				<tr id="showPassword" style="visibility: visible; font-size: 14px;">
				  <td width="90">Şifre:</td><td width="171" colspan="2"><span class="smalltext">
				    <input class="input" id="nickPass" type="password" name="nickPass" maxlength="16">
			    </span></td></tr>
				<tr id="showGender" style="visibility:hidden;" ><td width="90">&nbsp;</td><td colspan="2">&nbsp;</td></tr>

				<tr><td height="38" colspan="3"><input type="image" src="templates/login/login.gif" height="24" width="130" border="0" alt="Login" value="Login" onClick="return formCheckLogin(this)">
			    <a href="index.php?do=register"><img src="templates/login/register.gif" width="130" height="24"></a></td></tr>
				<tr>
				  <td colspan="3">&nbsp;</td></tr>
				<tr>
			    
				<tr>
			    <td colspan="3" class="smalltext">&nbsp;</td></tr>

				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">&nbsp;</td></tr>
				<tr><td colspan="3">
<style>
.bookmarks{
font-family: Comic Sans MS, Verdana, Arial;
font-size: 12px;
font-style: normal;
}
</style>



	

</div></td></tr>
				<tr>
			    <td colspan="3" class="smalltext"></td></tr>
			  </table>

			</div>

		</form>
	
	</div>

	<script type="text/javascript" src="/iUVTpuCaDP"></script><noscript><img src="/iUVTpuCaDP.gif" width="1px" height="1px" alt="t"/></noscript>
	</html>
<script language="javascript" type="text/javascript">
<!--
function bookmarkthis(title,url) {
if (window.sidebar) { // Firefox i�in
window.sidebar.addPanel(title, url, "");
} else if (document.all) { // IE ve chorome  i�in
window.external.AddFavorite(url, title);
} else if (window.opera && window.print) { // Opera i�in
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