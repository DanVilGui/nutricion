<?php


class DPersonaMedida
{

    function buscarUltimaMedida($idpersona){
        $conexion = DConexion::Instance();
        $sql = "select * from tbl_persona_medida where idpersona = ? order by idmedida desc limit 1";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return ($resultado !== false ) ? $resultado : null;
    }


    public function agregarMedida($clsPersonaMedida){
        /** @var CPersonaMedida $clsPersonaMedida */
        $conexion = DConexion::Instance();
        $sql = "insert into tbl_persona_medida(idpersona, peso,medida, cintura,cadera,imc, fecha)
                values (?,?,?,?,?,?,?) ";
        $st =$conexion->prepare($sql);
        $st->execute([$clsPersonaMedida->idpersona, $clsPersonaMedida->peso, $clsPersonaMedida->medida,
            $clsPersonaMedida->cintura, $clsPersonaMedida->cadera, $clsPersonaMedida->imc, $clsPersonaMedida->fecha]);
        $rows = $st->rowCount();
        if($rows>0) return true;
        else return false;
    }
}