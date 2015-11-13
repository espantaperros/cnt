<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 */
require_once('cod/lib/mod.php');
class Evento extends Mod{
	function __construct($id=0){
		parent::__construct($id,'contenidos_eventos');
		$this->setOrder('fecha_inicio');
		$this->setDescendiente(false);
	}
	public function relaciona(){
		global $bd;
		$query = "select ef.*,contenidos_eventos.*,'70' as id_bloque from  
			(select contenidos.id as contenido_id,contenidos.titulo as contenido_titulo,min(fecha_inicio) as fecha from contenidos inner join 
			(select * from contenidos_eventos where fecha_inicio>=:fecha_inicio) as e on e.id_contenido=contenidos.id 
			group by contenidos.id) as ef inner join contenidos_eventos on ef.contenido_id=contenidos_eventos.id_contenido order by fecha,contenido_id,fecha_inicio";
		$bd->prepara($query);
		$bd->addParam(':fecha_inicio', $this->ahora());
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
	private function ahora(){
		return (date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s"));
	}
}?>
