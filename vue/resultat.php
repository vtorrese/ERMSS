<?php //var_dump($donnees['NBref']); ?>


<div id="compteur_resultat">
<?php if($donnees['rechercheavc']) { 
$chaineretour = explode("/",$donnees['rechercheavc']);
if(strlen($chaineretour[0])>0) {$titrex = "Termes : ".$chaineretour[0]."<br>";}
if(strlen($chaineretour[1])>3) {$datedx = "Depuis le, du : ".$chaineretour[1]."<br>";}
if(strlen($chaineretour[2])>3) {$datefx = "Jusqu'au : ".$chaineretour[2]."<br>";}
if(strlen($chaineretour[3])>0) {$themx = "Thème : ".$chaineretour[3]."<br>";}
if(strlen($chaineretour[4])>0) {$editx = "Editions : ".$chaineretour[4]."<br>";}
if(strlen($chaineretour[5])>0) {$supx = "Ref. : ".$chaineretour[5]."<br>";}
?>
<h4>Recherche personnalisée : <span id="cpt_resul"></span></h4>
<?php echo $titrex.$datedx.$datefx.$themx.$editx.$supx."<hr>";  } else { ?>
<h4>Recherche : <?php echo $donnees['recherche']." "; ?><span id="cpt_resul"></span></h4><hr>

<?php
}
$cpt=0;

foreach($donnees['NBref'] as $elem) {
	if($elem['NBcat']>0) {
		$image = "web/image/categ".$elem['CE_IDcat'].".png";
		if ($elem['CE_IDcat']==1) {$nom = "Juridique";} else {$nom=$elem['Nom_cat'];}
		if (file_exists($image)) {echo "<p><img src='$image' alt='".$nom."' title='".$nom."' style='cursor:hand;' onclick='confirme(".$elem['CE_IDcat'].");'/>"." ".$nom." (".$elem['NBcat'].")</p>";}
		$cpt +=  $elem['NBcat'];
		}
		
	}
?>

</div>
<input type="hidden" id="compteur" value="<?php echo $cpt; ?>">

<div id="resultat">
<?php

foreach($donnees['NBref'] as $elem) { 
if($elem['NBcat']>0) {
?>
<div class="panelcat">
<?php 
$image = "web/image/categ".$elem['CE_IDcat'].".png";
if (file_exists($image)) {echo "<img src='$image' style='cursor:hand;' onclick='confirme(".$elem['CE_IDcat'].")' alt='image_ref'>";} ?>
</div>
<?php
}
}


?>
</div>


<div id="affichage_resultat"></div>




<script>
var cpt = document.getElementById('compteur').value;
document.getElementById('cpt_resul').innerHTML = "(" + cpt + " résul.)";

function confirme(tonID) {
	var tableau_test = new Object();
	var tableau_test = <?php echo json_encode($donnees['resultats'], JSON_PRETTY_PRINT) ?>;
	var MonTableau = new Array();
	  for (var i = 0; i < tableau_test.length; i++){
		  if(tableau_test[i]['CE_IDcat']==tonID) {
			 if(tableau_test[i]['CE_IDcat']==1) { // gestion de la catégorie archive
			 var titre = tableau_test[i]['Nom_type'] + " " + tableau_test[i]['num'] + " " + tableau_test[i]['titre'];
			 var numero = "";
			 var lien_image = null;
			 } else {var titre = tableau_test[i]['titre'];
			 var numero = tableau_test[i]['num'];}
			 
			var auteur = tableau_test[i]['Nom_personne'] + ", " + tableau_test[i]['Prenom_personne'];
			if (auteur=="null, null") {var auteur = "";}
			
			var datex = tableau_test[i]['vdate'].split("-");
			var dateref = datex[2]+"/"+datex[1]+"/"+datex[0];
			
			if(tableau_test[i]['Nom_groupe']=="-") {var groupe = "";} else {var groupe = tableau_test[i]['Nom_groupe'];}
			if(tableau_test[i]['Nom_support']=="-") {var support = "";} else {var support = ", " + tableau_test[i]['Nom_support'];}
			
			if(tableau_test[i]['url']!="") {
				var lien_titre = "<a href='" + tableau_test[i]['url'] + "' target='_blank'>" + titre + "</a>";
			} else {var lien_titre = titre;}
			
			if(tableau_test[i]['lien_image']!="") {
				var lien_image = "<img src='" + tableau_test[i]['lien_image'] + "'>";
			}
			
			var liste = "<fieldset>"+
                 "<b>" + lien_titre + "</b>" + lien_image + "<br><span style='font-size:small'>" + tableau_test[i]['commentaire'] + "..." + "</span><br>"
					+ auteur + "<br>" + groupe
					 +  support + " " + numero + "<br>" + dateref + 
             "</fieldset>";
			if(tableau_test[i]['CE_IDcat']==0) {
				var liste = "<fieldset>"+
                 "<b>" + lien_titre + "</b><br>" +
               dateref + 
             "</fieldset>";
			}
			 
			MonTableau.push(liste);
			 
		  }
        }
		document.getElementById('affichage_resultat').innerHTML = MonTableau.join("");
}

</script>