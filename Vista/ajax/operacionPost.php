<?php
$title = "Nutrilife";
include_once '../../vendor/autoload.php';

include_once '../../Clases/imports.php';
include_once '../../Datos/imports.php';
include_once '../../Logica/imports.php';

function uploadFile($id,$types,$filename='',$path,$maxSizeX = 100, $overwrite = false,$image=true){


    if(isset($_FILES[$id]) && $_FILES[$id]['name'] != '' ){

        $fn = explode('.',$filename);
        if(isset($fn[1])){
            $filename= $fn[0];
        }

        $handle = new \Verot\Upload\Upload($_FILES[$id],'es_ES');
        if ($handle->uploaded) {
            $handle->file_new_name_body   = $filename;
            if($image){
                $handle->image_resize         = true;
                $handle->image_x              = $maxSizeX;
                $handle->image_ratio_y        = true;
            }
            if($types!=null)  $handle->allowed = $types;
            else $handle->mime_check = false;
            $handle->file_overwrite = $overwrite;
            $handle->process($path);
            if ($handle->processed) {
                $fname = $handle->file_dst_name;
                $handle->clean();
                $rpt = ['status'=> true, 'msg'=> $fname];
            } else {
                $rpt = ['status'=> false, 'msg'=> $handle->error];
            }
            if(!$rpt['status']){
                exit(json_encode($rpt));
            }
            $name = $rpt['msg'];
        }
        else{
            $name = null;
        }

        return $name ;

    }

    return null;
}

$idpost = $_POST["idpost"];
$titulo = $_POST["titulo"];
$texto = $_POST["texto"];
$requerida = $_POST["imagen_requerida"];
$imagen = uploadFile('imagen',['image/*'],md5(uniqid()).".jpg",$ruta_imagenes.'posts/',500,true);
if($requerida == 1 &&  $imagen==null){
    exit(json_encode(CRespuestaWs::mostrar(false, "Carge una imagen!")));
}

$cPost = new CPost();
$cPost->setIdpost($idpost);
$cPost->setTitulo($titulo);
$cPost->setTexto($texto);
$cPost->setImagen($imagen);
$dPost = new DPost();
if($idpost == -1){
    $rpt = $dPost->agregarPost($cPost);
}else $rpt = $dPost->actualizarPost($cPost);

exit(json_encode(CRespuestaWs::mostrar($rpt["success"], $rpt["message"])));

