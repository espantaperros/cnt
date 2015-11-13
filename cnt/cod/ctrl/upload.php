<?php
/**
 *
 * Desarrollado por Myra
 * 1/5/2015 *
 */
require_once('cod/lib/arch.php');
$arch = new Arch($ses->getCarpeta());
if (isset($_FILES['file'])) {
	if (!$arch->subeArchivo($_FILES['file'])){
		echo $arch->txtResultado;
	}	
}?>