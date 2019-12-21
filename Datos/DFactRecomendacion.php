<?php


class DFactRecomendacion
{
    public function cargarHechos(){
        $conexion = DConexion::Instance();
        $sql = "TRUNCATE fact_recomendacion;
                INSERT INTO fact_recomendacion (idproducto, idhorario, maximo, obligatorio)
                SELECT p.id AS idproducto, h.id AS idhorario, ht.maximo, ht.obligatorio FROM dim_producto p 
                INNER JOIN dim_tipo t ON p.idtipo = t.id
                INNER JOIN dim_horario_producto_restriccion hp ON hp.idproducto = p.id
                INNER JOIN dim_horario h ON h.id = hp.idhorario
                INNER JOIN dim_horario_tipo_restriccion ht ON ht.idtipo = t.id AND ht.idhorario = h.id
                WHERE hp.consumir = 1 AND ht.maximo >0 
                order by h.id , t.id, ht.obligatorio DESC;";
        $conexion->prepare($sql)->execute();
    }
}