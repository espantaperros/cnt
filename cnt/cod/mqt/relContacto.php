<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de contacto por sindicato: publico
 */
global $ses,$ctrlIzq;
require_once('cod/lib/util.php');
$ctrlIzq*=(-1);
$link='';
if ($enlace==''){
	$link = $ses->link(null,$id,$titulo);
}else{
	$link = $enlace;
}?>
<article class="contacto<?=$ctrlIzq==-1?' izquierda':''?>">
	<?php 
	if($titulo!=''){?>
	<header>
		<hgroup>
			<h1><a href="<?=$link?>" class="titulo"<?=$enlace==''?'':' target="_blank"'?>><?=$titulo?></a></h1>
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
		<?php 
		if($descripcion!=''){?>
		<div class="descripcion"><?=nl2br($descripcion)?></div>
       	<?php 
		}?>
	</section>
</article>