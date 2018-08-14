<?php //Page organisation ?>


<!-- bandeau latéral -->
<div id="bandeau_organisation">
<h4>Organisation des secteurs SMSS</h4>
<p><img src="web/image/nom_esmss.png" style="cursor:hand;" onclick="choix('esmss')">Nomenclature des ESMSS</p>
<p><img src="web/image/nom_metier.png" style="cursor:hand;" onclick="choix('metier')">Nomenclature des professions</p>
<p><img src="web/image/carte_formation.png" style="cursor:hand;" onclick="choix('carte')">Carte des centres de formation</p>
<p><img src="web/image/categ4.png" style="cursor:hand;" onclick="choix('lexique')">Lexique</p>
<hr>
<?php $image = "web/image/theme10.jpg";
if (file_exists($image)) {echo "<img src='$image' style='float : right;width : 40%;height : auto;'>";} ?>
<h4>Autour des ESMSS...</h4>

<?php  
	foreach($donnees['suggestion_orga'] as $itm) {
		
		$tit = $itm['titre'];
		$url = $itm['url'];
		$dat = substr($itm['date'],8,2)."-".substr($itm['date'],5,2)."-".substr($itm['date'],0,4);
		echo "<span style='font-size : medium'><a href='$url' target='_blank'>$tit</a><span style='color : red;font-size : small;'>  $dat</span></span>";
		echo "<hr align='center' width='33%'>";
	}
?>

</div>

<!-- icones -->
<div id="affichage_icone">

<div class="panelcat"><img src="web/image/nom_esmss.png" style="cursor:hand;" onclick="choix('esmss')"> </div>
<div class="panelcat"><img src="web/image/nom_metier.png" style="cursor:hand;" onclick="choix('metier')"> </div>
<div class="panelcat"><img src="web/image/carte_formation.png" style="cursor:hand;" onclick="choix('carte')"> </div>
<div class="panelcat"><img src="web/image/categ4.png" style="cursor:hand;" onclick="choix('lexique')"> </div>
<div id="progression"></div>

<div id="affichage_organisation">

</div>
</div>
<script>

var pan = <?php echo json_encode($donnees['panneau']); ?>;
if(pan!=null) {choix(pan);}

function choix(Panneau) {
	
	if(Panneau=='esmss') {
			var nomenclature = <?php echo json_encode($donnees['nomenclature'], JSON_FORCE_OBJECT); ?>;
			var population = <?php echo json_encode($donnees['population'], JSON_FORCE_OBJECT); ?>;
			var orientation = <?php echo json_encode($donnees['orientation'], JSON_FORCE_OBJECT); ?>;
			var type = <?php echo json_encode($donnees['type'], JSON_FORCE_OBJECT); ?>;
			var secteur = <?php echo json_encode($donnees['secteur'], JSON_FORCE_OBJECT); ?>;
			var ttpublic = <?php echo json_encode($donnees['public'], JSON_FORCE_OBJECT); ?>;
			document.getElementById('affichage_organisation').innerHTML = "<img src='web/image/progress_bar.gif' alt='load'/>";
			$(document).ready(function(){
				
				$("#affichage_organisation").load("vue/nomenclature", {"nomenclature" : [nomenclature], "population" : [population], "orientation" : [orientation], "type" : [type], "secteur" : [secteur], "public" : [ttpublic]});
			});

	}
	else if (Panneau=='metier') {
			$(document).ready(function(){
				$("#affichage_organisation").load("vue/metier.php");
			});
	}
	else if (Panneau=='carte') {
			$(document).ready(function(){
				$("#affichage_organisation").load("vue/carte_formation.php");
			});
	}
	else if (Panneau=='lexique') {
			var tableau_lettre = new Object();
			var tableau_definition = new Object();
			var tab = new Array();
			var tab_def = new Array();
			var tableau_lettre = <?php echo json_encode($donnees['initiale'], JSON_PRETTY_PRINT) ?>;
			var tableau_definition = <?php echo json_encode($donnees['definition'], JSON_PRETTY_PRINT) ?>;
			var text = "";
			var x;
			for (x in tableau_lettre) {
			text += tableau_lettre[x][0];
			tab.push(tableau_lettre[x][0]);
			}
			var y;
			for (y in tableau_definition) {
				tab_def.push(tableau_definition[y][0],tableau_definition[y][1],tableau_definition[y][2]);
			}
			
			$(document).ready(function(){
				$("#affichage_organisation").load("vue/lexique.php", { "lexique[]": [tab,tab_def] });
			});
		
	}

}

</script>