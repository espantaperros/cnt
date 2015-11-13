<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Cuerpo: Buscador
 */
// Zona derecha.
//require_once('cod/mqt/mqtDerecha.php');
$encontrados= $vista->contenidosEnZona(3);?>
<div id="zona_izquierda">
	<?php 
	if($ses->getBusca()!=''){?>
	<div id="titulo_search">Buscador</div>
	<?php 
	}elseif($ses->getTag()!=''){?>
	<div id="titulo_search">Filtro por etiquetas</div>
	<?php 
	}?>
	<form id="claves" method="post">
		<?php 
		if($ses->getBusca()!=''){?>
		<input type="text" name="search" value="<?=$ses->getBusca()?>"/>
		<?php 
		}elseif($ses->getTag()!=''){?>
		<input type="text" name="tag" value="<?=$ses->getTag()?>"/>
		<?php 
		}?>
		<div id="encontrados"><?=$encontrados?> encontrados</div>
	</form>
	<?php 
 	$vista->pintaZona(3)?>
</div>