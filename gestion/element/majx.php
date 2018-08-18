<?php

$titre_page = "Mise à jour";

require ("header.php");

require_once('../../modele/Maj.php');
$list = new Maj();
$recuplist = (array)$list->recup_affichage();
$cptlist = $list->recup_cpt_affichage();
$baselist = (array)$list->recup_base_cpt();
$basehisto = (array)$list->recup_base_histo();
?>

<div style="width : 50%;height:auto;display:inline-block;float:left;border-right : solid black 1px;padding : 1%;">
<form method='POST' name='validation' action='maj_cron.php'>
<h4>Résultats (<?php echo $cptlist[0]; ?>) <input type="submit" name="valid_maj" value="Valider" style="right : 50%;color:orange;position : fixed;"></h4>
<table style="font-size:small;">
	<tr>
		<th>Origine</th>
		<th>Nb archv</th>
		<th>Nb intgr</th>
		<th>Part %</th>
	</tr>
	<?php
	$archiv =0;
	$intgr =0;
	for($i=0;$i<count($baselist);$i++) {
		echo "<tr>";
			echo "<td>".$baselist[$i][0]."</td>";
			echo "<td>".$baselist[$i][1]."</td>";
			echo "<td>".$baselist[$i][2]."</td>";
			$tx = ($baselist[$i][2]/($baselist[$i][1] + $baselist[$i][2]))*100;
			echo "<td>".number_format($tx,2)."</td>";
		echo "</tr>";
		$archiv=$archiv+$baselist[$i][1];
		$intgr =$intgr+$baselist[$i][2];
	}
	?>
	<tr style='font-size:medium'>
		<td>TOTAL</td><td style="color:red"><?php echo $archiv; ?></td><td style="color:green"><?php echo $intgr; ?></td><td><?php echo number_format(($intgr/($archiv+$intgr))*100,2)?></td>
	</tr>
</table>
<hr>
<table style="font-size:small;">
	<tr>
		<th>Titre</th>
		<th>Origine</th>
		<th></th>
		<th>Archiver</th>
		<th>Intégrer</th>
	</tr>
	<?php
	for($i=0;$i<count($recuplist);$i++) {
		echo "<tr>";
			echo "<td>".$recuplist[$i][2]."</td>"; // TITRE
			echo "<td>".$recuplist[$i][1]."</td>"; // ORIGINE
			echo "<td><a href='".$recuplist[$i][3]."' target='_blank'><button type='button'>Voir</button></a></td>"; // Voir
			echo "<td><input type='checkbox' name = 'tabarchive[]' value='".$recuplist[$i][0]."'></td>"; // Archiver
			echo "<td><input type='checkbox' name = 'tabintegre[]' value='".$recuplist[$i][0]."'></td>"; // Intégrer
		echo "</tr>";
	}
	?>
</table>
</form>
</div>
<div style="width : auto;height:auto;float:left;padding : 1%;">
<h4>Historique des MAJ</h4>
<table style="font-size:small;">
	<tr>
		<th>Date/heure</th>
		<th>origine</th>
		<th>durée</th>
		<th>Nb reslt</th>
	</tr>
<?php
	for($i=0;$i<count($basehisto);$i++) {
		echo "<tr>";
			echo "<td>".$basehisto[$i][0]."</td>"; // DATE
			echo "<td>".$basehisto[$i][1]."</td>"; // ORIGINE
			echo "<td>".$basehisto[$i][2]."</td>"; // DUREE
			echo "<td>".$basehisto[$i][3]."</td>"; // NB
		echo "</tr>";
	}
?>
</table>
</div>

