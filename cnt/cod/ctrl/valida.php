<?php
/**
 *
 * Desarrollado por Myra
 * 17/06/2015 *
 *
 * Controlador de inicio de sesión.
 */
require_once('cod/cfg/datos.php');
require_once('cod/lib/sql.php');
require_once('cod/mod/usuario.php');

/* conexión con la base de datos */
$bd = new Sql( $cfg_servidor,$cfg_basedatos, $cfg_usuario, $cfg_password);
if (!$bd->conectar()) {
	echo "Problemas al conectar con la base de datos";
	echo $bd->errNo.': '.$db->error;
}
$login = new Usuario();
$resultado = $login->valida($_POST['user'],$_POST['password'],$_POST['clave']);
if($resultado==1){
	// Abre sesion.
	include_once('cod/mod/sessionAdmtva.php');
	$ses = new SessionAdmtva();
	$ses->abrirSesion();
	$ses->inicializa();
	$ses->setSuper($login->getSuper());
	$ses->setUsuario($login->getCampos());
	$ses->setSeccion('portada');
	// Limpia Tablas.
	$bd->optimiza();
	// Borra Imágenes de carpeta temporal.
	require_once 'cod/lib/arch.php';
	$arch = new Arch();
	$arch->setContenedor('img');
	$files = $arch->relacionaArchivos();
	foreach ($files as $file=>$valor){
		$arch->borraArchivo($file);
	}
	header("Location: index.php");
}else{
	// Error de validación.
	header("Location: login.php?errusu=".$resultado);
}?>