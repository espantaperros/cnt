<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Agenda
 */
global $agendaIdContenido,$agendaFecha,$ses;
require_once('cod/lib/util.php');
if($agendaIdContenido!=$contenido_id){
	$agendaFecha='';
	if ($agendaIdContenido!=''){?>
		</span>
		<?php
	}
	$agendaIdContenido=$contenido_id;?>
	<p class="agenda_fecha"><?=$contenido_titulo?></p>
	<span class="inter_agenda">
<?php 
}
if($agendaFecha!=txtFecha($fecha_inicio)){
	$agendaFecha = txtFecha($fecha_inicio);?>
	<span class="agenda_date"><?=txtFecha($fecha_inicio)?></span>
<?php 
}
$link = $ses->link('portada',$contenido_id,$contenido_titulo);?>
<a href="<?=$link?>" class="agenda_hora"><?=txtHora($fecha_inicio).($fecha_final==''?'':' a'.txtHora($fecha_final))?> 
<span class="agenda_titulo"><?=$titulo?></span></a>
<?php		
if($lugar!=''){?>
	<span class="agenda_lugar">en <?=$lugar?></span>
<?
}
if($localidad!=''){?>
	<span class="agenda_localidad">de <?=$localidad?></span>
<?
}?><br/>
<?php 
if($descripcion!=''){?>
	<span class="agenda_descripcion"><?=nl2br($descripcion)?></span>
<?php 
}?><br/>