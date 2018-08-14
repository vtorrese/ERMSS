Lexique<hr>

<?php 

// Panneau des lettres à cliquer
$initiales = explode(",",$_POST['lexique'][0]);
foreach($initiales as $init) { ?>
<p class='initiale' onclick='affichedef("<?php echo $init; ?>")'><?php echo "&nbsp".$init."&nbsp"; ?></p>
<?php
}
 ?>
 <div id="progression"></div>
 <fieldset><div id="aff"></div></fieldset>
 
<script>
 
 function affichedef(lettre) {
	 var definition = new Object();
	 var definition = <?php echo json_encode($_POST['lexique'][1], JSON_PRETTY_PRINT) ?>;
	 var test = definition.split(",");
	 var Monaffichage = new Array();
		for (var y=0;y<test.length;y++) {
			if(((test[y].length)==1)&& (test[y]==lettre)){
				var ligne = test[y+1] + " :  " + test[y+2] + "</br>";
				Monaffichage.push(ligne);
			}
				
	
		}
	document.getElementById('aff').innerHTML = Monaffichage.join("");
 }
 
</script>