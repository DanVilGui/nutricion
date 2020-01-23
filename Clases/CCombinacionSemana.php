<?php
class CCombinacionSemana{
    const MARGEN_KCAL = 30;
    const MARGEN_KCAL_MAX1 = 200;
    const MARGEN_KCAL_MAX2 = 400;
    const MARGEN_KCAL_MAX3 = 500;
    const MARGEN_KCAL_MAX4 = 600;

    const MAX_DIAS = 6;
    /** @var CCombinacion array  */
    public $listaCombinaciones = array();

    public function validaCombinacionSemanal($maxKcal, $dia, $combinacion){
        /** @var CCombinacion $combinacion */
        $diff = $maxKcal - $combinacion->kcalTotal;
        $margen = self::MARGEN_KCAL;
        if($maxKcal>2800) $margen = self::MARGEN_KCAL_MAX4;
        else if($maxKcal>2500) $margen = self::MARGEN_KCAL_MAX3;
        else if($maxKcal>2000) $margen = self::MARGEN_KCAL_MAX2;
        else if($maxKcal>1000) $margen = self::MARGEN_KCAL_MAX1;
        if($diff<0 or $diff> $margen) return false;
        if(!$combinacion->esValida()) return false;
        /*
         * creamos uan copia del objeto combinacion a validar a la semana
         */
        $copiaListaCombinaciones = $this->listaCombinaciones;
        $this->crearIndice($copiaListaCombinaciones, $dia, $combinacion->idhorario);
        $copiaListaCombinaciones[$dia][$combinacion->idhorario] = $combinacion;
        if($combinacion->idhorario == CHorario::DESAYUNOID) return $this->validacionDesayunoSemanal($copiaListaCombinaciones);
        if($combinacion->idhorario == CHorario::ALMUERZOID) return $this->validacionAlmuerzoSemanal($copiaListaCombinaciones);
        if($combinacion->idhorario == CHorario::CENAID) return $this->validacionCenaSemanal($copiaListaCombinaciones);


        return true;
    }

    public function crearIndice(&$lista, $dia, $horario){
        if(!isset($lista[$dia])){
            $lista[$dia] = array();
        }

        if(!isset($lista[$dia][$horario])){
            $lista[$dia][$horario] = array();
        }
    }

    public function agregarCombinacion($dia, $combinacion){
        /** @var CCombinacion $combinacion */
        $this->crearIndice($this->listaCombinaciones, $dia,$combinacion->idhorario);
        $this->listaCombinaciones[$dia][$combinacion->idhorario] = $combinacion;
    }

    public function validacionDesayunoSemanal($copiaListaCombinaciones){
        $cantDiasAvena = 0;
        $cantDiasCafe = 0;

        foreach ($copiaListaCombinaciones as $combinacionDia){
            if(isset( $combinacionDia[CHorario::DESAYUNOID])){
                $combinacionDesayuno = $combinacionDia[CHorario::DESAYUNOID];
                foreach ($combinacionDesayuno->listaCombinacion as $combinacionDetalle){
                     /** @var CCombinacionDetalle $combinacionDetalle */
                    if($combinacionDetalle->esProducto("AVENA")) $cantDiasAvena += 1;
                    if($combinacionDetalle->esProducto("CAFE"
                        or $combinacionDetalle->esProducto("CAFÉ"))) $cantDiasCafe += 1;

                }
            }
        }
        if($cantDiasAvena>3) return false;
        if($cantDiasCafe>2) return false;
        return true;
    }
    public function validacionAlmuerzoSemanal($copiaListaCombinaciones){
        $cantCarneRes = 0;
        $arrComioPescado = array();
        foreach ($copiaListaCombinaciones as $indexDia=> $combinacionDia){
            $arrComioPescado[$indexDia] = false;
            if( $indexDia%2 == 0) $pescadoDiaActual = false;
            if(isset( $combinacionDia[CHorario::ALMUERZOID])){
                $combinacionAlmuerzo = $combinacionDia[CHorario::ALMUERZOID];
                foreach ($combinacionAlmuerzo->listaCombinacion as $combinacionDetalle){
                    /** @var CCombinacionDetalle $combinacionDetalle */
                    if($combinacionDetalle->esProducto("CARNE DE RES")) $cantCarneRes += 1;
                  //  if($combinacionDetalle->esProducto("PESCADO")) $almuerzaPescado = true;
                    if($combinacionDetalle->esProducto("PESCADO")){
                        $arrComioPescado[$indexDia] = true;
                    }
                }
            }
            if($arrComioPescado[$indexDia]){
                if(isset($arrComioPescado[$indexDia-1] ) and $arrComioPescado[$indexDia-1]) return false;
            }
        }

        if($cantCarneRes>1)  return false;
        return true;
    }

    public function validacionCenaDia($combinacionDia){
        echo json_encode($combinacionDia);
    }

    public function validacionCenaSemanal($copiaListaCombinaciones){
        $cantDiasCafe = 0;

        foreach ($copiaListaCombinaciones as $indexDia=> $combinacionDia){
           $pescadoDiaActual = false;
            /*
             * index dia 0....6
             */
            // if( $indexDia%2 == 1 and $almuerzaPescado) return false;

            $avenaDesayuno = false;
            $cafeDesayuno = false;
            if(isset( $combinacionDia[CHorario::DESAYUNOID])){
                $combinacionDesayuno = $combinacionDia[CHorario::ALMUERZOID];
                if(isset($combinacionDesayuno->listaCombinacion)) {
                    foreach ($combinacionDesayuno->listaCombinacion as $combinacionDetalleDesayuno) {
                        /** @var CCombinacionDetalle $combinacionDetalleDesayuno */
                        if ($combinacionDetalleDesayuno->esProducto("AVENA")) {
                            $avenaDesayuno = true;
                            // break;
                        }
                        if ($combinacionDetalleDesayuno->esProducto("CAFE") or $combinacionDetalleDesayuno->esProducto("CAFÉ")) {
                            $cafeDesayuno = true;
                        }
                    }
                }
            }

            if(isset( $combinacionDia[CHorario::CENAID])){
                $combinacionCena = $combinacionDia[CHorario::CENAID];
                foreach ($combinacionCena->listaCombinacion as $combinacionDetalleCena) {
                    /** @var CCombinacionDetalle $combinacionDetalle */
                    if ($combinacionDetalleCena->esProducto("CAFE") or $combinacionDetalleCena->esProducto("CAFÉ")){
                        $cantDiasCafe += 1;
                        if($cafeDesayuno) return false;
                    }

                    if ($combinacionDetalleCena->esProducto("AVENA")){
                        if($avenaDesayuno) return false;
                    }

                }
            }

        }

        if($cantDiasCafe>2)  return false;
        return true;
    }
}