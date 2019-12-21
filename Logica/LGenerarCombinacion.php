<?php


class LGenerarCombinacion
{
    public $maxSemana;
    public $idhorario;
    public $listaProductos;
    public $tipos;
    const MAX_COMBINACIONES = 100000;
    const MARGEN_KCAL = 50;
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
    public function getListaProductos()
    {
        return $this->listaProductos;
    }

    /**
     * @param mixed $listaProductos
     */
    public function setListaProductos($listaProductos)
    {
        $this->listaProductos = $listaProductos;
    }

    /**
     * @return mixed
     */
    public function getTipos()
    {
        return $this->tipos;
    }

    /**
     * @param mixed $tipos
     */
    public function setTipos($tipos)
    {
        $this->tipos = $tipos;
    }

    /**
     * @return mixed
     */
    public function getMaxSemana()
    {
        return $this->maxSemana;
    }

    /**
     * @param mixed $maxSemana
     */
    public function setMaxSemana($maxSemana)
    {
        $this->maxSemana = $maxSemana;
    }


    public function filtrarXHorario($idhorario){
        $dProducto = new DProducto();
        $dtTipos = $dProducto->buscarHorarioTipoProductos($idhorario);
        $tipos = array();
        foreach ($dtTipos as $tip){
            $tipo = new CTipoProducto();
            $tipo->setId($tip["idtipo"]);
            $tipo->setNombre($tip["tipo"]);
            $tipo->setMaximo($tip["maximo"]);
            $tipo->setObligatorio($tip["obligatorio"]);
            $tipos[]= $tipo;
        }
        $dtProductos = $dProducto->buscarProductosHorarios($idhorario);
        $listaProductos = array();
        foreach ($dtProductos as $pro){
            $producto = new CProducto();
            $producto->setReferenciaFact($pro["id"]);
            $producto->setId($pro["idproducto"]);
            $producto->setNombre($pro["nombre"]);
            $producto->setKcal($pro["kcal"]);
            $producto->setIdtipo($pro["idtipo"]);
            $producto->setObligatorio($pro["obligatorio"]);
            $producto->tipo = $pro["tipo"];
            $producto->horario = $pro["horario"];
            $producto->medida = $pro["medida"];
            $listaProductos[] = $producto;
        }
        $this->listaProductos = $listaProductos;
        $this->tipos = $tipos;

    }
    public function listarHorarios(){
        $datatable = (new DHorario())->listarHorarios();
        $horarios = array();
        foreach ($datatable as $row){
            $horario = new CHorario();
            $horario->setId($row["id"]);
            $horario->setNombre($row["nombre"]);
            $horario->setPorcentaje($row["porcentaje"]);
            $horario->setAlias($row["alias"]);
            $horarios[]= $horario;
        }
        return $horarios;
    }

    public function filtrarProductoTipo($idtipo){
        $arr = array();

        foreach ($this->listaProductos as $producto){
            if($producto->idtipo == $idtipo){
                $arr[] = $producto;
            }
        }
        return $arr;
    }

    public function generarCombinacion(){
        $tipos = $this->tipos;
        $nCombinacion = new CCombinacion();
        $kcalTotal = 0;
        $kcalAcumulada = 0;
        $cantIntentos = 0;
        $arrIdsProducto = array();
        foreach ($tipos as $tipo) {
            /** @var CTipoProducto $tipo */
            $esObligatorio = $tipo->getObligatorio();
            $cantMaximaAGenerar = $tipo->getMaximo();
            $decisionProcesarNoObligatorio = rand(0, 1);
            if ($esObligatorio or $decisionProcesarNoObligatorio) {
                $contadorProductoHorario = 0;
                $contadorMaxProductoHorario = rand(1, $cantMaximaAGenerar);
                do {

                    $filtro = $this->filtrarProductoTipo($tipo->getId());
                    $productoAleatorio = $filtro[rand(0, sizeof($filtro) - 1)];
                    $combinacionDetalle = new CCombinacionDetalle($productoAleatorio);
                    $idproducto = $combinacionDetalle->getIdproducto();
                    $existeProducto = intval (array_search($idproducto, $arrIdsProducto));
                    if ($existeProducto == 0) {
                        $combinacionDetalle->generarMedida();
                        $kcalAcumulada += $combinacionDetalle->kcalTotal;
                        $nCombinacion->agregarCombinacion($combinacionDetalle);
                        $arrIdsProducto[] = $idproducto;
                    }
                    $contadorProductoHorario++;
                } while ($cantMaximaAGenerar > 1 and $contadorProductoHorario < $contadorMaxProductoHorario);
            }
        }
        $nCombinacion->kcalTotal = $kcalAcumulada;

        return $nCombinacion;
    }

}