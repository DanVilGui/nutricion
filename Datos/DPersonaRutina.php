<?php


class DPersonaRutina
{

    function buscarRutina($idpersona){
        $conexion = DConexion::Instance();
        $sql = "select * from tbl_persona_rutina where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return ($resultado !== false ) ? $resultado : null;
    }

    function cambiarRecalcular($idpersona, $recalcular){
        $conexion = DConexion::Instance();
        $sql = "update tbl_persona_rutina set recalcular = ? where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$recalcular, $idpersona]);
    }

    function registrarRutina($clsPersonaRutina){
        /** @var CPersonaRutina $clsPersonaRutina */
        $existeRutina = $this->buscarRutina($clsPersonaRutina->idpersona);
        $conexion = DConexion::Instance();
        if($existeRutina == null){
            $sql = 'insert into  tbl_persona_rutina(idpersona, caminar, escaleras, trabaja, trabaja_casa,
                    trabaja_ligero, trabaja_activo, trabaja_muyactivo, ciclismo, futbol, danza, baloncesto, 
                    natacion, tenis, correr, recalcular) 
                    VALUES (?,?,?,?,?,?,?,?,?,?,?,?,?,?,?,1)';
            try {
                $st =$conexion->prepare($sql);
                $conexion->beginTransaction();
                $st->execute(array($clsPersonaRutina->idpersona, $clsPersonaRutina->caminar, $clsPersonaRutina->escaleras,
                    $clsPersonaRutina->trabaja, $clsPersonaRutina->trabaja_casa, $clsPersonaRutina->trabaja_ligero,
                    $clsPersonaRutina->trabaja_activo, $clsPersonaRutina->trabaja_muyactivo, $clsPersonaRutina->ciclismo,
                    $clsPersonaRutina->futbol, $clsPersonaRutina->danza, $clsPersonaRutina->baloncesto,
                    $clsPersonaRutina->natacion, $clsPersonaRutina->tenis, $clsPersonaRutina->correr
                    ));
                $conexion->commit();
                return true;
            } catch(PDOException $exception) {
                $conexion->rollback();
                return false;
            }

        }else{
            $sql = 'update  tbl_persona_rutina set caminar = ? , escaleras = ? , trabaja = ?, trabaja_casa = ?,
                    trabaja_ligero = ?, trabaja_activo = ?, trabaja_muyactivo = ?, ciclismo = ?, futbol = ?, danza = ?,
                     baloncesto = ?, natacion = ?, tenis = ?, correr = ?, recalcular = 1 where idpersona = ?';
            try {
                $st =$conexion->prepare($sql);
                $conexion->beginTransaction();
                $st->execute(array( $clsPersonaRutina->caminar, $clsPersonaRutina->escaleras, $clsPersonaRutina->trabaja,
                    $clsPersonaRutina->trabaja_casa, $clsPersonaRutina->trabaja_ligero,
                    $clsPersonaRutina->trabaja_activo, $clsPersonaRutina->trabaja_muyactivo, $clsPersonaRutina->ciclismo,
                    $clsPersonaRutina->futbol, $clsPersonaRutina->danza, $clsPersonaRutina->baloncesto,
                    $clsPersonaRutina->natacion, $clsPersonaRutina->tenis, $clsPersonaRutina->correr,
                    $clsPersonaRutina->idpersona
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