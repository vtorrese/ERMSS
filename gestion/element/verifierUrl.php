<?php
$titre_page = "Vérification URL";

require ("header.php");
require_once('../../modele/Reference.php');
$reference = new Reference();
$min = $_GET['minctlurl'];
$nb = $_GET['nbctlurl'];
$recupurl = (array)$reference->recup_url($min,$nb);
//Création du tableau
?>
<table>
	<tr>
		<th>ID</th>
		<th>url</th>
		<th>ctl</th>
	</tr>
<?php
foreach($recupurl as $fiche) {
	if(url_exists($fiche[1])>0){ // conrol 1
		if(control($fiche[1])>0) {
			echo "<tr>";
			echo "<td>".$fiche[0]."</td><td>".$fiche[1]."</td><td>".control($fiche[1])."</td>";
			echo "</tr>";
		}
	}
	$lastmax = $fiche[0];
}
$cible = "verifierUrl.php?minctlurl=".($lastmax+1)."&nbctlurl=".$nb;

?>
</table>

<input type="button" name="voirsuiv" value="Voir 30 suiv." onclick="self.location.href='<?php echo $cible; ?>'">
<?php
function url_exists($url_a_tester)
{
$F=@fopen($url_a_tester,"r");
if($F){
	fclose($F);
	return 0;
	}
else {return 1;} 
}

function control($url_a_tester) {
	$test = @get_headers($url_a_tester);
	for($i=0;$i<count($test);$i++) {
		if (preg_match("/forbidden/i", $test[$i])) {
			return 0;
		}
	}
	return 1;
}
?>