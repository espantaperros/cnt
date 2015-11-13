<?php
/**
 *
 * Desarrollado por Myra
 * 1/08/2014 *
 *
 * Controlador para el mantenimiento del archivo.
 */
require_once('cod/lib/arch.php');
if($ses->getLlamada()=='files'){
	$ses->setCarpeta($_POST['folder']);
}
$arch = new Arch($ses->getCarpeta());
// Operaciones sobre archivos.
switch ($ses->getLlamada()){
	case 'renFile':
		$arch->renombraArchivo($ses->getArchivo(), $_POST['newName']);
		break;
	case 'delFile':
		$arch->borraArchivo($ses->getArchivo());
		break;
}?>