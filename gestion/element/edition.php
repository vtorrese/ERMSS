<?php
require_once('../../modele/Reference.php');
require_once('../../modele/Categorie.php');
require_once('../../modele/Theme.php');
require_once('../../modele/Type.php');
require_once('../../modele/Groupe.php');
require_once('../../modele/Support.php');
require_once('../../modele/Personne.php');
require_once('../../modele/Lien_url.php');

if((isset($_GET['mode']))&&($_GET['mode']=='ajout')) {
	$mode=$_GET['mode'];
} else {$mode='edition';}

if($mode=='edition') {$titre_page = "Edition";} elseif($mode=='ajout') {$titre_page = "Nouvel Enregistrement";} 

require ("header.php");
$reference = new Reference();

if(isset($_GET['idref'])) {
	$_POST['idref']=$_GET['idref'];
}

if($mode=='edition') {
echo "<form method='POST'>";
	
	echo "<input type='number' name='idref' value='' min='1'>&nbsp&nbsp<input type='submit' name='atteindre' value='atteindre'>";
echo "</form>";
}

////// la sous-fenetre parametres

	if(isset($_POST['valid_nwcategorie'])) { // insérer nouvelle categorie
		if((isset($_POST['new_categorie']))&&(!empty($_POST['new_categorie']))) {
			$nomcat = $_POST['new_categorie'];
			$categorie = new Categorie();
			$categorie->Insere_nouveau($nomcat);
			}
	}
	
	if(isset($_POST['valid_nwtheme'])) { // insérer nouveau theme
		if((isset($_POST['new_theme']))&&(!empty($_POST['new_theme']))) {
			$nomth = $_POST['new_theme'];
			$theme = new Theme();
			$theme->Insere_nouveau($nomth);
			}
	}

	if(isset($_POST['valid_nwtype'])) { // insérer nouveau type
		if((isset($_POST['new_type']))&&(!empty($_POST['new_type']))) {
			$nomty = $_POST['new_type'];
			$type = new Type();
			$type->Insere_nouveau($nomty);
			}
	}
	
	if(isset($_POST['valid_nwgroupe'])) { // insérer nouveau groupe
		if((isset($_POST['new_groupe']))&&(!empty($_POST['new_groupe']))) {
			$nomgp = $_POST['new_groupe'];
			$groupe = new Groupe();
			$groupe->Insere_nouveau($nomgp);
			}
	}
	
	if(isset($_POST['valid_nwsupport'])) { // insérer nouveau support
		if((isset($_POST['new_support']))&&(!empty($_POST['new_support']))) {
			$nomsp = $_POST['new_support'];
			$support = new Support();
			$support->Insere_nouveau($nomsp);
			}
	}
	
	if(isset($_POST['valid_nwpersonne'])) {		// insérer nouveau auteur
		if((isset($_POST['new_nom']))&&(!empty($_POST['new_nom']))) {
			$nom = $_POST['new_nom'];
				if((isset($_POST['new_prenom']))&&(!empty($_POST['new_prenom']))) {
					$prenom = $_POST['new_prenom'];
					$personne = new Personne();
					$personne->Insere_nouveau($nom,$prenom);	
				}
			
			}
	}
	
//////////// la fenetre edition
if(isset($_POST['valid_nwpersonne'])) { // Pour ajouter un auteur
	$idnwauteur = $_POST['auteur'];
	$idref = $_POST['idref'];
	$reference->Insere_auteur($idnwauteur,$idref);
}
if(isset($_POST['valid_collectif'])) { // Pour ajouter un auteur : collectif
	$idnwauteur = 17;
	$idref = $_POST['idref'];
	$reference->Insere_auteur($idnwauteur,$idref);
}

$img = New Lien_url(); //On récupère toutes le images sytème ermss
$tabimg = $img->recup_tout();
foreach($tabimg as $tit) {
	$nom = 'valid_'.$tit['label'];
	$add = 'add_'.$tit['label'];
	if(isset($_POST[$nom])) { // Pour ajouter une image
		$idref = $_POST['idref'];
		$img = $_POST[$add];
		$reference->Insere_img($idref,$img);
	}
}

