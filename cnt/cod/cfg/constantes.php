<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Definición de constantes.
 */

/* Nombre de la web */
define("DENO_WEB","CNT Extremadura");
/* URL raíz al resto de documentos */
define("URL_BASE","http://192.168.1.49/myra/cnt/");
define("URL_PHP","cod/mqt/");
define("URL_MTO","cod/mqt/mto/");
define("URL_CSS","cod/img/cnt/");
define("URL_JS","cod/lib/js/");

/* Identificador de Session */
define("SESSION_ID","cnt");

/* Tiempo máximo de vida de sesion */
define("MAX_SESSION",3600);  // (600 = 5 minutos)

/* Número de intentos en login */
define("MAX_LOGIN",5);

/* Artículos por página */
define("NUM_ARTICULOS",10);

/* Password por defecto */
define("DEFAULT_PASSWORD",'4c13d3985384e040bc4eee73ebe61854'); // C3NT3nario

/* Carpeta de contenidos */
define("SERVIDOR_WEB","apache");
define("RAIZ","cont/");?>