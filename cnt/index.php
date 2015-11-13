<?php
/**
 *
 * Desarrollado por Myra
 * para Paideia
 * 1/08/2014 *
 *
 * Index.
 *
 */

error_reporting (E_ERROR | E_WARNING | E_PARSE | E_NOTICE);
require_once('cod/cfg/constantes.php');
/* Abre Sesión */
require_once('cod/ctrl/session.php');
// Llamadas en FrontEnd;
require_once('cod/ctrl/frontend.php');
/*
require_once('cod/cfg/datos.php');
require_once('cod/lib/sql.php');
$bd = new Sql( $cfg_servidor,$cfg_basedatos, $cfg_usuario, $cfg_password);
if (!$bd->conectar()) {
	echo "DB Error:";
	echo $bd->errNo.': '.$bd->error;
}
require_once('cod/mod/cont.php');
$contenido = new Cont(11);
print_r($contenido->getCampos());
$bd->desconectar();*/