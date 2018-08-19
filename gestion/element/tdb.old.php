<!-- tableau de bord ERMSS -->
<script src="../../web/js/Chart.js"></script>

<?php

$titre_page = "Tableau de bord";

require ("header.php");

require_once('../../modele/Reference.php');
require_once('../../modele/Theme.php');  

$reference = new Reference();
$theme = new Theme();
$nb_reference =  (array)$reference->compter_reference();
$nb_categorie = $reference->compter_categorie();
$date_reference = (array)$reference->dater_reference();
$nb_theme = (array)$theme->compter_theme();
$ssauteur = (array)$reference->sans_auteur();
$ssimage = (array)$reference->sans_image();
$sscom = (array)$reference->sans_com();
$taillebdd = (array)$reference->taille_table();
?>

<table id="compteur_total">
	<tr>
		<th>Base</th>
		<th>Effectifs</th>
		<th>Projection</th>
	</tr>
	<?php 
		$total = 0;
		$totalref = 0;
		$totalrss = 0;
		for($i=0;$i<count($nb_reference)-1;$i++) {
		echo "<tr style='font-size:small'>";
		echo "<td>".$nb_reference[$i][0]."</td>"; // intitulé
		echo "<td>".$nb_reference[$i][1]."</td>"; // valeurs
		echo "<td><span id='".$nb_reference[$i][0]."'></span></td>";
		echo "</tr>";
		if($i<2) {$total = $total + $nb_reference[$i][1];}
		if($nb_reference[$i][0]=="references") {$totalref = $totalref + $nb_reference[$i][1];}
		if($nb_reference[$i][0]=="rss valides") {$totalrss = $totalrss + $nb_reference[$i][1];}
	} ?>

		<th></th>
		<th style='font-size:small;border-top : solid black 0.5px'>Date+</th><th style='font-size:small;border-top : solid black 0.5px'><span id='dateproj'></span></th>
	</tr>
	<?php 
		for($i=0;$i<count($date_reference);$i++) {
		$date = substr($date_reference[$i][1],8,2)."-".substr($date_reference[$i][1],5,2)."-".substr($date_reference[$i][1],0,4);
		echo "<tr style='font-size:small'>";
		echo "<td>".$date_reference[$i][0]."</td>";
		echo "<td>".$date."</td>";
		echo "</tr>";
	} ?>

	<tr style='font-size:small;'>
		<td>Ecart ref/rss</td><td style='color:orange;border-top : solid black 0.5px'><?php echo $totalrss - $totalref; ?></td><td style='color:orange;border-top : solid black 0.5px'><span id='ecartth'></span></td>
	</tr>

	<tr style='font-size:small'>
		<td>Tx Rss.</td><td style='color:green;'><span id='tauxrss'></span></td>
	</tr>

	<tr style='font-size:small'>
		<td>Tx Ref.</td><td style='color:blue;'><span id='tauxref'></span></td>
	</tr>
	<tr><td style="color : black;">TOTAL</td><td style="color : red;font-weight : bold;border-top : solid black 0.5px;"><?php echo $total; ?></td><td style="color : purple;font-weight : bold;border-top : solid black 0.5px;"><span id='projeff'></span></td></tr>
	<tr>
</table>


<div id="graphe_categorie">
<canvas id="myChart" ></canvas>
</div>




<?php 
$label = "";
$cpt = "";

for($i=0;$i<count($nb_theme);$i++) {
	$nomtheme = $nb_theme[$i][0];
	$cptheme = $nb_theme[$i][1];
	$label .= ", \"$nomtheme\"";
	$cpt .= ",$cptheme";
	$tob[$i]= (int) $cptheme;
}
$label = substr($label,1);
$cpt = substr($cpt,1);
$ecartype = ecart_type ($tob);
$moyenne = substr(array_sum($tob)/count($tob),0,4);
?>
<p><?php echo "Ecart-type : ".$ecartype." | Moyenne : ".$moyenne; ?></p>
<div id="liste_theme">
<canvas id="bar-chart" style="height:200px; width:40vw"></canvas>

</div>


