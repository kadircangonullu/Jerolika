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


// Send headers to prevent IE cache

	header("Expires: Mon, 26 Jul 1997 05:00:00 GMT" ); 
	header("Last-Modified: " . gmdate( "D, d M Y H:i:s" ) . "GMT" ); 
	header("Cache-Control: no-cache, must-revalidate" ); 
	header("Pragma: no-cache" );
	header("Content-Type: text/html; charset=utf-8");

// include files

	include("../includes/session.php");
	include("../includes/db.php");
	include("../includes/config.php");
	include("../includes/functions.php");

// check login

	if(!isset($_SESSION['cp_isLoggedIN']) || isset($_SESSION['cp_isLoggedIN']) != md5(md5($CONFIG['cp_prefix']))){

		// header redirect
		// header("Status: 200");
		header("Location: index.php");
		die;

	}

	// check itemid is numeric

	if($_GET['cp_update_shopID'] && !is_numeric($_GET['cp_update_shopID'])){

		die('update_shop value is not numeric');

	}

	if($_POST['cp_shop_ID'] && !is_numeric($_POST['cp_shop_ID'])){

		die('update_shop value is not numeric');

	}

	// reset confirmations

	$cp_shop_confirm = '0';
	$cp_shop_confirm_delete = '0';

	// update item

	if($_POST && is_numeric($_POST['cp_shop_ID'])){

		$sql = "
		UPDATE ".$CONFIG['mysql_prefix']."shop 
		SET 
		item = '".htmlspecialchars(makeSafe($_POST['cp_shop_Name']), ENT_QUOTES)."',
		image = '".htmlspecialchars(makeSafe($_POST['cp_shop_Image']), ENT_QUOTES)."',
		description = '".htmlspecialchars(makeSafe($_POST['cp_shop_Desc']), ENT_QUOTES)."',
		cost = '".htmlspecialchars(makeSafe($_POST['cp_shop_Cost']), ENT_QUOTES)."',
		featured = '".htmlspecialchars(makeSafe($_POST['cp_shop_Featured']), ENT_QUOTES)."',
		section = '".htmlspecialchars(makeSafe($_POST['cp_shop_Category']), ENT_QUOTES)."'
		WHERE id = '".makeSafe($_POST['cp_shop_ID'])."'";
		mysql_query($sql) or die(mysql_error());

		$_GET['cp_update_shopID'] = $_POST['cp_shop_ID'];

		$cp_shop_confirm = '1';

	}


	// add item

	if($_POST && is_numeric($_POST['cp_add_shopID'])){

		$sql = "
			INSERT INTO ".$CONFIG['mysql_prefix']."shop
			(
				item, 
				image,
				description,
				cost,
				featured,
				section				
			) 
			VALUES 
			(
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Name']), ENT_QUOTES)."',
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Image']), ENT_QUOTES)."',
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Desc']), ENT_QUOTES)."',
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Cost']), ENT_QUOTES)."',
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Featured']), ENT_QUOTES)."',
				'".htmlspecialchars(makeSafe($_POST['cp_shop_Category']), ENT_QUOTES)."'
			)
			";mysql_query($sql) or die(mysql_error());

		$_GET['cp_update_shopID'] = $_POST['cp_shop_ID'];

		$cp_shop_confirm = '1';

	}

	// delete item

	if($_POST && is_numeric($_POST['cp_shop_ID']) && $_POST['cp_shop_delete']){
 
		// delete item from shop
		$sql = "
			DELETE FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE id = '".makeSafe($_POST['cp_shop_ID'])."'
			";
			mysql_query($sql) or die(mysql_error());

		// delete item from user shop purchases
		$sql = "
			DELETE FROM ".$CONFIG['mysql_prefix']."shop_payments 
			WHERE purchase = '".makeSafe($_POST['cp_shop_ID'])."'
			";
			mysql_query($sql) or die(mysql_error());


		$_GET['cp_update_shopID'] = $_POST['cp_shop_ID'];

		$cp_shop_confirm = '1';

		$cp_shop_confirm_delete = '1';

	}

	// format page results

	$limitResults  = 10;

	$r = $_REQUEST['r'];

	if(!$r){
		$r = 0;
	}

?>

