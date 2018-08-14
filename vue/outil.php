<?php //page outil ?>

<?php //var_dump($donnees['panneau']); ?>


<!-- bandeau latéral -->
<div id="bandeau_outil">
<h4>Outils</h4>
<p><img src="web/image/timeline.png" style="cursor:hand;" onclick="choix('time')">Créer une chronologie</p>

<p>D'autres outils à venir...</p>
</div>

<!-- icones -->
<div id="affichage_icone_outil">

<div class="panelcat"><img src="web/image/timeline.png" style="cursor:hand;" onclick="choix('time')"> </div>

<div id="progression"></div>

<div id="affichage_outil"></div>

<?php if(isset($donnees['timeline'])) {
	
	include_once('timelineG2.php');
	

	
} ?>


</div>


<script>

var pan = <?php echo json_encode($donnees['panneau']); ?>;
if(pan!=null) {choix(pan);}

function choix(Panneau) {
	
	
	if(Panneau=='time') {
		
			$(document).ready(function(){
				var theme = <?php echo json_encode($donnees['theme'], JSON_FORCE_OBJECT); ?>;
				$("#affichage_outil").load("vue/timeline", {"theme" : [theme]});
			});

	}

}


</script>