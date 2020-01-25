<?php


class CCombinacionDetalle
{

    const MEDIBLES_STEPS = [60,80,90,100,120,150,180,200];
    const MEDIBLES_CARNES = [200, 250, 300, 350, 400,420,450,480,500,520,550,600];
    const UNIDADES_STEPS = [1,2];

    public $idcombinacion;
    public $idproducto;
    public $producto;
    public $idtipo;
    public $tipo;
    public $idhorario;
    public $horario;
    public $cant;
    public $medida;
    public $kcal;
    public $kcalTotal;
    public $idrecomendacion;

    public function __construct($producto)
    {
        /** @var CProducto $producto */
        $this->idrecomendacion = $producto->referenciaFact;
        $this->idproducto = $producto->id;
        $this->producto = $producto->nombre;
        $this->idtipo = $producto->idtipo;
        $this->tipo = $producto->tipo;
        $this->idhorario = $producto->idhorario;
        $this->horario = $producto->horario;
        $this->medida = $producto->medida;
        $this->cant = $producto->cantidad;
        $this->kcal = $producto->kcal;
    }

    /**
     * @return mixed
     */
    public function getIdcombinacion()
    {
        return $this->idcombinacion;
    }

    /**
     * @param mixed $idcombinacion
     */
    public function setIdcombinacion($idcombinacion)
    {
        $this->idcombinacion = $idcombinacion;
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
    public function getCant()
    {
        return $this->cant;
    }

    /**
     * @param mixed $cant
     */
    public function setCant($cant)
    {
        $this->cant = $cant;
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
    function unidadAleatoria(){
        return  round( self::UNIDADES_STEPS[array_rand( self::UNIDADES_STEPS)], 2);
    }
    function medidaAleatoria(){
        return self::MEDIBLES_STEPS[array_rand(self::MEDIBLES_STEPS)];
    }

    function medidaAleatoriaCarnes(){
        return self::MEDIBLES_CARNES[array_rand(self::MEDIBLES_CARNES)];
    }

    function generarMedida( ){
        $kcal = $this->kcal;
        $idtipo = $this->idtipo;
        $tipo_carne = 4;
        if ($this->medida == "unidad") {
            $cantidad = $this->unidadAleatoria();
            $kcalTotal = $cantidad * $kcal;
        } else {

            $cantidad = $this->medidaAleatoria();
            $kcalTotal = $cantidad * $kcal / 100;
        }
        $this->cant = round($cantidad, 2);
        $this->kcalTotal = round($kcalTotal, 2);

        if($this->idtipo == 4 && $cantidad <120){
            $this->generarMedida();
        }
        if($this->idtipo == 9 && $cantidad <80){
            $this->generarMedida();
        }

    }

    function esProducto($nombre){
        return mb_strpos($this->producto, $nombre) !== false;
    }
}