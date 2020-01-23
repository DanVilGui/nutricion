<?php
include_once 'validaciones.php';
$data = WS::validarToken();
$idpersona = $data["idpersona"];
$lPost =new LPost();
$posts = $lPost->listarPosts("",$idpersona);
function shorten_string($string, $wordsreturned)
{
    $retval = $string;
    $string = preg_replace('/(?<=\S,)(?=\S)/', ' ', $string);
    $string = str_replace("\n", " ", $string);
    $array = explode(" ", $string);
    if (count($array)<=$wordsreturned)
    {
        $retval = $string;
    }
    else
    {
        array_splice($array, $wordsreturned);
        $retval = implode(" ", $array)." ...";
    }
    return $retval;
}

foreach ($posts as &$post){
    $post["resumen"] = shorten_string($post["texto"], 40);
}
echo json_encode(CRespuestaWs::mostrar(true, "", ["posts"=>$posts]));