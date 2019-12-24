<?php

include_once 'validaciones.php';

$data = WS::validarToken();
$idpersona = $data["idpersona"];

$lPersona = new LPersona();
$lista = $lPersona->buscarMedidas($idpersona);

if($lista != null){

    echo json_encode(CRespuestaWs::mostrar(true, "", ["medidas"=> $lista] ));
}
else{
    echo json_encode(CRespuestaWs::mostrar(false, "No tiene medidas registradas" ));

}