if(isset($_POST['sup_auteur'])) { // Pour supprimer un auteur
	$idref = $_POST['idref'];
	$idauteur = $_POST['sup_auteur'];
	$reference->Supprime_auteur($idref,$idauteur);
}
if(isset($_POST['sup_edition'])) { // Pour supprimer une référence
	$idref = $_POST['idref'];
	$reference->Supprime_reference($idref);
	$_POST['idref'] = null;
}
if(isset($_POST['valid_edition'])) { // Pour enregistrer les modifications d'une référence
	$idref = $_POST['idref'];
	$titre = $_POST['titre'];
	$categorie = $_POST['categorie'];
	if($categorie==0) {$categorie = null;}
	$date = $_POST['datex'];
	$theme = $_POST['theme'];
	$type = $_POST['type'];
	$url = $_POST['url'];
	$groupe = $_POST['groupe'];
	$support = $_POST['support'];
	$num = $_POST['num'];
	$commentaire = $_POST['com'];
	$image = $_POST['img'];
	$reference->Modifie_reference($idref,$titre,$categorie,$date,$theme,$type,$url,$groupe,$support,$num,$commentaire,$image);
}
if(isset($_POST['ajout_ref'])) { // Pour enregistrer une nouvelle référence
	$titre = $_POST['titre'];
	$categorie = $_POST['categorie'];
	if($categorie==0) {$categorie = null;}
	$date = $_POST['datex'];
	$theme = $_POST['theme'];
	$type = $_POST['type'];
	$url = $_POST['url'];
	$groupe = $_POST['groupe'];
	$support = $_POST['support'];
	$num = $_POST['num'];
	$commentaire = $_POST['com'];
	$image = $_POST['img'];
	$reference->Enregistre_reference($titre,$categorie,$date,$theme,$type,$url,$groupe,$support,$num,$commentaire,$image);
	//sortir du mode ajout
	$recup_last_id = $reference->recup_lastID();
	$mode=null;
	$_POST['idref'] = $recup_last_id[0]['dernier'];
}


