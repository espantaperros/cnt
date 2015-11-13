<?php
/**
 *
 * Desarrollado por Myra
 * 14/06/2015
 * 
 * Modelo de contenidos web.
 */
require_once('cod/lib/mod.php');
require_once('cod/mod/vinculada.php');

class Cont extends Mod{
	private $selPublicado = false;	// Selección por campo publicado
	private $selVigente = false;	// Selección por vigencia
	private $estilos = '';
	private $autor = '';
	private $tag = '';
	private $fecha = '';
	private $vinculadas = Array();
	
	public function __construct($id=0){
		parent::__construct($id,'contenidos');
	}
	function postDefine(){
		global $vista,$ses;
		// Definición de campos.
		if ($ses->vistaPrivada()){
			$this->setInsert('id',false);
			$this->setInsert('publicado',false);
			$this->setInsert('visitas',false);
			$this->setDefault('titulo','T&iacute;tulo del contenido');
			$this->setDefault('descripcion','Escriba aqu&iacute; una descripci&oacute;n breve del contenido');
			$this->setDefault('fecha_publicacion',$ses->getFecha());
			$this->setDefault('autor',$ses->getUsuario('usuario'));
		}
		// Definición de vínculos.
		$this->addVinculada('estilos');
		$this->addVinculada('desarrollos');
		$this->addVinculada('fotos');
		$this->addVinculada('documentos');
		$this->addVinculada('enlaces');
		$this->addVinculada('eventos');
		$this->addVinculada('etiquetas');
		$this->addVinculada('relacionados');
		// Propiedades propias.
		$this->setBusqueda('titulo');
		$this->setBusqueda('descripcion');
		$this->setOrder('fecha_publicacion');
		if(isset($vista))	$this->setEstilos($vista->getIdBloques());
		$this->setCuantos(NUM_ARTICULOS);
	}
	function preRelaciona(){
		if($this->isBusqueda()||$this->tag!=''){
			$this->addCampoSelect('','id_bloque',90);			
		}else{
			$this->addCampoSelect('contenidos_estilos.id','idEstilo');
			$this->addCampoSelect('contenidos_estilos.id_bloque','id_bloque');
		}
	}
	function parametrosRelacion(){
		global $bd;
		if($this->fecha!=''){
			$bd->addParam(':fecha',$this->fecha,PDO::PARAM_STR);
		}
		if ($this->autor!=''){
			$bd->addParam(':autor',$this->autor,PDO::PARAM_STR);
		}
		if ($this->tag!=''){
			$bd->addParam(':tag',''.$this->tag,PDO::PARAM_STR);
		}		
	}
	function postCarga(){
		// Tratamiento de tablas vinculadas.
		foreach ($this->vinculadas as $nombre=>$vinculada){
			$datos = $vinculada->relacion();
			$this->campos[$nombre]->set($datos);
		}
		return true;
	}
	public function setPublicado($selPublicado=true){
		$this->selPublicado = $selPublicado;
	}
	public function setVigente($selVigente=true){
		$this->selVigente = $selVigente;
	}
	public function setEstilos($estilos){
		$this->estilos = $estilos;
	}
	public function setAutor($autor){
		$this->autor = $autor;
	}
	public function setTag($tag){
		$this->tag = $tag;
	}
	public function setFecha($fecha){
		if ($fecha==''){
			$this->fecha = '';
		}else{
			$this->fecha = date("Y-d-m",strtotime($fecha));
		}
	}
	public function addVinculada($nombre){
		$this->vinculadas[$nombre] = new Vinculada($this->tabla.'_'.$nombre,$this->id);
		$this->campos[$nombre] = new Campo($nombre,false,false,false);
	}
	function from(){
		$tablas = 'contenidos';
		if($this->tag!='') $tablas.=' INNER JOIN contenidos_etiquetas ON contenidos.id=contenidos_etiquetas.id_contenido';
		if(!$this->isBusqueda()) $tablas.=' INNER JOIN contenidos_estilos ON contenidos.id=contenidos_estilos.id_contenido';
		return $tablas;
	}
	function postCondicion(){
		$where="";
		if ($this->selPublicado){
			$where.=" AND contenidos.publicado='1'";
		}
		if($this->fecha!=''){
			$where.= " AND (fecha_publicacion<=:fecha) AND (fecha_caducidad is null or fecha_caducidad>=:fecha)";
		}elseif ($this->selVigente){
			$where.= " AND (contenidos.fecha_publicacion<CURRENT_TIMESTAMP()) AND (contenidos.fecha_caducidad is null or contenidos.fecha_caducidad>CURRENT_TIMESTAMP())";
		}
		if ($this->autor!=''){
			$where.= " AND contenidos.autor=:autor";
		}
		if (!$this->isBusqueda() && !empty($this->estilos)){
			$where.= " AND contenidos_estilos.id_bloque IN ($this->estilos)";
		}
		if ($this->tag!=''){
			$where.= " AND contenidos_etiquetas.nombre=:tag";
		}
		return $where;
	}
	public function visita($id){
		$this->update($id,'visitas','visitas+1');
	}		
}