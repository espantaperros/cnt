<?php
/**
 *
 * Desarrollado por Myra
 * 13/07/2015 *
 * 
 * Clase para gestionar la vista.
 */

class Medio{
	private $id=0;
	private $nombre = 'screen';
	public function __construct($id=0,$nombre='screen'){
		$this->id = $id;
		$this->nombre = $nombre;		
	}
	public function setId($id){
		$this->id = $id;
	}
	public function getId(){
		return $this->id;
	}
	public function setNombre($nombre){
		$this->nombre = $nombre;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function esMovil(){
		$useragent=$_SERVER['HTTP_USER_AGENT'];
		return (preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|mobile.+firefox|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows ce|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4)));
	}
}

class Seccion{
	private $id = 0;
	private $nombre = '';

	public function __construct($id,$nombre){
		$this->id = $id;
		$this->nombre = $nombre;
	}
	public function getId(){
		return $this->id;
	}
	public function getNombre(){
		return $this->nombre;
	}
}

class Zona{
	private $id=0;
	private $nombre='';
	private $dataSource='';
	private $zonaFija = true;
	/* Simple enumeración de ids de bloques, 
	 * los bloques con toda su información en el array de bloques de la clase Vista	 */
	private $bloques=Array();

	public function __construct($id,$nombre,$dataSource,$zonaFija){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->dataSource = $dataSource;
		$this->zonaFija = $zonaFija;
	}
	public function getId(){
		return $this->id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getDataSource(){
		return $this->dataSource;
	}
	public function getZonaFija(){
		return $this->zonaFija;
	}
	public function addBloque($idBloque){
		$this->bloques[] = $idBloque;
	}
	public function getBloques(){
		return $this->bloques;
	}
}

class Bloque{
	private $id = 0;
	private $nombre = '';
	private $numero = 0;
	private $css = '';
	private $javascript = '';
	private $php = '';
	private $contenidos = Array();

	public function __construct($id,$nombre,$numero,$css,$javascript,$php){
		$this->id = $id;
		$this->nombre = $nombre;
		$this->numero = $numero;
		$this->css = $css;
		$this->javascript = $javascript;
		$this->php = $php;
	}
	public function getId(){
		return $this->id;
	}
	public function getNombre(){
		return $this->nombre;
	}
	public function getCSS(){
		return $this->css;
	}
	public function getJavaScript(){
		return $this->javascript;
	}
	public function getPHP(){
		return $this->php;
	}
	public function addContenido($contenido){
		$this->contenidos[$contenido['id']] = $contenido;
	}
	public function getContenidos(){
		return $this->contenidos;
	}
	public function count(){
		return (count($this->contenidos));
	}
	public function pintaBloque($pagina=-1){
		global $ses;
		$contenidos = $this->getContenidos();
		// Cálculo del número máximo de contenidos a mostrar por página.
		$contenido = reset($contenidos);
		$numero = $this->numero;
		if ($pagina<0) $pagina = $ses->getPagina();
		$pagina++;
		if($numero==0) $numero = count($contenidos);
		$i=0;?>
		<div id="<?=$this->nombre?>">
		<?php 
		foreach ($contenidos as $id=>$contenido){
			$i++;
			if($i > (($pagina-1)*$numero)){
				if($i < ($pagina*$numero)+1){
					$this->pintaContenido($contenido);
				}else{
					break;
				}
			}
		}?>
		</div>
	<?php 		
	}
	public function pintaContenido($contenido){
		if($contenido==null) return;
		extract($contenido);
		$plantilla=implode("",file($this->php));
		eval("?>".$plantilla."<?");
	}
}

class Vista{
	private $medio;
	private $seccion;
	private $titulo = '';
	private $metas = Array();
	private $CSSs = Array();
	private $javaScripts = Array();
	
	private $zonas = Array();
	private $datasources = Array();
	private $bloques = Array();
	
	public function __construct($medio,$seccion,$titulo){
		$this->medio = $medio;
		$this->seccion = $seccion;
		$this->titulo = $titulo;
	}
	public function getMedio(){
		return $this->medio->getNombre();
	}
	public function setTitle($titulo){
		$this->titulo = $titulo;
	}
	public function getTitle(){
		return $this->titulo;
	}
	public function addMeta($name,$content){
		$this->metas[$name]=strip_tags($content);		
	}
	public function getMetas(){
		return $this->metas;
	}
	public function addCSS($css){
		$this->CSSs[$css] = URL_CSS.'/'.$css;
	}
	public function getCSSs(){
		return $this->CSSs;
	}
	public function addJavaScript($javaScript){
		$this->javaScripts[$javaScript] = URL_JS.'/'.$javaScript;
	}
	public function getJavaScripts(){
		return $this->javaScripts;
	}
	/**
	 * Trabajo con zonas
	 */
	public function addZona($id,$nombre,$datasource,$zonaFija=true){
		$this->zonas[$id] = new Zona($id,$nombre,$datasource,$zonaFija);
		if (!isset($this->datasources[$datasource])){
			$this->datasources[$datasource] = Array();				
		}
		$this->datasources[$datasource][$id] = $nombre;
	}
	public function getZonas(){
		return $this->zonas;
	}
	public function getZona($id){
		if (isset($this->zonas[$id])){
			return $this->zonas[$id];
		}else{
			return ('zonaFueraComposicion'.$id);
		}
	}
	public function pintaZona($idZona,$fuerza=false){
		$zona = $this->zonas[$idZona];
		if($fuerza ||
		   $zona->getZonaFija() ||
		   $this->contenidosEnZona($idZona)>0){
			$bloques = $zona->getBloques();
			foreach($bloques as $idBloque){
				$this->getBloque($idBloque)->pintaBloque();
			}
		}
	}
	/**
	 * Trabajo general con bloques
	 */
	public function addBloque($id,$nombre,$zona,$numero,$css,$javascript,$php){
		global $ses;
		$php = ($ses->vistaPrivada()?URL_MTO:URL_PHP).$php;
		$bloque = new Bloque($id,$nombre,$numero,$css,$javascript,$php);
		$this->zonas[$zona]->addBloque($id);
		$this->bloques[$id] = $bloque;
	}
	public function getBloque($id){
		return $this->bloques[$id];
	}
	public function getIdBloques(){
		$idBloques = "";
		$primer = true;
		foreach ($this->bloques as $idBloque=>$bloque){
			if($primer){
				$primer = false;
			}else{
				$idBloques.=',';
			}
			$idBloques .= $bloque->getId();
		}
		return $idBloques;
	}
	public function cargaContenidos($dataSources){
		foreach ($this->datasources as $datasource=>$objeto){
			$contenidos = $dataSources[$datasource]->relaciona();
			foreach ($contenidos as $i=>$contenido){
				$bloque = $this->getBloque($contenido['id_bloque']);
				// Control de páginas.
				$bloque->addContenido($contenido);
				$css = $bloque->getCSS();
				$javascript = $bloque->getJavaScript();
				if($css!='') $this->addCSS($css);
				if($javascript!='') $this->addJavaScript($javascript);
			}
		}
	}
	public function contenidosEnZona($idZona){
		$resultado = 0;
		$bloques = $this->zonas[$idZona]->getBloques();
		foreach ($bloques as $idBloque){
			$resultado += $this->bloques[$idBloque]->count();
		}
		return $resultado;
	}
}