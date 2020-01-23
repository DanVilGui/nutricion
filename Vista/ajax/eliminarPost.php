<?php
$title = "Nutrilife";
include_once '../../Clases/imports.php';
include_once '../../Datos/imports.php';
include_once '../../Logica/imports.php';
$id = $_POST["id"];

$lPost = new LPost();
$post = $lPost->eliminarPost($id);
echo json_encode( $post);