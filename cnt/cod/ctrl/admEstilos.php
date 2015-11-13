<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Controlador para la selección de tablas vinculadas a contenidos
 *  
 *  */

// Lee los estilos del contenido.
require_once('cod/mod/vinculada.php');
$obj = new Vinculada('contenidos_estilos',$ses->getId());
$estilosContenido = $obj->relacion();

// Nos llevamos a un array plano los estilos leidos.
$estilosAplicados = Array();
foreach ($estilosContenido as $id=>$estiloContenido){
	$estilosAplicados[] = $estiloContenido['id_bloque'];	
}

// Repasa los estilos
$estiloSelect = Array();
require_once('cod/lib/vis.php');
// Crea vista específica para pintar todos los estilos.
$vistaSelect = new Vista(0, 0, '');
$vistaSelect->addZona(0,'select','select');
$vistaSelect->addBloque(10,'anuncio cabecera',0,0,'','','');
$vistaSelect->addBloque(20,'triple',0,0,'','','');
$vistaSelect->addBloque(40,'doble',0,0,'','','');
$vistaSelect->addBloque(30,'derecha',0,0,'','','');
$vistaSelect->addBloque(50,'izquierda',0,0,'','','');
$vistaSelect->addBloque(60,'central',0,0,'','','');
$vistaSelect->addBloque(55,'contacto',0,0,'','','');

$idBloques = explode(',',$vistaSelect->getIdBloques());
foreach($idBloques as $idEstilo){
	if($idEstilo>60){ 
		break;
	}
	$estilo = $vistaSelect->getBloque($idEstilo);
	$estiloSelect[] = Array('id'=>$idEstilo,'nombre'=>$estilo->getNombre(),'check'=>in_array($idEstilo,$estilosAplicados)?'1':'0');
}