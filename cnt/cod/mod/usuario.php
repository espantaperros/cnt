<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Modelo de la clase Usuario
 */

require_once('cod/lib/mod.php');

class Usuario extends Mod{
	
	// Método constructor.
	public function __construct($id=0){
		// Apela al método constructor del padre.
		parent::__construct($id,'usuarios');
		// Modifica propiedades de la relación.
		$this->setOrder('usuario');
	}
	// Métodos de acceso a variables.
	function getNombre(){
		return $this->campos['nombre']->get();
	}
	function getEmail(){
		return $this->campos['email']->get();
	}
	function getSuper(){
		return $this->campos['super']->get();
	}
	function postDefine(){
		$this->setInsert('id',false);
		$this->setDefault('usuario','nuevo');
		$this->setDefault('password',DEFAULT_PASSWORD);
		$this->setDefault('nombre',' nuevo usuario');
		$this->setDefault('super','0');
		$this->setDefault('bloqueado','0');
		$this->setBusqueda('nombre');		
	}
	public function valida($usuario,$cifrado,$numero){
		if ($usuario=='') return 0;		
		$this->traeUsuario($usuario);
		$password = $this->campos['password']->get();
		if ($password=='') return 0;
		// Bloqueo de acceso permanente;
		$bloqueado = ($this->campos['bloqueado']->get()==''?0:$this->campos['bloqueado']->get());
		if ($bloqueado==1) return 0;
		// Bloqueo de acceso temporal
		$ultimoAcceso = strtotime($this->campos['ultimo_acceso']->get())+(24*60*60);
		if ($bloqueado-1<=(-MAX_LOGIN) && time()<$ultimoAcceso ) return ($ultimoAcceso);
		// Procesa
		$serverpassword = strtolower(md5(strtolower($password).$numero));
		$clientpassword = strtolower($cifrado);
		$id = $this->campos['id']->get();
		if ($serverpassword==$clientpassword){
			$this->update($id,'bloqueado',0);
			$this->update($id,'ultimo_acceso',$this->ahora());
			$this->update($id,'origen','INET_ATON('.$this->getIP().')');
			$this->campos['id']->set($id);
			return 1;
		}else{
			$intentos = ($bloqueado<=(-MAX_LOGIN)?-1:$bloqueado-1);
			$this->update($id,'bloqueado',$intentos);
			$this->update($id,'ultimo_acceso',$this->ahora());
			$this->update($id,'origen','INET_ATON("'.$this->getIP().'")');
			return ($intentos);
		}
	}
	private function traeUsuario($usuario){
		global $bd;
		$bd->prepara("SELECT * FROM ".$this->tabla." WHERE usuario=:usuario");
		$bd->addParam(':usuario', $usuario,PDO::PARAM_STR,20);
		if($bd->ejecuta()){
			$this->preCarga();
			$this->carga($bd->siguiente());
			$this->postCarga();
			return true;
		}
		return false;
	}
	private function ahora(){
		return (date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s"));
	}
	private function getIP(){
		if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
			$ip = getenv("HTTP_CLIENT_IP");
		}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
			$ip = getenv("HTTP_X_FORWARDED_FOR");
		}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
			$ip = getenv("REMOTE_ADDR");
		}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
			$ip = $_SERVER['REMOTE_ADDR'];
		}else{
			$ip = "unknown";
		}
	   return $ip;
	}
}?>