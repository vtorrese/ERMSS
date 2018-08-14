<?php

$titre_page = "Paramètres";

require ("header.php");
require_once('../../modele/Lien_url.php');

$lien = new Lien_url();
$recuptt = (array)$lien->recup_tout();
?>

<!-- Changement des images -->
<div style="width:50%;height:auto;display:inline-block;float:left;border: 0.5px solid grey;padding:1%;">
<h3 style="text-align:center;">Edition des images</h3>
<form method="POST" name="choix_img">
<p><input type="text" name="newlabel" Placeholder="nouveau label"></p><p><input type="text" name="newadresse" Placeholder="adresse" size="70"><input type="submit" name="valide_new" value="Ajouter">
<hr>
<?php

foreach($recuptt as $li) { ?>
	<section style="padding:1%">
		<h4><?php echo $li[1]." (".$li[3]." ref.)"; ?></h4>
		
		<img src="<?php echo $li[2]; ?>" alt="<?php echo "img_".$li[1]; ?>" width="50" height="auto">
		<input type="text" name="<?php echo "adr_".$li[1]; ?>" placeholder="adresse image" value="<?php echo $li[2]; ?>" size="70">
		<input type="submit" name="<?php echo "modif_".$li[1]; ?>" value="modifier">
		<input type="hidden" name="<?php echo "IDimg_".$li[1]; ?>" value="<?php echo $li[0]; ?>">
		<?php 
		if($li[3]<1) { ?>
		<input type="submit" name="<?php echo "supp_".$li[1]; ?>" value="supprimer">	
		<?php }
		?>
		<hr>
	</section>
<?php } ?>
</form>
</div>

<?php
$message="";
//Gestion boutons

//Nouvelle image
if(isset($_POST['valide_new'])) {
	if((!empty($_POST['newlabel']))&&(!empty($_POST['newadresse']))) {
		$newimg = $lien->ajoute_lien($_POST['newlabel'],$_POST['newadresse']);
	} else {$message = "erreur ! champs incorrects !";}
}

foreach($recuptt as $lienx) {
	
	$id = "IDimg_".$lienx[1];
	$modif = "modif_".$lienx[1];
	$supp = "supp_".$lienx[1];
	$image = "img_".$lienx[1];
	$adres = "adr_".$lienx[1];
	//Suppresion d'une image
	if(isset($_POST[$supp])) {
		$ln = new Lien_url();
		$suppimg = $ln->supp_lien($_POST[$id]);
	}
	//Modification d'une image
	if(isset($_POST[$modif])) {
		$ln = new Lien_url();
		$smodifimg = $ln->modif_lien($_POST[$id],$_POST[$adres]);
	}
}
//message erreur en retour ou rechargement de la page
if(!empty($message)) {
	echo "<p>".$message."</p>";
} else {header('Location: param.php');}
?>