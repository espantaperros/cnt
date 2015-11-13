<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Controlador para la búsqueda de elementos interactivo y paso de datos.
 *  
 *  */
if (isset($_GET['etiqueta'])){
	require_once('cod/mod/etiqueta.php');
	$obj = new Etiqueta();
	$obj->setClavesBusqueda($_GET['etiqueta']);
}else if (isset($_GET['relacion'])){
	require_once('cod/mod/cont.php');
	$obj = new Cont();
	$obj->setCuantos(0);
	$obj->setClavesBusqueda($_GET['relacion']);
}else if (isset($_GET['usuario'])){
	require_once('cod/mod/usuario.php');
	$obj = new Usuario();
	$obj->setClavesBusqueda($_GET['usuario']);
}
$resultado = $obj->relaciona();?>