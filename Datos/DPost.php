<?php


class DPost
{
    public function buscarPost($id){
        $conexion = DConexion::Instance();
        $sql = "SELECT * from tbl_post where idpost = ?";
        $st =$conexion->prepare($sql);
        $st->execute([$id]);
        $resultado = $st->fetch(PDO::FETCH_ASSOC);
        return $resultado;
    }

    public function listarPosts($titulo, $idpersona){
        $conexion = DConexion::Instance();
        $sql = "SELECT  p.*, count(distinct l.idpersona) as likes, case when l2.idpersona is null then 0 else 1 end as liked   from tbl_post p
                left join tbl_post_like l on p.idpost =l.idpost
                left join tbl_post_like l2 on  p.idpost =l2.idpost and l2.idpersona = ?
                where titulo like concat('%', ?, '%')
                group by p.idpost";
        $st =$conexion->prepare($sql);
        $st->execute([$idpersona, $titulo]);
        $resultado = $st->fetchAll(PDO::FETCH_ASSOC);
        return $resultado;
    }
    public function cambiarLike($idpost, $idpersona, $like){
        $conexion = DConexion::Instance();

        if($like){
            $sql = "insert into tbl_post_like(idpost, idpersona) values (?,?)";
        }else  $sql = "delete from tbl_post_like where idpost = ? and idpersona = ?";
        $st =$conexion->prepare($sql);
        try{
            $st->execute([$idpost, $idpersona]);
            return [ 'success'=> true , 'message'=> ''];
        }catch (PDOException $exception){
            return [ 'success'=> false , 'message'=> ''];
        }

    }
    public  function agregarPost($clsPost){
        /** @var  CPost $clsPost */
        $conexion = DConexion::Instance();
        $sql = 'INSERT INTO tbl_post(titulo, texto, imagen)
                      VALUES (?,?, ? )';
        try {
            $st =$conexion->prepare($sql);
            $conexion->beginTransaction();
            $st->execute(array($clsPost->titulo, $clsPost->texto, $clsPost->imagen));
            $conexion->commit();
            return [ 'success'=> true, 'message'=>'Registrado Correctamente'];
        } catch(PDOException $exception) {
            $conexion->rollback();
            return [ 'success'=> false , 'message'=> $exception->getMessage()];
        }
    }
    public  function actualizarPost($clsPost){
        /** @var  CPost $clsPost */
        $conexion = DConexion::Instance();
        $sql = 'update tbl_post set titulo = ?, texto = ?, imagen = coalesce(?, imagen) where idpost = ?';
        try {
            $st =$conexion->prepare($sql);
            $conexion->beginTransaction();
            $st->execute(array($clsPost->titulo, $clsPost->texto, $clsPost->imagen, $clsPost->idpost));
            $conexion->commit();
            return [ 'success'=> true, 'message'=>'Actualizado Correctamente'];
        } catch(PDOException $exception) {
            $conexion->rollback();
            return [ 'success'=> false , 'message'=> $exception->getMessage()];
        }
    }

    public  function eliminarPost($id){
        /** @var  CPost $clsPost */
        $conexion = DConexion::Instance();
        $sql = 'delete from tbl_post  where idpost = ?';
        try {
            $st =$conexion->prepare($sql);
            $conexion->beginTransaction();
            $st->execute(array( $id));
            $conexion->commit();
            return [ 'success'=> true, 'message'=>'Eliminado Correctamente'];
        } catch(PDOException $exception) {
            $conexion->rollback();
            return [ 'success'=> false , 'message'=> $exception->getMessage()];
        }
    }
}