<html> 
<head>
<title>Avatar Chat - Admin Area</title>
<meta http-equiv="X-UA-Compatible" content="IE=7"/>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<style>
.body {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
}
.table {
color: #CCCCCC;
font-family: Verdana, Arial;
font-size: 12px;
font-style: normal;
background-color: #000000;
}
a:link {text-decoration: none; color: #CCCCCC;}
a:visited {text-decoration: none; color: #CCCCCC;}
a:active {text-decoration: none; color: #CCCCCC;}
a:hover {text-decoration: underline; color: #CCCCCC;}
</style>

</head>
<body class="body">

<?php if(!$_GET['cp_update_shopID'] && !$_GET['cp_add_shopID']){?>

	<table class="table" border="0">
	<tr><td colspan="7"><b>Shop</b> [<a href="shop.php?cp_add_shopID=1">add item</a>]</td></tr>
	<tr><td colspan="7">&nbsp;</td></tr>

	<tr><td colspan="7">

		<form name="search" method="post" action="shop.php">
		Search Items: <input type="text" name="search_item"><input type="submit" name="submit" value="Go!">
		</form>

	</td></tr>

	<tr><td colspan="7">&nbsp;</td></tr>

	<tr><td width="10">ID</td><td width="70">Image</td><td>Item</td><td>Description</td><td width="70" align="center">Featured</td><td width="70" align="center">Cost</td><td>&nbsp;</td></tr>

	<?php

	// define loop
	$cols = 5; // set columns 
	$l = 1; // sets loop for columns 

	if($_REQUEST['search_item'])
	{
		$incSearch = "WHERE description LIKE '%".makeSafe($_REQUEST['search_item'])."%'";
	}

	// get shop data
	$tmp=mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			".$incSearch." 
			ORDER BY id DESC 
			LIMIT ".$r.", ".$limitResults." 
			");

	while($i=mysql_fetch_array($tmp)) 
	{

		if($i['section'] == 2)
		{
			// backgrounds
			$imgWidth = '150';
			$imgHeight = '100';
		}
		else
		{
			// avatars
			$imgWidth = '100';
			$imgHeight = '200';
		}
		
	?>
		<tr>
		<td width="10">
			<?php echo $i['id'];?>
		</td>
		<td width="70">
			<img src="../<?php echo ($i['image']);?>" width="<?php echo $imgWidth;?>" height="<?php echo $imgHeight;?>">
		</a>
		</td>
		<td width="140">
			<b><?php echo htmlentities($i['item']);?></b>
		</td>
		<td width="210">
			<?php echo htmlentities($i['description']);?>
		</td>
		<td align="center">
			<?php echo $i['featured'];?>
		</td>
		<td align="center" width="70">
			<?php echo $i['cost'];?>
		</td>
		<td width="70" align="center">

			[<a href="shop.php?cp_update_shopID=<?php echo $i['id'];?>">Edit</a>]

		</td>
		</tr>

	<?php } ?>

	</table>
	<br><br>

	<?php 

	// get shop items
	$tmp=mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			".$incSearch." 
			");

	$num_rows = mysql_num_rows($tmp); 

	$last = $r - $limitResults;
	$next = $r + $limitResults;

	if($num_rows <= $limitResults){

		echo "Displaying ".$num_rows." of " .$num_rows. " Results";

	}else{

		if($next > $num_rows){$next = $num_rows;}

		echo "Displaying ".$next." of " .$num_rows. " Results";
	}

	echo "<br><br>";

	if($last >= 0){

		echo "<a href='shop.php?search_item=".$_REQUEST['search_item']."&r=".$last."'><< Last</a>";
	}

	if($last >= 0 && $next < $num_rows){

		echo " | ";
	}

	if($next < $num_rows){

		echo "<a href='shop.php?search_item=".$_REQUEST['search_item']."&r=".$next."'>Next >></a>";
	}

	?>

<?php } ?>

<?php if($_GET['cp_update_shopID']){

	// get shop items
	$tmp=mysql_query("
			SELECT * 
			FROM ".$CONFIG['mysql_prefix']."shop 
			WHERE id = '".makeSafe($_GET['cp_update_shopID'])."'
			");

	while($i=mysql_fetch_array($tmp)) 
	{
		$cp_shop_ID = $i['id'];
		$cp_shop_Image = $i['image'];
		$cp_shop_Name = $i['item'];
		$cp_shop_Desc = $i['description'];
		$cp_shop_Cost = $i['cost'];
		$cp_shop_Featured = $i['featured'];
		$cp_shop_Category = $i['section'];

		if($i['section'] == 2)
		{
			// backgrounds
			$imgWidth = '150';
			$imgHeight = '100';
		}
		else
		{
			// avatars
			$imgWidth = '100';
			$imgHeight = '200';
		}
	}

	?>

	<table class="table">
	<form action="shop.php" method="post" name="cp_shop_form"></td></tr>
	<input type="hidden" name="cp_shop_ID" value="<?php echo $cp_shop_ID;?>">
	<input type="hidden" name="cp_update_shopID" value="<?php echo $cp_shop_ID;?>">

	<tr><td colspan="3"><b>Edit Shop Item</b></td></tr>
	<tr><td colspan="3">&nbsp;</td></tr>

	<?php if($cp_shop_confirm){?>

		<tr><td colspan="3"><font color="green">Success, Item has been updated.</font></b></td></tr>
		<tr><td colspan="3">&nbsp;</td></tr>

	<?php }?>

	<?php if($cp_shop_confirm_delete){return;}?>

	<tr><td colspan="3">
		<img src="../<?php echo $cp_shop_Image;?>" width="<?php echo $imgWidth;?>" height="<?php echo $imgHeight;?>>
	</td></tr>

	<tr><td colspan="3">&nbsp;</td></tr>
	<tr><td>Item ID:</td><td colspan="2"><?php echo $cp_shop_ID?></td></tr>

	<tr><td>Item Category:</td><td colspan="2">

		<select name="cp_shop_Category">
			<option value="1" <?php if($cp_shop_Category == 1){echo "SELECTED";}?> />Avatars
			<option value="2" <?php if($cp_shop_Category == 2){echo "SELECTED";}?> />Backgrounds
			<option value="3" <?php if($cp_shop_Category == 3){echo "SELECTED";}?> />Body
			<option value="4" <?php if($cp_shop_Category == 4){echo "SELECTED";}?> />Mouth
			<option value="5" <?php if($cp_shop_Category == 5){echo "SELECTED";}?> />Eyes
			<option value="6" <?php if($cp_shop_Category == 6){echo "SELECTED";}?> />Accessories
			<option value="7" <?php if($cp_shop_Category == 7){echo "SELECTED";}?> />Tops
			<option value="8" <?php if($cp_shop_Category == 8){echo "SELECTED";}?> />Hair
			<option value="9" <?php if($cp_shop_Category == 9){echo "SELECTED";}?> />Beard
			<option value="10" <?php if($cp_shop_Category == 10){echo "SELECTED";}?> />Bottoms
			<option value="11" <?php if($cp_shop_Category == 11){echo "SELECTED";}?> />Shoes
		</select>

	</td></tr>

	<tr><td>Item Name:</td><td colspan="2"><input type="text" name="cp_shop_Name" value="<?php echo $cp_shop_Name;?>"></td></tr>
	<tr><td>Item Desc:</td><td colspan="2"><textarea rows="3" cols="20" name="cp_shop_Desc"><?php echo $cp_shop_Desc;?></textarea></td></tr>
	<tr><td>Item Cost:</td><td colspan="2"><input type="text" name="cp_shop_Cost" value="<?php echo $cp_shop_Cost;?>"></td></tr>
	<tr><td>Item Featured:</td><td colspan="2"><input type="text" name="cp_shop_Featured" value="<?php echo $cp_shop_Featured;?>"></td></tr>
	<tr><td>Item Image:</td><td colspan="2"><input type="text" name="cp_shop_Image" value="<?php echo $cp_shop_Image;?>"></td></tr>
	<tr><td>&nbsp;</td><td colspan="2"><input type="submit" name="cp_shop_update" value="Update">&nbsp;</td></tr>

	<tr><td>&nbsp;</td><td colspan="2"><b>Upload your images to,</b> <br>Avatar Male Folder: <i>avatars/male/</i><br>Avatar Female Folder: <i>avatars/female/</i><br>Backgrounds Folder: <i>backgrounds/</i><br></td></tr>

	</form>
	</table>

<?php } ?>

<?php if($_GET['cp_add_shopID']){?>

	<table class="table">
	<form action="shop.php" method="post" name="cp_shop_form"></td></tr>
	<input type="hidden" name="cp_add_shopID" value="1">

	<tr><td colspan="3"><b>Add Shop Item</b></td></tr>
	<tr><td colspan="3">&nbsp;</td></tr>

	<tr><td>Item Category:</td><td colspan="2">

		<select name="cp_shop_Category">
			<option value="1">Avatars
			<option value="2">Backgrounds
			<option value="3">Body
			<option value="4">Mouth
			<option value="5">Eyes
			<option value="6">Accessories
			<option value="7">Tops
			<option value="8">Hair
			<option value="9">Beard
			<option value="10">Bottoms
			<option value="11">Shoes
		</select>

	</td></tr>

	<tr><td>Item Name:</td><td colspan="2"><input type="text" name="cp_shop_Name" value="<?php echo $cp_shop_Name;?>"></td></tr>
	<tr><td>Item Desc:</td><td colspan="2"><textarea rows="3" cols="20" name="cp_shop_Desc"><?php echo $cp_shop_Desc;?></textarea></td></tr>
	<tr><td>Item Cost:</td><td colspan="2"><input type="text" name="cp_shop_Cost" value="0"></td></tr>
	<tr><td>Item Featured:</td><td colspan="2"><input type="text" name="cp_shop_Featured" value="0"> 0 No, 1 Yes</td></tr>
	<tr><td>Item Image:</td><td colspan="2"><input type="text" name="cp_shop_Image" value="<?php echo $cp_shop_Image;?>"></td></tr>
	<tr><td>&nbsp;</td><td colspan="2"><input type="submit" name="cp_shop_update" value="Update">&nbsp;</td></tr>

	<tr><td>&nbsp;</td><td colspan="2"><b>Upload your images to,</b> <br>Avatar Male Folder: <i>avatars/male/</i><br>Avatar Female Folder: <i>avatars/female/</i><br>Backgrounds Folder: <i>backgrounds/</i><br></td></tr>

	</form>
	</table>

<?php } ?>

<br><br>


</body>
</html>