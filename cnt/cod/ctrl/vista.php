<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Controlador de vistas
 *
 * */

require_once('cod/lib/vis.php');

// Calcula el medio.
$medio = new Medio();
if($ses->getVistaImprimible()){
	$medio->setId(2);
	$medio->setNombre('print');	
}elseif($medio->esMovil()){
	$medio->setId(1);
	$medio->setNombre('handheld');
}else{
	$medio->setId(0);
	$medio->setNombre('screen');
}

// Sección.
if($ses->getId()==0){
	switch($ses->getLlamada()){
		case 'portada':
			$seccion = new Seccion(0,'portada');
			break;
		case 'contacto':
			$seccion = new Seccion(1,'contacto');
			break;
		case 'search':
			$seccion = new Seccion(2,'search');
			break;
		default:
			$seccion = new Seccion(0,'portada');
	}
}else{
	$seccion = new Seccion(3,'desarrollo');
}

/**
 * Diseño de Vistas (localización de zonas)
 * según un medio y una sección determinada
 */
$vista = new Vista($medio,$seccion,'CNT Extremadura');
$vista->addMeta("author","CR CNT Extremadura");
$vista->addMeta("description","CNT Extremadura - Federación de Sindicatos Anarcosindicalistas adheridos a la CNT en Extremadura");
$vista->addMeta("keywords","CNT Extremadura- Federación de Sindicatos Anarcosindicalistas adheridos a la CNT en Extremadura");
$vista->addCSS("html5reset.css");
switch ($medio->getNombre()){
	case 'screen':
		$vista->addCSS("myra.css");
		$vista->addJavaScript("inicio.js");
		break;
	case 'handheld':
		$vista->addCSS("myra_movil.css");
		$vista->addJavaScript("inicio_movil.js");
		break;
}
// Diseño de Zonas 
$vista->addZona(0,'cabecera','contenido',false);
$vista->addZona(2,'derecha','contenido');
$vista->addZona(6,'agenda','agenda',false);
$vista->addZona(7,'masleido','masleido');
switch ($seccion->getNombre()){
	case 'portada':
		$vista->addZona(1,'triple','contenido',false);
		$vista->addZona(3,'doble','contenido',false);
		$vista->addZona(4,'izquierda','contenido');
		$vista->addZona(5,'central','contenido');
		break;
	case 'contacto':
		$vista->addZona(3,'doble','contenido');
		break;
	case 'search':
		$vista->addZona(3,'doble','search');
		break;
	case 'desarrollo':
		$vista->addCSS("desarrollo.css");
		$vista->addCSS("fundido.css");
		$vista->addJavaScript("jq_fundido.js");
		$vista->addJavaScript("jq_entrelineas.js");
		break;
}
/** Diseño de Bloques de estilo 
$vista->addBloque(id,nombre,zona,paginas,numero,css,javascript,php);*/
$vista->addBloque(10,'anuncio_cabecera',0,1,'','','relCabeceraAnuncio.php');
$vista->addBloque(30,'cderecha',2,5,'triple.css','','relUna.php');
$vista->addBloque(70,'agenda',6,0,'agenda.css','jq_entrelineas.js','relAgenda.php');
$vista->addBloque(80,'masleido',7,0,'','','relMasLeido.php');
switch ($seccion->getNombre()){
	case 'portada':
		$vista->addBloque(20,'triple',1,1,'triple.css','','relMultiple.php');
		$vista->addBloque(40,'doble',3,1,'','','relMultiple.php');
		$vista->addBloque(50,'izquierda',4,5,'','','relUna.php');
		$vista->addBloque(60,'central',5,5,'','','relUna.php');
		break;
	case 'contacto':
		$vista->addBloque(55,'contacto',3,0,'contacto.css','','relContacto.php');
		break;
	case 'search':
		$vista->addBloque(90,'busqueda',3,0,'','','relSearch.php');
		break;
	case 'desarrollo':
		break;
}?>