<?php


class DCombinacionDetalle
{
    public function registrar($clsCombinacionDetalle){
        /** @var CCombinacionDetalle $clsCombinacionDetalle */
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO tbl_combinacion_detalle (idcombinacion, idrecomendacion,kcal, cantidad) VALUES (?,?,?,?)";
        $conexion->prepare($sql)->execute([$clsCombinacionDetalle->idcombinacion, $clsCombinacionDetalle->idrecomendacion,
            $clsCombinacionDetalle->kcalTotal, $clsCombinacionDetalle->cant ]);
    }
}