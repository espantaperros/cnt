<?php
/**
 * Desarrollado por Myra
 * 10/6/2015
 *
 * Librería para el manejo de la base de datos.
 */

class Sql {

	/* Propiedades de la Conexión */
		private $baseDatos;
		private $servidor;
		private $usuario;
		private $clave;

	/* Identificador de conexión */
		private $idPDO = null;

	/* Propiedades de errores: número y descripción */
		private $errNo = 0;
		private $error = "";

	/* Propiedades para la ejecución y control de la consulta */
		private $query = null;
		private $parametros = Array();
		private $filasAfectadas = 0;
		private $ultimoId = -1;


	/* Método Constructor: */
	public function __construct($host,$bd,$user,$pass) {
		$this->servidor = $host;
		$this->baseDatos = $bd;
		$this->usuario = $user;
		$this->clave = $pass;
	}

	public function getErrNo(){
		return $this->errNo;
	}
	public function getError(){
		return $this->error;
	}
	public function getFilasAfectadas(){
		return $this->filasAfectadas;
	}

	/*Conexión a la base de datos*/
	public function conectar(){
		// Conectamos al servidor
		try {
			$this->idPDO = new PDO('mysql:host='.$this->servidor.';dbname='.$this->baseDatos, $this->usuario, $this->clave);
		} catch (PDOException $e) {
			$this->errNo = $e->getCode();
			$this->error = $e->getMessage();
			return false;
		}
		$this->idPDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
		return true;
	}

	public function desconectar(){
		$this->idPDO = null;
	}

	public function iniciaTransaccion(){
		try {
			$this->idPDO->beginTransaction();
		}catch (PDOException $e) {
			$this->errNo = $e->getCode();
			$this->error = $e->getMessage();
			return false;
		}
		return true;
	}

	public function commit(){
		$this->idPDO->commit();
	}

	public function rollback(){
		$this->idPDO->rollBack();
	}

	/** Funcion Querys **/
	public function limpia(){
		$this->query = null;
		$this->parametros = Array();
		$this->filasAfectadas = 0;
		$this->ultimoId = -1;
	}
	public function prepara($sql){
		$this->query = $this->idPDO->prepare($sql);
//echo '###'.$sql.'<br>';
		$this->parametros = Array();
	}
	public function addParam($nombre,$valor,$tipo=PDO::PARAM_STR,$longitud=null){
		if($longitud==null){
			switch ($tipo){
				case PDO::PARAM_BOOL:
					$longitud=1;
					break;
				case PDO::PARAM_INT:
					$longitud=8;
					break;
				case PDO::PARAM_STR:
					$longitud=30;
					break;
				case PDO::PARAM_LOB:
				default:
					$logintud=null;
			}
		}
		$this->parametros[$nombre] = new Parametro($nombre,$valor,$tipo,$longitud);
	}
	public function ejecuta(){
		try{
			foreach($this->parametros as $nombre=>$parametro){
				$this->query->bindParam($nombre,$parametro->getValor(),$parametro->getTipo(),$parametro->getLongitud());
			}
			$this->query->execute();
//echo '###'.$this->query->debugDumpParams().'<br>';
		} catch (PDOException $e){
			$this->errNo = $e->getCode();
			$this->error = $e->getMessage();
			return false;
		}
		$this->filasAfectadas = $this->query->rowCount();
		return true;
	}
	
	/** Funciones de utilidad **/
	public function query($sql){
		$this->filasAfectadas = -1;
		// Ejecuta la consulta y comprueba su validez.
		$this->prepara($sql);
		return ($this->ejecuta());
	}
	public function optimiza(){
		$resultado = true;
		$tablas = array();
		$query = 'SHOW TABLES;';
		
		if (!$this->query($query) and $this->errNo!=0) {
			echo "Problemas al optimizar. Error nº.".$this->errNo.": ".$this->error;
			$resultado=false;
		}elseif ($this->filasAfectadas>0){
			// Carga ids para no desvirtuar la consulta.
			while ($row = $this->siguiente()){
				$tablas[] = $row;
			}
			// Optimiza cada tabla recogida anteriormente.
			foreach ($tablas as $tabla){			
				$query = 'OPTIMIZE TABLE '.$tabla->Tables_in_extremadura.';';
				if (!$this->query($query) and $this->errNo!=0) {
					echo "Problemas al optimizar la tabla.".$tabla->Tables_in_extremadura.". Error nº.".$this->errNo.": ".$this->error;
					$resultado=false;
				}
			}
		}else{
			$resultado=false;
		}
		return $resultado;		
	}
	public function campos($tabla){
		$campos = false;
		$query = "DESCRIBE ".$tabla;
		$resultado = array();
		// Envía la sentencia a la base de datos.
		if (!$this->query($query) and $this->errNo!=0) {
			echo "Problemas al acceder a ".$tabla.": Error nº.".$this->errNo.": ".$this->error;
			$resultado=false;
		}elseif ($this->filasAfectadas>0){
			$primer=true;
			// Carga ids para no desvirtuar la consulta.
			$campos=Array();
			while ($row = $this->query->fetch(PDO::FETCH_BOTH)){
				$campos[$row['Field']]=$row;
			}
		}
		return $campos;
	}

	public function ultimoId(){
		$this->ultimoId = $this->idPDO->lastInsertId();
		return $this->ultimoId;
	}

	/* Número de campos de una consulta */
	public function numCampos() {
		return $this->query->columnCount();
	}

	/* Número de registros de una consulta */
	public function numRegistros(){
		return $this->filasAfectadas;
	}

	/* Devuelve el nombre de un campo de una consulta */
	public function nombreCampo($numcampo) {
		$meta = $this->query->getColumnMeta($numcampo);
		$resultado = false;
		if ($meta !==false){
			$resultado = $meta['name'];
		}
		return $resultado;
	}

	public function siguiente(){
		if ($this->filasAfectadas==0) {
			return false;
		}
		return ($this->query->fetch(PDO::FETCH_OBJ)); // FETCH_BOTH
	}
	public function relaciona(){
		$relacion = $this->query->fetchAll();
		if ($this->filasAfectadas==0) {
			return array();
		}else{
			return $relacion;
		}
	}
	public function mysqlToPDO($tipoMySql){
		$tipoPDO = 0;
		switch ($tipoMySql){
			case 'double':
			case 'tinyint':
				$tipoPDO = PDO::PARAM_INT;
				break;
			case 'varchar':
			case 'text':
			case 'tinytext':
			case 'timestamp':
			case 'datetime':
				$tipoPDO = PDO::PARAM_STR;
				break;
			default:
				$tipoPDO = PDO::PARAM_STR;
		}
		return $tipoPDO;
	}
}
class Parametro{
	private $nombre;
	private $valor;
	private $tipo;
	private $longitud;
	public function __construct($nombre,$valor,$tipo=PDO::PARAM_STR,$longitud=null){
		$this->nombre = $nombre;
		$this->valor = $valor;
		$this->tipo = $tipo;
		$this->longitud = $longitud;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getValor(){
		return $this->valor;
	}
	public function getTipo(){
		return $this->tipo;
	}
	public function getLongitud(){
		return $this->longitud;
	}
}?>