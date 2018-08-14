<!-- chercher ERMSS -->


<?php

$titre_page = "Recherche";

require ("header.php");
require_once('../../modele/Reference.php');

?>

<form name="rechercher" method="POST" class="menu">
	<input type="text" Placeholder="Rechercher..." name="cherche_mot" size="50" required>
	<input type="submit" name="valid_chercher" value="Go" >
</form>
<hr>


<?php

if(isset($_POST['valid_chercher'])) {
	$mot = $_POST['cherche_mot'];
	$reference = new Reference();
	$result = (array)$reference->recherche_mot($mot);

	usort($result, 'datcomparer');	
	echo count($result)." résultats"; ?>
	<table id='result_rech'>
		<tr>
			<th>ID</th><th>Titre</th><th>Date</th>
		</tr>
		<?php
			foreach($result as $item) {
				echo "<tr>";
				$ref = $item['ID'];
					echo "<td><a href='edition.php?idref=$ref'>$ref</a></td>";
					echo "<td>".$item['titre']."</td>";
					echo "<td>".$item['vdate']."</td>";
				echo "</tr>";
			}
		?>
	</table>
	
<?php	
}

function datcomparer($a, $b)
{
    $t1 = strtotime($a['vdate']);
    $t2 = strtotime($b['vdate']);
    return $t2 - $t1;
}
?>