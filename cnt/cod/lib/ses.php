<?php
/**
 *
 * Desarrollado por RkR
 *
 * Modelo para centralizar todo el manejo de la sesión aquí.
 */

require_once('cod/cfg/constantes.php');
class Session{
	/* Valor de la llamada a bloque */
	private $llamada = 'portada';
	private $ajax = false;
	private $session = 0;
	
	/*Define y abre espacio de sesion */
	public function __construct(){
	}
	public function abrirSesion(){
		session_cache_limiter('nocache,private');
		session_name(SESSION_ID);
		session_start();
		/* Indica el estado de la sesion.-
		 * 0  --> Vista Pública
		 * 1  --> Vista Privada
		 *-1  --> Login caducado
		 *    --> Login		 */
		if (!isset($_SESSION['session'])){
			$_SESSION['session']=$this->session;
		}
	}
	protected function setSession($session){
		$this->session = $session;
		$_SESSION['session'] = $this->session;
	}
		/* Cerrar la sesión */
	public function cerrarSession(){
		session_unset();	// Elimina variables de sesion.
		session_destroy();
	}
	protected function inicializa(){
	}
	public function vistaPublica(){
		return ($_SESSION['session']==0);
	}
	public function vistaPrivada(){
		return ($_SESSION['session']==1);
	}
	public function vistaPrevia(){
		return false;
	}
	public function sesionCaducada(){
		return ($_SESSION['session']==-1);
	}
	public function getLlamada(){
		return $this->llamada;
	}
	public function setLlamada($llamada){
		$this->llamada = $llamada;
	}
	public function setAjax($ajax){
		$this->ajax = $ajax;
	}
	public function getAjax(){
		return $this->ajax;
	}

		/* Enlaces en la session */
			/* Dentro de la etiqueta a href */
	public function link(){
	}
		/* Función genérica de llamada a bloques
		 * hace que el resto de los métodos sean privados */
	public function llama($llamada=""){
		$this->llamada = $llamada;
		if (method_exists($this,$llamada)){
			call_user_func(array($this, $llamada));
		}
	}
}