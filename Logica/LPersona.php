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
        $rutina = $dPersonaRutina->buscarRutina($idpersona);
        return ["datos"=> $persona, "medidas"=>$medidas, "rutina"=> $rutina ];
    }

    function registrarRutina($clsPersonaRutina){
        $dPersonaRutina = new DPersonaRutina();
        return $dPersonaRutina->registrarRutina($clsPersonaRutina);
    }

}