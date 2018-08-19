<script src="https://canvasjs.com/assets/script/canvasjs.min.js"></script>


	<?php
	// Tableau des references
	require_once('../../modele/Historique.php');
	$historique = new Historique();
	$histo_reference =  (array)$historique->recup_histo_ref();
	$a=0;
	foreach($histo_reference as $itm) {
		
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $itm['Hdate']);
		$newFormat = $date->format('Y,m,d');
		//new Date();
		unset($date);
		$effectif = (int)$itm['Heff'];
		$dateref[$a] = json_encode($newFormat);
		$valeuref[$a] = json_encode($effectif);
		$a++;
	}
	
	$minref = $valeuref[0];
	$maxref = $valeuref[$a-1];
	$tauxref = (($maxref-$minref)/$minref)*100;
	//echo substr($tauxref,0,4);
	
	// Tableau des rss
	$histo_rss = (array)$historique->recup_histo_rss();
	$a=0;
	foreach($histo_rss as $itm) {
		
		$date = DateTime::createFromFormat('Y-m-d H:i:s', $itm['Hdate']);
		$newFormat = $date->format('Y,m,d');
		//new Date();
		unset($date);
		$effectif_actif = (int)$itm['Heffact'];
		$effectif_tot = (int)$itm['Hefftot'];
		$effectif_nactif = $effectif_tot-$effectif_actif;
		$daterssact[$a] = json_encode($newFormat);
		$valeurssact[$a] = json_encode($effectif_actif);
		$valeurssnact[$a] = json_encode($effectif_nactif);
		$a++;
	}
	$minrss = $valeurssact[$a-1];
	$maxrss = $valeurssact[0];
	$tauxrss = (($maxrss-$minrss)/$minrss)*100;
	//echo substr($tauxrss,0,4);
	
	?>
	
	<div id="chartContainer3" style="width: 50%; height: 300px;display: inline-block;border-left : 1px solid black;"></div>
	<hr>
	<script type="text/javascript">
		
		var jour = 60;
		var tauxref = <?php echo substr($tauxref,0,4); ?>;
		var tauxrss = <?php echo substr($tauxrss,0,4); ?>;
		var maxref = <?php echo $maxref; ?>;
		var maxrss = <?php echo $maxrss; ?>;
		var minref = <?php echo $minref; ?>;
		var minrss = <?php echo $minrss; ?>;
		var txjrref = (tauxref/100)/jour;
		var txjrrss = (tauxrss/100)/jour;
		
		document.getElementById('tauxref').innerHTML = tauxref + " %";
		document.getElementById('tauxrss').innerHTML = tauxrss + " %";		
		var effthref = maxref;
		
		var effthrss = maxrss;
		/*while (effthref<effthrss) {
			effthref = (txjrref*maxref*jour)+maxref;
			effthrss = (txjrrss*maxrss*jour)+maxrss;
			jour++;
		}	*/
		
		//Fixer la date du jour de l'équilibre ref/css
		datex = new Date(Date.now());
		datex.setDate(datex.getDate() + jour);
		var datesc = datex.toLocaleDateString();
		//Pour estimer le nombre total de références+rss quand équilibre entre rss et ref
		var totalesc = effthref+effthrss;
		var factor = Math.pow(10, -1);
		document.getElementById('dateproj').innerHTML = datesc;
		document.getElementById('projeff').innerHTML = Math.round(totalesc * factor) / factor;
		window.onload = function () {

			var oDateref = new Object();
			var oDateref = <?php echo json_encode($dateref) ?>;
			
			var oValref = new Object();
			var oValref = <?php echo json_encode($valeuref) ?>;
			
			var oDaterssact = new Object();
			var oDaterssact = <?php echo json_encode($daterssact) ?>;
			
			var oValrssact = new Object();
			var oValrssact = <?php echo json_encode($valeurssact) ?>;	

			var oValrssnact = new Object();
			var oValrssnact = <?php echo json_encode($valeurssnact) ?>;			
			
			var min = 100000;
			
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
			
			var cpt = 0;
			var rssactive = [];
			for(key in oDaterssact) {
			var yvaleur = parseInt(oValrssact[cpt]);
			var xvaleur = oDaterssact[key];
			x = new Date(xvaleur);
			if(cpt<1) {var mindaterss= x;}
			y = yvaleur;
			if(y<min) {min=y};
			rssactive.push({
			x: x,
			y: y                
				});
			cpt++;
			}

			
			//Gestion des effectifs théoriques en fonction du taux de progression ref et rss
			var today = new Date();
			var WNbJours = today.getTime() - mindateref.getTime();
			var WNbJours = Math.ceil(WNbJours/(1000*60*60*24));
			var effprojref = Math.round(((txjrref*minref*WNbJours)+minref) * factor) / factor;
			var ecart1 = effprojref;
			effprojref = maxref-effprojref;
			if(effprojref>=0) {
			var rapEffTot = "<span style='color:green;'>+" + effprojref + "</span>";}
			else {var rapEffTot = "<span style='color:red;'>" + effprojref + "</span>";}
			document.getElementById('references').innerHTML = rapEffTot;


			var effprojrss = Math.round(((txjrrss*minrss*WNbJours)+minrss) * factor) / factor;
			var ecart2 = effprojrss;
			
			effprojrss = maxrss-effprojrss;
			if(effprojrss>=0) {
			var rapEffTot = "<span style='color:green;'>+" + effprojrss + "</span>";}
			else {var rapEffTot = "<span style='color:red;'>" + effprojrss + "</span>";}
			document.getElementById('rss valides').innerHTML = rapEffTot;
			
			//écart eff-rss en projection
			
			var ecartth = ecart2-ecart1;
			document.getElementById('ecartth').innerHTML = Math.round(ecartth * factor) / factor;;
			
			//création du graph
			var chart = new CanvasJS.Chart("chartContainer3", {
				title: {
					text: "Historique Ressources",
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
					minimum: min-50,
					tickColor: "silver"
				},
				legend: {
					verticalAlign: "bottom",
					horizontalAlign: "center"
				},
				data: [
						{ type: "line", showInLegend: true,
							lineThickness: 2,
							name: "Ref actives",
							markerType: "none",
							color: "#117AF2", dataPoints: refactive },
						{ type: "line", showInLegend: true,
							lineThickness: 2,
							name: "Rss actives",
							markerType: "none",
							color: "#4A874F", dataPoints: rssactive }
				]
			});
			
			chart.render();

		
		
		}

	</script>