<?php


class LPersona
{

    function buscarRutina($idpersona){
        $dPersonaRutina = new DPersonaRutina();
        $rutina = $dPersonaRutina->buscarRutina($idpersona);
        return $rutina;
    }

    function buscarPersonaDatos($idpersona){
        $dPersona = new DPersona();
        $persona =  $dPersona->buscarPersonaID($idpersona);
        $medidas = $dPersona->buscarMedidasControles($idpersona);
        $dPersonaRutina = new DPersonaRutina();
        $dPersonaPreferencia = new DPersonaPreferencia();
        $rutina = $dPersonaRutina->buscarRutina($idpersona);
        $preferencia = $dPersonaPreferencia->buscarPreferencia($idpersona);
        $persona["medidas"] = $medidas;
        $persona["rutina"] = $rutina;
        $persona["preferencia"] = $preferencia;
        return ["datos"=> $persona];
    }

    function registrarRutina($clsPersonaRutina){
        $dPersonaRutina = new DPersonaRutina();
        return $dPersonaRutina->registrarRutina($clsPersonaRutina);
    }
    function buscarPreferencia($idpersona){
        $dPersonaPreferencia = new DPersonaPreferencia();
        return $dPersonaPreferencia->buscarPreferencia($idpersona);
    }

    function registrarPreferencia($clsPersonaPreferencua){
        $dPersonaPreferencia = new DPersonaPreferencia();
        return $dPersonaPreferencia->registrarPreferencia($clsPersonaPreferencua);
    }

}