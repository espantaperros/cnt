<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Desarrollo
 */
require_once('cod/lib/util.php');
// Zona derecha.
require_once('cod/mqt/mqtDerecha.php');?>
<div id="doble">
	<article id="articulo" data-autor="<?=$autor?>">
		<header>
			<hgroup>
				<textarea id="titulo" maxlength="250" class="titulo" data-id="<?=$id?>" data-campo="titulo"><?=$titulo?></textarea>
			</hgroup>
		</header>
		<section>
			<aside><div class="autor"><?=$autor?></div></aside>
			<textarea maxlength="255" id="descripcion" class="descripcion" data-id="<?=$id?>" data-campo="descripcion"><?=$descripcion?></textarea>
			<?php 
			if($embebido!=''){?>
				<div id="embebido"><?=$embebido?></div>
			<?php 
			}
			if (count($fotos)>0){?>
				<div id="galeria" data-id="<?=$id?>" data-campo="galeria" data-tipo="edit" data-usuario="<?=$autor?>" data-idestilo="galeria">
				<?php 
					foreach($fotos as $foto){?>
					<div class="rollover">
						<figure>
					<img src="<?=redimensionaFoto($foto['imagen'],true,522,$autor.'_d_')?>" title="<?=$foto['descripcion']?>" border="0" data-idArchivo="img_<?=$foto['id']?>" data-idfoto="<?=$foto['id']?>" data-imagen="<?=$foto['imagen']?>" data-comentario="<?=$foto['descripcion']?>"/>
						</figure>
					</div>
					<?php 
				}?>
				</div>
			<?php 
			}?>
			<div class="desarrollo_text">
			<?php 
			$complementos=false;
			if(count($documentos)+count($enlaces)+count($relacionados)+count($etiquetas)>0){
				$complementos=true;?>
				<div id="complementos">
					<h2>Más información</h2>
					<div id="relacion_complementos">
					<?php 
					if(count($documentos)>0){?>
					<p class="complemento">Ficheros adjuntos</p>
					<p class="inter_complemento">
						<?php 
						foreach($documentos as $documento){?>
							<span id="adjunto_<?=$documento['id']?>" class="complex" title="<?=$documento['descripcion']?>" data-id="<?=$documento['id']?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="adjunto" data-idestilo="<?=$documento['id']?>" data-titulo="<?=$documento['titulo']?>" data-descripcion="<?=$documento['descripcion']?>" data-documento="<?=$documento['documento']?>"><?=$documento['titulo']?><br/>
							 <?=nl2br($documento['descripcion'])?></span>
						<?php 
						}?>
					</p>
					<?php 
					}
					if(count($enlaces)>0){?>
					<p class="complemento">Enlaces</p>
					<p class="inter_complemento">
						<?php 
						foreach($enlaces as $enlace){?>
							<span id="enlace_<?=$enlace['id']?>" class="complex" data-id="<?=$enlace['id']?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="link" data-idestilo="<?=$enlace['id']?>" data-nombre="<?=$enlace['nombre']?>" data-enlace="<?=$enlace['enlace']?>" data-target="<?=$enlace['target']?>"><?=$enlace['nombre']?></span>
						<?php 
						}?>
					</p>
					<?php 
					}
					if(count($relacionados)>0){?>
					<p class="complemento">Otros contenidos</p>
					<p class="inter_complemento">
						<?php 
						foreach($relacionados as $relacionado){?>
							<span id="relacion_<?=$relacionado['id']?>" class="complex" data-id="<?=$relacionado['id']?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="relacion" data-idestilo="<?=$relacionado['id']?>" data-idrelacion="<?=$relacionado['id_relacion']?>" data-titulo="<?=$relacionado['titulo']?>"><?=$relacionado['titulo']?></span>
						<?php 
						}?>
					</p>
					<?php 
					}
					if(count($etiquetas)>0){?>
					<p class="complemento">Etiquetas</p>
					<p class="inter_complemento">
						<?php 
						foreach($etiquetas as $etiqueta){?>
							<span id="etiqueta_<?=$etiqueta['id']?>" class="complex" data-id="<?=$etiqueta['id']?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="etiqueta" data-idestilo="<?=$etiqueta['id']?>" data-nombre="<?=$etiqueta['nombre']?>"><?=$etiqueta['nombre']?></span>
						<?php 
						}?>
					</p>
					<?php 
					}?>
					</div>		
				</div>
			<?php 
			}
			if (count($desarrollos)>0){?>
				<?php 
				foreach($desarrollos as $desarrollo){?>
					<div class="text<?=$complementos?' corto':''?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="desarrollo" data-id="<?=$desarrollo['id']?>"data-idestilo="desarrollo">
					<textarea class="texto" data-id="<?=$desarrollo['id']?>"><?=$desarrollo['desarrollo']?></textarea>
					</div>
				<?php 
				}?>
			<?php 
			}?>
			</div>
			<?php 	
			if(count($eventos)>0){?>
				<div id="programa">
				<h2>Programa.-</h2>
				<?php
				$fecha = "";
				foreach($eventos as $evento){ 
					if($fecha!=txtFecha($evento['fecha_inicio'])){
						$fecha=txtFecha($evento['fecha_inicio'])?>
						<h3><?=$fecha?></h3>
					<?php 
					}?>
					<div id="evento_<?=$evento['id']?>" data-id="<?=$evento['id']?>" data-tipo="edit" data-usuario="<?=$autor?>" data-campo="evento" data-idestilo="<?=$evento['id']?>" data-fecha_inicio="<?=$evento['fecha_inicio']?>" data-fecha_final="<?=$evento['fecha_final']?>" data-titulo="<?=$evento['titulo']?>" data-descripcion="<?=$evento['descripcion']?>" data-lugar="<?=$evento['lugar']?>" data-localidad="<?=$evento['localidad']?>">
					<h4><?=txtHora($evento['fecha_inicio']).($evento['fecha_final']==''?'':' a'.txtHora($evento['fecha_final']).(txtFecha($evento['fecha_inicio'])!=txtFecha($evento['fecha_final'])?(' del día '.txtFecha($evento['fecha_final'])):''))?> <?=$evento['titulo']?></h4>
					<?php		
					if($evento['lugar']!=''){?>
						en <?=$evento['lugar']?>
					<?
					}
					if($evento['localidad']!=''){?>
						de <?=$evento['localidad']?>
					<?
					}?><br/>
					<?php 
					if($evento['descripcion']!=''){?>
						<?=nl2br($evento['descripcion'])?>
					<?php 
					}?>
					</div>
				<?php 
				}?>
				</div>
				<?php 
				}?>
		</section>
	</article>
</div>