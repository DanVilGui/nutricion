<?php


class LDieta
{


    function registrarDieta($dieta){
        $dDieta = new DDieta();
        return $dDieta->registrar($dieta);
    }
    function registrarCombinacion($combinacion){
        $dCombinacion = new DCombinacion();
        return $dCombinacion->registrar($combinacion);
    }
    function registrarCombinacionDetalle($combinacionDetalle){
        $dCombinacionDetalle = new DCombinacionDetalle();
        return $dCombinacionDetalle->registrar($combinacionDetalle);
    }
}