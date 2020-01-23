<?php
include_once '../Clases/imports.php';
include_once '../Datos/imports.php';
include_once '../Logica/imports.php';
date_default_timezone_set('America/Lima');

Class WS
{

    static function variableNombre($var, $scope = 0)
    {
        $old = $var;
        if (($key = array_search($var = 'unique' . rand() . 'value', !$scope ? $GLOBALS : $scope)) && $var = $old) return $key;
    }

    static function POST($campo, $validar = true)
    {
        if (isset($_POST[$campo]) or !$validar)
            return isset($_POST[$campo]) ? $_POST[$campo] : null;
        exit(json_encode(["success" => false, "code" => 403, "message" => "El campo $campo no existe"]));
    }

    static function JSONPOST($campo, $validar = true)
    {
        $data = json_decode(file_get_contents('php://input'), true);
        if (isset($data[$campo]) or !$validar)
            return isset($data[$campo]) ? $data[$campo] : null;
        exit(json_encode(["success" => false, "code" => 403, "message" => "El campo $campo no existe"]));
    }


    static function validarToken()
    {
        $headers = getallheaders();
        if (!isset($headers["TOKEN"])) exit(json_encode(["success" => false, "code" => 403, "message" => "No incluye el token"]));
        $token = $headers["TOKEN"];
        $dPersona = new DPersona();
        $data = $dPersona->validarToken($token);
        if ($data === false) {
            exit(json_encode(["success" => false, "code" => 403, "message" => "El token no es válido"]));
        }
        return $data;
    }
}
