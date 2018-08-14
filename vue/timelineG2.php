
<script type="text/javascript" src="http://www.google.com/jsapi"></script>

<script type="text/javascript" src="web/librairie/timeline/timeline.js"></script>
<link rel="stylesheet" type="text/css" href="web/librairie/timeline/timeline-theme.css">

 <?php echo count($donnees['timeline'])." résultat(s)"; ?>
<div id="mytimeline" style="position : relative; height : 350px;width : auto; font-size: x-small;>"</div>

<?php

$a=0;
foreach($donnees['timeline'] as $time) {
	$annee = $time['annee'];
	if($time['Nom_cat']=='archive') {$nomparent = $time['Nom_type']." ".$time['titre'];}
	else {$nomparent = $time['Nom_cat']." : ".$time['titre'];}
	if($time['Nom_cat']=='News') {$catt =0;} else {foreach($donnees['cat'] as $cat) {if($cat['Nom_cat']==$time['Nom_cat']) {$catt = $cat['IDcat'];}}}

	$mois = $time['mois']-1;
	$jour = $time['jour'];
	$url = $time['url'];
	$tableau[$a] = array("occ"=>$nomparent,"annee"=>$annee,"mois"=>$mois,"jour"=>$jour, "url" =>$url, "catt" => $catt);
	$a++;
}

?>

<script type="text/javascript">
      google.load("visualization", "1");

      // Set callback to run when API is loaded
      google.setOnLoadCallback(drawVisualization);
		
		//on récupère les données
		var tableau_test = new Object();
		var tableau_test = <?php echo json_encode($tableau, JSON_PRETTY_PRINT) ?>;
		
      // Called when the Visualization API is loaded.
      function drawVisualization() {
        // Create and populate a data table.
        var data = new google.visualization.DataTable();
        data.addColumn('datetime', 'start');
        data.addColumn('datetime', 'end');
        data.addColumn('string', 'content');
		
		
		for (var key in tableau_test) 
		{ // On stocke l'identifiant dans « id » pour parcourir l'objet
		
		

		if((tableau_test[key].url)!='') {
			var sigle = '<a href="' + tableau_test[key].url +'" target="_blank">' + tableau_test[key].occ + '</a>';
		} else
		{
			var sigle = tableau_test[key].occ;
		}
		
		var image = '<img src="web/image/categ'+ tableau_test[key].catt +'.png" style="width:32px; height:32px;display : online-block;float:left;margin : 0% 1% 0% 0%;">';
		
		data.addRows([
          [new Date(tableau_test[key].annee, tableau_test[key].mois, tableau_test[key].jour), ,
           image + '<span style="background-color : white">' + sigle + '</span>']]);
	
}

        // specify options
        var options = {
          "width":  "100%",
          "height": "100%",
          "style": "box" // optional
        };

        // Instantiate our timeline object.
        var timeline = new links.Timeline(document.getElementById('mytimeline'));

        // Draw our timeline with the created data and options
        timeline.draw(data, options);
      }
</script>