<?php

$titre_page = "Consultations";

require ("header.php");
require_once('../../modele/Visite.php');

//On récupère les visites selon condition :
$visite = new Visite();
$tabvisite = (array)$visite->recup_tout();
$cptvisite = (array)$visite->cpt_visite();
$paysvisite = (array)$visite->cpt_visite_ByPays();
$recordvisite =(array)$visite->cpt_record_Days();
?>

<div style="display :inline-block;float:left;">
<table>
	<tr>
		<th>Source</th>
		<th>ip publique</th>
	</tr>
	<tr style='font-size : small'>
<?php
echo "<td>IP Pub. effect.</td><td>".$_SERVER['REMOTE_ADDR']."</td></tr>";
$test = fopen('../../IPG.txt','r');
$ligneIP = fgets($test);
echo "<tr style='font-size : small'><td>IP Pub. par déf.</td><td>".$ligneIP."</td></tr></table>";
fclose($test);
?>

<input type="button" name="modifierIP" value="Modifier" onclick="self.location.href='<?php echo $href."modifierIP.php?new=".$_SERVER['REMOTE_ADDR'];?>'" style='display : inline-block;float : left;'><br>
<hr>
<p>Nb visites total : <?php echo $cptvisite[0][0]; ?><br>
Nb visites Hs  : <?php echo $cptvisite[0][1]; ?></p>
<p style="font-size:small">Nb record : <?php echo $recordvisite[0][1]; ?>
 | le : <?php echo $recordvisite[0][0]; ?></p>
<hr>
Par pays :
<table>
	<tr>
		<th>Pays</th>
		<th>Nbre Hs</th>
	
	</tr>
	<?php
	foreach($paysvisite as $key=>$value) {
		echo "<tr style='font-size :small'><td>".$value[0]."</td><td>".$value[1]."</td></tr>";
	}
	?>
</table>
</div>

<div style="max-height: 450px;width : auto;overflow:scroll;overflow-x : hidden;display : inline-block;float:left;border-left : 1px solid black;margin-left : 1%;">
<table>
	<tr>
		<th>Date</th>
		<th>Heure</th>
		<th>IP</th>
		<th>Host</th>
		<th>Ville</th>
		<th>Région</th>
		<th>Pays</th>
		<th></th>
	</tr>
	<?php
	foreach($tabvisite as $key=>$value) {
		$chrono = explode(" ",$value[1]);
		$date = $chrono[0];
		$heure = $chrono[1];
		echo "<tr style='font-size : small'>";
		echo "<td>".$date."</td>";
		echo "<td>".$heure."</td>";
		echo "<td>".$value[2]."</td>";
		echo "<td>".$value[3]."</td>";
		echo "<td>".$value[6]."</td>";
		echo "<td>".$value[5]."</td>";
		echo "<td>".$value[4]."</td>";
	?>
		<td><input type="button" name="supp_visit" value="Supprimer" onclick="self.location.href='<?php echo $href."supprimerIP.php?IP=".$value[0];?>'" ></td>
		</tr>
	<?php }
	?>
</table>
</div>

<?php include('historique_vst.php'); ?>
