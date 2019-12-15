<?php


class DHorario
{

    public function limpiar(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE TABLE dim_horario";
        $conexion->prepare($sql)->execute();
    }

    public function listarHorarios(){
        $conexion = DConexion::Instance();
        $sql = "select * from dim_horario";
        $st =$conexion->prepare($sql);
        $st->execute();
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function registrar($horario){
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO dim_horario (id, alias, nombre, porcentaje) VALUES (?,?,?,?)";
        $conexion->prepare($sql)->execute([$horario->id, $horario->alias, $horario->nombre, doubleval( $horario->porcentaje)]);
    }
}