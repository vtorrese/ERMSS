Nomenclature des ESMSS<hr>

<?php 
//le type des ESMSS
$newtype = array_column($_POST["type"][0], 'nomtype', 'idtype');
$newsecteur = array_column($_POST["secteur"][0], 'nomsecteur', 'idsecteur');
$newpublic = array_column($_POST["public"][0], 'Nom_population', 'IDpopulation');

$newnomenclature = ['ident' => array_column($_POST["nomenclature"][0], 'IDentite'),'sigle' => array_column($_POST["nomenclature"][0], 'sigle'),'definition' => array_column($_POST["nomenclature"][0], 'definition'),'mission' => array_column($_POST["nomenclature"][0], 'mission'),'disposition' => array_column($_POST["nomenclature"][0], 'disposition'),'autorisation' => array_column($_POST["nomenclature"][0], 'Nom_autorisation'),'autorite' => array_column($_POST["nomenclature"][0], 'Nom_autorite'),'financeur' => array_column($_POST["nomenclature"][0], 'Nom_financeur'),'type' => array_column($_POST["nomenclature"][0], 'Nom_typessms'),'secteur' => array_column($_POST["nomenclature"][0], 'Nom_secteur'),'cetype' => array_column($_POST["nomenclature"][0], 'CE_type'),'cesecteur' => array_column($_POST["nomenclature"][0], 'CE_secteur'), 'cadre' => array_column($_POST["nomenclature"][0], 'cadre')];

$population = ['identpop' => array_column($_POST["population"][0],'IDent'),'idpop' => array_column($_POST["population"][0],'IDpopulation')];

$orientation = ['identori' => array_column($_POST["orientation"][0],'IDent'),'nomori' => array_column($_POST["orientation"][0],'Nom_orientation')];


?>

<div id="filtre_nomenclature">
<fieldset>

<a href="http://finess.sante.gouv.fr/jsp/rechercheSimple.jsp?coche=ok" target="_blank"><img src="http://finess.sante.gouv.fr/fininter/images/LogoFiness_32b.png" alt="Finess" title="Nomenclature Finess"></a>

<br>

<p>Filtrer</p>


<select id="dmr" onchange="affichessms('unique','')">
<option></option>
<?php 

for($a=0;$a<count($newnomenclature['sigle']);$a++) {
	$sigle = $newnomenclature['sigle'][$a];
	$identite = $newnomenclature['IDent'][$a];
	echo "<option value='$identite'>$sigle</option>";
 }

 ?>
</select>

<hr>

<span class="titre_filtre">Par type</span><br>
<?php // affichage du filtre type
foreach($newtype as $key=>$elem) {
	if(!empty($elem)) { ?>
	<span class='filtres' onclick='affichessms("type",<?php echo $key; ?>)'><?php echo "&nbsp".$elem."&nbsp"; ?></span><br />
<?php }
}
?>

<span class="titre_filtre">Par secteur</span><br>
<?php // affichage du filtre secteur
foreach($newsecteur as $key=>$elem) {
	if(!empty($elem)) { ?>
	<span class='filtres' onclick='affichessms("secteur",<?php echo $key; ?>)'><?php echo "&nbsp".$elem."&nbsp"; ?></span><br />
	
<?php }
}
?>


<span class="titre_filtre">Par public</span><br>
<?php // affichage du filtre public
foreach($newpublic as $key=>$elem) {
	if(!empty($elem)) { ?>
	<span class='filtres' onclick='affichessms("public",<?php echo $key; ?>)'><?php echo "&nbsp".$elem."&nbsp"; ?></span><br />
<?php }
}
?>
</fieldset>
</div>


<div id="nomenclature_aff">
<span id="nomenc"></span>

</div>
<hr>
<script>

