<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Maquetación de Login a parte privada.
 */
for ($i=1;$i<5;$i++){
	$bloques = $vista->getBloques($i); // Pilla bloques de la zona $i
	if (count($bloques)>0){
		$nombreZona = $vista->getZona($i)->getNombre()?>
		<div id="<?=$nombreZona?>">
		<?php
		foreach($bloques as $nombre=>$bloque){
			if ($nombre!=$nombreZona){?>
			<div class="<?=$nombre?>">
			<?php 
			}
	 		$bloque->mostrarContenidos();
	 		if ($nombre!=$nombreZona){?>		 		
	 		</div>
	 		<?php 
	 		}
 		}?>
		</div>
	<?php
	}
 }?>
<div id=doble>
	<div>
		<div class="sobretitulo">
			<?
			if (isset($_GET['errusu']) and $_GET['errusu']=='si'){?>
				nombre de usuario o contraseña incorrectos
			<?
			}elseif(isset($_GET['sesion']) and $_GET['sesion']=='no'){?>
				la sesión a caducado
			<?
			}else{?>
			iniciar sesión
			<?
			}?>
		</div>				
		<div class="descripcion">
			<form method="post" action="login.php" id="login">
				<input type="hidden" name="clave" value=""/>
				<label for="user">Nombre de usuario:</label>
				<input type="text" size="35" maxlength="50" name="user"/>
				<label for="password">Contraseña:</label>
				<input type="password" size="35" maxlength="50" name="password"/>
				<input type="submit" value="ENTRAR" name="enviar" onclick="enviaMD5(calculaMD5())" class="submit"/>
				<input type="reset" value="BORRAR" name="reset" class="reset"/>
				<br/>
			</form>
		</div>	
		<div class="clear"></div>
	</div>
</div>