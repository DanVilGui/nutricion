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
        $sql = "SELECT  distinct t.id AS idtipo, t.alias AS tipo, fr.maximo,fr.obligatorio FROM fact_recomendacion fr
                INNER JOIN dim_producto p  ON fr.idproducto = p.id
                INNER JOIN dim_horario h ON  fr.idhorario = h.id
                INNER JOIN dim_tipo t ON p.idtipo = t.id
                WHERE idhorario = ?
                order by h.id ,fr.obligatorio DESC, t.id";
        $st =$conexion->prepare($sql);
        $st->execute([$idhorario]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }


    public function buscarProductosHorarios($idhorario){
        $conexion = DConexion::Instance();
        $sql = "SELECT fr.id,fr.idproducto, p.nombre ,p.medida, kcal,h.id AS idhorario, h.alias AS horario, h.porcentaje,
                 t.id AS idtipo, t.alias AS tipo,fr.obligatorio, fr.maximo FROM fact_recomendacion fr
                INNER JOIN dim_producto p  ON fr.idproducto = p.id
                INNER JOIN dim_horario h ON  fr.idhorario = h.id
                INNER JOIN dim_tipo t ON p.idtipo = t.id
                where fr.idhorario = ?
                order by h.id ,fr.obligatorio DESC, t.id";
        $st =$conexion->prepare($sql);
        $st->execute([$idhorario]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
}
