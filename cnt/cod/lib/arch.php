<?php
/**
 *
 * Desarrollado por Myra
 * 1/08/2014 *
 */
class Arch {

	// Variables funcionales.
	private $archivos;

	// Variables estructurales.
	private $contenedor = RAIZ;
	private $destino = "";

	// Filtro de archivos por extensión y tamaño.
	private $extensionesPermitidas = array();
	private $tamanoMaximo =  0;
	
	// variables del resultado;
	private $resultado = false;
	private $txtResultado = "ok";

	public function __construct($subCarpeta='') {
		// Deja calculado la carpeta repositorio.
		$this->destino($subCarpeta);
		// Especifica extensiones permitidas.
		$this->setExtensionesPermitidas();
	}
	// acceso a propiedades.
	public function setContenedor($contenedor){
		$this->contenedor = $contenedor;
		$this->destino();
	}
	public function getDestino(){
		return $this->destino;
	}
	public function setDestino($subCarpeta){
		$this->destino = $this->destino($subCarpeta);
	}
	public function subeArchivo($archivo) {
		$this->txtResultado = "Ok";
		$this->resultado = $this->upLoad($archivo);
		return $this->resultado;
	}
	public function bajaArchivo($archivo){
		$this->txtResultado = "Ok";
		$this->resultado = $this->downLoad($archivo);
		return $this->resultado;
	}
	public function borraArchivo($archivo){
		$this->txtResultado = "Ok";
		$this->resultado = $this->delete($archivo);
		return $this->resultado;
	}
	public function renombraArchivo($archivo,$nuevoNombre){
		$this->txtResultado = "Ok";
		$this->resultado = $this->renameFile($archivo,$nuevoNombre);
		return $this->resultado;
	}

