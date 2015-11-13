<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 */

require_once('cod/lib/mod.php');

class Vinculada extends Mod{
	private $idContenido=0;

	public function __construct($tabla,$idContenido=0){
		parent::__construct(0,$tabla);
		$this->idContenido = $idContenido;
	}
	function postCondicion(){
		$where = ' AND '.$this->tabla.'.id_contenido=:idContenido';
		return $where;
	}
	public function inserta($datos){
		$datos['id_contenido'] = $this->idContenido;
		foreach ($this->campos as $nombre=>$campo){
			if(isset($datos[$nombre])) $campo->setDefault($datos[$nombre]);
		}
		return $this->insert();
	}
	public function borraIdContenido($idContenido=0){
		global $bd;
		// Prepara la sentencia.
		$query = "DELETE FROM ".$this->tabla." WHERE id_contenido=:idContenido;";
		// Prepara la sentencia.
		$bd->prepara($query);
		// Prepara valores.
		$bd->addParam(':idContenido',$this->idContenido,PDO::PARAM_INT);
		// Envía la sentencia a la base de datos.
		return ($this->ejecuta());
	}
	function parametrosRelacion(){
		global $bd;
		$bd->addParam(':idContenido',$this->idContenido,PDO::PARAM_INT);
	}
	public function relacion(){
		return $this->relaciona();
	}
}?>