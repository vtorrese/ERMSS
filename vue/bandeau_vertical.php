<div id="bandeau_vertical">


<h4>Des outils à disposition...</h4>
<form name="outils_dispo" method="POST" class="menu">
	
	<div class='carre'><button type="submit" name="out_nomenclature" value=""><img src="web/image/nom_esmss.png" alt="Submit" title="Nomenclature des ESMSS"></button> </div>

	<div class='carre'><button type="submit" name="out_profession" value=""><img src="web/image/nom_metier.png" alt="Submit" title="Nomenclature des professions"> </button></div>
	
	<div class='carre'><button type="submit" name="out_lexique" value=""><img src="web/image/categ4.png" alt="Submit" title="Lexique"> </button></div>
	
	<div class='carre'><button type="submit" name="juridique" value=""><img src="web/image/categ1.png" alt="Submit" title="Veille & ressources Juridiques"> </button></div>
	
	<div class='carre'><button type="submit" name="outil" value=""><img src="web/image/timeline.png" alt="Submit" title="Créer une chronologie"> </button></div>

</form>

<div id="progression"></div>
<hr>
<h4>Colloques, Conférences, Formations</h4>

<?php //var_dump($donnees['evenement'][1]['titre']); ?>

<?php
 foreach($donnees['evenement'] as $itevn) {
	 $datew = substr($itevn['vdate'],8,2)."-".substr($itevn['vdate'],5,2)."-".substr($itevn['vdate'],0,4);
	 echo "<div class='liste-even'>";
	 if($itevn['lien_image']!='') {echo "<img src='".$itevn['lien_image']."' alt='".$itevn['titre']."'>";}
	 echo "<a href='".$itevn['url']."' target='_blank'>".$itevn['titre']."</a><br>";
	 echo $datew."</div><br>";
 }
?>


</div>