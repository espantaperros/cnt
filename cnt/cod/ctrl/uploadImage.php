<?php
/**
 *
 * Desarrollado por Myra
 * 1/08/2014 *
 */
if ($_POST) {
    define('UPLOAD_DIR', 'cont/');
    $img = $_POST['source'];
    $img = str_replace('data:image/jpeg;base64,', '', $img);
    $img = str_replace('data:image/png;base64,', '', $img);
    $img = str_replace('data:image/gif;base64,', '', $img);
    $img = str_replace(' ', '+', $img);
    $data = base64_decode($img);
    $file = UPLOAD_DIR.$ses->getCarpeta().'/'.$ses->getArchivo();
    $success = file_put_contents($file, $data);
    if ($success) echo 'Imágen subida correctamente';
}?>