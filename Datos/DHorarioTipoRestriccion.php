<?php


class DHorarioTipoRestriccion
{


    public function limpiar(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE TABLE dim_horario_tipo_restriccion";
        $conexion->prepare($sql)->execute();
    }
    public function registrar($cHorarioTipoRestricion){
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO dim_horario_tipo_restriccion (idtipo, idhorario, maximo,obligatorio) VALUES (?,?,?,?)";
        $conexion->prepare($sql)->execute([$cHorarioTipoRestricion->idtipo, $cHorarioTipoRestricion->idhorario,
            $cHorarioTipoRestricion->maximo,$cHorarioTipoRestricion->obligatorio]);
    }


}