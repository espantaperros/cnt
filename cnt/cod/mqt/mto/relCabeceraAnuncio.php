<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de anuncio de cabecera: privado
 */
global $ses;
require_once('cod/lib/util.php');?>
<article  data-tipo="anuncio_cabecera" data-id="<?=$id?>" data-idEstilo="<?=$idEstilo?>" data-publicado='<?=$publicado?>' data-enlace='<?=addslashes($enlace)?>' data-embebido='<?=addslashes($embebido)?>' data-anuncio='<?=$anuncio?>' data-comentario_imagen='<?=$comentario_imagen?>' data-fecha_publicacion='<?=$fecha_publicacion?>' data-fecha_caducidad='<?=$fecha_caducidad?>' data-usuario="<?=$autor?>">
	<figure id="anuncio_cabecera">
		<img src="<?=redimensionaAnchoFoto($imagen,1024,$autor.'_ap_',0)?>" alt="<?=$comentario_imagen?>" data-idArchivo="img_<?=$id?>" data-campo="anuncio"/>
	</figure>
</article>