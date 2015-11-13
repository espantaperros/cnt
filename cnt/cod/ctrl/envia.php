<?php
/**
 *
 * Desarrollado por Myra
 * para CNT Extremadura
 * 1/5/2015 *
 * 
 * Envia el formulario que sea.
 *
 */

$error=false;
$txtError='';

if (isset($_POST['enviar'])){
	// Array de campos erróneos.
	$camposErroneos = array();

	// Detecta campo oculto de tipo de formulario.
	if(!isset($_POST['formulario'])){
		$txtError= "La consulta enviada es sospechosa";
	//Chequea código captcha para evitar spam.
	}elseif(!$_POST['imagetext']) {
		$camposErroneos['imagetext'] = "Por favor, copia de la imagen el código antispam";
	    $txtError= "Por favor, copia de la imagen el c&oacute;digo antispam";
	}else{
	    include_once("cod/lib/captcha/securimage.php");
	    $img = new Securimage();
	    if(!$img->check($_POST['imagetext'])) {
			$camposErroneos['imagetext'] = "C&oacute;digo antispam incorrecto";
	    	$txtError= "C&oacute;digo antispam incorrecto";
		}
	}
	if ($_POST['nombre']==''){
		$camposErroneos['nombre'] = "Tenemos información sin rellenar";
	    $txtError= "Por favor, escribe tu nombre";
	}
	if (!emailValido($_POST['email'])){
		$camposErroneos['email'] = "Email incorrecto";
		$txtError= "Escribe correctamente tu correo electr&oacute;nico";
	}
	if ($_POST['formulario']=='consulta' and $_POST['asunto']==''){
		$camposErroneos['asunto'] = "Tenemos información sin rellenar";
	    $txtError= "No has escrito nada en el asunto";
	}
	if ($_POST['formulario']=='consulta' and $_POST['mensaje']==''){
		$camposErroneos['mensaje'] = "Tenemos información sin rellenar";
	    $txtError= "No has escrito nada en el mensaje";
	}
	if($txtError==''){
		$txtMensaje="";
		switch ($_POST['formulario']){
			case 'consulta':
				// Construye el mensaje.
				$txtMensaje = "Nombre y Apellidos: ".$_POST['nombre']."<br/>".
						"Correo electrónico: ".$_POST['email']."<br/>".
						"Mensaje.-<br/>".$_POST['mensaje'];
				$asunto = 'Contacto: '.$_POST['asunto'];
				$destinatario='';
				break;
			default:
				$txtError = "El formulario enviado es sospechoso";
				$txtMensaje = "Se ha enviado un correo sospechoso desde la IP: ".getIP();
				break;
		}
	}
	if($txtError==""){
		// Manda el correo.
		require_once("cod/lib/phpmailer/class.phpmailer.php");
		$txtMensaje = chequeaMensaje($txtMensaje);
		$txtError=enviaCorreo($destinatario,$txtMensaje,$asunto);
		if ($txtError=="1"){
			$txtError = "Mensaje enviado correctamente";
		}
	}else{
		$error=true;
	}
}
function chequeaMensaje($mensaje){
	$mensaje = preg_replace("/\nfrom\:.*?\n/i", "", $mensaje);
	$mensaje = preg_replace("/\nbcc\:.*?\n/i", "", $mensaje);
	$mensaje = preg_replace("/\ncc\:.*?\n/i", "", $mensaje);
	return $mensaje;
}
function emailValido($email){
    $mail_correcto = 0;
    //priemro compruebo unas cosas
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) {
          //miro si tiene caracter .
          if (substr_count($email,".")>= 1){
             //obtengo la terminacion del dominio
             $term_dom = substr(strrchr ($email, '.'),1);
             //compruebo que la terminación del dominio sea correcta
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){
                //compruebo que lo de antes del dominio sea correcto
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1);
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1);
                if ($caracter_ult != "@" && $caracter_ult != "."){
                   $mail_correcto = 1;
                }
             }
          }
       }
    }
    if ($mail_correcto)
       return 1;
    else
       return 0;
}
function enviaCorreo($destinatario,$mensaje,$asunto){
	require_once "cod/lib/phpmailer/class.phpmailer.php";	
	$mail = new phpmailer();
	$mail->PluginDir = "";
	$mail->SetLanguage("es");
	$mail->IsSMTP();
	$mail->Host = "localhost";
	$mail->SMTPAuth = true;
	$mail->Username = "web@extremadura.cnt.es";
	$mail->Password = "webextremadura";
	$mail -> IsHTML (true);
	$mail->From = "web@extremadura.cnt.es";
	$mail->FromName = "CNT Extremadura - Contacto WEB";
	$mail->Timeout=600;
	$mail->AddAddress("web@extremadura.cnt.es");
	if($destinatario!='') $mail->AddAddress($destinatario);
	$mail->FromName = DENO_WEB;
	$mail->Subject = DENO_WEB." - ".$asunto;
	$mail->Body = $mensaje;
	$mail->AltBody = $mensaje;
	if ($mail->Send()){
		return true;
	}else{
		return $mail->ErrorInfo;
	}
}
function getIP(){
	if (getenv("HTTP_CLIENT_IP") && strcasecmp(getenv("HTTP_CLIENT_IP"),"unknown")){
		$ip = getenv("HTTP_CLIENT_IP");
	}else if (getenv("HTTP_X_FORWARDED_FOR") && strcasecmp(getenv("HTTP_X_FORWARDED_FOR"), "unknown")){
		$ip = getenv("HTTP_X_FORWARDED_FOR");
	}else if (getenv("REMOTE_ADDR") && strcasecmp(getenv("REMOTE_ADDR"),"unknown")){
		$ip = getenv("REMOTE_ADDR");
	}else if (isset($_SERVER['REMOTE_ADDR']) && $_SERVER['REMOTE_ADDR'] && strcasecmp($_SERVER['REMOTE_ADDR'], "unknown")){
		$ip = $_SERVER['REMOTE_ADDR'];
	}else{
		$ip = "unknown";
	}
   return $ip;
}?>