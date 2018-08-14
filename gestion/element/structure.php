<?php

$titre_page = "Structure de la BDD";

require ("header.php");
require_once('../../modele/Reference.php');
require_once('../../modele/Categorie.php');
require_once('../../modele/Theme.php');

$reference = new Reference();
$Struct_By_cat = (array)$reference->structure_cat(); 
$theme = new Theme();
$tabtheme = (array)$theme->recup_theme();
$categorie = new Categorie();
$tabcateg = (array)$categorie->recup_cat();
foreach($Struct_By_cat as $element) {
	$tabcroise[$element[0].$element[1]] = $element[2];
}
$casemax = max($tabcroise);

//détermination des max par catégories
$nbmax = 0;
foreach($tabcateg as $indexa) {
	foreach($tabtheme as $indexb) {if($tabcroise[$indexa[1].$indexb[1]]>$nbmax) {$nbmax = $tabcroise[$indexa[1].$indexb[1]];}		}
	$tabmax[$indexa[1]] = $nbmax;
	$nbmax=0;
}


echo "<div style='width :80%;height:auto;display : online-block;float:left'>";
echo "<table style='font-size:small;'>";
	echo "<tr>";
		echo "<th>Thémes</th>";
		foreach($tabcateg as $ctg) {
				echo "<th>".$ctg[1]."</th>";
			}
		echo "</tr>";
		foreach($tabtheme as $them) {
				echo "<tr><td style='font-weight:bold;'>".$them[1]."</td>";
			foreach($tabcateg as $ct) {
				if(!empty($tabcroise[$ct[1].$them[1]])) {
					//Pour identifier (color) l'effectif maximum de la structure totale en rouge
					if($tabcroise[$ct[1].$them[1]]==$casemax) {$color="red";} else {$color="white";}
					
					//Pour identifier (color background) l'effectif maximum par catégorie
					if($tabcroise[$ct[1].$them[1]]==$tabmax[$ct[1]]) {$bcgcolor="#2F94B5";} else {$bcgcolor="grey";}
					
					//affichage de la case
					echo "<td style='color:".$color.";background-color:".$bcgcolor.";text-align : center;'>".$tabcroise[$ct[1].$them[1]]."</td>";
				} else {
					//Affichage par défaut case à 0 effectif
					echo "<td style='color:black;text-align : center;'>0</td>";}
				}
			echo "</tr>";
}
echo "</table>";
echo "</div>";


?>