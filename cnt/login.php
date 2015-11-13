<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 *
 * Página de acceso al mantenimiento de la web de Las 3 jotas
 * 
 */
require_once 'cod/cfg/constantes.php';
 // Procesa el login
if (isset($_POST['clave'])){
	require_once('cod/ctrl/valida.php');
}else{?>
	<!DOCTYPE html>
	<html>
	<head>
		<meta charset="UTF-8">
		<title>CNT Extremadura - Zona privada</title>
		<meta name="robots" content="noindex,nofollow"/>
		<link rel="STYLESHEET" type="text/css" href="cod/img/mto/login.css"/>
		<script type="text/javascript" src="cod/lib/js/encripta.js"></script>
		<script type="text/javascript">
		function iniFocus(){
			document.forms["login"].elements["user"].focus();
			document.forms["login"].elements["user"].select();
		}
		</script>
	</head>
	<body onload="iniFocus()">
		<div id="principal">
			<a href="<?=URL_BASE?>">
			<div id="cabecera"></div></a>
			<div id="sobre">
				<a href="mailto:espantaperros@gmail.com" title="servicio técnico" border="0" alt="servicio técnico"/></a>myra
			</div>
			<div id="titulo">
				<?
				$blq = false;
				if (isset($_GET['errusu'])){
					if ($_GET['errusu']==0){?>
						login incorrecto
					<?php 
					}elseif ($_GET['errusu']<0){?>
						login incorrecto, quedan <?=MAX_LOGIN-($_GET['errusu']*-1)?> intentos
					<?
					}else{
						$blq = true;?>
						cuenta de usuario bloqueada
					<?php 
					}					
				}elseif(isset($_GET['sesion']) and $_GET['sesion']=='no'){?>
					la sesión ha caducado
				<?
				}else{?>
				iniciar sesión
				<?
				}?>
			</div>
			<div id="login">
				<?php
				if($blq<0){?>
				tiene bloqueado el acceso hasta el <?=date("d/m/Y H:i:s",$_GET['errusu'])?>
				<?php 
				}?>
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
		</div>
	</body>
	</html>
<?
}?>