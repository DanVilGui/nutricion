<?php


class CHorarioTipoRestriccion
{

    public $idtipo;
    public $idhorario;
    public $maximo;
    public $obligatorio;

    /**
     * @return mixed
     */
    public function getIdtipo()
    {
        return $this->idtipo;
    }

    /**
     * @param mixed $idtipo
     */
    public function setIdtipo($idtipo)
    {
        $this->idtipo = $idtipo;
    }

    /**
     * @return mixed
     */
    public function getIdhorario()
    {
        return $this->idhorario;
    }

    /**
     * @param mixed $idhorario
     */
    public function setIdhorario($idhorario)
    {
        $this->idhorario = $idhorario;
    }

    /**
     * @return mixed
     */
    public function getMaximo()
    {
        return $this->maximo;
    }

    /**
     * @param mixed $maximo
     */
    public function setMaximo($maximo)
    {
        $this->maximo = $maximo;
    }

    /**
     * @return mixed
     */
    public function getObligatorio()
    {
        return $this->obligatorio;
    }

    /**
     * @param mixed $obligatorio
     */
    public function setObligatorio($obligatorio)
    {
        $this->obligatorio = $obligatorio;
    }

}