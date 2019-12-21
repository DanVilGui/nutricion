<?php


class CProducto
{
    public $id;
    public $nombre;
    public $medida;
    public $kcal;
    public $idtipo;
    public $tipo;
    public $idhorario;
    public $horario;
    private $maxKCal;
    private $obligatorio;
    public $cantidad;
    public $kcalTotal;
    public $referenciaFact;

    /**
     * @return mixed
     */
    public function getId()
    {
        return $this->id;
    }

    /**
     * @param mixed $id
     */
    public function setId($id)
    {
        $this->id = $id;
    }

    /**
     * @return mixed
     */
    public function getNombre()
    {
        return $this->nombre;
    }

    /**
     * @param mixed $nombre
     */
    public function setNombre($nombre)
    {
        $this->nombre = $nombre;
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
    public function getKcal()
    {
        return $this->kcal;
    }

    /**
     * @param mixed $kcal
     */
    public function setKcal($kcal)
    {
        $this->kcal = $kcal;
    }

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
    public function getMaxKCal()
    {
        return $this->maxKCal;
    }

    /**
     * @param mixed $maxKCal

     */
    public function setMaxKCal($maxKCal)
    {
        $this->maxKCal = $maxKCal;
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

    /**
     * @return mixed
     */
    public function getTipo()
    {
        return $this->tipo;
    }

    /**
     * @param mixed $tipo
     */
    public function setTipo($tipo)
    {
        $this->tipo = $tipo;
    }

    /**
     * @return mixed
     */
    public function getHorario()
    {
        return $this->horario;
    }

    /**
     * @param mixed $horario
     */
    public function setHorario($horario)
    {
        $this->horario = $horario;
    }

    /**
     * @return mixed
     */
    public function getCantidad()
    {
        return $this->cantidad;
    }

    /**
     * @param mixed $cantidad
     */
    public function setCantidad($cantidad)
    {
        $this->cantidad = $cantidad;
    }

    /**
     * @return mixed
     */
    public function getKcalTotal()
    {
        return $this->kcalTotal;
    }

    /**
     * @param mixed $kcalTotal
     */
    public function setKcalTotal($kcalTotal)
    {
        $this->kcalTotal = $kcalTotal;
    }

    /**
     * @return mixed
     */
    public function getReferenciaFact()
    {
        return $this->referenciaFact;
    }

    /**
     * @param mixed $referenciaFact
     */
    public function setReferenciaFact($referenciaFact)
    {
        $this->referenciaFact = $referenciaFact;
    }




}