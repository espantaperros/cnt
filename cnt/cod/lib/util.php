<?php
/**
 *
 * Desarrollado por RkR
 *
 * Funciones de utilidad.
 */

function recortaFoto($foto, $ancho,$alto, $prefijo,$zona=2){
	if($foto==''){
		return "";
	}
	/* zona -1 -> izquierda; 0->centro; 1->derecha; 2->aleatorio */
	#Calculamos nombres de fichero y URLs
	$archivo = nombreArchivoOrigen($foto);
	$url = urlOrigen($foto);
	$scrD = nombreArchivoDestino($foto,$prefijo);
	$urlD = urlDestino($foto,$prefijo);
	if (file_exists($scrD)){
		return $urlD;
	}elseif (!file_exists($archivo)){
		return $url;
	}
	# Extraer el tipo de imagen.
	list($wO, $hO, $tipo) = getimagesize($archivo);
	/* Seleccionamos según el tipo la fuente.*/
	switch($tipo){
	    case 1:
	          $imgO=@imagecreatefromgif($archivo);
	    	break;
	    case 2:
	          $imgO=@imagecreatefromjpeg($archivo);
	    	break;
	    case 3:
	          $imgO=@imagecreatefrompng($archivo);
	    	break;
	    default:
	    	return $url;
	 }
	/* Calcula proporciones */
	if ($wO/$ancho < $hO/$alto) {
		$wD = $ancho;
		$hD = round($hO/($wO/$ancho));
	}else{
		$wD = round($wO/($hO/$alto));
		$hD = $alto;
	}
/* Crea imagen destino provisional
	 * redimensionada con estos anchos y altos provisionales.*/
	 $imgD = ImageCreateTrueColor($wD,$hD);
	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);	
	 /* Cálculo de coordenadas de corte*/
	switch ($zona){
		case 0:
			$lO = round(($wD-$ancho)/2);
			$tO = round(($hD-$alto)/2);
			break;
		case -1:
			$lO = 0;
			$tO = 0;
			break;
		case 1:
			$lO = round($wO-$ancho);
			$tO = round($hO-$alto);	
			break;
		default:
			mt_srand (time());
			//generamos un número aleatorio
			$lO = round(mt_rand(0,($wD-$ancho)));
			$tO = round(mt_rand(0,($hD-$alto)));
	}
	/* Crea imagen con las dimensiones solicitadas */
	 $imgD1 = ImageCreateTrueColor($ancho,$alto);	
	 #Generamos la imagen según el tipo la fuente.
	imagecopy($imgD1, $imgD, 0, 0, $lO, $tO, $ancho, $alto);
	switch($tipo){
	    case 1:
			$imgO=imagegif($imgD1,$scrD,95);
	    	break;
	    case 2:
			$imgO=imagejpeg($imgD1,$scrD,95);
	    	break;
	    case 3:
			$imgO=imagepng($imgD1,$scrD,9);
	    	break;
	 }
	 #liberamos memoria
	 imageDestroy($imgD);
	 imageDestroy($imgD1);
	 return $urlD;
}
function redimensionaFoto($foto,$ancho,$alto,$prefijo="a_"){
	if($foto==''){
		return "";
	}
	$archivo = nombreArchivoOrigen($foto);
	$url = urlOrigen($foto);
	#Calculamos nombre y url del fichero de imagen
	$scrD = nombreArchivoDestino($foto,$prefijo);
	$urlD = urlDestino($foto,$prefijo);
	if (file_exists($scrD)){
		return $urlD;
	}elseif (!file_exists($archivo)){
		return $url;
	}
	# Extraer el tipo de imagen.
	list($wO, $hO, $tipo) = getimagesize($archivo);
	/* Seleccionamos según el tipo la fuente.*/
	switch($tipo){
	    case 1:
	          $imgO=@imagecreatefromgif($archivo);
	    	break;
	    case 2:
	          $imgO=@imagecreatefromjpeg($archivo);
	    	break;
	    case 3:
	          $imgO=@imagecreatefrompng($archivo);
	    	break;
	    default:
	    	return false;
	 }
	 #Extraemos ancho (w), alto (h)
	 $wO = ImageSX($imgO);
	 $hO = ImageSY($imgO);

	 if ($ancho===true){ // Conserva Proporción cambiando el ancho
		$hD = $alto;
		$wD = ($wO*$hD)/$hO;
	 }elseif($alto===true){  // Conserva proporción cambiando el alto
		$wD = $ancho;
		$hD = ($wO*$wD)/$hO;
	 }else{	// Deforma la imágen	 	
	 	$hD = $alto;
		$wD = $ancho;
	 }
	 #Creamos la imagen Destino
	 $imgD = ImageCreateTrueColor($wD,$hD);

	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);

	 #Generamos la imagen según el tipo la fuente.*/
	 switch($tipo){
	 	case 1:
	 		$imgO=imagegif($imgD,$scrD,95);
	 		break;
	 	case 2:
	 		$imgO=imagejpeg($imgD,$scrD,95);
	 		break;
	 	case 3:
	 		$imgO=imagepng($imgD,$scrD,9);
	 		break;
	 	default:
	 		return false;
	 }
	 #liberamos memoria
	 imageDestroy($imgD);
	 
	 return $urlD;
}
function redimensionaAltoFoto($foto,$alto,$prefijo="p_"){
	if($foto==''){
		return "";
	}
	#Calculamos nombre u url del fichero de imagen
	$archivo = nombreArchivoOrigen($foto);
	$url = urlOrigen($foto);
	$scrD = nombreArchivoDestino($foto,$prefijo);
	$urlD = urlDestino($foto,$prefijo);
	if (file_exists($scrD)){
		return $urlD;
	}elseif (!file_exists($archivo)){
		return $url;
	}
	# Extraer el tipo de imagen.
	list($wO, $hO, $tipo) = getimagesize($archivo);
	/* Seleccionamos según el tipo la fuente.*/
	switch($tipo){
	    case 1:
	          $imgO=@imagecreatefromgif($archivo);
	    	break;
	    case 2:
	          $imgO=@imagecreatefromjpeg($archivo);
	    	break;
	    case 3:
	          $imgO=@imagecreatefrompng($archivo);
	    	break;
	    default:
	    	return false;
	 }
	 #Extraemos ancho (w), alto (h)
	 $wO = ImageSX($imgO);
	 $hO = ImageSY($imgO);

	 #Recalculamos al alto segun el ancho.
	 $ancho = round(($alto*$wO)/$hO);

	 #Comprobamos si el alto se ajusta al alto de la columna
	 	$hD = $alto;
	 	$wD = round(($alto*$wO)/$hO);
	 	
	 #Creamos la imagen Destino
	 $imgD = ImageCreateTrueColor($wD,$hD);

	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);

	 #Generamos la imagen según el tipo la fuente.*/
	switch($tipo){
	    case 1:
			$imgO=imagegif($imgD,$scrD,95);
	    	break;
	    case 2:
			$imgO=imagejpeg($imgD,$scrD,95);
	    	break;
	    case 3:
			$imgO=imagepng($imgD,$scrD,9);
	    	break;
	    default:
	    	return false;
	 }
	 #liberamos memoria
	 imageDestroy($imgD);

	 return $urlD;
}
function redimensionaAnchoFoto($foto,$ancho,$prefijo="m_"){
	if($foto==''){
		return "";
	}
	/* zona -1 -> izquierda; 0->centro; 1->derecha; 2->aleatorio */
	#Calculamos nombres de fichero y URLs
	$archivo = nombreArchivoOrigen($foto);
	$url = urlOrigen($foto);
	$scrD = nombreArchivoDestino($foto,$prefijo);
	$urlD = urlDestino($foto,$prefijo);
	if (file_exists($scrD)){
		return $urlD;
	}elseif (!file_exists($archivo)){
		return $url;
	}
	# Extraer el tipo de imagen.
	list($wO, $hO, $tipo) = getimagesize($archivo);
	/* Seleccionamos según el tipo la fuente.*/
	switch($tipo){
	    case 1:
	          $imgO=@imagecreatefromgif($archivo);
	    	break;
	    case 2:
	          $imgO=@imagecreatefromjpeg($archivo);
	    	break;
	    case 3:
	          $imgO=@imagecreatefrompng($archivo);
	    	break;
	    default:
	    	return $url;
	 }
	 #Extraemos ancho (w), alto (h)
	 $wO = ImageSX($imgO);
	 $hO = ImageSY($imgO);

	 #Comprobamos si el ancho se ajusta al ancho de la columna
	 if ($wO<=$ancho) {
	 	$wD = $wO;
	 	$hD = $hO;
	 }else{
	 	$wD = $ancho;
	 	$hD = round(($wD*$hO)/$wO);
	 }
	 
/* Crea imagen destino provisional
	 * redimensionada con estos anchos y altos provisionales.*/
	 $imgD = ImageCreateTrueColor($wD,$hD);
	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);	
	 #Creamos la imagen Destino
	 $imgD = ImageCreateTrueColor($wD,$hD);
	 if($tipo==3){ //png
		 imagealphablending($imgD, false);
		 imagesavealpha($imgD,true);
	 }

	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);

	 #Generamos la imagen según el tipo la fuente.*/
	switch($tipo){
	    case 1:
			$imgO=imagegif($imgD,$scrD,95);
	    	break;
	    case 2:
			$imgO=imagejpeg($imgD,$scrD,95);
	    	break;
	    case 3:
			$imgO=imagepng($imgD,$scrD,9);
	    	break;
	    default:
	    	return $url;
	 }
	 #liberamos memoria
	 imageDestroy($imgD);

	 return $urlD;
	 
}
function redimensionaAnchoAltoFoto($foto,$ancho,$alto,$prefijo="p_"){
	if($foto==''){
		return "";
	}
	#Calculamos nombre u url del fichero de imagen
	$archivo = nombreArchivoOrigen($foto);
	$url = urlOrigen($foto);
	$scrD = nombreArchivoDestino($foto,$prefijo);
	$urlD = urlDestino($foto,$prefijo);
	if (file_exists($scrD)){
		return $urlD;
	}elseif (!file_exists($archivo)){
		return $url;
	}
	# Extraer el tipo de imagen.
	list($wO, $hO, $tipo) = getimagesize($archivo);
	/* Seleccionamos según el tipo la fuente.*/
	switch($tipo){
	    case 1:
	          $imgO=@imagecreatefromgif($archivo);
	    	break;
	    case 2:
	          $imgO=@imagecreatefromjpeg($archivo);
	    	break;
	    case 3:
	          $imgO=@imagecreatefrompng($archivo);
	    	break;
	    default:
	    	return false;
	 }
	 #Extraemos ancho (w), alto (h)
	 $wO = ImageSX($imgO);
	 $hO = ImageSY($imgO);

	 #Recalculamos al alto segun el ancho.
	 // Conserva Proporción cambiando el alto
	$ratio = $wO/$hO;
	if(($ancho/$alto)>$ratio){
		$hD = $alto;
		$wD = $alto*$ratio;
	}else{
		$wD = $ancho;
		if($ratio<1){
			$hD = $ancho*$ratio;
		}else{
			$hD = $ancho/$ratio;
		}
	}
		
	 #Creamos la imagen Destino
	 $imgD = ImageCreateTrueColor($wD,$hD);

	 #Redimensionamos
	 imagecopyresized($imgD,$imgO,0,0,0,0,$wD,$hD,$wO,$hO);

	 #Generamos la imagen según el tipo la fuente.*/
	switch($tipo){
	    case 1:
			$imgO=imagegif($imgD,$scrD,95);
	    	break;
	    case 2:
			$imgO=imagejpeg($imgD,$scrD,95);
	    	break;
	    case 3:
			$imgO=imagepng($imgD,$scrD,9);
	    	break;
	    default:
	    	return false;
	 }
	 #liberamos memoria
	 imageDestroy($imgD);

	 return $urlD;
}
function nombreArchivoOrigen($foto){
	return dirname($_SERVER['SCRIPT_FILENAME']).'/'.RAIZ.$foto;
}
function nombreArchivoDestino($foto,$prefijo){
	return dirname($_SERVER['SCRIPT_FILENAME']).'/img/'.$prefijo.substr($foto, strrpos($foto, '/')+1);
}
function urlOrigen($foto){
	return URL_BASE.RAIZ.$foto;
}
function urlDestino($foto,$prefijo){
	return URL_BASE."img/".$prefijo.substr($foto, strrpos($foto, '/')+1);
}
function strAnno($timestamp){
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	return (strftime("%Y",strtotime($timestamp)));
}
function strFecha($timestamp){
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	return (strftime("%d/%m/%Y",strtotime($timestamp)));	
}
function txtFecha($timestamp){
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	$time = strtotime($timestamp);
	$ano = date('Y',$time);
	$mes = date('n',$time);
	$dia = date('d',$time);
	$meses=array("Enero","Febrero","Marzo","Abril","Mayo","Junio","Julio","Agosto","Septiembre","Octubre","Noviembre","Diciembre");
	return ($dia." de ".$meses[$mes-1]." de ".$ano);	
}
function txtHora($timestamp){
	setlocale(LC_ALL,"es_ES@euro","es_ES","esp");
	$time = strtotime($timestamp);
	return date('G:i\h.',$time);	
}?>
