<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque Contenido con foto destacada en doble columna: publico
 */
global $ses;
require_once('cod/lib/util.php');
$link='';
if ($enlace==''){
	$link = $ses->link(null,$id,$titulo);
}else{
	$link = $enlace;
}?>
<article>
	<?php 
	if($titulo!=''){?>
	<header>
		<hgroup>
			<h1><a href="<?=$link?>"<?=$enlace==''?'':' target="_blank"'?>><?=$titulo?></a></h1>
		</hgroup>
	</header>
	<?php 
	}?>
	<section>
       	<?php 
		if($embebido!=''){?>
			<div class="embebido"><?=$embebido?></div>
		<?php 
		}elseif($imagen!=''){?>
		<figure>
			<a href="<?=$link?>"<?=$enlace==''?'':' target="_blank"'?>>
			<img src="<?=redimensionaAnchoFoto($imagen,512,$autor.'_t_',0)?>" alt="<?=$comentario_imagen?>"/>
			</a>
			<figcaption><?=$comentario_imagen?></figcaption>
       	</figure>
       	<?php 
		}?>
		<aside><div><?=$autor?></div></aside>
		<div><?=$descripcion?></div>
	</section>
</article>