<div id="tableau_erreur">
<table>
	<tr>
		<th>Ref. ss auteur <?php echo count($ssauteur); ?></th>
		<th>Ref. ss img <?php echo count($ssimage); ?></th>
		<th>Ref. ss com <?php echo count($sscom); ?></th>
	</tr>
	<?php
	for($i=0;$i<9;$i++) {
	echo "<tr>";	
	if(isset($ssauteur[$i])) {$refa = $ssauteur[$i][0];
	echo "<td><a href='edition.php?idref=$refa'>$refa</a></td>";} else {echo "<td></td>";}
	if(isset($ssimage[$i])) {$refi = $ssimage[$i][0];
	echo "<td><a href='edition.php?idref=$refi'>$refi</a></td>";} else {echo "<td></td>";}
	if(isset($sscom[$i])) {$refc = $sscom[$i][0];
	echo "<td><a href='edition.php?idref=$refc'>$refc</a></td>";} else {echo "<td></td>";}
	echo "</tr>";
	}
		
	
	
	?>
</table>
</div>
<span style="margin-left : 1%;font-size :small;">
<form method="GET" action="verifierUrl.php">
<p>Borne : <input type="text" name="minctlurl" value="1" size="7"></p>
<p>Nbrel : <input type="text" name="nbctlurl" value="30" size="7"></p>
<p><input type="submit" value="lancer vérification url"></p>
</form>
</span>
<div id="progression"></div>
	<hr>
<div id="taille_bdd">
<?php 
$nomt = "";
$taillet = "";
for($i=0;$i<count($taillebdd);$i++) {
	$nomtable = $taillebdd[$i][0];
	$taille = $taillebdd[$i][1];
	$nomt .= ", \"$nomtable\"";
	$taillet .= ",$taille";
}
$nomt = substr($nomt,1);
$taillet = substr($taillet,1);

?>
<canvas id="etat_bdd" style="height:350px; width:auto"></canvas>

</div>
<?php require_once('historique.php'); ?>

<?php

function ecart_type ($donnees) {
    //0 - Nombre d’éléments dans le tableau
    $population = count($donnees);
    if ($population != 0) {
        //1 - somme du tableau
        $somme_tableau = array_sum($donnees);
        //2 - Calcul de la moyenne
        $moyenne = $somme_tableau / $population;
        //3 - écart pour chaque valeur
        $ecart = [];
        for ($i = 0; $i < $population; $i++){
            //écart entre la valeur et la moyenne
			
            $ecart_donnee = $donnees[$i] - $moyenne;
            //carré de l'écart
				//$ecart_donnee_carre = bcpow($ecart_donnee, 2, 2);  // bcpow pose probleme et empeche le script de tourner
				$ecart_donnee_carre = ($ecart_donnee^2);
            //Insertion dans le tableau
			
            array_push($ecart, $ecart_donnee_carre);
        }
        //4 - somme des écarts
        $somme_ecart = array_sum($ecart);
		
        //5 - division de la somme des écarts par la population
        $division = $somme_ecart / $population;
        //6 - racine carrée de la division 
		$ecart_type = substr(sqrt($division)*100,0,5);
        //$ecart_type = bcsqrt ($division, 2); // bcsqrt pose probleme et empeche le script de tourner
    } else {
        $ecart_type = "Le tableau est vide";
    }
      //7 - renvoi du résultat
    return $ecart_type;
}
?>


<script>
//Graphe radar des catégories
var ctx = document.getElementById("myChart");
var myChart = new Chart(ctx, {
	
    type: 'radar',
    data: {
        labels: ["Archives", "Articles", "Cartes", "Lexique","Ouvrages", "Sites", "Statistiques", "Téléchargements"],
        datasets: [{
            label: 'Catégories',
            data: <?php echo json_encode($nb_categorie, JSON_PRETTY_PRINT) ?>,
            backgroundColor: [
                'rgba(227, 7, 7, 0.4)'
            ],
            borderColor: [
                'red'
            ],
            borderWidth: 1
        }]
    },
    options: {

        scale: {
			reverse: false,
                ticks: {
                    beginAtZero: true
                }
        }
    }
});

var theme = document.getElementById("bar-chart");
var barChart = new Chart(theme, {

  type: 'bar',
  data: {
    labels: [<?php echo $label; ?>],
    datasets: [{
      data: [<?php echo $cpt; ?>]
    }]
  },
      options: {
        legend: {
            display: false,
            labels: {
                display: false
            }
        },
		title: {
            display: true,
            text: 'Fréquences des thèmes'
        }
}
});


var base = document.getElementById("etat_bdd");
var lastChart = new Chart(base, {

  type: 'horizontalBar',
  data: {
    labels: [<?php echo $nomt; ?>],
    datasets: [{
		backgroundColor: "rgba(153,255,51,0.4)",
      data: [<?php echo $taillet; ?>]
    }]
  },
      options: {
        legend: {
            display: false,
            labels: {
                display: false
            }
        },
		title: {
            display: true,
            text: 'Poids des tables (Mo)'
        }
}
});



</script>