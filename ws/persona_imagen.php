<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$ruta = $ruta_imagenes.$idpersona.".jpg";
if (!file_exists($ruta)) {
    $ruta =$ruta_imagenes."sinfoto.png";
}
$c = file_get_contents($ruta,true);
$size = filesize($ruta);
header ('Content-Type: image/x-icon');
header ("Content-length: $size");
echo $c;