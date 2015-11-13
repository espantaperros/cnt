<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque Contenido con foto destacada en doble columna: privado
 */
global $ses;
require_once('cod/lib/util.php');
$permitido = ($ses->getUsuario('super')==1 || $ses->getUsuario('usuario')==$autor);?>
<article data-usuario="<?=$autor?>" data-tipo="info" data-id="<?=$id?>" data-idEstilo="<?=$idEstilo?>" data-publicado='<?=$publicado?>' data-enlace='<?=addslashes($enlace)?>' data-embebido='<?=addslashes($embebido)?>' data-imagen='<?=$imagen?>' data-comentario_imagen='<?=$comentario_imagen?>' data-fecha_publicacion='<?=$fecha_publicacion?>' data-fecha_caducidad='<?=$fecha_caducidad?>' >
	<header>
		<hgroup>
			<textarea id="titulo_<?=$idEstilo?>" maxlength="250" class="titulo" data-id="<?=$id?>" data-campo="titulo"<?=$permitido?'':' readonly'?> "><?=$titulo?></textarea>
		</hgroup>
	</header>
	<section>
       	<?php 
       	$multimedia=false;
		if($embebido!=''){
	       	$multimedia=true;?>
			<div><?=$embebido?></div>
		<?php 
		}elseif($imagen!=''){
	       	$multimedia=true;
		}?>
		<figure style="<?=$imagen==''?'display:none;':''?>">
			<img src="<?=redimensionaAnchoFoto($imagen,512,$autor.'_t_',0)?>" alt="<?=$comentario_imagen?>"  data-idArchivo="img_<?=$id?>"/>
			<figcaption><?=$comentario_imagen?></figcaption>
       	</figure>
		<aside><div><?=$autor?></div></aside>
		<div<?=$multimedia?' class="corto"':''?>>
		<?php 
		if ($permitido){?>
		<textarea id="descripcion_<?=$idEstilo?>" maxlength="500" class="descripcion" data-id="<?=$id?>" data-campo="descripcion"><?=$descripcion?></textarea>
		<?php 
		}else{?>
		<div><?=$descripcion?></div>
		<?php
		}?>
		</div>
	</section>		
</article>