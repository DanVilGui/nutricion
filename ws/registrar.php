<?php
include_once 'validaciones.php';

$nombres = WS::JSONPOST("nombres");
$apellidos = WS::JSONPOST("apellidos");
$correo = WS::JSONPOST("correo");
$idlogin_tipo = WS::JSONPOST('idlogin_tipo');

if($idlogin_tipo == 1){
    $contrasenia = WS::JSONPOST("contrasenia");
}else{
    $contrasenia = WS::JSONPOST("contrasenia",false);
}
$clsPersona = new CPersona();
$clsPersona->setNombres( $nombres);
$clsPersona->setApellidos($apellidos);
$clsPersona->setCorreo($correo);
$clsPersona->setContrasenia($contrasenia);
$clsPersona->setIdloginTipo($idlogin_tipo);
$dPersona = new DPersona();
$respuesta = $dPersona->registrarPesona($clsPersona);
$idpersona = null;
if(isset($respuesta["success"])) {
    //error
    if(!$respuesta["success"]) exit (json_encode($respuesta));
    //ok
    $idpersona = $respuesta["idpersona"];
    if($idlogin_tipo!=1){
        $lPersona  = new LPersona();
        $res =  $lPersona->buscarPersonaDatos($idpersona);
        echo json_encode( CRespuestaWs::mostrar(true, "Registrado correctamente", $res));

    }else{
        echo json_encode(CRespuestaWs::mostrar(true, "Registrado correctamente"));
    }
}else{
    //ya existe
    $rptidlogin_tipo = $respuesta["idlogin_tipo"];
    $login_tipo = $respuesta["login_tipo"];
    if($login_tipo =="NATIVO" or $rptidlogin_tipo != $clsPersona->getIdloginTipo()){
        $message = "";
        switch ($rptidlogin_tipo){
            case 2: $message = "Este ya se encuentra registrado con FACEBOOK";break;
            case 3: $message = "Este ya se encuentra registrado con GOOGLE";break;
            case 1: $message = "Este ya se encuentra registrado, ingrese con su correo y contraseña.";break;
        }
        echo json_encode(CRespuestaWs::mostrar(false, $message));
    }else{
        $idpersona = $respuesta["idpersona"];
        $lPersona  = new LPersona();
        $res =  $lPersona->buscarPersonaDatos($idpersona);
        echo json_encode( CRespuestaWs::mostrar(true, "Bienvenido!", $res));
    }
}


