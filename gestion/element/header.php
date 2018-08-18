<!DOCTYPE html>

<html>

<head>

<title><?php echo $titre_page; ?></title>

<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />

<link rel="stylesheet" type="text/css" href="../css/style.css">
<?php ini_set("display_errors",0); ?>

</head>

<body>
<header><h1><?php echo $titre_page; ?></h1></header>
<span id="menu_bouton">

<?php $chemin = array_reverse(explode("/",$_SERVER['SCRIPT_NAME'])); 
if (($chemin[1]=='gestion')&&($chemin[0]=='index.php')) {$href="element/";} else {$href="";}
?>
<input style= "color : red;" type="button" name="maj" value="MaJ" onclick="self.location.href='<?php echo $href."majx.php";?>'">
<!-- <input style= "color : blue;" type="button" name="Newmaj" value="NewMaJ" onclick="self.location.href='<?php echo $href."Newmaj.php";?>'">
<input style= "color : green;" type="button" name="test" value="test" onclick="self.location.href='<?php echo $href."testpy.php";?>'"> -->
 |
<input type="button" name="param" value="Paramètres" onclick="self.location.href='<?php echo $href."param.php";?>'">

<input type="button" name="ajout" value="Ajouter Ref" onclick="self.location.href='<?php echo $href."edition.php?mode=ajout";?>'">

<input type="button" name="chercher" value="Chercher Ref" onclick="self.location.href='<?php echo $href."chercher.php";?>'">

<input type="button" name="edition" value="Reference" onclick="self.location.href='<?php echo $href."edition.php";?>'">

<input type="button" name="esmss" value="RSS" onclick="self.location.href='<?php echo $href."edit_rss.php";?>'">

<input type="button" name="tdb" value="TdB" onclick="self.location.href='<?php echo $href."tdb.php";?>'">

<input type="button" name="structure" value="Structure" onclick="self.location.href='<?php echo $href."structure.php";?>'">
|
<input type="button" name="visit" value="Visites" onclick="self.location.href='<?php echo $href."visites.php";?>'">
<input type="button" name="lien7" value="Site" onclick="self.location.href='http://192.168.1.34/ERMSS/'">

</span>

<hr>

<script>
	if(document.getElementById('form_auth')) {
 document.getElementById('form_auth').style.display = 'none';
	}
</script>