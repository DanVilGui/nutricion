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
}