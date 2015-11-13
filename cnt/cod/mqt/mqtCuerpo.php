<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo
 */
 ?>
<section id="cuerpo">
  	<?
  	// Zona izquierda
  	switch ($seccion->getNombre()){
  		case 'portada':
  			require_once("cod/mqt/mqtPortada.php");
  			break;
  		case 'contacto':
  			require_once("cod/mqt/mqtContacto.php");
  			break;
  		case 'desarrollo':
			if($ses->vistaPrivada()){
  				require_once("cod/mqt/mto/mqtDesarrollo.php");
			}else{
  				require_once("cod/mqt/mqtDesarrollo.php");				
			}
  			break;
  		case 'search':
  			require_once("cod/mqt/mqtSearch.php");
  			break;
	} 
	// Zona derecha.
	require_once('cod/mqt/mqtDerecha.php');?>
</section>