<span id="form_auth">
<p>Authentification</p>
<form method='POST' name='valid_gestion'>
<p>Code d'entrée : <input type='password' name='pass' id='pass'><input type='submit' name='valid_pass' value='ok'></p>

</form>
</span>
<?php
if(isset($_POST['valid_pass'])) {
	$mdp = $_POST['pass'];
	$fix = "47961c8e17506bf08eda0fff9eaeedcd4931a33f";
	if(sha1($mdp)===$fix) {
		require("header.php");
	}
	else
	{
		echo "code invalide !!";
	}
}


?>

<script>
   function loadFocus()
   {
     document.getElementById('pass').focus();
   }
   window.onload = loadFocus;
</script>