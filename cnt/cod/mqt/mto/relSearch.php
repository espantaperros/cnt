<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Maquetación de Búsqueda: privado
 * */
global $ses;
require_once('cod/lib/util.php');
////////////////// POR CONSTRUIR .../////////////////////////////
?>
<article>
	<?php
	$link='';
	if ($enlace==''){
		$link = $ses->link(null,$id,$titulo);
	}else{
		$link = $enlace;
	}
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
		if($imagen!=''){?>
		<figure>
			<a href="<?=$link?>"<?=$enlace==''?'':' target="_blank"'?>>
			<img src="<?=redimensionaAnchoFoto($imagen,200,$autor.'_s_',0)?>" alt="<?=$comentario_imagen?>"/>
			</a>
			<figcaption><?=$comentario_imagen?></figcaption>
       	</figure>
       	<?php 
		}?>
		<aside><div><?=$autor?></div></aside>
		<div class="descripcion"><?=nl2br($descripcion)?></div>
	</section>
</article>