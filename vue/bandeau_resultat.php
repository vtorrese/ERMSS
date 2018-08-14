
<?php if($donnees['rechercheavc']) { 
$chaineretour = explode("/",$donnees['rechercheavc']);
if(strlen($chaineretour[0])>0) {$titre = $chaineretour[0];}
if(strlen($chaineretour[1])>0) {$dated = $chaineretour[1];}
if(strlen($chaineretour[2])>0) {$datef = $chaineretour[2];}
if(strlen($chaineretour[3])>0) {$them = $chaineretour[3];}
if(strlen($chaineretour[4])>0) {$edit = $chaineretour[4];}
if(strlen($chaineretour[5])>0) {$sup = $chaineretour[5];}
}
$dated = substr($dated,6,4)."-".substr($dated,3,2)."-".substr($dated,0,2);
$datef = substr($datef,6,4)."-".substr($datef,3,2)."-".substr($datef,0,2);

?>
<div id="suggestion">
<input type="button" onclick='efface("recheravc")' value="Recherche avancée">

<?php 

if($donnees['lock']==true){
echo "<div id='recheravc' style='display : block;'>"; }
else {
echo "<div id='recheravc' style='display : none;'>";	
} ?>
<form method='POST' name='recher_avc' class="menu">
<hr>
<input type="text" name="mot_avc" placeholder="Mots du titre, commentaires...." value="<?php If($titre) {echo $titre;} ?>">  De : <input type="date" name="date1" id="date1" onchange='test()' value="<?php If($dated) {echo $dated;} ?>"> à <input type="date" name="date2" id="date2" onchange='test()' value="<?php If($datef) {echo $datef;} ?>"><br>

Par Thème : <select name="choixtheme">
<option></option>
<?php

foreach($donnees['tabtheme'] as $itm) {
	$nomtheme = $itm['Nom_theme'];
	$idtheme =$itm['IDtheme'];
	if($them==$nomtheme) {echo "<option value='$idtheme' selected>$nomtheme</option>";} else {echo "<option value='$idtheme'>$nomtheme</option>";}
	
}

?>
</select><br>



Par Editeur : <select name="choixedit">
<option></option>
<?php

foreach($donnees['editeur'] as $itm) {
	$nomedit = $itm['Nom_groupe'];
	$idedit =$itm['IDgroupe'];
	if($edit==$nomedit) {echo "<option value='$idedit' selected>$nomedit</option>";} else {echo "<option value='$idedit'>$nomedit</option>";} 
}

?>
</select><br>

Par Collection : <select name="choixsup">
<option></option>
<?php

foreach($donnees['support'] as $itm) {
	$nomsup = $itm['Nom_support'];
	$idsup =$itm['IDsupport'];
	if($sup==$nomsup) {echo "<option value='$idsup' selected>$nomsup</option>";} else {echo "<option value='$idsup'>$nomsup</option>";} 
	
}

?>
</select><br>

<input type="submit"  name="valid_avc" value="Voir" style='float : right;font-size : small;margin-left : 1%;background-color : white;'>
<input type="submit" name ="init_avc" value="Init" style='float : right;font-size : small;margin-left : 1%;background-color : white;'>
</form>
</div>
</div>

<script>
function efface($champ){

if (document.getElementById($champ).style.display == "block")	{	document.getElementById($champ).style.display= 'none';	}
	else {	document.getElementById($champ).style.display= 'block';	}
		
}

function test() {
var datedeb = document.getElementById('date1').value;
var datefin = document.getElementById('date2').value;
if((datefin!='')&& (datedeb!='')){
	if(datedeb>datefin) {document.getElementById('date1').value = datefin;}
} 
if((datefin!='')&&(datedeb=='')) {
	
}
	
}



</script>