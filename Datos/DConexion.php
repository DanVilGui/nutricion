<?php


class DConexion
{
    public static  $PDO;
    private static $server = "localhost";
    private static $port= "3306";
    private static $bd = "nutricion";
    private static $user = "root";
    private static $pass = "";



    public static function Instance(){
        if(self::$PDO == null){
            self::$PDO  = new PDO("mysql:host=" . self::$server . ";port=" . self::$port . ";dbname=" . self::$bd . ";charset=UTF8;",
                self::$user,self::$pass, array(PDO::ATTR_PERSISTENT=>true));
            self::$PDO->query("SET NAMES utf8;");
            self::$PDO->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
        }
        return self::$PDO;
    }
    public static function desabilitarKeys(){
        $conexion = DConexion::Instance();
        $sql = "SET FOREIGN_KEY_CHECKS=0";
        $conexion->prepare($sql)->execute();
    }
    public static function habilitarKeys(){
        $conexion = DConexion::Instance();
        $sql = "SET FOREIGN_KEY_CHECKS=1";
        $conexion->prepare($sql)->execute();
    }

}