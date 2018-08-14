<?php //page juridique ?>

<?php //var_dump($donnees['textes']); ?>

<!-- bandeau latéral -->
<div id="bandeau_juridique_lat">
<h4>Sources juridiques (<?php echo count($donnees['textes']); ?> ref.)</h4>
<?php
$cpt=0;

foreach($donnees['NBtype'] as $elem) {
		$type = $elem['CE_type'];
		$nomtype = $elem['Nom_type']."s";
		
		$nbtype = $elem['NBt'];
		$image = "web/image/type".$type.".png";
		if (file_exists($image)) {echo "<p><img src='$image' alt='' title='".$nomtype."' style='cursor:hand;' onclick='confirme($type);'/>$nomtype ($nbtype)</p>";
		}
	}
?>
<hr>
Trier par thème : <br>
<select id="choix_th_textes" onchange="affiche('theme','')">
<option></option>
<?php
	foreach($donnees['theme'] as $itmth) {
		echo "<option value='".$itmth['IDtheme']."'>".$itmth['Nom_theme']."</option>";
	}
?>
</select>
<hr>
Trier par mot-clé : <br>
<input type="text" id="bymot" >
<input type="submit" value="Chercher" onclick="affiche('mot','')">

</div>

<div id="resultat_textes">
<div id="compteur" style="float : left"></div>
<?php

foreach($donnees['NBtype'] as $elem) { 
if($elem['NBt']>0) {
?>
<div class="panelcat">
<?php 
$image = "web/image/type".$elem['CE_type'].".png";
$tonID = $elem['CE_type'];
if (file_exists($image)) {echo "<img src='$image' style='cursor:hand;' onclick='confirme($tonID)'>";} ?>
</div>
<?php
}
}


?>

</div>

<div id="affichage_resultat_textes">
</div>

<script>
function confirme(tonID) {
	document.getElementById('choix_th_textes').value = 0;
	document.getElementById('bymot').value = '';
	var tableau_test = new Object();
	var tableau_test = <?php echo json_encode($donnees['textes'], JSON_PRETTY_PRINT) ?>;
	var MonTableau = new Array();
		var cpt = 0;
	  for (var i = 0; i < tableau_test.length; i++){
		  var liste ='';
		  if(tableau_test[i]['CE_type']==tonID) {
			  var titre = tableau_test[i]['titre'] + "<br>";
			  var ntype = tableau_test[i]['Nom_type'];
			  if(tableau_test[i]['vdate']!='') {
				  var datex = tableau_test[i]['vdate'].split("-");
					var dateref = " du " + datex[2]+"/"+datex[1]+"/"+datex[0];
			  } else {var dateref ='';}
			  if(tableau_test[i]['num']!='') {var num = " n°" + tableau_test[i]['num'];} else {var num ='';}
			  if(tableau_test[i]['commentaire']!='') {var com = "<span style='font-size :small;'>" + tableau_test[i]['commentaire'] + "</span><br>";} else {var com ='';}
			  if(tableau_test[i]['Nom_theme']!='') {var the = "Thème : " + tableau_test[i]['Nom_theme'];} else {var the ='';}
			  if(tableau_test[i]['url']!='') {var url = "<span style='float : right;'><a href='" + tableau_test[i]['url'] + "' target='_blank'>  Voir</a></span>";} else {var url ='';}
			  var image = "<img src='web/image/type" + tableau_test[i]['CE_type'] + ".png' style='float : left;margin-right : 0.5%;'>";
			  var liste = "<fieldset>" + image + "<b>" + ntype + num + dateref + "</b> " + titre + com + the + url + "</fieldset>";
			  cpt++;
		  }
		MonTableau.push(liste);
	  }
	  
	  document.getElementById('affichage_resultat_textes').innerHTML = MonTableau.join("");
	  document.getElementById('compteur').innerHTML = cpt + " résultats";
	  
}

function affiche(filtre) {

	var tableau_test = new Object();
	var tableau_test = <?php echo json_encode($donnees['textes'], JSON_PRETTY_PRINT) ?>;
	var MonTableau = new Array();
	
	if(filtre=='theme') { // filtre par themes
	document.getElementById('bymot').value = '';
	select = document.getElementById("choix_th_textes");
	theme_choix = select.selectedIndex;
	cpt=0;
		for (var i = 0; i < tableau_test.length; i++){
		  if(tableau_test[i]['CE_theme']==select.options[theme_choix].value) {
			  MonTableau.push(tableau_test[i]);
			  cpt++;
		  }
		}
	}
	
	if(filtre=='mot') { // filtre par mot
	document.getElementById('choix_th_textes').value = 0;
	var text = document.getElementById("bymot").value;
	var matchx = new RegExp(text, 'gi');
		cpt=0;
		for (var i = 0; i < tableau_test.length; i++){
		  if((tableau_test[i]['titre'].match(matchx))|| (tableau_test[i]['commentaire'].match(matchx))){
			  MonTableau.push(tableau_test[i]);
			  cpt++;
		  }
		}
	}

	
	//Affichage final des résultats
	var MonAffichage = new Array();
		for (var i = 0; i < MonTableau.length; i++){
			var liste ='';
			var titre = MonTableau[i]['titre'] + "<br>";
			  var ntype = MonTableau[i]['Nom_type'];
			  if(MonTableau[i]['vdate']!='') {
				  var datex = MonTableau[i]['vdate'].split("-");
					var dateref = " du " + datex[2]+"/"+datex[1]+"/"+datex[0];
			  } else {var dateref ='';}
			  if(MonTableau[i]['num']!='') {var num = " n°" + MonTableau[i]['num'];} else {var num ='';}
			  if(MonTableau[i]['commentaire']!='') {var com = "<span style='font-size :small;'>" + MonTableau[i]['commentaire'] + "</span><br>";} else {var com ='';}
			  if(MonTableau[i]['Nom_theme']!='') {var the = "Thème : " + MonTableau[i]['Nom_theme'];} else {var the ='';}
			  if(MonTableau[i]['url']!='') {var url = "<span style='float : right;'><a href='" + MonTableau[i]['url'] + "' target='_blank'>  Voir</a></span>";} else {var url ='';}
			  var image = "<img src='web/image/type" + MonTableau[i]['CE_type'] + ".png' style='float : left;margin-right : 0.5%;'>";
			  var liste = "<fieldset>" + image + "<b>" + ntype + num + dateref + "</b> " + titre + com + the + url + "</fieldset>";
			  MonAffichage.push(liste);
		}
			  document.getElementById('affichage_resultat_textes').innerHTML = MonAffichage.join("");
				document.getElementById('compteur').innerHTML = cpt + " résultats";
}

</script>