if($mode=='ajout') {
	F_affiche(-1,0);
}
else
{
	if((isset($_POST['atteindre']))||(isset($_POST['idref']))) { //pour récupérer la fiche d'une réf. selon ID
		$id = $_POST['idref'];
		if($id!='') {
		$recup_ref_id = (array)$reference->recup_ref_tot($id);
		$recup_ref_personne = (array)$reference->recup_auteur($id);
		F_affiche($recup_ref_id,$recup_ref_personne);
		}
	}
	if((count($reference->recup_newref())>0)&&(!isset($_POST['idref']))) {
			$recup_sscat = (array)$reference->recup_newref();
			if(isset($recup_sscat[0][0])) {$idref = $recup_sscat[0][0];} else {$idref = 0;}
			$recup_ref_id = (array)$reference->recup_ref_tot($idref);
			$recup_ref_personne = (array)$reference->recup_auteur($idref);
			F_affiche($recup_ref_id,$recup_ref_personne);
	}
}

	
	///// les fonctions ///////////////////
	
	function F_affiche($ref,$personne) {
		
		echo "<div id='formulaire_edition'>";
		echo "<form method='POST' name='edition' style='color : blue;'>";
		
		echo "<fieldset>";
		echo "<h3>Référence n° : ".$ref[0]['IDref']."<input type='hidden' name='idref' value='".$ref[0]['IDref']."'></h3>";
		if($ref>=0) {
		echo "<input type='submit' name='valid_edition' value='Modifier'>&nbsp&nbsp";
			echo "<input type='submit' name='sup_edition' value='Supprimer'>";
		} else
		{
			echo "<input type='submit' name='ajout_ref' value='Ajouter'>";
			
		}
		 
			//TITRE
			$tit = $ref[0]['titre'];
			echo '<p>Titre : <input type="text" name="titre" value="'.$tit.'" size="150"></p>';
			
			//CATEGORIE
			$categorie = new Categorie();
			$recupcat = (array)$categorie->recup_cat();
		
			echo "<p>Catégorie <select name='categorie'>";
				echo "<option style='color : red'>null</option>";
				foreach($recupcat as $itcat) {
					if($itcat['IDcat']==$ref[0]['CE_IDcat']) {echo "<option value='".$itcat['IDcat']."' selected>".$itcat['Nom_cat']."</option>";} else {echo "<option value='".$itcat['IDcat']."'>".$itcat['Nom_cat']."</option>";}
				}
			echo "</select>&nbsp&nbsp";
			
			//DATE
			echo "Date <input type='date' name='datex' value='".$ref[0]['vdate']."'>&nbsp&nbsp";
			
			//THEME
			$theme = new Theme();
			$recupth = (array)$theme->recup_theme();
			echo "Thèmes <select name='theme'>";
				echo "<option value='1'>Tous sujets</option>";
				foreach($recupth as $itth) {
					if($itth['IDtheme']==$ref[0]['CE_theme']) {echo "<option value='".$itth['IDtheme']."' selected>".$itth['Nom_theme']."</option>";} else {echo "<option value='".$itth['IDtheme']."'>".$itth['Nom_theme']."</option>";}
				}
			echo "</select>&nbsp&nbsp";
			
			//TYPE
			$type = new Type();
			$recupty = (array)$type->recup_type();
			echo "Type <select name='type'>";
				echo "<option value='1'>-</option>";
				foreach($recupty as $itty) {
					if($itty['IDtype']==$ref[0]['CE_type']) {echo "<option value='".$itty['IDtype']."' selected>".$itty['Nom_type']."</option>";} else {echo "<option value='".$itty['IDtype']."'>".$itty['Nom_type']."</option>";}
				}
			echo "</select></p>";
		
			//URL
			echo "<p>Url <input type='text' name='url' value='".$ref[0]['url']."' size='80'>&nbsp&nbsp";
			if(($ref>=0)&&(!empty($ref[0]['url']))) {
				/*if(url_exists($ref[0]['url'])==0) {*/
					echo "<button><a href='".$ref[0]['url']."' target='_blank'>Voir</a></button>";
				/*} else {echo "<span style='color:red;'>url à vérifier !!</span>";}*/
				}
			echo "</p>";
			
			//EDITEUR
			$groupe = new Groupe();
			$recupgp = (array)$groupe->recup_groupe();
			echo "Editeur <select name='groupe'>";
				echo "<option value='1'>-</option>";
				foreach($recupgp as $itgp) {
					if($itgp['IDgroupe']==$ref[0]['CE_groupe']) {echo "<option value='".$itgp['IDgroupe']."' selected>".$itgp['Nom_groupe']."</option>";} else {echo "<option value='".$itgp['IDgroupe']."'>".$itgp['Nom_groupe']."</option>";}
				}
			echo "</select>&nbsp&nbsp";
			
			//Support
			$support = new Support();
			$recupsp = (array)$support->recup_support();
			echo "Collection <select name='support'>";
				echo "<option value='1'>-</option>";
				foreach($recupsp as $itsp) {
					if($itsp['IDsupport']==$ref[0]['CE_support']) {echo "<option value='".$itsp['IDsupport']."' selected>".$itsp['Nom_support']."</option>";} else {echo "<option value='".$itsp['IDsupport']."'>".$itsp['Nom_support']."</option>";}
				}
			echo "</select>&nbsp&nbsp";
			
			//NUM
			echo "Numero <input type='text' name='num' value='".$ref[0]['num']."'></p>";
			
			//commentaire
			echo '<p>Commentaire <input type="text" name="com" value="'.$ref[0]['commentaire'].'" size="150"></p>';
			
			if($ref>=0) {
			//auteur
			$tabperson = new Personne();
			$recupersonne = (array)$tabperson->recup_personne();
			foreach($recupersonne as $pers) {
				$tabauteur[$pers['IDpersonne']] = $pers['Nom_personne'].", ".$pers['Prenom_personne'];
			}
			
			echo "<p><table>";
				echo "<tr style='color : blue;'><th >Auteurs</th><th>Suppression</th></tr>";
				foreach($personne as $idpers) {
					echo "<tr style='font-size : small;'><td style='width : 100px'>".$tabauteur[$idpers['IDpersonne']]."</td>";
					echo "<td><input type='submit' name='sup_auteur' value='".$idpers['IDpersonne']."'><input type='hidden' name='idsup_auteur' value='".$ref[0]['IDref'].'/'.$idpers['IDpersonne']."'></td>";
					echo"</tr>";
				}
			echo "</table>";
			echo "Ajouter <select name='auteur'>";
				echo "<option value='0'></option>";
				foreach($recupersonne as $itpers) {
					echo "<option value='".$itpers['IDpersonne']."'>".$itpers['Nom_personne'].', '.$itpers['Prenom_personne']."</option>";
				}
			echo "</select>&nbsp&nbsp";
			echo "<input type='submit' name='valid_nwpersonne' value='+'>&nbsp&nbsp<input type='submit' name='valid_collectif' value='Collectif'></p>";
			}
			
			//image
			echo "<p>Image <input type='text' name='img' value='".$ref[0]['lien_image']."' size='80'>&nbsp&nbsp";
			if($ref>=0) {
				
				$liens = New Lien_url();
				$tablabel = $liens->recup_tout();
				foreach($tablabel as $tit) { // boutons affectation image
					$name = "valid_".$tit['label'];
					$adresse = "add_".$tit['label'];
					echo "<input type='submit' name='".$name."' value='".$tit['label']."'><input type='hidden' name='".$adresse."' value='".$tit['adresse']."' >";
				}
				/*echo "<input type='submit' name='valid_img' value='Defaut'>  ";
				echo "<input type='submit' name='valid_legifrance' value='Legifrance'>  ";
				echo "<input type='submit' name='valid_calenda' value='Calenda'>  ";*/
				}
			echo "</p>";
			
			if(!empty($ref[0]['lien_image'])) {echo "<img src='".$ref[0]['lien_image']."'>";}
			
		
		echo "</fieldset>";
		echo "</div>";
		
		echo "<div id='param' style='text-align : right;'>";
		echo "<fieldset>";
			require_once('moteur_param.php');
		echo "</fieldset>";
		echo "</div>";
		
		echo "</form>";
		
		return;
	}
	
	/*function url_exists($url_a_tester)
	{
	$F=@fopen($url_a_tester,"r");
	 
	if($F)
	{
	 fclose($F);
	 return 1;
	}
	else return 0;
	 
	}*/

?>