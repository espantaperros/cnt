<?php
/**
 *
 * Desarrollado por Myra
 * 20/5/2010
 *
 * Presentación de archivos en el módulo archivero.
 */
 $entradas = $arch->relacionaArchivos();?>
<ul>
<?php 
foreach($entradas as $descripcion=>$title){?>
	<li data-file="<?=$descripcion?>" title="<?=$title?>"<?=$descripcion==$ses->getArchivo()?' class="selected"':''?>><?=$descripcion?></li>
<?
}?>
</ul>