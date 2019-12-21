<?php


class CRespuestaWs
{

    static function mostrar($success , $message = "", $array =null, $code = null){
        $respuesta = array();
        $respuesta["success"] = $success;
        $respuesta["message"] = $message;
        $respuesta["code"] = $code;
        if($array!=null){
            foreach ($array as $index => $value){
                $respuesta[$index] = $value;
            }
        }

        return $respuesta;
    }
}