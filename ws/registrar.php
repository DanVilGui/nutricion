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
        $persona =  $dPersona->buscarPersonaID($idpersona);
        $medidas = $dPersona->buscarMedidasControles($idpersona);
        echo json_encode( CRespuestaWs::mostrar(true, "Registrado correctamente",
            ["datos"=> $persona,"medidas"=> $medidas]));

    }else{
        echo json_encode(CRespuestaWs::mostrar(true, "Registrado correctamente"));
    }
}else{
    //ya existe
    $rptidlogin_tipo = $respuesta["idlogin_tipo"];
    $login_tipo = $respuesta["login_tipo"];
    if($login_tipo =="NATIVO" or $rptidlogin_tipo != $clsPersona->getIdloginTipo()){
        switch ($login_tipo){
            case "FACEBOOK": $message = "Este ya se encuentra registrado con FACEBOOK";break;
            case "GOOGLE": $message = "Este ya se encuentra registrado con GOOGLE";break;
            case "NATIVO": $message = "Este ya se encuentra registrado, ingrese con su correo y contraseña.";break;
        }
        echo json_encode(CRespuestaWs::mostrar(false, $message));
    }else{
        $idpersona = $respuesta["idpersona"];
        $persona =  $dPersona->buscarPersonaID($idpersona);
        $medidas = $dPersona->buscarMedidasControles($idpersona);
        echo json_encode( CRespuestaWs::mostrar(true, "Registrado correctamente",
            ["datos"=> $persona,"medidas"=> $medidas]));
    }
}


