<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
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