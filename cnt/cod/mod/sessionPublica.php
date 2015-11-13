<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Modelo de sessión pública.
 */
require_once('cod/lib/ses.php');

class SessionPublica extends Session{
	private $vistaImprimible=false;
	private $uId = 0;
	protected $autor='';
	protected $tag='';
	protected $search='';
	protected $fecha = '';
	protected $pagina=0;
	
	public function __construct(){
//		$this->vistaPrevia = $vistaPrevia; 
	}
	public function inicializa(){
		parent::inicializa();
		/* Declaración de Variables de sesion */
		/**
		 * evitar a toda costa variables de sesion en un entorno pùblico
		 */
	}	
	public function setId($id){
		$this->uId =$id;
	}
	public function getId(){
		return $this->uId;
	}
	public function setVistaImprimible($vistaImprimible){
		$this->vistaImprimible = $vistaImprimible;
	}
	public function getVistaImprimible(){
		return $this->vistaImprimible;
	}
	public function setTag($tag){
		$this->tag=$tag;
	}
	public function getTag(){
		return $this->tag;
	}
	public function setAutor($autor){
		$this->autor=$autor;
	}
	public function getAutor(){
		return $this->autor;
	}
	public function setBusca($search){
		$this->search=$search;
	}
	public function getBusca(){
		return $this->search;
	}
	public function setFecha($fecha){
		$this->fecha=$fecha;
	}
	public function getFecha(){
		return $this->fecha;
	}
	public function setPagina($pagina){
		$this->pagina = $pagina;
	}
	public function getPagina(){
		return $this->pagina;
	}
	/*
	function getExtension(){ // Chapuza
		return "";
	}*/
	/**
	 * 
	 *  Funciones de llamada
	 */
	protected function portada(){
		$this->llamada = 'portada';
		$this->setId(0);
	}
	protected function contacto(){
		$this->llamada = 'contacto';
		$this->setId(0);
	}
	protected function search(){
		$this->llamada = 'search';
		$this->setId(0);
	}
	public function link($seccion=null,$id=0,$titulo=''){
		$enlace = URL_BASE;
		if ($seccion==null){
			$seccion = $this->getLlamada();
		}elseif(strpos($seccion,'a=')!==false){
			$seccion = 'sindicato/'.substr($seccion,2);
		}elseif(strpos($seccion,'tag=')!==false){
			$seccion = 'tag/'.substr($seccion,4);
		}
		$enlace.= $seccion;
		if ($titulo!=''){
			$titulo = trim($titulo);
			$titulo = str_replace("aacute", "a",$titulo);
			$titulo = str_replace("eacute", "e",$titulo);
			$titulo = str_replace("iacute", "i",$titulo);
			$titulo = str_replace("oacute", "a",$titulo);
			$titulo = str_replace("uacute", "u",$titulo);
			$titulo = str_replace("€", "euros",$titulo);
			$titulo = str_replace("$", "dolares",$titulo);
			$titulo = str_replace("?", "",$titulo);
			$titulo = str_replace("&", "",$titulo);
	    	// 	transforma vocales acentuadas, eñes y demás
			$in  = utf8_decode('ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏÐÑÒÓÔÕÖØÙÚÛÜüÝÞßàáâãäåæçèéêëìíîïðñòóôõöøùúûýýþÿŔŕ');
    		$out = utf8_decode('aaaaaaaceeeeiiiidnoooooouuuuuybsaaaaaaaceeeeiiiidnoooooouuuyybyRr');
    		$titulo = utf8_decode($titulo);
    		$titulo = strtr($titulo, $in, $out);
    		$titulo = utf8_encode($titulo);
	    	// elimina el resto de caracteres raros
    	  	$titulo = preg_replace('/[^ A-Za-z0-9]/','', $titulo);
    		// sustituye espacios por guiones
			$titulo = str_replace(" ", "-",$titulo);
	//		$titulo = preg_replace("[ \t\n\r]+", "-", $titulo);
    		// pone en minúsculas
    		$titulo = strtolower($titulo);
    		$enlace.= ("/".$id."-".$titulo.".html");
    		
		}
		return $enlace;
	}		
	private function ahora(){
		return (date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s"));
	}
}?>
