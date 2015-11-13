<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Zona Derecha
 */
?>
<div id="zona_derecha">
	<article>
		<section>
			<figure>
				<a href="http://www.cnt.es/que_es_cnt" target="_blank"'?>
				<img src="<?=URL_BASE?>cont/extremadura/que_es_cnt-banner.png" alt="¿Qué es la CNT?"/>
				</a>
	       	</figure>
		</section>
	</article>
	<article>
		<header>
			<hgroup>
				<h1><a href="http://madrid.cnt.es/historia/" class="titulo" target="_blank">Historia de la CNT</a></h1>
			</hgroup>
		</header>		
	</article>
	<?
	// Agenda
	if($vista->contenidosEnZona(6)>0){
		require_once('cod/mqt/mqtAgenda.php');
	}
	// Más Leído
		require_once('cod/mqt/mqtMasLeido.php');
	// Derecha
		$vista->pintaZona(2);?>
</div>
