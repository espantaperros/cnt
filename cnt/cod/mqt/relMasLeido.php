<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 25/03/2014 *
 * 
 * Cuerpo: Agenda
 */
global $ses;
$link='';
if ($enlace==''){
	$link = $ses->link('portada',$id,$titulo);
}else{
	$link = $enlace;
}?>
<a href="<?=$link?>"><?=$titulo?></a>