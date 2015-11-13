<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Controlador principal de llamadas.
 *
if($ses->vistaPublica()){
	require_once('cod/mqt/enConstruccion.php');
	exit; 
}
 */

/**
 *  Sesión caducada
 */
if ($ses->sesionCaducada()){
	header("Location:".URL_BASE."/login.php?sesion=no");
}
/* Conexión con la base de datos */
require_once('cod/cfg/datos.php');
require_once('cod/lib/sql.php');
$bd = new Sql( $cfg_servidor,$cfg_basedatos, $cfg_usuario, $cfg_password);
if (!$bd->conectar()) {
	echo "DB Error:";
	echo $bd->getErrNo().': '.$bd->getError();
}
if($ses->vistaPrivada()){
	// Archivero
	switch ($ses->getLlamada()){
			case 'init':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archivero.php');
				break;
			case 'folders':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archCarpetas.php');
				break;
			case 'files':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archFicheros.php');
				break;
			case 'newFolder':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archCarpetas.php');
				break;
			case 'renFile':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archFicheros.php');
				break;
			case 'delFile':
				require_once('cod/ctrl/archivo.php');
				require_once('cod/mqt/mto/archFicheros.php');
				break;
			case 'upFile':
				require_once('cod/mqt/mto/frmUpLoad.php');
				break;
			case 'upImage':
				require_once('cod/mqt/mto/imageUploader.php');
				break;
			case 'fileUp':
				require_once('cod/ctrl/upload.php');
				break;
			case 'imageUp':
				require_once('cod/ctrl/uploadImage.php');
				break;
/*			case 'delFolder':
				$ses->setLlamada('borra_carpeta');
				break;*/
			case 'buscaItem':
				require_once('cod/ctrl/admBuscaItem.php');
				require_once('cod/mqt/mto/frmBuscaItem.php');
				break;
			case 'estilos':
				require_once('cod/ctrl/admEstilos.php');
				require_once('cod/mqt/mto/frmEstilos.php');
				break;
			case 'perfil':
				require_once('cod/ctrl/admUsuarios.php');
				require_once('cod/mqt/frmUsuarios.php');
				break;
		}
		if ($ses->getMantenimiento()){
			// acciones de mantenimiento de la web.
			require_once('cod/ctrl/mantenimiento.php');
		}
}elseif ($ses->getLlamada()=='downLoad'){
	// llamada de acción de download.
	require_once('cod/ctrl/download.php');
	$ses->setLlamada('');
}
if ($ses->getAjax()==false){
	/* Selecciona Idioma */
	//require_once('cod/lib/lng.php');
	require_once("vista.php");
	require_once("cod/ctrl/admRel.php");
	require_once('cod/mqt/inicio.php');
}elseif($ses->getLlamada()=='selItem'){
	require_once('cod/ctrl/admBuscaItem.php');
	require_once('cod/mqt/mqtBuscaTag.php');
}
/* Desconexión con base de datos*/
$bd->desconectar();
?>