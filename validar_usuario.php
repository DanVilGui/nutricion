<?php

$menus = [
    ['name'=>'INICIO', 'text'=>'INICIO','href'=>'index.php'],
];



define("ACCESO1","usuario");
define("ACCESO2","administrador");

if($validarUsuario) {
    if(isset($_SESSION['acceso_login'])){
        $acceso = mb_strtolower( $_SESSION['acceso_login'] );
        if($acceso ==ACCESO1){
            $menu_permiso = ['INICIO'];
       }else if($acceso ==ACCESO2){
            $menu_permiso = ['INICIO'];
       }

    }else{
        header("Location: login.php");
    }
}
else{

    if(isset($_SESSION['acceso_login'])){
        $acceso = mb_strtolower( $_SESSION['acceso_login'] );
        if($acceso ==ACCESO1||$acceso==ACCESO2){
            header("Location: index.php");
        }
    }
 
}