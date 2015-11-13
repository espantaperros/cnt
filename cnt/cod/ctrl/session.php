<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Controlador de la sessión.
 */
	/* Inicia objeto de session */

require_once('cod/lib/ses.php');
$ses = new Session();
$ses->abrirSesion();
if ($ses->vistaPrivada()){
	// Web Privada
	require_once("cod/mod/sessionAdmtva.php");
	$ses = new SessionAdmtva();
}else{
	// Web Pública
	require_once("cod/mod/sessionPublica.php");
	$ses = new SessionPublica();
}
$ses->inicializa();
// Vista Previa
if ($ses->vistaPrivada()){
	if (isset($_GET['ll'])){
		if ($_GET['ll']=="buscaItem" ||
		    $_GET['ll']=="perfil" ||
		    $_GET['ll']=="estilos"){
			$ses->setAjax(true);
		}
	}else{
		$ses->setLlamada($ses->getSeccion());
	}
	if (!$ses->getSuper()){
		$ses->setAutor($ses->getUsuario('usuario'));
	}
	if (isset($_GET['vp'])){
		$ses->setVistaPrevia($_GET['vp']);
	}
	// Archivero
	if (isset($_POST['arch'])){
		$ses->setAjax(true);
		$ses->setLlamada($_POST['arch']);
		if (isset($_POST['folder'])){
			$ses->setCarpeta($_POST['folder']);
		}
		if (isset($_POST['file'])){
			$ses->setArchivo($_POST['file']);
		}
	}
	// Control de Mantenimiento.
	if (isset($_POST['op'])){
		$ses->setOperacion($_POST['op']);
		if(($_POST['op']%5==0 && ($_POST['op']!=0 && $_POST['op']!=65) && $_POST['op']!=85)){
			$ses->setAjax(true);
		}
	}
}else{
	// ¿operación en sesion pública? NO
	if (isset($_POST['op'])){
		if(($_POST['op']%5==0 && ($_POST['op']!=0 && $_POST['op']!=65) && $_POST['op']!=85)) exit;
	}
}
if (isset($_GET['a'])){
		$ses->llama('portada');
		$ses->setAutor($_GET['a']);
}
if (isset($_GET['ll']) && $_GET['ll']=="selItem"){
	$ses->setAjax(true);
}
// Filtros por búsqueda y fecha
if (isset($_POST['search'])){
	$ses->setId(0);
	$ses->llama('search');
	$ses->setBusca($_POST['search']);
	$_GET['ll']=null;
}
if (isset($_POST['hemeroteca'])){
	$ses->setId(0);
	$ses->setFecha($_POST['hemeroteca']);
	$_GET['ll']=null;
}
if (isset($_POST['tag'])){
	$ses->setId(0);
	$ses->llama('search');
	$ses->setTag($_POST['tag']);
	$_GET['ll']=null;
}
if (isset($_GET['tag'])){
	$ses->setId(0);
	$ses->llama('search');
	$ses->setTag($_GET['tag']);
	$_GET['ll']=null;
}
// Llamada.
if (isset($_GET['ll'])){
	$ses->llama($_GET['ll']);
}
// Id.
if (isset($_GET['id'])){
	$ses->setId($_GET['id']);
	unset($_GET['id']);
}
// Sección
if ($ses->vistaPrivada()){
	if($ses->getId()==0){
		if ($ses->getAjax()!==true){
			$ses->setSeccion($ses->getLlamada());
		}
	}else{
		$ses->setSeccion('desarrollo');
	}
}
if (isset($_GET['pg'])){
	$ses->setPagina($_GET['pg']);
}
if (isset($_GET['fdown'])){
	$ses->setLlamada('downLoad');
}
?>