<?php

class CCombinacion
{

    public $iddieta;
    public $idhorario;
    public $idpersona;
    public $fecha;
    /** @var CCombinacionDetalle array  */
    public $listaCombinacion = array();
    public $kcalTotal;

    public function agregarCombinacion($comb)
    {
        $this->listaCombinacion[] = $comb;
    }

    public  function  mostrarJson(){
        echo json_encode($this->listaCombinacion);
    }

    public function imprimir(){
        echo "<table>
                        <thead>
                        <th>GRUPO</th>
                        <th>ALIMENTO</th>
                        <th>CANTIDAD</th>
                        <th>CALORIAS Q APORTA</th>
                        <th>HORARIO</th>
                        </thead>
                        <tbody>";
                        $kcalTest = 0;
                        foreach($this->listaCombinacion as $producto) :


                            echo "<tr>
                                <td>$producto->tipo</td>
                                <td>$producto->producto</td>
                                <td>$producto->cant $producto->medida</td>
                                <td>$producto->kcalTotal</td>
                                <td>$producto->horario</td></tr>";

                        endforeach;

         echo "</tbody>
                    </table>
                    TOTAL : $this->kcalTotal<br><br>";

    }

    public function esValida(){

        if($this->idhorario == CHorario::DESAYUNOID) return $this->validarDesayuno();
        if($this->idhorario == CHorario::ALMUERZOID) return $this->validarAlmuerzo();
        return true;
    }



    public function validarDesayuno(){
        $contadorYemas = 0;
        $contadorClaras = 0;
        foreach ($this->listaCombinacion as $combinacion){
            /** @var CCombinacionDetalle $combinacion */
            if($combinacion->esProducto("YEMA")) $contadorYemas += $combinacion->cant;
            if($combinacion->esProducto("CLARA") ) $contadorClaras += $combinacion->cant;
        }
        if($contadorYemas> $contadorClaras) return false;
        return true;
    }
    public function validarAlmuerzo(){
        $contadorArrozoFideo = 0;
        foreach ($this->listaCombinacion as $combinacion){
            /** @var CCombinacionDetalle $combinacion */
            if($combinacion->esProducto("ARROZ") or $combinacion->esProducto("FIDEO")) {
                $contadorArrozoFideo+=1;
            }
            if($combinacion->esProducto("PAPA AMARILLA") or $combinacion->esProducto("PAPA BLANCA") or
                $combinacion->esProducto("OLLUCO") ) {
                if($contadorArrozoFideo>0){
                    return false;
                }
            }
        }

        return true;
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

}