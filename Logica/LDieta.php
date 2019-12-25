<?php


class LDieta
{


    public function borrarDietasAntiguas($idpersona, $fecha)
    {
        $dDieta = new DDieta();
        return $dDieta->borrarDietasAntiguas($idpersona, $fecha);
    }

    function registrarDieta($dieta)
    {
        $dDieta = new DDieta();
        return $dDieta->registrar($dieta);
    }

    function registrarCombinacion($combinacion)
    {
        $dCombinacion = new DCombinacion();
        return $dCombinacion->registrar($combinacion);
    }

    function registrarCombinacionDetalle($combinacionDetalle)
    {
        $dCombinacionDetalle = new DCombinacionDetalle();
        return $dCombinacionDetalle->registrar($combinacionDetalle);
    }

    public function buscarDietaPersonaFecha($idpersona, $fecha)
    {
        $dDieta = new DDieta();
        return $dDieta->buscarDietaPersonaFecha($idpersona, $fecha);
    }
    public function buscarDietaPersonaInfo($idpersona,$fecha){
        $dDieta = new DDieta();
        return $dDieta->buscarDietaPersonaInfo($idpersona, $fecha);
    }

        public function buscarHorarios(){
        $dHorario = new DHorario();
        return $dHorario->listarHorarios();
    }
}