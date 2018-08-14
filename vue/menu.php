<?php // menu navigation ?>
<div id='barre_menu'>
<form method="POST" name="menu" class="menu">
<input type="submit" name="accueil" value="Accueil">
<input type="submit" name="organisation" value="Organisation">
<input type="submit" name="juridique" value="Juridique">
<input type="submit" name="outil" value="Outils">
<input type="submit" name="contact" value="Contact">
	
	<input name="init_avc" type="submit" value='+' style='float : right;font-size : small;margin-left : 1%;' >
	
	<span class='hide'>
	<input name="valid_rechercher" type="submit" value='ok' style='float : right;font-size : small;margin-left : 0.3%;' >
	
	<input type="text" Placeholder="....." name="recherche" size="10" style='float : right;color:inherit;'>
	</span>
	<input type="hidden" name="fichier_err" value="<?php echo $donnees['fichier']; ?>">
	
</form>
</div>


<?php
$label = array('accueil'=> "Accueil",'organisation'=>"Les secteurs des ESMSS",'juridique'=>"Ressources juridiques",'outil'=>"Outils",'contact'=>"Contacts & Mentions légales",'resultat'=>"Recherche");
$nompage = $label[$donnees['fichier']]; 
?>
<div id='nom_page'>
<hr>
<h3> <?php echo $nompage; ?></h3>

</div>

