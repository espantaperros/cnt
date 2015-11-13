<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Punto de arranque de vistas de la Web;
 *
 */?>

<!DOCTYPE html>
<html>
<head>
	<meta charset="utf-8" />
	<title><?=$vista->getTitle()?></title>
	<link href="cod/img/cnt/favicon.ico" rel="icon" type="image/x-icon" />
	<meta name="viewport" content="width=device-width, initial-scale=1">
	<?php
  	$metas = $vista->getMetas();
  	foreach($metas as $name=>$content){?>
  		<meta name="<?=$name?>" content="<?=$content?>"/>
  	<?php
  	}
  	$metas = $vista->getJavaScripts();?>
  	<script src="//ajax.googleapis.com/ajax/libs/jquery/1.11.1/jquery.min.js"></script>
	<script>window.jQuery || document.write('<script src="cod/lib/js/jquery-1.11.1.min.js">x3C/script>')</script>
	<?php 
  	foreach($metas as $meta=>$name){?>
  		<script type="text/javascript" src="<?=URL_BASE?>/<?=$name?>" charset="utf8"></script>
  	<?php
  	}
  	if($ses->vistaPrivada()){?>
  				<script src="cod/lib/js/jq_mto.js"></script>
  				<script src="cod/lib/js/jq_archivero.js"></script>
  				<script type="text/javascript" src="cod/lib/js/jscalendar/calendar.js"></script>
  				<script type="text/javascript" src="cod/lib/js/jscalendar/lang/calendar-es.js"></script>
  				<script type="text/javascript" src="cod/lib/js/jscalendar/calendar-setup.js"></script>
  				<script type="text/javascript" src="cod/lib/js/tinymce/tinymce.min.js"></script>
  				<script src="<?=URL_BASE?>/cod/lib/js/jq_buscaItem.js"></script>
  		<?php 
	}
	$metas = $vista->getCSSs();
	foreach($metas as $meta=>$name){?>
		<link rel="stylesheet" type="text/css" href="<?=URL_BASE?>/<?=$name?>"/>
	<?php
	}
	if($ses->vistaPrivada()){?>
		<link rel="stylesheet" type="text/css" href="cod/img/mto/mto.css"/>
		<link rel="stylesheet" type="text/css" href="cod/img/mto/archivero.css"/>
  	 	<link rel="stylesheet" type="text/css" media="all" href="cod/lib/js/jscalendar/calendar-system.css" title="system" />
	<?php 	
	}?>
</head>
<body>
	<main id="principal"<?=$ses->vistaPrivada()?(' data-seccion='.$ses->getSeccion()):''?>>
	<?php
	if($ses->vistaPrivada()){
		require_once('cod/mqt/mto/mqtCabecera.php');
	}
	require_once('cod/mqt/mqtCabecera.php');
	require_once('cod/mqt/mqtCuerpo.php');
	require_once('cod/mqt/mqtPie.php');?>
	</main>
</body>
</html>