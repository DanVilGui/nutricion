<?php

include_once 'validaciones.php';
use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\SMTP;
$emailEnvio = WS::JSONPOST("correo");

$codigo = WS::JSONPOST("codigo",false);
$contrasenia = WS::JSONPOST("pass",false);


$correo = 'adidas29019@gmail.com';
$pass = 'aplicacion2020';
$randomNumber = rand(100000,999999);
$tit = "Nutrilife: Recuperación de contraseña $randomNumber";
$msg = "Su código de recuperación es :  <b> $randomNumber </b>";

$fecha_hoy = CFecha::hoy();
$fecha = CFecha::formatFechaHoraBD($fecha_hoy);

$lPersona = new LPersona();
$rs = $lPersona->validarEnvioRecuperacion($emailEnvio);
if($rs === false){
    exit(json_encode(CRespuestaWs::mostrar(false, "Correo eléctronico no encontrado!")));
}

$codigo_rec = isset($rs["codigorecuperacion"]) ??  $rs["codigorecuperacion"];

if($contrasenia!=null && $codigo != null){
    if($codigo == $codigo_rec ){
        //cambio de contraseña
        $lPersona->cambiarPassRecuperar($codigo, $contrasenia, $emailEnvio );
        exit(json_encode(CRespuestaWs::mostrar(true, "Contraseña cambiada!")));
    }else{
        exit(json_encode(CRespuestaWs::mostrar(false, "Código incorrecto!")));
    }
}

if( $rs["codigorecuperacion"]!=null){
    $codigo_rec = $rs["codigorecuperacion"];
    $fecha_rec = $rs["fecharecuperacion"];
    $fecha_recuperacion = DateTime::createFromFormat(CFecha::FORMATO_DATETIME, $fecha_rec);
    $dif = $fecha_hoy->diff($fecha_recuperacion);
    $minutes = $dif->days * 24 * 60;
    $minutes += $dif->h * 60;
    $minutes += $dif->i;
    if( $minutes<5){
        $min = 5 - $minutes;
        exit(json_encode(CRespuestaWs::mostrar(false, "Ya ha solicitado un código,revise su correo electrónico ,espere $min  minutos para solicitar otro . ")));
    }
}




$mail = new PHPMailer;
$mail->IsSMTP();
$mail->SMTPOptions = array(
    'ssl' => array(
        'verify_peer' => false,
        'verify_peer_name' => false,
        'allow_self_signed' => true
    )
);
$mail->SMTPDebug = 0;
$mail->SMTPAuth = true;
$mail->SMTPSecure = 'tsl';
$mail->Host = "smtp.gmail.com";
$mail->Port = 587;
$mail->IsHTML(true);
$mail->CharSet  ="utf-8";
$mail->Username = $correo;
$mail->Password = $pass;
$mail->SetFrom($correo, "Nutrilife");
$mail->AddAddress($emailEnvio);
$mail->Subject = $tit;
$mail->Body = $msg;


if (!$mail->send()) {
    echo $mail->ErrorInfo;
    echo json_encode( CRespuestaWs::mostrar(false, "Error al enviar el código de recuperación"));

} else {
    $lPersona->cambiarCodigoRecuperacion($randomNumber, $fecha, $emailEnvio);
    echo json_encode( CRespuestaWs::mostrar(true, "Codigo enviado, revise su correo electrónico"));
}