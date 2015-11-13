<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Desarrollo
 */
require_once('cod/lib/util.php');?>
<div id="zona_izquierda">
	<article id="articulo" data-autor="<?=$autor?>">
		<?php 
		$link='';
		if ($enlace==''){
			$link = $ses->link(null,$id,$titulo);
		}else{
			$link = $enlace;
		}?>
		<?php 
		if($titulo!=''){?>
		<header>
			<hgroup>
				<h1><?=$titulo?></h1>
			</hgroup>
		</header>
		<?php 
		}?>
		<section>
			<?php 
			if($titulo!=''){?>
			<aside><div class="autor"><?=$autor?></div></aside>
			<?php 
			}
			if($descripcion!=''){?>
			<div class="descripcion"><?=nl2br($descripcion)?></div>
	       	<?php 
			}
			if($embebido!=''){?>
				<div id="embebido"><?=$embebido?></div>
			<?php 
			}
			if (count($fotos)>0){?>
				<div id="galeria">
				<?php 
				foreach($fotos as $foto){?>
					<div class="rollover">
						<figure>
							<img src="<?=redimensionaFoto($foto['imagen'],true,522,$autor.'_d_')?>" title="<?=$foto['descripcion']?>" border="0"/>
							<figcaption><?=$comentario_imagen?></figcaption>
				       	</figure>
					</div>
				<?php 
				}?>
				</div>
			<?php 
			}?>
			<div class="desarrollo_text">
			<?php 
			if(count($documentos)+count($enlaces)+count($relacionados)+count($etiquetas)>0){?>
				<div id="complementos" class="bloque">
					<h2>Más información</h2>
					<div id="complementos_relacion">
					<?php 
					if(count($documentos)>0){?>
					<p class="complemento">Ficheros adjuntos</p>
					<p class="inter_complemento">
						<?php 
						foreach($documentos as $documento){?>
							<span><a href="<?=URL_BASE?>/index.php?fdown=<?=$documento['documento']?>" title="<?=$documento['descripcion']?>"><?=$documento['titulo']?></a>
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
							<a href="<?=$enlace['enlace']?>"<?=$enlace['target']==1?' target="blank"':''?>><?=$enlace['nombre']?></a>
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
							<span><a href="<?=$ses->link('',$relacionado['id_relacion'],$relacionado['titulo'])?>"><?=$relacionado['titulo']?></a></span>
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
							<span>
								<a href="<?=$ses->link('tag='.$etiqueta['nombre'])?>" class="etiqueta"><?=$etiqueta['nombre']?></a>
							</span>
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
						<?=nl2br($desarrollo['desarrollo'])?>
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
					<div>
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