<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 25/03/2014 *
 *
 * Modelo adaptado de sesion para el Mto de la web.
 */

require_once('cod/mod/sessionPublica.php');

class SessionAdmtva extends SessionPublica{
	
	private $usuario=null;
	private $operacion = '';
	private $tabla = '';
	private $campo = '';
	private $valor = '';
	private $resultado = '';
//	private $carpeta='';
	private $archivo='';

	public function __construct(){	
	}
	public function inicializa(){
		parent::inicializa();

		/* Declaración de Variables de sesion */
			/*Control de último acceso*/
		if (!isset($_SESSION['ultimoAcceso'])){
			$this->setSession(1);
			$_SESSION['ultimoAcceso'] = date("Y-n-j H:i:s");
				/* Id */
			if (!isset($_SESSION['id'])){
				$_SESSION['id']=0;
			}
			/* Sección*/
			if (!isset($_SESSION['seccion'])){
				$_SESSION['seccion']='';
			}
			if (!isset($_SESSION['vp'])){
				$_SESSION['vp']=0;
			}
/* Control de Filtro por Búsqueda */
			if (!isset($_SESSION['busca'])){
				$_SESSION['busca']='';
			}
			/* Coloca variables propias para el mantenimiento */
				/*Control de Usuario*/
			if (!isset($_SESSION['usuario'])){
				$_SESSION['usuario']=$this->usuario;
			}
			if (!isset($_SESSION['super'])){
				$_SESSION['super']=false;
			}
			/* Carpeta del archivero */
			if (!isset($_SESSION['carpeta'])){
				$_SESSION['carpeta']='';
			}			
			// Actualiza el reloj del último acceso.
		}elseif (!$this->setUltimoAcceso()){
			$this->setSession(-1);
		}		
	}
		// Actualiza el reloj del último acceso.
	private function setUltimoAcceso(){
	    // Calculamos el tiempo transcurrido
	    $accesoActual = date("Y-n-j H:i:s");
	    $tiempoTranscurrido = (strtotime($accesoActual)-strtotime($this->getUltimoAcceso()));
	    //Control del tiempo transcurrido (600 = 5 minutos máximo)
		if($tiempoTranscurrido >= MAX_SESSION) {
			$this->cerrarSession(); // cerrar la sesión
			return false;
	    }else {
		    $_SESSION['ultimoAcceso'] = $accesoActual;
		    return true;
		}
	}
	private function getUltimoAcceso(){
		return $_SESSION['ultimoAcceso'];
	}
	public function vistaPrevia(){
		return $_SESSION['vp'];
	}
	public function setVistaPrevia($vistaPrevia){
		$_SESSION['vp'] = $vistaPrevia;
	}
	
	/* Área de encapsulación de variables de Session */
	
	public function setId($id){
		$_SESSION['id'] = $id;
	}
	public function getId(){
		return $_SESSION['id'];
	}
	public function setSeccion($seccion){
		$_SESSION['seccion'] = $seccion;
	}
	public function getSeccion(){
		return $_SESSION['seccion'];
	}
	public function setCampo($campo){
		$this->campo = $campo;
	}
	public function getCampo(){
		return $this->campo;
	}
	public function setValor($valor){
		$this->valor = $valor;
	}
	public function getValor(){
		return $this->valor;
	}
	public function setResultado($resultado){
		$this->resultado = $resultado;
	}
	public function getResultado(){
		return $this->resultado;
	}
	
	/* Área de encapsulación de variables de Session */
	public function setUsuario($usuario){
		$_SESSION['usuario']=$usuario;
	}
	public function getUsuario($dato){
		return $_SESSION['usuario'][$dato];
	}
	public function setSuper($super){
		$_SESSION['super']=$super;
	}
	public function getSuper(){
		return $_SESSION['super'];
	}
	public function getMantenimiento(){
		return ($this->operacion!='');
	}
	public function getOperacion(){
		return $this->operacion;
	}
	public function setOperacion($operacion){
		$this->operacion = $operacion;
	}
	function setCarpeta($carpeta){
		$_SESSION['carpeta'] = $carpeta;
	}
	function getCarpeta(){
		return $_SESSION['carpeta'];
	}
	function setArchivo($archivo){
		$this->archivo=$archivo;
	}
	function getArchivo(){
		return $this->archivo;
	}
	public function salir(){
		$this->cerrarSession();
		header("Location:login.php");
	}
	protected function archivero(){
		$this->llamada = 'archivero';
	}
	protected function buscaItem(){
		$this->llamada = 'buscaItem';
	}
	protected function estilos(){
		$this->llamada = 'estilos';
	}
	protected function buscador($busca){
		$this->setId(0);
		$this->setResultado('');
		if ($_POST['busca']==''){
			$this->setBusca('');
		}else{
			$this->setBusca($_POST['busca']);
		}
	}
	public function link($seccion='portada',$id=0,$titulo=''){
		$enlace = 'index.php?';
		// Tratamiento de Llamada.
		if(strpos($seccion,'=')===false){
			$enlace.=('ll='.$seccion);
		}else{
			$enlace.= $seccion;
		}
		// Tratamiento de Id.
		if($id!=0) $enlace.= '&amp;id='.$id;
		// Tratamiento de filtro por etiquetas		
		if($this->tag!='') $enlace.=('&amp;tag='.$this->tag);
		// Tratamiento de Vista Privada.
		if($this->vistaPrivada()) $enlace.=('&amp;'.session_name()."=".session_id());
		return $enlace;
	}
}?>