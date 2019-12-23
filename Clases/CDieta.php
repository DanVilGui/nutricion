<?php


class CDieta
{
    public $iddieta;
    public $fecha;
    public $idpersona;
    public $asignado;

    /**
     * @return mixed
     */
    public function getIddieta()
    {
        return $this->iddieta;
    }

    /**
     * @param mixed $iddieta
     */
    public function setIddieta($iddieta)
    {
        $this->iddieta = $iddieta;
    }

    /**
     * @return mixed
     */
    public function getFecha()
    {
        return $this->fecha;
    }

    /**
     * @param mixed $fecha
     */
    public function setFecha($fecha)
    {
        $this->fecha = $fecha;
    }

    /**
     * @return mixed
     */
    public function getIdpersona()
    {
        return $this->idpersona;
    }

    /**
     * @param mixed $idpersona
     */
    public function setIdpersona($idpersona)
    {
        $this->idpersona = $idpersona;
    }

    /**
     * @return mixed
     */
    public function getAsignado()
    {
        return $this->asignado;
    }

    /**
     * @param mixed $asignado
     */
    public function setAsignado($asignado)
    {
        $this->asignado = $asignado;
    }


}