<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Contacto
 */
// Zona derecha.
//require_once('cod/mqt/mqtDerecha.php');?>
<div id="zona_izquierda">
 	<div id="formulario_contacto"> 
 		<h1>Formulario de contacto</h1>
 		<?php 		
		require_once('cod/ctrl/envia.php');?>
		<div id="error_contacta"><?=$txtError?></div>
		<form method="POST" action="<?=URL_BASE?>/index.php?ll=contacto" name="contacto" accept-charset="UTF-8">
			<input type="hidden" name="formulario" value="consulta" />
		 	<label for="nombre">Nombre:</label><input type="text" maxlength="200" name="nombre" value="<?=$error?$_POST['nombre']:''?>"<?=isset($camposErroneos['nombre'])?' class="error_campo"':''?> /><br/>
		 	<label for="email">Email:</label><input type="text" maxlength="60" name="email" value="<?=$error?$_POST['email']:''?>"<?=isset($camposErroneos['email'])?' class="error_campo"':''?> /><br/>
		 	<label for="asunto">Asunto:</label><input type="text" name="asunto" value="<?=$error?$_POST['asunto']:''?>"<?=isset($camposErroneos['asunto'])?' class="error_campo"':''?> /><br/>
		 	<label for="mensaje">Mensaje:</label>
		 	<textarea rows="10" name="mensaje"<?=isset($camposErroneos['mensaje'])?' class="error_campo"':''?>><?=$error?$_POST['mensaje']:''?></textarea>
		 	<img src="cod/lib/captcha/securimageShow.php" alt="código antispam" title="código antispam" class="captcha"/>
		 	<label for="imagetext" class="copia"> Copia de la imágen el código</label>
		 	<input type="text" size="5" maxlength="5" name="imagetext"  class="captcha<?=isset($camposErroneos['imagetext'])?' error_campo"':''?>"/>
		 	<input type="submit" value="enviar" name="enviar" class="boton"/>
		</form>
 	</div>
 	<?php 
 	$ctrlIzq = 1;
 	$vista->pintaZona(3)?>
</div>