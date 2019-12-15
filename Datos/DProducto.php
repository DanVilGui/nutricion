<?php


class DProducto
{


    public function limpiar(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE TABLE dim_producto";
        $conexion->prepare($sql)->execute();
    }
    public function registrar($cProducto){
        $conexion = DConexion::Instance();
        $sql = "INSERT INTO dim_producto (id,  nombre, medida, kcal, idtipo) VALUES (?,?,?,?,?)";
        $conexion->prepare($sql)->execute([$cProducto->id, $cProducto->nombre, $cProducto->medida, $cProducto->kcal,
            $cProducto->idtipo]);
    }

    public function buscarDisponibles(){
        $conexion = DConexion::Instance();
        $sql = "select * from productos_buscar";
        $st =$conexion->prepare($sql);
        $st->execute();
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function buscarHorarioTipoProductos($idhorario){
        $conexion = DConexion::Instance();
        $sql = "SELECT DISTINCT  idtipo, tipo, maximo, obligatorio from productos_buscar where idhorario = ? order by obligatorio desc ";
        $st =$conexion->prepare($sql);
        $st->execute([$idhorario]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function buscarProductoHorarioTipo($idhorario, $idtipo,$maxKCal){
        $conexion = DConexion::Instance();
        $sql = "SELECT * from productos_buscar p
                where idhorario = ? AND idtipo = ?
                and kcal < ?
                ORDER BY RAND() LIMIT 1;";
        $st =$conexion->prepare($sql);
        $st->execute([$idhorario, $idtipo, $maxKCal]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function buscarProductosHorarios($idhorario){
        $conexion = DConexion::Instance();
        $sql = "SELECT * from productos_buscar p
                where idhorario = ?;";
        $st =$conexion->prepare($sql);
        $st->execute([$idhorario]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
