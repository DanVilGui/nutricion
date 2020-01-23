<?php
include_once 'validaciones.php';
if(isset($_GET["f"])) {
    $file = $_GET["f"];
    $ruta = $ruta_imagenes . "posts/$file";
    $c = file_get_contents($ruta, true);
    $size = filesize($ruta);
    header('Content-Type: image/x-icon');
    header("Content-length: $size");
    echo $c;
}