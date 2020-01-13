<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];

$base64Image = WS::JSONPOST("imagen");


try{
    $base64Image = trim($base64Image);
    $base64Image = str_replace('data:image/png;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/jpg;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/jpeg;base64,', '', $base64Image);
    $base64Image = str_replace('data:image/gif;base64,', '', $base64Image);
    $base64Image = str_replace(' ', '+', $base64Image);
    $imageData = base64_decode($base64Image);
    file_put_contents($ruta_imagenes.$idpersona.".jpg", $imageData);
    echo json_encode( CRespuestaWs::mostrar(true, "Imagen guardada!"));
}catch (Exception $ex){
    echo json_encode(CRespuestaWs::mostrar(false, "Error al guardar la imagen!"));
}
