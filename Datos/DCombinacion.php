<?php


class DCombinacion
{
    public function registrar($clsCombinacion){
        /** @var CCombinacion $clsCombinacion */
        $conexion = DConexion::Instance();
        $sql = 'INSERT INTO tbl_combinacion(idpersona, kcaltotal, fecha, idhorario)  VALUES (?,?,?,?)';
        try {
            $st =$conexion->prepare($sql);
            $conexion->beginTransaction();
            $st->execute(array($clsCombinacion->idpersona, $clsCombinacion->kcalTotal, $clsCombinacion->fecha,
                $clsCombinacion->idhorario));
            $idcombinacion = $conexion->lastInsertId();
            $conexion->commit();
            return [ 'success'=> true, 'message'=>'Registrado Correctamente', 'idcombinacion'=> $idcombinacion];
        } catch(PDOException $exception) {
            $conexion->rollback();
            return [ 'success'=> false , 'message'=> $exception->getMessage()];
        }
    }
}