<?php //var_dump($donnees); ?>
<fieldset>
<h4>La cause de votre erreur : <?php echo $donnees['message']; ?></h4>

<form method="POST" name='valid_retour' class="menu">
<input type="hidden" name="<?php echo $donnees['fichier_retour']; ?>">
<input type="submit" name="validation_ret" value='retour'>
</form>
</fieldset>