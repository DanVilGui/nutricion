<?php

class DDieta{
    public function registrar($cDieta){
        /** @var CDieta $cDieta */
        $conexion = DConexion::Instance();
        $sql = 'INSERT INTO tbl_dieta( idpersona,fecha, asignado, fecharegistro)  VALUES (?,?,?, ?)';
        try {
            $st =$conexion->prepare($sql);
            $conexion->beginTransaction();
            $st->execute(array($cDieta->idpersona, $cDieta->fecha, $cDieta->asignado, $cDieta->fecharegistro));
            $iddieta = $conexion->lastInsertId();
            $conexion->commit();
            return [ 'success'=> true, 'message'=>'Registrado Correctamente', 'iddieta'=> $iddieta];
        } catch(PDOException $exception) {
            $conexion->rollback();
            return [ 'success'=> false , 'message'=> $exception->getMessage()];
        }
    }

    public function borrarDietasAntiguas($idpersona, $fecha){
        $conexion = DConexion::Instance();
        $sql = "delete  FROM tbl_dieta WHERE idpersona = ? and fecharegistro < ? AND date(fecha) >= DATE( ? );";
        $conexion->prepare($sql)->execute([$idpersona, $fecha, $fecha]);
    }

    public function buscarDietaPersonaFecha($idpersona,$fecha){
        $conexion = DConexion::Instance();
        $sql = "select
                       dp.nombre as producto, tc.idhorario, dh.nombre as horario,tcd.kcal,
                       tcd.cantidad, dp.medida, fecha  from tbl_dieta td
                inner join tbl_combinacion tc on td.iddieta = tc.iddieta
                inner join tbl_combinacion_detalle tcd on tc.idcombinacion = tcd.idcombinacion
                inner join fact_recomendacion fr on tcd.idrecomendacion = fr.id
                inner join dim_producto dp on fr.idproducto = dp.id
                inner join dim_horario dh on tc.idhorario = dh.id
                where td.idpersona = ? and date(td.fecha) = ?;";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona, $fecha]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}