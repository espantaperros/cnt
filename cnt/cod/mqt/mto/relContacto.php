<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de contacto por sindicato: privado
 */
global $ses,$ctrlIzq;
require_once('cod/lib/util.php');
$ctrlIzq*=(-1);
$permitido = ($ses->getUsuario('super')==1 || $ses->getUsuario('usuario')==$autor);?>
<article class="<?=$ctrlIzq==-1?' izquierda':''?>" data-usuario="<?=$autor?>" data-tipo="contacto" data-id="<?=$id?>" data-idEstilo="<?=$idEstilo?>" data-publicado='<?=$publicado?>' data-enlace='<?=addslashes($enlace)?>' data-embebido='<?=addslashes($embebido)?>' data-imagen='<?=$imagen?>' data-comentario_imagen='<?=$comentario_imagen?>' data-fecha_publicacion='<?=$fecha_publicacion?>' data-fecha_caducidad='<?=$fecha_caducidad?>' >
	<?php 
	include('cod/mqt/mto/frmCtrl.php');?>
	<header>
		<hgroup>
			<textarea id="titulo_<?=$idEstilo?>" maxlength="250" class="titulo" data-id="<?=$id?>" data-campo="titulo"<?=$permitido?'':' readonly'?> " data-id="<?=$id?>"><?=$titulo?></textarea>
		</hgroup>
	</header>
	<section>
		<?php 
		if($embebido!=''){?>
			<div class="embebido"><?=$embebido?></div>
		<?php 
		}elseif($imagen!=''){?>
		<figure>
			<img src="<?=redimensionaAnchoFoto($imagen,512,$autor.'_t_',0)?>" alt="<?=$comentario_imagen?>"/>
			<figcaption><?=$comentario_imagen?></figcaption>
       	</figure>
       	<?php 
		}
		if($permitido){?> 
		<textarea id="descripcion_<?=$idEstilo?>" maxlength="500" class="descripcion" data-id="<?=$id?>" data-campo="descripcion"><?=$descripcion?></textarea>
		<?php 
		}else{?>
		<div class="descripcion"><?=nl2br($descripcion)?></div>
		<?php 
		}?>
	</section>		
</article>