<?php


class LPersona
{


    function buscarRutina($idpersona)
    {
        $dPersonaRutina = new DPersonaRutina();
        $rutina = $dPersonaRutina->buscarRutina($idpersona);
        return $rutina;
    }

    function cambiarRecalcular($idpersona, $recalcular)
    {
        $dPersonaRutina = new DPersonaRutina();
        $rutina = $dPersonaRutina->cambiarRecalcular($idpersona, $recalcular);
        return $rutina;
    }

    function buscarPersonaDatos($idpersona)
    {
        $dPersona = new DPersona();
        $dPersonaMedida = new DPersonaMedida();
        $persona = $dPersona->buscarPersonaID($idpersona);
        $medidas = $dPersonaMedida->buscarUltimaMedida($idpersona);
        $dPersonaRutina = new DPersonaRutina();
        $dPersonaPreferencia = new DPersonaPreferencia();
        $rutina = $dPersonaRutina->buscarRutina($idpersona);
        $preferencia = $dPersonaPreferencia->buscarPreferencia($idpersona);
        $persona["medidas"] = $medidas;
        $persona["rutina"] = $rutina;
        $persona["preferencia"] = $preferencia;
        $persona["ultimadieta"] = $dPersona->buscarUltimaDieta($idpersona);
        return ["datos" => $persona];
    }

    function accederCuenta($clsPersona)
    {
        $dPersona = new DPersona();
        return $dPersona->accederCuenta($clsPersona);
    }

    function registrarRutina($clsPersonaRutina)
    {
        $dPersonaRutina = new DPersonaRutina();
        return $dPersonaRutina->registrarRutina($clsPersonaRutina);
    }

    function buscarPreferencia($idpersona)
    {
        $dPersonaPreferencia = new DPersonaPreferencia();
        return $dPersonaPreferencia->buscarPreferencia($idpersona);
    }

    function registrarPreferencia($clsPersonaPreferencua)
    {
        $dPersonaPreferencia = new DPersonaPreferencia();
        return $dPersonaPreferencia->registrarPreferencia($clsPersonaPreferencua);
    }

    function buscarPersona($idpersona)
    {
        $dPersona = new DPersona();
        return $dPersona->buscarPersonaID($idpersona);
    }

    function buscarUltimaMedida($idpersona)
    {
        $dPersonaMedida = new DPersonaMedida();
        return $dPersonaMedida->buscarUltimaMedida($idpersona);
    }

    function buscarMedidas($idpersona)
    {
        $dPersonaMedida = new DPersonaMedida();
        return $dPersonaMedida->buscarMedidas($idpersona);
    }

    function cambiarKcal($cPersona)
    {
        $dPersona = new DPersona();
        return $dPersona->cambiarKcal($cPersona);
    }

    function validarEnvioRecuperacion($correo)
    {
        $dPersona = new DPersona();
        return $dPersona->validarEnvioRecuperacion($correo);
    }

    function cambiarCodigoRecuperacion($codigo, $fecha, $correo)
    {
        $dPersona = new DPersona();
        $dPersona->cambiarCodigoRecuperacion($codigo, $fecha, $correo);
    }

    function cambiarPassRecuperar($codigo, $contrasenia, $correo)
    {
        $dPersona = new DPersona();
        $dPersona->cambiarPassRecuperar($codigo, $contrasenia, $correo);
    }
}