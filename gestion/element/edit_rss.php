<?php
require_once('../../modele/Rss.php');
require_once('../../modele/Theme.php');


$titre_page = "Edition Rss";
require ("header.php");
$rss = new Rss();

// suppression de rss
if(isset($_POST['supp_rs'])) {
	$idrss = $_POST['choix_id'];
	$rss->supprss($idrss);
	$_POST['choix_id'] = 0;
}

// activation de rss
if(isset($_POST['active_rs'])) {
	$idrss = $_POST['choix_id'];
	$statut = $_POST['archiverss'];
	$rss->activerss($idrss,$statut);
}

// validation changements rss
if(isset($_POST['valid_rs'])) {
	$idrss = $_POST['choix_id'];
	$statut = $_POST['archiverss'];
	$titre = $_POST['titrerss'];
	$url = $_POST['urlrss'];
	$cethe = $_POST['themerss'];
	$date = $_POST['datexrss'];
	$rss->modifierss($idrss,$titre,$url,$cethe,$date,$statut);
}

// recherche de rss inactives
if(isset($_POST['inactif_rss'])) {
	$recuptout = (array)$rss->inactrecup();
	$_POST['choix_id'] = 0;
}

// recherche de rss
elseif(isset($_POST['recherche_rs'])) {
	$cible = $_POST['titrerss'];
	$recuptout = (array)$rss->rcrecup($cible);
}	
else
{
 /// affichage simplifié de rss
$recuptout = (array)$rss->ttrecup();
}

//choix d'une rss
if((isset($_POST['choix_id']))||(isset($_POST['atteindrerss']))) {
	$idrss = $_POST['choix_id'];
	$recupseul = (array)$rss->slrecup($idrss);
} else {$idrss = 0;}

F_affichett($recuptout);

F_affichesl($idrss, $recupseul);


//////////////// fonctions //////////////////////

function F_affichett($liste) {
	
	echo "<div id='liste_rss'>";
	echo "<fieldset>";
	echo "<form method='POST' name='form_rss'>";
	echo "<input type='submit' name='inactif_rss' value='Inactifs'><hr>";
	echo "<table>";
	echo "<tr><th>ID</th><th>Titre</th></tr>";
	foreach($liste as $rss) {
		echo "<tr>";
		if($rss['archive']<1) {$color = 'green';} else {$color = 'red';}
			echo "<td><input type='submit' name='choix_id' value='".$rss['IDrss']."' style='color : ".$color."'></td><td>".$rss['titre']."</td></tr>";
	}
	echo "</table>";
	echo "</form>";
	echo "</fieldset>";
	echo "</div>";
	return;
}

function F_affichesl($id,$info) {

	echo "<div id='fiche_rss'>";
	echo "<fieldset>";
	echo "<form method='POST' name='formF_rss'>";
	echo "<h2>ID n° <input type='number' name='choix_id' value='$id' size ='10'> <input type='submit' name='atteindrerss' value='atteindre'></h2>";
	$tit = $info[0]['titre'];
	$urlrss = $info[0]['url'];
	echo '<p>Titre : <input type="text" name="titrerss" value="'.$tit.'" size="100">  <input type="submit" name="recherche_rs" value="Rechercher"></p>';
	echo '<p>URL : <input type="text" name="urlrss" value="'.$urlrss.'" size="100">  <button><a href="'.$urlrss.'" target="_blank">Voir</a></button></p>';
	$theme = new Theme();
	$recupth = (array)$theme->recup_theme();
			echo "Thèmes : <select name='themerss'>";
				echo "<option value='1'>Tous sujets</option>";
				foreach($recupth as $itth) {
					if($itth['IDtheme']==$info[0]['CE_theme']) {echo "<option value='".$itth['IDtheme']."' selected>".$itth['Nom_theme']."</option>";} else {echo "<option value='".$itth['IDtheme']."'>".$itth['Nom_theme']."</option>";}
				}
			echo "</select>&nbsp&nbsp";
	echo "<p>Date : <input type='date' name='datexrss' value='".$info[0]['date']."'>&nbsp&nbsp";
	if($info[0]['archive']==0) {$actif = "checked";} else {$actif = "";}
	echo "Actif : <input type='checkbox' name='archiverss' ".$actif." ></p>";
	echo "<span style='float : right'><input type='submit' name='valid_rs' value='Valider'>  <input type='submit' name='active_rs' value='Activer/désact.'>  <input type='submit' name='supp_rs' value='Supprimer'></span>";
	echo "</form>";
	echo "</fieldset>";
	echo "</div>";
	return;
}


?>