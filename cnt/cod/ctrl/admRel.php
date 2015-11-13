<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * 
 * Controlador para zona pública.
 *
 * */

$dataSources = Array();

require_once("cod/mod/cont.php");
$objContenido = new Cont();
$objContenido->setPublicado($ses->vistaPublica());
$objContenido->setVigente($ses->vistaPublica());
$objContenido->setAutor($ses->getAutor());
$objContenido->setFecha($ses->getFecha());
$objContenido->setCuantos(0);
$dataSources['contenido'] = $objContenido;

// Carga de ficha en Desarrollo
$objDesarrollo = null;
$objSearch = null;

// Agenda.
require_once("cod/mod/evento.php");
$objAgenda = new Evento();
$dataSources['agenda'] = $objAgenda;
// Lo más leido
require_once("cod/mod/masleido.php");
$objMasLeido = new MasLeido();
$dataSources['masleido'] = $objMasLeido;	

if($ses->getId()!=0){
	$objDesarrollo = new Cont($ses->getId());
	extract($objDesarrollo->getCampos());
	$vista->setTitle($vista->getTitle()."-".$titulo);
	$vista->addMeta('author',$autor);
	$vista->addMeta('description',$descripcion);
}else{
	if($ses->getBusca()!=''){
				$objSearch = new Cont();
				$objSearch->setPublicado($ses->vistaPrevia());
				$objSearch->setCuantos(0);
				$objSearch->setClavesBusqueda($ses->getBusca());
				$dataSources['search'] = $objSearch;
	}elseif( $ses->getTag()!=''){
				$objSearch = new Cont();
				$objSearch->setPublicado($ses->vistaPrevia());
				$objSearch->setVigente($ses->vistaPrivada());
				$objSearch->setCuantos(0);
				$objSearch->setTag($ses->getTag());
				$dataSources['search'] = $objSearch;
	}
}

$vista->cargaContenidos($dataSources);

// contador de visitas.
if($ses->vistaPublica() && $ses->getId()!=0){
	$objContenido->visita($ses->getId());
}?>