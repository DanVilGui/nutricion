<?php


class DTipoProducto
{


    public function limpiar(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE TABLE dim_tipo";
        $conexion->prepare($sql)->execute();
    }
    public function registrar($cTipo){
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO dim_tipo (id,alias,nombre) VALUES (?,?,?)";
        $conexion->prepare($sql)->execute([$cTipo->id, $cTipo->alias, $cTipo->alias]);
    }
}