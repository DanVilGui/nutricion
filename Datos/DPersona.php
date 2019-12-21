<?php
class DPersona
{
    function buscarPersonaID($idpersona){
        $conexion = DConexion::Instance();
        $sql = "select p.* , l.nombre AS login_tipo 
                from tbl_persona p
                INNER JOIN tbl_login_tipo l ON p.idlogin_tipo = l.idlogin_tipo where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    function buscarMedidasControles($idpersona){
        $conexion = DConexion::Instance();
        $sql = "select * from tbl_persona_medida where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return ($resultado !== false ) ? $resultado : null;
    }

    function validarCorreoExiste($correo){
        $conexion = DConexion::Instance();
        $sql = "select idpersona,nombres,apellidos, correo, l.idlogin_tipo, l.nombre AS login_tipo, token 
                from tbl_persona p
                INNER JOIN tbl_login_tipo l ON p.idlogin_tipo = l.idlogin_tipo where correo = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$correo]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }


    function registrarPesona($clsPersona){
        /** @var CPersona $clsPersona */
        $existeCorreo = $this->validarCorreoExiste($clsPersona->getCorreo());
        if($existeCorreo === false){
            //No existe correo
              $conexion = DConexion::Instance();
              $sql = 'INSERT INTO tbl_persona(nombres, apellidos, correo, contrasenia, idlogin_tipo, token)
                      VALUES (?,?,?, sha2(?,256),?, substring( sha2(uuid(), 256) from 1 for 80) )';
              try {
                  $st =$conexion->prepare($sql);
                  $conexion->beginTransaction();
                  $st->execute(array($clsPersona->nombres, $clsPersona->apellidos, $clsPersona->correo, $clsPersona->contrasenia,
                      $clsPersona->idlogin_tipo));
                  $idpersona = $conexion->lastInsertId();
                  $conexion->commit();
                  return [ 'success'=> true, 'message'=>'Registrado Correctamente', 'idpersona'=> $idpersona];
              } catch(PDOException $exception) {
                  $conexion->rollback();
                  return [ 'success'=> false , 'message'=> $exception->getMessage()];
              }

        }else{
            //Existe correo
            return $existeCorreo;
        }
    }

    public function validarToken($token){
        $conexion = DConexion::Instance();
        $sql = "select * from tbl_persona where token = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$token]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function cambiarSexoEdad($clsPersona){
        /** @var CPersona $clsPersona */
        $conexion = DConexion::Instance();
        $sql = "update tbl_persona set sexo = ?, fecha_nacimiento = ? where idpersona = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$clsPersona->sexo, $clsPersona->fecha_nacimiento, $clsPersona->idpersona ]);
        return true;
    }

}