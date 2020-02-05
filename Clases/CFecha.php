<?php


class CFecha
{
    const DIAS_SEMANA  = [ "Domingo","Lunes", "Martes","Miércoles","Jueves","Viernes","Sábado"];
    const FORMATO_DATETIME = 'Y-m-d H:i:s';
    static function hoy(){
        return new DateTime("now");
    }
    static function fechaHoyBD(){
        $hoy = self::hoy();
        return $hoy->format('Y-m-d');
    }
    static function formatFechaBD($datetime){
        return $datetime->format('Y-m-d');

    }
    static function formatFechaHoraBD($datetime){
        return $datetime->format('Y-m-d H:i:s');
    }



    static function obtenerDiaSemana($datetime){
        return $datetime->format('w');
    }
    static  function esDomingo($datetime){
        $dia = self::obtenerDiaSemana($datetime);
        if (mb_strtoupper( self::DIAS_SEMANA[$dia]) == "DOMINGO")return true;
        return false;
    }

    static  function agregarDia($datetime, $cantDias){
        $clone = clone $datetime;
        $clone->modify("+$cantDias day");
        return $clone;
    }
}