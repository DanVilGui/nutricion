<?php


class CPersonaMedida
{
    public $idpersona;
    public $peso;
    public $medida;
    public $cintura;
    public $cadera;
    public $imc;
    public $fecha;

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
    public function getPeso()
    {
        return $this->peso;
    }

    /**
     * @param mixed $peso
     */
    public function setPeso($peso)
    {
        $this->peso = $peso;
    }

    /**
     * @return mixed
     */
    public function getMedida()
    {
        return $this->medida;
    }

    /**
     * @param mixed $medida
     */
    public function setMedida($medida)
    {
        $this->medida = $medida;
    }

    /**
     * @return mixed
     */
    public function getCintura()
    {
        return $this->cintura;
    }

    /**
     * @param mixed $cintura
     */
    public function setCintura($cintura)
    {
        $this->cintura = $cintura;
    }

    /**
     * @return mixed
     */
    public function getCadera()
    {
        return $this->cadera;
    }

    /**
     * @param mixed $cadera
     */
    public function setCadera($cadera)
    {
        $this->cadera = $cadera;
    }

    /**
     * @return mixed
     */
    public function getImc()
    {
        return $this->imc;
    }

    /**
     * @param mixed $imc
     */
    public function setImc($imc)
    {
        $this->imc = $imc;
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


}