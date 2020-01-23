<?php


class LPost
{
    public function listarPosts($titulo, $idpersona = 0)
    {
        $dPost = new DPost();
        return $dPost->listarPosts($titulo, $idpersona);
    }

    public function buscarPost($id)
    {
        $dPost = new DPost();
        return $dPost->buscarPost($id);
    }

    public function eliminarPost($id)
    {
        $dPost = new DPost();
        return $dPost->eliminarPost($id);
    }

    public function cambiarLike($idpost, $idpersona, $like)
    {
        $dPost = new DPost();
        return $dPost->cambiarLike($idpost, $idpersona, $like);
    }
}