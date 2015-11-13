<?php
/**
 *
 * Desarrollado por Myra
 *
 * Modelo abstracto de datos
 */

class Mod{
	// Propiedades básicas comunes.
	protected $id;					// Id del objeto, coincide con el id de la tabla.
	protected $tabla;				// Tabla soporte de persistencia
	protected $campos=Array();		// Colección de objetos Campo
		
	// Búsquedas por texto.
	private $camposBusqueda='';
	protected $clavesBusqueda='';
	
	// Orden de la relación.
	protected   $descendiente = true;
	protected   $order = "id";
	// Variables de límites.
	protected $desde = 0;			// Desde el registro nº...
	protected $cuantos = 0;		// Indica cuántos registros salen en la selección
	
	// Número de registros de una colección.
	protected $totalFilas = 0;
	
	// Variables para la actualización
	private $camposInsert='';
	protected $permitidaGrabacion = false;
	
	// Captura de errores.
	protected  $errNo=0;
	protected $error = '';
	
	public function __construct($id=0,$tabla=''){
		$this->id = $id;
		$this->tabla = $tabla;
		
		$this->preDefine();
		$this->define();
		$this->postDefine();
		
		// Calcula campos de búsqueda.
		$this->camposBusqueda = $this->campos('busqueda');
		$this->camposInsert = $this->campos('insert');
		
		// Carga valores.
		if ($id==0 || !$this->desdeBD($id)){
			$this->carga();
		}
	}
	
	// Funciones de acceso a variables.
	public function getId(){
		return $this->id;
	}
	public function setId($id){
		$this->id = $id;
	}
	public function setOrder($order){
		$this->order = $order;
	}
	public function setDescendiente($descendiente=true){
		$this->descendiente = $descendiente;
	}
	public function setDesde($desde){
		$this->desde = $desde;
	}
	public function getCuantos(){
		return $this->cuantos;
	}
	public function setCuantos($cuantos){
		$this->cuantos = $cuantos;
	}
	public function getTotalFilas(){
		return $this->totalFilas;
	}
	public function setPermitidaGrabacion($permitida=true){
		$this->permitidaGrabacion = $permitida;
	}
	public function getPermitidaGrabacion(){
		return $this->permitidaGrabacion;
	}
	public function addCampoSelect($nombre,$alias,$constante=null){
		$this->campos[$alias] = new Campo($nombre,true,false,false);
		$this->campos[$alias]->setAlias($alias);
		$this->campos[$alias]->setPostSelect(true);
		if($constante!=null){
			$this->campos[$alias]->set($constante);
			$this->campos[$alias]->setConstante(true);
		}
	}
	public function getCampos(){
		$campos = Array();
		foreach ($this->campos as $nombre=>$campo){
			$campos[$nombre]=$campo->get();
		}
		return $campos;
	}
	public function setSelect($campo,$valor=false){
		$this->campos[$campo]->setSelect($valor);
	}
	public function setInsert($campo,$valor=false){
		$this->campos[$campo]->setInsert($valor);
	}
	public function setDefault($campo,$valor){
		$this->campos[$campo]->setDefault($valor);
	}
	public function setBusqueda($campo,$valor=true){
		$this->campos[$campo]->setBusqueda($valor);
	}
	public function setClavesBusqueda($claves){
		$this->clavesBusqueda = $claves;
	}
	public function isBusqueda(){
		return (!empty($this->clavesBusqueda));
	}
	public function getError(){
		return $this->errNo.':'.$this->error;
	}
	
	/** Métodos. */
	// Define campos: usar postDefine para afinar ;->	
	private function define(){
		global $bd;
		$campos = $bd->campos($this->tabla);
		foreach ($campos as $nombre=>$campo){
			$this->campos[$nombre] = new Campo($nombre);
			$this->campos[$nombre]->setPropiedades($campo);
		}
	}
	// Carga uno desde su Id.
	private function desdeBD(){
		global $bd;
		$bd->prepara("SELECT * FROM ".$this->tabla." WHERE id=:id");
		$bd->addParam(':id', $this->id,PDO::PARAM_INT);
		if($bd->ejecuta()){
			$this->preCarga();
			$this->carga($bd->siguiente());
			$this->postCarga();
			return true;
		}
		return false;
	}
	protected function carga($datos=null){
		foreach ($this->campos as $nombre=>$campo){
			if(!$campo->in('constante')) {
				if(isset($datos->$nombre)){
					$campo->set($datos->$nombre);
				}else{
					$campo->set(null);
				}
			}
		}
	}
	
