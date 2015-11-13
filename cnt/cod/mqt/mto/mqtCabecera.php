<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Capa Cabecera de Mantenimiento
 */
?>
<div id="mto_cabecera">
	<h1><?=$ses->getUsuario('nombre')?><br/>Gestión de contenidos</h1>
	<div id="panel">
		<a href="<?=$ses->link('salir')?>" class="out opt" title="salir"></a>
		<span title="añadir contenido" class="add opt">
			<div class="insert">
			<?php 
			if($ses->getId()==0){
				$idBloques = explode(',',$vista->getIdBloques());
				foreach($idBloques as $idEstilo){
					if($idEstilo < 70){
						if($ses->getUsuario('super')==1 || $idEstilo>20){?>
						<a href="javascript:insertaContenido('<?=$idEstilo?>')"><?=$vista->getBloque($idEstilo)->getNombre()?></a>
						<?php
						}
					}
				}
			}else if($ses->getUsuario('super')==1 || $ses->getUsuario('usuario')==$autor){				
				if(count($desarrollos)==0){?>
					<a href="javascript:insertaDesarrollo('desarrollo')">Texto de desarrollo</a>
					<?php 
				}?>
				<a href="javascript:insertaDesarrollo('galeria')">Foto de Galería</a>
				<a href="javascript:insertaDesarrollo('evento')">Evento</a>
				<a href="javascript:insertaDesarrollo('adjunto')">Archivo adjunto</a>
				<a href="javascript:insertaDesarrollo('link')">Enlace relacionado</a>
				<a href="javascript:insertaDesarrollo('relacion')">Contenido relacionado</a>
				<a href="javascript:insertaDesarrollo('etiqueta')">Etiqueta</a>
				<?php 
			}?>
			</div>
		</span>
		<?php 
		if($ses->vistaPrevia()){?>
		<a href="<?=$ses->link('vp=0')?>" class="up opt" title="mostrar todo"></a>
		<?php 
		}else{?>
		<a href="<?=$ses->link('vp=1')?>" class="down opt" title="vista previa"></a>
		<?php 		
		}?>
		<span id="perfil" title="modificar perfil" class="usr opt" data-usuario="<?=$ses->getUsuario('usuario')?>" data-super="<?=$ses->getUsuario('super')==1?'si':'no'?>"></span>		
		<?php 
		require_once('cod/mqt/mto/frmUsuario.php');?>
		<span id="resultado" class="mensaje"><?=$ses->getResultado()?></span>
	</div>
</div>
<div id="dialogo" data-carpeta="<?=$ses->getCarpeta()?>">
	<?php
	if($ses->getSeccion()=='desarrollo'){
		require_once('cod/mqt/mto/frmCtrlDesarrollo.php');
	}
	require_once('cod/mqt/mto/frmCtrl.php');?>
</div>
<form id="mto" method="post">
<input type="hidden" name="op" value=""/>
<input type="hidden" name="id" value="<?=$ses->getId()?>"/>
</form>