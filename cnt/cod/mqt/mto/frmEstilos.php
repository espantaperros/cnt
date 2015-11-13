<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de la relación de estilos.
 * 
 **/ 
foreach($estiloSelect as $estilo){?>
	<input type="checkbox" name="estilo[<?=$estilo['id']?>]" <?=($estilo['check']=='1'?"checked":'')?>> <label for="estilo[<?=$estilo['id']?>]"><?=$estilo['nombre']?></label></br>
<?php 	
}?>