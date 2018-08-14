 <?php

$titre_page = "Mise à jour";

require ("header.php");


?>

<form method='POST' name='validationmaj' action='moteur_maj.php'>

<div id="mail">
<span class="titre">mails</span>
<?php /*require_once('legifrance.php'); 

		//if($revueorg) {var_dump($revueorg);}
		echo "<table>";
		//echo "<p style='float : right;'><input type='submit' name='validarchive' value='Intégrer'></p>";
			echo "<tr>";
				echo "<th>Type</th><th>Titre</th><th>url</th><th>Action</th>";
			echo "</tr>";
			$cc = 0;
			foreach($tabquatre as $item) {
			$type = $item['type'];
			$titrex = $item['titre'];
			$urlx = $item['url'];
			echo "<tr style='font-size : small;'>";
				echo "<td>$type</td>";
				echo "<td style='text-align:left;'>$titrex</td>";
				echo "<td>".urlExist($urlx)."</td>";
				$ref = $cc++;
				echo "<td><input type='checkbox' name = 'tab[]' value='$ref'><input type = 'hidden' name ='selection_mail' value = '".base64_encode( serialize( $tabquatre ) )."'></td>";
				
			echo "</tr>";
		}		
		echo "</table>";*/
		
		

?>

</div>

<div id="rss">
<span class="titre">rss</span>
<?php require_once('rss.php'); 

	if(count($tabrssx)>0) {
	echo "<table>";
			echo "<tr>";
				echo "<th>Titre</th><th>Date</th><th>Theme</th><th>Action</th>";
			echo "</tr>";
			$ccr = 0;
			
			foreach($tabrssx as $item) {

			$titre = $item['titre'];
			$theme = $item['Nomth'];
			$idtheme = $item['IDtheme'];
			$datex = $item['date'];
			echo "<tr style='font-size : small;'>";
				echo "<td>$titre</td>";
				echo "<td>$datex</td>";
				echo "<td>$theme<input type = 'hidden' name ='idtheme' value = '$idtheme'></td>";
				$ref = $ccr++;
				echo "<td><input type='checkbox' name = 'tabrss[]' value='$ref'></td>";
				
			echo "</tr>";
		}	
		
		echo "</table>";
		$newrss = json_decode(json_encode((array)$tabrssx), TRUE);
		
	echo "<input type = 'hidden' name ='selection_rss' value = '".base64_encode( serialize( $newrss ) )."'>";
	}
?>


</div>

<div id="ref">
<span class="titre">reference</span>
<?php require_once('ref.php'); 

	if(count($result_flux)>0) {
	echo "<table>";
			echo "<tr>";
				echo "<th>Titre</th><th>Date</th><th>Theme</th><th>Action</th>";
			echo "</tr>";
			$ccref = 0;
			
			foreach($result_flux as $item) {
			$titre = $item['titre'];
			$theme = $item['nmtheme'];
			$idtheme = $item['idtheme'];
			$datex = $item['date'];
			echo "<tr style='font-size : small;'>";
				echo "<td>$titre</td>";
				echo "<td>$datex</td>";
				echo "<td>$theme<input type = 'hidden' name ='idtheme' value = '$idtheme'></td>";
				$ref = $ccref++;
				echo "<td><input type='checkbox' name = 'tabref[]' value='$ref'></td>";
				
			echo "</tr>";
		}	
		
		echo "</table>";
		$newref = json_decode(json_encode((array)$result_flux), TRUE);
	echo "<input type = 'hidden' name ='selection_ref' value = '".base64_encode( serialize( $newref ) )."'>";
	}

?>
</div>

<div id="progression"></div>

<hr>
<input type="submit" name="valid_maj" value="Valider">
</form>

<script>
//Moteur d'affichage du tableau revue.org si courrier dispo
var stro = <?php echo json_encode($revueorg, JSON_FORCE_OBJECT); ?>;
parser = new DOMParser();
doc = parser.parseFromString(stro, "text/html");
var titre = doc.title;
var datex = titre.split("|");
var tab = new Array();
var debtxt = '<table><tr><th>titre</th><th>Url</th><th>Action</th></tr>';
var text = '';
var a = 0;
var myNodelist = doc.querySelectorAll("p");
for (i=0;i<myNodelist.length;i++) {
	var longu = myNodelist[i].textContent.length;
	if (longu>500)  {
	var lib = myNodelist[i].textContent.substr(0,150);
	var url = myNodelist[i+1].textContent.substr(1);
	var text = text + "<tr style='font-size : small;'><td>" + lib + "</td><td>" + url +  "</td><td><input type='checkbox' name='idrvorg[" + a + "]'><input type='hidden' name='fcrvo[" + a + "]' value='" + datex[2] + "*" + url + "*" + myNodelist[i].textContent + "'></td></tr>";
	a++;
	}
	
}
text = "<p style='font-size : small;'>" + titre + "</p>" + debtxt + text + "</table>";
tab.push(text);
document.getElementById('result').innerHTML = tab.join("");

</script>