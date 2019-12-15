<?php


class CHorarioProductoRestriccion
{
    public $idhorario;
    public $idproducto;
    public $consumir;

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
    public function getIdproducto()
    {
        return $this->idproducto;
    }

    /**
     * @param mixed $idproducto
     */
    public function setIdproducto($idproducto)
    {
        $this->idproducto = $idproducto;
    }

    /**
     * @return mixed
     */
    public function getConsumir()
    {
        return $this->consumir;
    }

    /**
     * @param mixed $consumir
     */
    public function setConsumir($consumir)
    {
        $this->consumir = $consumir;
    }
}