function affichessms(filtre,cle) {
	
	
	var tabnomenclature = new Array();
	var tabpop = new Array();
	nomenclature = <?php echo json_encode($newnomenclature); ?>;
	pop = <?php echo json_encode($population); ?>;
	
	orientation = <?php echo json_encode($orientation); ?>;

	popula = <?php echo json_encode($newpublic); ?>; // creation d'un tableau à partir d'un objet javascript
	var tabpopula = new Array();
	Object.getOwnPropertyNames(popula).forEach(
	function(val, idx, array) {
		tabpopula[val] = popula[val];
	});
	
	if(filtre=='unique') {
				select = document.getElementById("dmr");
				sigle_choix = select.selectedIndex;
				tabnomenclature.push(sigle_choix);
	}
	else {
	for(var i=0;i<nomenclature['ident'].length;i++) { //parcours de la nomenclature
	
			if(filtre=='type') { // tri sur le type
				if(nomenclature['cetype'][i]==cle) {
					tabnomenclature.push(nomenclature['ident'][i]); // ajouter les données au tableau
				}
			}
			if(filtre=='secteur') { // tri sur le secteur
				if(nomenclature['cesecteur'][i]==cle) {
					tabnomenclature.push(nomenclature['ident'][i]); // ajouter les données au tableau
				}
			}
			if(filtre=='public') { // tri sur les publics
			
				for(var a=0;a<pop['identpop'].length;a++) {
						if((nomenclature['ident'][i]==pop['identpop'][a])&&(pop['idpop'][a]==cle)){
						tabnomenclature.push(nomenclature['ident'][i]); // ajouter les données au tableau
					}
					
				}	
			}
			if(filtre=='unique') {
				select = document.getElementById("dmr");
				sigle_choix = select.selectedIndex;
				tabnomenclature.push(sigle_choix);
			}
		
		
	}
	}
	//affichage du tableau final
	var list_nom = "";
	var tab_final = new Array();
	
	for(var p=0;p<tabnomenclature.length;p++) {
	 
			var popu = "";
			var orient = "";			
			for(var a=0;a<nomenclature['ident'].length;a++) {
				var id = tabnomenclature[p];
				if(nomenclature['ident'][a]==id) {
					
								// population accueillie
					for(var ax=0;ax<pop['identpop'].length;ax++) {
						if(id==pop['identpop'][ax]){
							popu = popu + ", " + tabpopula[pop['idpop'][ax]];
						}
						
					}
					
							// orientation
					
					for(var axi=0;axi<orientation['identori'].length;axi++) {
						if(orientation['identori'][axi]==id){
							orient = orient + ", " + orientation['nomori'][axi];
						}
						
					 }
					
					var sigle = nomenclature['sigle'][a]; // sigle
					list_nom = "<div class='listnm'><span class='list_nomenc'>" + sigle;
					var definition = nomenclature['definition'][a]; // définition du sigle
					list_nom = list_nom + " - " + definition + "</span><br><br>";
					list_nom = list_nom + "<blockquote>";
					var secteur = nomenclature['secteur'][a]; // secteur				
					var type = nomenclature['type'][a]; // type
					list_nom = list_nom + "Secteur : " + secteur +  "  - Type : " + type + "<br>";
					
					
					list_nom = list_nom + "Populations accueillies : " + popu.substring(1) + " | Orientation : " + orient.substring(1) + "<br>";
					
					var mission = nomenclature['mission'][a]; // mission
					list_nom = list_nom + "Missions : " + mission + "<br>";
					
					if(nomenclature['disposition'][a]!=' ') {
					var disposition = nomenclature['disposition'][a]; // disposition
					var terme = "Dispositions légales : ";
					list_nom = list_nom + "<span style='font-size : small;color : black;'>" + terme + disposition + "</span><br>";}
					
					if(nomenclature['cadre'][a]!=' ') {
					if (terme=='Dispositions légales : ') {var terme = '';} else {var terme = "Dispositions légales : ";}
					var cadre = nomenclature['cadre'][a]; // cadre
					list_nom = list_nom + "<span style='font-size : small;color : black;'>" + terme + cadre + "</span><br>";}
					
					
					if(nomenclature['autorisation'][a]!='') {
					var autorisation = nomenclature['autorisation'][a]; // autorisation 
					list_nom = list_nom + "<span style='font-size : small;color : black;'>Autorisation : " + autorisation + "</span><br>";}
					
					if(nomenclature['autorite'][a]!='') {
					var autorite = nomenclature['autorite'][a]; // autorite de tarification
					list_nom = list_nom + "<span style='font-size : small;color : black;'>Autorite de tarification : " + autorite + "</span><br>";}
					
					if(nomenclature['financeur'][a]!='') {
					var financeur = nomenclature['financeur'][a]; // financeur
					list_nom = list_nom + "<span style='font-size : small;color : black;'>Financeur : " + financeur + "</span><br>";}
					
					
					list_nom = list_nom + "</blockquote><hr><br></div>";
				}
				
			}
		
		tab_final.push(list_nom);
		}
	document.getElementById('nomenc').innerHTML = tab_final.join("");
}



</script>