	private function preparaRelacion(){
		global $bd;
		$query = "SELECT ".$this->camposSelect()." FROM  ".$this->from()." WHERE ".$this->condicion()." ORDER BY ".$this->order.($this->descendiente?' DESC':'').$this->limite();
		$bd->prepara($query);
	}
	public function relaciona(){
		global $bd;
		$this->preRelaciona();
		$this->preparaRelacion();
		$this->parametrosRelacion();
		try{
			$bd->ejecuta();
			$this->totalFilas = $bd->getFilasAfectadas();
			return $bd->relaciona();
		}catch (Exception $e){
			$this->errNo = $bd->errNo;
			$this->error = $bd->error;
			return false;
		}
		$this->postRelaciona();
	}
	protected function camposSelect(){
		$camposSelect='';
		foreach ($this->campos as $alias=>$campo){
			$campoSelect = '';
			if ($campo->in('select')){
				if($campo->in('postSelect')){
					$campoSelect.= ($campo->in('constante')?('"'.$campo->get().'"'):($campo->getNombre()));
				}else{
					$campoSelect.= $this->tabla.'.'.$campo->getNombre();
				}
				if($campo->getNombre()!=$campo->getAlias()){
					$campoSelect.= (' AS '.$campo->getAlias());
				}
				$camposSelect.=($campoSelect.',');
			}
		}
		$camposSelect=substr($camposSelect,0,strlen($camposSelect)-1);
		return $camposSelect;
	}
	protected function from(){
		return $this->tabla;
	}
	protected function condicion(){
		if ($this->clavesBusqueda!==''){
			return $this->condicionBusqueda();
		}else{
			$where = 'TRUE';
			$where.= $this->postCondicion();
			return $where;
		}
	}
	private function condicionBusqueda(){
		/*
		 * Se utiliza el operador AND de modo que la búsqueda
		 * se afina con cada palabra que se escribe
		 */
		$claves=explode(" ",$this->clavesBusqueda);
		$campos=explode(",",$this->camposBusqueda);
		$where="  (";
		foreach ($claves as $clave){
			$where.= '(';
			foreach ($campos as $alias){
				$where.= "$alias LIKE '%".$clave."%' OR ";
			}
			$where=substr($where,0,strlen($where)-4);
			$where.= ') AND ';
		}
		$where=substr($where,1,strlen($where)-5);
		$where.=")";
		return $where;
		/*
		 * El siguiente código no funciona en tablas InnoDB
		 * para MyISAM explota el comando MATCH AGAINST
		 */
		//		$busca=trim($this->criteriosBusqueda);
		//		$where="  (";
		//		$criterios=explode(" ",$this->criteriosBusqueda);
		//		if (count($criterios)==1) {
		//			// la búsqueda la hacemos con like.
		//			$claves=explode(",",$this->camposBusqueda);
		//			foreach ($claves as $clave){
		//				$where.= "$clave LIKE '%".$this->criteriosBusqueda."%' OR ";
		//			}
		//			// quita el último or.
		//			$where=substr($where,1,strlen($where)-4);
		//		}else{
		//			// la búsqueda la hacemos con match ... against.
		//			foreach ($criterios as $criterio){
		//				$where.=" MATCH (".$this->camposBusqueda.") AGAINST ('$criterio') AND ";
		//			}
		//			// quita el último or.
		//			$where=substr($where,1,strlen($where)-5);
		//		}
		//		$where.=")";
		//		return $where;
	}
	protected function limite(){
		$limite = '';
		if ($this->cuantos){
		$limite = ' LIMIT '.$this->desde.','.$this->cuantos;
		}
			return $limite;
	}
	private function campos($propiedad,$largo=true){
		$campos = '';
		foreach ($this->campos as $alias=>$campo){
			if($campo->in($propiedad)){
				if ($largo){
					$campos.= $this->tabla.'.';
				}
				$campos.= $campo->getNombre().',';
			}
		}
		$campos = substr($campos,0,strlen($campos)-1);
		return $campos;
	}
	public function primero(){
		$this->desde = 0;
		$this->cuantos = 1;
		return $this->relaciona();
	}
	public function siguiente(){
		$this->desde++;
		$this->cuantos = 1;
		return $this->relaciona();
	}
	public function anterior(){
		$this->desde--;
		$this->cuantos = 1;
		return $this->relaciona();
	}
	public function ultimo(){
		$this->desde = $this->totalFilas()-1;
		$this->cuantos = 1;
		return $this->relaciona();
	}
	public function totalFilas(){
		global $bd;
		$query = "SELECT COUNT(".$this->tabla.".id) as total FROM  ".$this->from()." WHERE ".$this->condicion()." ORDER BY ".$this->order.($this->descendiente?' DESC':'');
		$bd->prepara($query);
		$bd->ejecuta();
		$resultado = $bd->siguiente();
		return $resultado->total;
	}
	// Funciones para la actualizazión.
	public function insert(){
		global $bd;
		$campos = $this->campos('default',false);
		$query="INSERT INTO ".$this->tabla." (".$campos.") VALUES (:".str_replace(',',',:',$campos).");";
		// Prepara la sentencia.
		$bd->prepara($query);
		// Prepara valores por defecto;
		foreach ($this->campos as $nombre=>$campo){
			if($campo->in('default')){
//				echo 'addParam - '.$nombre.'='.$campo->getPropiedad('Default').' ('.$campo->getPropiedad('Type').'->'.$bd->mysqlToPDO($campo->getPropiedad('Type')).'<br>';
				$bd->addParam(':'.$nombre,$campo->getPropiedad('Default'));
			}
		}
		// Envía la sentencia a la base de datos.
		return ($this->ejecuta());
	}

