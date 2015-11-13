<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Formulario para la actualización de usuarios
 * */
global $ses;
?>
<form id="form_perfil" method="post" data-edit="0">
	<input type="hidden" name="display" id="user_display" value="<?=$ses->getOperacion()==65?'si':'no'?>"/>
	<input type="hidden" name="op" value="65"/>
	<input type="hidden" name="id_usuario" id="user_id" value="<?=$ses->getUsuario('id')?>"/>
	<a href="javascript:editaUsuario()" id="editUsuario" title="editar Usuario"></a>
	<?php 
	if($ses->getUsuario('super')==1){?>
		<a href="javascript:eliminaUsuario()" id="delUsuario" title="eliminar Usuario"></a>
		<a href="javascript:insertaUsuario()" id="newUsuario" title="añadir Usuario"></a>
	<?php 
	}?>
	<h2>Ficha de usuario</h2>			
 	<hr>
 	<div class="lista">
		<?php
		if ($ses->getUsuario('super')==1){?>
		<input type="search" maxlength="20" name="busqueda" id="user_busqueda" maxsize="20" autocomplete="off" autofocus/>
		<div id="user_lista"></div>
		<?php				
		}?>
 	</div>
 	<div class="ficha1">
 	<label for="usuario">Usuario:</label><input type="text" maxlength="20" name="usuario" id="user_usuario" value="<?=$ses->getUsuario('usuario')?>" readonly/>
 	<label for="nombre">Nombre:</label><input type="text" maxlength="200" name="nombre" id="user_nombre" value="<?=$ses->getUsuario('nombre')?>" readonly/>
 	<label for="password">Contraseña:</label><input type="password" maxlength="12" name="password" id="user_password" value="<?=$ses->getUsuario('password')?>" readonly/>
 	<label for="repassword">Repita:</label><input type="password" maxlength="12" name="repassword" value="" readonly/>
	<?php
	if ($ses->getUsuario('super')==1){?>
 		<hr>
 		<label for="super">Admin:</label><input type="checkbox" name="super" id="user_super" <?=$ses->getUsuario('super')=='1'?'checked':''?> disabled>
 		<hr>
 		<label for="bloqueado">Bloqueado:</label><input type="checkbox" name="bloqueado" id="user_bloqueado" <?=$ses->getUsuario('bloqueado')=='1'?'checked':''?> disabled>
 		<?php 
	}?>
 	<hr>
 	<label for="email">E-mail:</label><input type="email" maxlength="60" name="email" id="user_email" value="<?=$ses->getUsuario('email')?>" readonly/>
 	<hr>
 	<input type="submit" value="Guardar" name="enviar" class="submit" id="user_enviar"/>
 	</div>
 	
</form>
