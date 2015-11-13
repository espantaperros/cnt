<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Modelo Estilos de Contenidos.
 */
require_once('cod/lib/modelo.php');
class Estilo extends Modelo{
	var $idContenido = 0;
	function Estilo($id=0){
		$this->Modelo($id,'contenidos_estilos');
		$this->cuantos = 0;
	}
	function setIdContenido($idContenido){
		$this->idContenido = $idContenido;
	}
	function postCondicion(){
		$where = " AND id_contenido='".$this->idContenido."'";
		return $where;
	}
	function insertaEstilo($id_contenido,$id_bloque){
		$this->cargaCampos(Array('id'=>0,'id_contenido'=>$id_contenido,'id_bloque'=>$id_bloque));
		return $this->SQL_Insert();
	}
	function borraDeContenido($id_contenido){
		global $bd;
		$query = "DELETE FROM contenidos_estilos WHERE id_contenido='".$id_contenido."';";
//echo $query;
		// Envía la sentencia a la base de datos.
		if ($bd->query($query,true)){
			$this->id = $bd->ultimoId();
		}
		return ($bd->errNo==0);
	}
}?>