	public function update($id,$campo,$valor){
		// Construye y ejecuta la sentencia SQL.
		global $bd;
		// Validación.
		switch ($campo){
/*			case 'fecha_publicacion':
				if ($valor==''){
					$valor = $this->ahora();
				}
				break;
			case 'embebido':
				$valor= str_replace('¬','&amp;',$valor);*/
		}
		if ($valor==''){
			$valor = null;
		}elseif($this->campos[$campo]->getPropiedad('Type')=='double unsigned'){
		}elseif($campo=='embebido'){
		}else{
			$valor = addslashes($valor);
		}
		$query = "UPDATE ".$this->tabla." SET ".$campo."=:".$campo." WHERE id=:id;";
		// Prepara la sentencia.
		$bd->prepara($query);
		// Prepara valores.
		$bd->addParam(':id', $id,$bd->mysqlToPDO($this->campos[$campo]->getPropiedad('Type')));
		$bd->addParam(':'.$campo, $valor,$bd->mysqlToPDO($this->campos[$campo]->getPropiedad('Type')));
		// Envía la sentencia a la base de datos.
		return ($this->ejecuta());
	}
	public function delete($id){
		if ($id<=0){
			return false;
		}
		global $bd;
		// Prepara la sentencia.
		$query = "DELETE FROM ".$this->tabla." WHERE id=:id;";
		// Prepara la sentencia.
		$bd->prepara($query);
		// Prepara valores.
		$bd->addParam(':id', $id,PDO::PARAM_INT);
		// Envía la sentencia a la base de datos.
		return ($this->ejecuta());
	}
	protected function ejecuta(){
		global $bd;
		$this->errNo= 0;
		try{
			$bd->ejecuta();
			$this->id = $bd->ultimoId();
			$this->campos['id']->set($this->id);
			$this->totalFilas = $bd->getFilasAfectadas();
		}catch (Exception $e){
			$this->errNo = $bd->getErrNo();
			$this->error = $bd->getError();
		}
		return ($this->errNo==0);
	}	
	
	// Métodos para ser sobrecargados.		
	protected function preDefine(){
		return true;
	} 
	protected function postDefine(){ 
		return true;
	}
	protected function preCarga(){
		return true;
	}
	protected function postCarga(){
		return true;
	}
	protected function preRelaciona(){
		return true;
	}
	protected function parametrosRelacion(){
		return true;
	}
	protected function postRelaciona(){
		return true;
	}
	protected function postCondicion(){
		return '';
	}
}

class Campo{
	private $nombre;			// Nombre del campo
	private $valor;				// Valor del campo, si es una colección será un Array de objetos secundarios
	private $propiedades;		// Si es campo, las propiedades de campo de BD; si no nombre del objeto secundario
	private $select=true;		// Si entra en la select
	private $insert=true;
	private $busqueda=false;	// Si entra en condiciones de búsqueda.
	private $alias='';			// Para ser usado como alias en un select
	private $postSelect=false;
	private $constante = false;
	
	public function __construct($nombre,$select=true,$insert=true,$busqueda=false){
		$this->nombre = $nombre;
		$this->select = $select;
		$this->insert = $insert;
		$this->busqueda = $busqueda;
		$this->alias = $nombre;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function get(){
		return $this->valor;
	}
	public function set($valor=null){
		if(!$this->constante){
			if(gettype($valor)!='array' && empty($valor)){
				if($this->in('default')){
					$valor = $this->propiedades['Default'];
				}else{
					$valor = '';
				}
			}
			$this->valor = $valor;
		}
	}
	public function setSelect($select){
		$this->select = $select;
	}
	public function setInsert($insert){
		$this->insert = $insert;
	}
	public function setBusqueda($busqueda=true){
		$this->busqueda = $busqueda;
	}
	public function setDefault($valor){
		$this->propiedades['Default'] = $valor;
	}
	public function setPropiedades($propiedades){
		$this->propiedades = $propiedades;
	}
	public function getPropiedad($propiedad){
		return $this->propiedades[$propiedad];
	}
	public function in($propiedad){
		if ($propiedad=='default'){
			return (!empty($this->propiedades['Default']));
		}
		return $this->$propiedad;
	}
	public function setAlias($alias){
		$this->alias = $alias;
	}
	public function getAlias(){
		return $this->alias;
	}
	public function setPostSelect($postSelect=true){
		$this->postSelect = $postSelect;
	}
	public function setConstante($constante=true){
		$this->constante = $constante;
	}
}?>