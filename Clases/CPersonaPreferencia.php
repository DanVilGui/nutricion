<?php


class CPersonaPreferencia
{
    public $idpersona;
    public $cant_comidas;
    public $cant_vasos;
    public $hace_dieta;
    public $comida_hambre;

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
    public function getCantComidas()
    {
        return $this->cant_comidas;
    }

    /**
     * @param mixed $cant_comidas
     */
    public function setCantComidas($cant_comidas)
    {
        $this->cant_comidas = $cant_comidas;
    }

    /**
     * @return mixed
     */
    public function getCantVasos()
    {
        return $this->cant_vasos;
    }

    /**
     * @param mixed $cant_vasos
     */
    public function setCantVasos($cant_vasos)
    {
        $this->cant_vasos = $cant_vasos;
    }

    /**
     * @return mixed
     */
    public function getHaceDieta()
    {
        return $this->hace_dieta;
    }

    /**
     * @param mixed $hace_dieta
     */
    public function setHaceDieta($hace_dieta)
    {
        $this->hace_dieta = $hace_dieta;
    }

    /**
     * @return mixed
     */
    public function getComidaHambre()
    {
        return $this->comida_hambre;
    }

    /**
     * @param mixed $comida_hambre
     */
    public function setComidaHambre($comida_hambre)
    {
        $this->comida_hambre = $comida_hambre;
    }


}