<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 *
 * Controlador para el mantenimiento de la base de datos.
 */

/* Códigos de Tablas y Operaciones */
$opTablas = Array(
		'contenidos'=>11,
		'usuarios'=>13,
		'estilos'=>17,
		'desarrollos'=>19,
		'documentos'=>23,
		'enlaces'=>29,
		'etiquetas'=>31,
		'eventos'=>37,
		'fotos'=>41,
		'relacionados'=>43 );
$opAccion = Array(
		'inserta'=>2,
		'borra'=>3,
		'actualiza'=>5 );

/* Ejecuta Transacción */
try{
	$bd->iniciaTransaccion();
	// Construye Objeto.
	$obj = null;
	/**
	 *  Operaciones especiales.*/
	// Inserción de Contenido con un Estilo determinado.
	if ($ses->getOperacion()==34){
		require_once('cod/mod/cont.php');
		require_once('cod/mod/vinculada.php');
		$obj = new Cont();
		$obj->insert();
		$idContenido = $obj->getId();
		$obj= null;
		$obj = new Vinculada('contenidos_estilos', $idContenido);
		$obj->inserta(Array('id_bloque'=>$_POST['id']));
	}else{
	/**
	 * Operaciones estándar. */
		foreach ($opTablas as $tabla=>$codTabla){
			if($ses->getOperacion()%$codTabla==0){
				switch ($codTabla){
				case 11: // Contenidos. Se inserta cuando se inserta un estilo.
					require_once('cod/mod/cont.php');
					$obj = new Cont();
					break;
				case 13: // Usuarios
					require_once('cod/mod/usuario.php');
					$obj = new Usuario();
					break;
				case 17: // Estilos
				case 19: // Texto desarrollado
				case 23: // Documento adjunto
				case 29: // Enlaces
				case 31: // Etiquetas
				case 37: // Eventos
				case 41: // Fotos
				case 43: // Contenidos relacionados
					require_once('cod/mod/vinculada.php');
					$obj = new Vinculada('contenidos_'.$tabla,$_POST['id']);
					break;
				}
				break;
			}
		}
		if ($obj!=null){
			foreach ($opAccion as $operacion=>$codOperacion){
				if($ses->getOperacion()%$codOperacion==0){
					switch ($codOperacion){
					case 2: // Insert
						switch ($ses->getOperacion()){
						case 38: //'desarrollos':
							$obj->inserta(Array('desarrollo'=>'Escriba aqu&iacute; el texto desarrollado'));
							break;
						case 46: //'documentos':
							$obj->inserta(Array(
								'titulo'=>'T&iacute;tulo del documento',
								'descripcion'=>'descripci&oacute;n del documento',
								'documento'=>'prueba.pdf'));
							break;
						case 58: //'enlaces':
							$obj->inserta(Array(			
								'nombre'=>'Título del enlace',
								'enlace'=>'http://www.cnt.es',
								'target'=>'1'));
							break;
						case 62: //'etiquetas':
							$obj->inserta(Array('nombre'=>'Nombre de la etiqueta'));
							break;
						case 74: //'eventos':
							$obj->inserta(Array(
								'descripcion'=>'descripci&oacute;n del evento',
								'fecha_inicio'=>(date("Y")."-".date("m")."-".date("d")." ".date("H").":".date("i").":".date("s")),
								'lugar'=>'lugar donde se producir&aacute; el evento',
								'localidad'=>'localidad donde se producir&aacute; el evento'));
							break;
						case 82: //'fotos':
							$obj->inserta(Array('descripcion'=>'descripci&oacute;n de la im&aacute;gen','imagen'=>'insert.jpg'));
							break;
						case 86: //'relacionados':
							$obj->inserta(Array('titulo'=>'Título contenido relacionado'));
							break;
						case 26: //usuarios
							$obj->insert();
							break;
						}
						break;
					case 3: // Delete
						$obj->delete($_POST['id']);
						break;
					case 5: // Update
						switch ($ses->getOperacion()){
						case 65: //'usuarios':
							$obj->update($_POST['id_usuario'],'usuario',$_POST['usuario']);
							$obj->update($_POST['id_usuario'],'nombre',$_POST['nombre']);
							$obj->update($_POST['id_usuario'],'email',$_POST['email']);
							$obj->update($_POST['id_usuario'],'super',isset($_POST['super'])?'1':'0');
							$obj->update($_POST['id_usuario'],'bloqueado',isset($_POST['bloqueado'])?'1':'0');
							if ($_POST['password']==$_POST['repassword']){
								$obj->update($_POST['id_usuario'],'password',md5($_POST['password']));
							}
							if ($_POST['id_usuario']==$ses->getUsuario('id')){
								$obj = new Usuario($ses->getUsuario('id'));
								$ses->setUsuario($obj->getCampos());
							}
							break;
						case 85: //'estilos':
							$obj->borraIdContenido();
							foreach($_POST['estilo'] as $idEstilo=>$valor){
								$obj->inserta(Array('id_bloque'=>$idEstilo));
							}
							break;
						default:
							$obj->update($_POST['id'],$_POST['campo'],$_POST['valor']);
						}
						break;
					default:
						throw new PDOException('Operación desconocida:'.$ses->getOperacion());
					}
					break;
				}
			}
		}else{
			throw new PDOException('Operación no admitida:'.$ses->getOperacion());
		}
	}
	$bd->commit();
	$ses->setResultado("Ok");
}catch(PDOException $e){
	$ses->setResultado($bd->getErrNo().':'.$bd->getError());
	$bd->rollback();
}/*finally{
	$obj=null;
	$bd->limpia();
}*/?>