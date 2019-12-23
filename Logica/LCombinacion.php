<?php


class LCombinacion
{
    function registrarCombinacion($combinacion){
        $dCombinacion = new DCombinacion();
        return $dCombinacion->registrar($combinacion);
    }
    function registrarCombinacionDetalle($combinacionDetalle){
        $dCombinacionDetalle = new DCombinacionDetalle();
        return $dCombinacionDetalle->registrar($combinacionDetalle);
    }
}