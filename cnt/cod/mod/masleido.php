<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Modelo Contenido Más Leído
 */
require_once('cod/lib/mod.php');

class MasLeido extends Mod{
	
	function __construct($id=0){
		parent::__construct($id,'contenidos');
		$this->setOrder('contenidos.visitas');
		$this->setCuantos(5);
	}
	function postDefine(){
		$this->addCampoSelect('id','id_bloque',80);
		
	}
}