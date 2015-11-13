<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de anuncio de cabecera: publico
 */
global $ses;
require_once('cod/lib/util.php');
$link='';
if ($enlace==''){
	$link = $ses->link(null,$id,$titulo);
}else{
	$link = $enlace;?>
<?php 
}?>
<article>
	<figure id="anuncio_cabecera">
	<a href="<?=$link?>" <?=$enlace==''?'':' target="_blank"'?>>
	 <img src="<?=redimensionaAnchoFoto($imagen,1024,$autor.'_ap_',0)?>" alt="<?=$comentario_imagen?>"/>
	</a>
	</figure>
</article>