<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Bloque de la relación para elementos encontrados
 * en una búsqueda interactiva
 * 
 * */
if ($resultado!=false){
	foreach($resultado as $item){
		if (isset($_GET['usuario'])){?>
		<span id="user_select_<?=$item['id']?>" data-iditem="<?=$item['id']?>" data-user_id="<?=$item['id']?>" data-user_usuario="<?=$item['usuario']?>" data-user_password="<?=$item['password']?>" data-user_nombre="<?=$item['nombre']?>" data-user_email="<?=$item['email']?>" data-user_super="<?=$item['super']?>" data-user_bloqueado="<?=$item['bloqueado']?>"><?=$item['nombre']?></span>
		<?php 
		}else if (isset($_GET['etiqueta'])){?>
		<span data-iditem="<?=$item['nombre']?>" data-nombre="<?=$item['nombre']?>"><?=$item['nombre']?></span>
		<?php 
		}else if (isset($_GET['relacion'])){?>
		<span data-iditem="<?=$item['id']?>" data-id_relacion="<?=$item['id']?>" data-titulo_relacion="<?=$item['titulo']?>"><?=$item['titulo']?></span>
		<?php 
		}
	}
}?>