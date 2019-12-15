<?php


class DHorarioProductoRestriccion
{


    public function limpiar(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE TABLE dim_horario_producto_restriccion";
        $conexion->prepare($sql)->execute();
    }
    public function registrar($cHorarioProductoRestriccion){
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO dim_horario_producto_restriccion (idhorario, idproducto,consumir) VALUES (?,?,?)";
        $conexion->prepare($sql)->execute([$cHorarioProductoRestriccion->idhorario,
                                    $cHorarioProductoRestriccion->idproducto,
                                    $cHorarioProductoRestriccion->consumir]);
    }
}