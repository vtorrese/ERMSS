<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>

<div style="width:100%;height:auto;float:left;">
<hr>
<?php
	// Tableau des references
	require_once('../../modele/Visite.php');
	$historique_vst = new Visite();
	$tabvisit = (array)$historique_vst->cpt_visite_ByDays();
	$a=0;
	foreach($tabvisit as $itm) {
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $itm['Datex']);
		$newFormat = $date->format('Y,m,d');
		//new Date();
		unset($date);
		$effectif = (int)$itm['CPT'];
		$datevst[$a] = json_encode($newFormat);
		$valeurvst[$a] = json_encode($effectif);
		$a++;
	}
?>
<div id="Graphvisit" style="width: 50%; height: 300px;display: inline-block;border-left : 1px solid black;"></div>

<script type="text/javascript">
	window.onload = function () {
			var oDateref = new Object();
			var oDateref = <?php echo json_encode($datevst) ?>;
			
			var oValref = new Object();
			var oValref = <?php echo json_encode($valeurvst) ?>;
			var min = 0;
			
			var cpt = 0;
			var refactive = [];
			for(key in oDateref) {
			var yvaleur = parseInt(oValref[cpt]);
			var xvaleur = oDateref[key];
			x = new Date(xvaleur);
			if(cpt<1) {var mindateref= x;}
			y = yvaleur;
			if(y<min) {min=y};
			refactive.push({
			x: x,
			y: y                
				});
			cpt++;
			}
						//création du graph
			var chart = new CanvasJS.Chart("Graphvisit", {
				title: {
					text: "Historique Visites Hs",
					fontSize: 30
				},
				animationEnabled: true,
				axisX: {

					gridColor: "Silver",
					tickColor: "silver",
					valueFormatString: "DD/MMM"

				},
				toolTip: {
					shared: true
				},
				theme: "theme2",
				axisY: {
					gridColor: "Silver",
					minimum: 0,
					tickColor: "silver"
				},
				legend: {
					verticalAlign: "bottom",
					horizontalAlign: "center"
				},
				data: [
						{ type: "bar", showInLegend: true,
							lineThickness: 2,
							name: "Nb Visites",
							markerType: "none",
							color: "#117AF2", dataPoints: refactive }
				]
			});
			
			chart.render();
	}
</script>
</div>