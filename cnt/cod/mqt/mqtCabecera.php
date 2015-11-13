<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Cabecera
 */
global $ses;?>

<header id="cabecera">
	<?php
	if($vista->getMedio()=='handheld'){?>
	<nav id="navegacion">
	</nav>
	<?php 
	}else{
	$vista->pintaZona(0);?>
	<nav id="navegacion">
		<form id="form_busca" method="post"><input id="busca" type="text" name="search" placeholder="buscador"/></form>
		<form id="form_hemeroteca" method="post"><input id="hemeroteca" type="date" name="hemeroteca" value="<?=$ses->getFecha()==''?'':$ses->getFecha()?>"></form>
		<div id="contacto_sel"><a href="<?=$ses->link('contacto')?>">contacto</a> &nbsp;</div>
		<div id="sindicatos_sel">sindicatos &darr;
			<span id="sindicatos">
				<a href="<?=$ses->link('a=caceresnorte')?>">Cáceres Norte</a>
				<a href="<?=$ses->link('a=caceres')?>">Cáceres</a>
				<a href="<?=$ses->link('a=badajoz')?>">Badajoz</a>
				<a href="<?=$ses->link('a=merida')?>">Mérida</a>
				<a href="<?=$ses->link('a=donbenito')?>">Don Benito</a>
			</span>
		</div>
	</nav>
	<?php 
	}?>
	<figure id="logo">
		<a href="<?=$ses->link('portada')?>">
		<img src="<?=URL_BASE?>/cod/img/cnt/logo_cnt.png" alt="CNT Extremadura"/>
		</a>
	</figure>
	<div id="barra_cabecera"></div>
</header>