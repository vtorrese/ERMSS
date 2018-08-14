 <?php

$titre_page = "New Mise à jour";

require ("header.php");
require_once('../../web/librairie/simple_html/simple_html_dom.php');
require_once('../../modele/Theme.php');
require_once('../../modele/Categorie.php');

?>
<form method="POST" name="choix_recherche">
<?php
$theme = new Theme();
$recupth = (array)$theme->recup_theme();
$categorie = new Categorie();
$recupcat = (array)$categorie->recup_cat();
?>
Choix du moteur : <br>
<input type="checkbox" name="moteur" value="google" ><label>Google</label>
<input type="checkbox" name="moteur" value="persee" ><label>Persée</label>
<input type="checkbox" name="moteur" value="cairn" ><label>Cairn</label>
<hr>
Thèmes <select name='theme'>

<?php	foreach($recupth as $itth) { ?>
		<option value='<?php echo $itth['Nom_theme']; ?>'><?php echo $itth['Nom_theme']; ?></option>
<?php	} ?>
</select>
<input type="text" name="autretheme">
 | 
Catégorie <select name='categorie'>
		<option value=''>Tous types</option>
<?php	foreach($recupcat as $itcat) { ?>
		<option value='<?php echo $itcat['Nom_cat']."+"; ?>'><?php echo $itcat['Nom_cat']; ?></option>
<?php	} ?>
</select>
 | 
 Nbre résultats <input type="number" name="nbr" min="2" max="100">
<input type="submit" name="recherche" value="chercher">
</form>
<?php

if(isset($_POST['recherche'])) {
	$theme = $_POST['theme'];
	$mot = $_POST['autretheme'];
	if(empty($mot)) {$cible=$theme;} else {$cible=$mot;}
	$cible = str_replace(" ","+",$cible);
	$cat =$_POST['categorie'];
	$nb =$_POST['nbr'];
	echo "<hr>";
	echo "<h3>Format : ".$cat." Cible : ".$cible."</h3>";
	
	//Inclusion du moteur
	if(isset($_POST['moteur'])) {
		
		$moteur = "moteur_".$_POST['moteur'].".php";
		include($moteur);
	
	?>
	<table>
		<tr>
			<th>Titre</th>
			<th>Catégorie</th>
			<th></th>
		</tr>
	<?php
	foreach($tabresult as $key => $value) {
		echo "<tr>";
			echo "<td>".$value["titre"]."</td>";
			echo "<td>".$value["categ"]."</td>";
			echo "<td><a href='".$value["url"]."' target='_blank'><button>voir</button></a></td>";
		//echo $value["titre"]." = ".$value["url"]."<br>";
		echo "</tr>";
	}
	} else
	{
		echo "<h2>Aucun moteur sélectionné !!!!</h2>";
	}
}
?>
</table>
