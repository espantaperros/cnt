<?php
/**
 *
 * Desarrollado por Myra
 * 1/08/2014 *
 * 
 * Programa para obligar a la descarga de un fichero.
 * 
 */
 
require_once('cod/lib/arch.php');
$arch = new Arch('/');
$arch->bajaArchivo($_GET['fdown']);
?>