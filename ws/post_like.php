<?php

include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$idpost = WS::JSONPOST("idpost");
$like = WS::JSONPOST("like");
$lPost =new LPost();
$resultado = $lPost->cambiarLike($idpost, $idpersona, $like);
echo json_encode($resultado);