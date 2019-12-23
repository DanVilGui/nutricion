<?php


class CFecha
{
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
    static  function agregarDia($datetime, $cantDias){

        $datetime->modify("+$cantDias day");
        return $datetime;
    }
}