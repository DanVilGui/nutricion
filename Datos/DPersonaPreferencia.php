<?php


class DPersonaPreferencia
{

    function buscarPreferencia($idpersona){
        $conexion = DConexion::Instance();
        $sql = "select * from tbl_persona_preferencia where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return ($resultado !== false ) ? $resultado : null;
    }

    function registrarPreferencia($clsPersonaPreferencia){
        /** @var CPersonaPreferencia $clsPersonaPreferencia */
        $existePreferencia = $this->buscarPreferencia($clsPersonaPreferencia->idpersona);
        $conexion = DConexion::Instance();
        if($existePreferencia == null){
            $sql = 'insert into tbl_persona_preferencia (idpersona, cant_comidas, cant_vasos, comida_hambre, hace_dieta) 
                    VALUES (?,?,?,?,?)';
            try {
                $st =$conexion->prepare($sql);
                $conexion->beginTransaction();
                $st->execute(array($clsPersonaPreferencia->idpersona, $clsPersonaPreferencia->cant_comidas,
                    $clsPersonaPreferencia->cant_vasos, $clsPersonaPreferencia->comida_hambre,
                    $clsPersonaPreferencia->hace_dieta));
                $conexion->commit();
                return true;
            } catch(PDOException $exception) {
                $conexion->rollback();
                return false;
            }

        }else{
            $sql = 'update tbl_persona_preferencia set cant_comidas = ? , cant_vasos = ?, comida_hambre = ?, hace_dieta = ?  where idpersona = ?';
            try {
                $st =$conexion->prepare($sql);
                $conexion->beginTransaction();
                $st->execute(array(  $clsPersonaPreferencia->cant_comidas,
                    $clsPersonaPreferencia->cant_vasos, $clsPersonaPreferencia->comida_hambre,
                    $clsPersonaPreferencia->hace_dieta,$clsPersonaPreferencia->idpersona
                ));
                $conexion->commit();
                return true;
            } catch(PDOException $exception) {
                $conexion->rollback();
                return false;
            }
        }
    }
}