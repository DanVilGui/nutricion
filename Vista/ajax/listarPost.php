<?php
$title = "Nutrilife";
include_once '../../Clases/imports.php';
include_once '../../Datos/imports.php';
include_once '../../Logica/imports.php';
$titulo = $_POST["titulo"];
$lPost = new LPost();
$posts = $lPost->listarPosts($titulo);

echo json_encode( ["data"=> $posts]);