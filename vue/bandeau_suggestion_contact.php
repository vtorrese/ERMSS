 <div id="suggestion">

 		<div class="panel panel-default">
			<div class="panel-heading" style="color : #6f8e6f; font-weight : bold;">Contactez-nous</div>
				<div class="panel-body">
					<form id="contact" method="POST" class="menu">
							<fieldset>
							<div style='display : inline-block;float : left;width : 30%;padding : 1%'>
							<legend style="font-size : medium;">Vos coordonnées</legend>
								<p><label for="nom" style="font-size : small;">Nom : </label><input type="text" id="nom" name="nom" tabindex="1" onFocus="javascript:this.value=''"  /></p>
								<p><label for="email" style="font-size : small;">Email : </label><input type="text" id="email" name="email" tabindex="2" /></p>
								</div>
								<div style='float : left;width : 30%;padding : 1%'>
							<legend style="font-size : medium;">Votre message : </legend>
								<p><label for="objet" style="font-size : small;">Objet : </label><input type="text" id="objet" name="objet" tabindex="3" /></p>
								<p><label for="message"style="font-size : small;">Message : </label><textarea id="message" name="message" tabindex="4" cols="auto" rows="2"></textarea></p>
								</div>
								<div style="text-align:center; font-size : small;"><input type="submit" name="envoimail" value="Envoyer votre message !" /></div>
							<?php 
								if($donnees['message']!=null) {
									echo "<div style='float : left;width : 30%'>";
									echo $donnees['message'];
									echo "</div>";
								}
							?>
							
						
						</fieldset>
					</form>
				</div>
		</div>
</div>