
<form method='POST' name='formulaire_timeline' class='menu'>
Choix d'un thème : <select name='choix_theme_time' id='choix_theme_time' onChange="affiche_time('theme')">
<option></option>
<?php
foreach($_POST['theme'][0] as $itmth) {
		echo "<option value='".$itmth['IDtheme']."'>".$itmth['Nom_theme']."</option>";
	}
?>
</select>

Choix d'un terme : <input type="text" id='choix_mot_time' name='choix_mot_time' onFocus="affiche_time('mot')"> <input type="submit" name="valid_time" value="ok">
</form>
<hr>


<script>
function affiche_time(panneau) {
	
	if(panneau=='theme') {
		document.getElementById('choix_mot_time').value = '';
		document.getElementById('choix_mot_time').required = false;
	}
	else if (panneau=='mot') {
		document.getElementById('choix_theme_time').value = '';
		document.getElementById('choix_mot_time').required = true;
	}
}

</script>