	public function mueveArchivo($archivo,$carpetaOrigen){
		$this->txtResultado = "Ok";
		$this->resultado = $this->renameFile($archivo,$carpetaOrigen,true);
		return $this->resultado;
	}
	public function creaCarpeta(){
		$this->txtResultado = "Ok";
		$this->resultado = $this->makeFolder();
		return $this->resultado;
	}
	public function borraCarpeta(){
		$this->txtResultado = "Ok";
		$this->resultado = $this->deleteFolder();
		return $this->resultado;
	}
	public function relacionaCarpetas(){
		// Carga el árbol de carpetas.
		return $this->arbolCarpetas();
	}
	public function arbolCarpetas($subCarpeta=''){
		$carpetaExplorar = $this->raiz().($subCarpeta==''?'':"/".$subCarpeta);
		$dir = opendir($carpetaExplorar);
		$entradas = Array();
		while ($archivo = readdir($dir)){
			if (is_dir($carpetaExplorar."/".$archivo)){
				if ($archivo!="." and $archivo!=".."){
					$carpetaActual = $subCarpeta; //Guarda la ropa.
					$subCarpeta .= "/".$archivo;
					$entradas[$subCarpeta] = $this->arbolCarpetas($subCarpeta);
					$subCarpeta = $carpetaActual; // pa luego vestirse.
				}
			}
		}
		closedir($dir);
		return $entradas;
	}
	public function relacionaArchivos(){
		// Abre directorio.
		$dir = opendir($this->destino);
		// Lee directorio y lo carga en entradas.
		$entradas = Array();
		$nombre='';
		$valor='';
		while ($archivo = readdir($dir)){
			if (!is_dir($this->destino.$archivo) and
				in_array(strtolower($this->extName($archivo)),$this->extensionesPermitidas)){
				$nombre = $archivo;
				$valor = filemtime($this->destino."/".$archivo);
			}
			$entradas[$nombre] = $valor;
		}
		closedir($dir);
		// Ordena por fecha.
		if (count($entradas)!=0){
			arsort ($entradas);
		}
		return $entradas;
	}
	public function relacionaContenido(){
		// Abre directorio.
		$dir = opendir($this->destino);
		// Lee directorio y lo carga en entradas.
		$entradas = Array();
		while ($archivo = readdir($dir)){
			if (is_dir($this->destino.$archivo)){
				if ($archivo=="."){
					$nombre = ".";
					$valor = "carpeta actual";
				}elseif ($archivo==".."){
					$nombre = "..";
					$valor = "carpeta anterior";
				}else{
					$nombre = "[".$archivo."]";
					$valor="carpeta";
				}
			}else{
				$nombre = $archivo;
				$valor = filemtime($this->destino."/".$archivo);
			}
			$entradas[$nombre] = $valor;
		}
		closedir($dir);
		// Ordena por fecha.
//		if (count($entradas)!=0){
//			arsort ($entradas);
//		}
		return $entradas;
	}
	public function getTxtResultado(){
		return $this->txtResultado;
	}
	public function setExtensionesPermitidas($ext=''){
		global $ses;
		if($ext==''){
			// Asume extensiones indicadas en variable de sesion.
//			if($ses->getExtension()==''){
				$this->extensionesPermitidas = array("gif","jpg","jpeg","png","pdf","txt","nfo","doc","rtf","zip","rar","gz","ods","odt","mp3","xls");
//			}elseif($ses->getExtension()=='img'){
//				$this->extensionesPermitidas = array("gif","jpg","jpeg","png");
//			}
		}else{
			$this->extensionesPermitidas = $ext;
		}
	}
	private function destino($subCarpeta='') {
		// Toma la raiz del alojamiento.
		$destino = $this->raiz();
		// Tratamiento de subcarpeta.
		if($subCarpeta!=''){
			if (strpos($subCarpeta,'%ant')===0){
				$caminos = explode('/',$destino);
				$destino="/";
				for ($i=0;$i<count($caminos)-1;$i++){
					$destino.=$caminos[$i].'/';
				}
			}else{
				$destino.= $subCarpeta."/";
			}
		}
		// Añade al camino la carpeta de contenidos.
		if (SERVIDOR_WEB == "iss"){
			$destino = str_replace("/","\\",$destino);
		}
		$this->destino = $destino;
		// Comprueba que exista la carpeta.
		if (!is_dir($this->destino)){
			$this->creaCarpeta();
		}
	}
	private function raiz(){
		// Toma la raiz del alojamiento.
		$destino = dirname($_SERVER['SCRIPT_FILENAME']);
		$caminos = explode('/cod',$destino);
		$destino = $caminos[0].'/'.$this->contenedor.'/';
		return $destino;
	}
	private function upLoad($archivo) {
		// Controles.
		if ($archivo==null or $archivo['name']==""){
			$this->txtResultado = "No se indicó el archivo a subir";
			return false;
		}
		if ($archivo['error']!=0) {
			switch ($archivo['error']) {
				case 1-2: $this->txtResultado = "El fichero es demasiado grande"; break;
				case 3: $this->txtResultado = "El fichero no se subió completo."; break;
				case 4: $this->txtResultado = "No se encontró el fichero."; break;
				case 6: $this->txtResultado = "No se dispone de carpeta provisional de trabajo."; break;
			}
			return false;
		}

		$origen = $archivo['tmp_name'];
		$nombreFichero = $archivo['name'];
		if(!in_array(strtolower($this->extName($nombreFichero)),$this->extensionesPermitidas)){
			$this->txtResultado = "Extensión de archivo no permitida";
			return false;
		}

		$size = $archivo['size'];
		if ($size==0){
			$this->txtResultado = "El fichero que se desea subir ocupa cero bytes";
			return false;
		}
		if ($this->tamanoMaximo>0 && $size > $this->tamanoMaximo) {
			$this->txtResultado = "El fichero es demasiado grande";
			return false;
		}
		// Si no existe la carpeta la crea.
		$destino = $this->destino."/".$nombreFichero;

		if (file_exists($destino)) {
			$this->txtResultado = "$nombreFichero ya existe en la web";
			return true;
		}

		if (!move_uploaded_file($origen,$destino)) {
			$this->txtResultado = "Hubo errores al copiar el fichero.";
			return false;
		}else{
			if (!chmod($destino, 0777)){
			$this->txtResultado = "Hubo errores al asignar permisos al fichero.";
			return false;
			}
		}
		return true;
	}
	private function downLoad($archivo){
		$archivo = $this->destino.$archivo;
//		$archivo = $this->destino.basename($archivo);
		if (!is_file($archivo)) {
			$this->txtResultado = "No se encuentra el archivo que desea bajar";
			return false;
		}
		header("Content-Type: application/octet-stream");
		header("Content-Size: ".filesize($archivo));
		header("Content-Disposition: attachment; filename=\"".basename($archivo)."\"");
		header("Content-Length: ".filesize($archivo));
		header("Content-transfer-encoding: binary");
		@readfile($archivo);
		exit(0);
	}
	private function renameFile($archivo,$nuevoNombre,$mueve=false){
		$archivoOrigen = $this->destino.basename($archivo);
		if ($mueve){
			$separador=(SERVIDOR_WEB=="iss")?("\\"):("/");
			$archivoOrigen=$this->destino;
			$archivoOrigen=substr($archivoOrigen,0,strrpos($archivoOrigen,$separador));
			$archivoOrigen=substr($archivoOrigen,0,strrpos($archivoOrigen,$separador));
			$archivoOrigen = $archivoOrigen.$separador.$nuevoNombre.$separador.basename($archivo);
			$nuevoNombre = $this->destino.basename($archivo);
		}else{
			$nuevoNombre = $this->destino.$nuevoNombre;
		}
		if (!is_file($archivoOrigen)) {
			$this->txtResultado = "No se encuentra el archivo que desea renombrar";
			return false;
		}
		if (!rename( $archivoOrigen,$nuevoNombre)){
			$this->txtResultado = "Hubo problemas para renombrar el archivo";
			return false;
		}
		return true;
	}
	private function delete($archivo){
		$archivo = $this->destino.basename($archivo);
		if (!is_file($archivo)) {
			$this->txtResultado = "No se encuentra el archivo que desea borrar";
			return false;
		}
		if (!unlink($archivo)){
			$this->txtResultado = "Hubo problemas para borrar el archivo";
			return false;
		}
		return true;

	}
	private function makeFolder(){
		// El nombre de la nueva carpeta va incluído en $this->destino.
		if (!mkdir($this->destino,0777)){
			$this->txtResultado = "Hubo problemas al crear la carpeta";
			return false;
		}
		chmod($this->destino,  0777);
		return true;
	}
	private function deleteFolder(){
		if (!@rmdir(($this->destino))){
			$this->txtResultado = "No se puede borrar una seccion con contenidos";
			return false;
		}
		return true;
	}
	private function extName($archivo) {
		$archivo = explode(".",basename($archivo));
	return $archivo[count($archivo)-1];
	}
}