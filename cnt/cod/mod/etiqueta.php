<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 */
require_once('cod/lib/mod.php');
class Etiqueta extends Mod{
	public function __construct($id=0){
		parent::__construct($id,'contenidos_etiquetas');
	}
	function postDefine(){
		$this->setBusqueda('nombre');
		
	}
	function relaciona(){
		global $bd;
		$query = "SELECT DISTINCT nombre FROM contenidos_etiquetas WHERE ".$this->condicion()." ORDER BY nombre";
		$bd->prepara($query);
		try{
			$bd->ejecuta();
			$this->totalFilas = $bd->getFilasAfectadas();
			return $bd->relaciona();
		}catch (Exception $e){
			$this->errNo = $bd->errNo;
			$this->error = $bd->error;
			return false;
		}
	}
}?>