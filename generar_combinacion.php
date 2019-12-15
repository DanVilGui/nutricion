<?php
include 'Clases/imports.php';
include 'Datos/imports.php';
include 'Logica/imports.php';



?>
<html>
<head>
    <style>
        table, th, td {
            border: 1px solid black;
        }
    </style>
</head>
<body>
<?php
$generador = new LGenerarCombinacion();
$generador->setMaxSemana(6);
$horarios=  $generador->listarHorarios();
$maxCombinacionGeneradas = LGenerarCombinacion::MAX_COMBINACIONES;

$imc = 2533;
$margenKcal = 40;
$stepsMedibles = [30,50,60,80,90,100,120,150,180,200];
$stepsUnidades = [1,2];
$arrCombinaciones = array();



//echo json_encode($horarios);
for($i=0;$i<$generador->getMaxSemana();$i++){
    echo "<br></br><h2>DIA ".($i+1)."</h2>";
    foreach ($horarios as $horario) {
        /** @var CHorario $horario */
            $kcalHorario = $imc*$horario->getPorcentaje();
            $generador->filtrarXHorario($horario->getId());
            $tipos = $generador->tipos;
            $listaProductos = $generador->listaProductos;

            $nroCombinacionGeneradas = 0;
            if(!isset($arrCombinaciones[$horario->getId()])){
                $arrCombinaciones[$horario->getId()] = array();
            }

            while($nroCombinacionGeneradas< $maxCombinacionGeneradas){
                $nCombinacion = array();
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

                                $filtro = $generador->filtrarProductoTipo($tipo->getId());
                                $productoAleatorio = $filtro[rand(0, sizeof($filtro) - 1)];
                                $idproducto = $productoAleatorio->getId();

                                $existeProducto = intval (array_search($idproducto, $arrIdsProducto));
                                if ($existeProducto == 0) {
                                    $kcal = $productoAleatorio->getKcal();

                                    if ($productoAleatorio->getMedida() == "unidad") {
                                        do {
                                            $cantidad = round($stepsUnidades[array_rand($stepsUnidades)], 2);
                                            $kcalTotal = $cantidad * $kcal;
                                            $cantIntentos += 1;
                                        } while ($kcalTotal + $kcalAcumulada > $kcalHorario and $cantIntentos < 5);
                                    } else {
                                        do {
                                            $cantidad = $stepsMedibles[array_rand($stepsMedibles)];
                                            $kcalTotal = $cantidad * $kcal / 100;
                                            $cantIntentos += 1;
                                        } while ($kcalTotal + $kcalAcumulada > $kcalHorario and $cantIntentos < 5);
                                    }
                                    if ($kcalTotal + $kcalAcumulada <= $kcalHorario) {
                                        $cantIntentos = 0;
                                    }
                                    $productoAleatorio->cantidad = round($cantidad, 2);
                                    $productoAleatorio->kcalTotal = round($kcalTotal, 2);
                                    $kcalAcumulada += $kcalTotal;
                                    $nCombinacion[] = $productoAleatorio;
                                    $arrIdsProducto[] = $idproducto;
                                   // var_dump($productoAleatorio);
                                }
                                $contadorProductoHorario++;
                            } while ($cantMaximaAGenerar > 1 and $contadorProductoHorario < $contadorMaxProductoHorario);
                        }


                  //  var_dump($nCombinacion);

                }
                $nroCombinacionGeneradas +=1;

                /*
                 * Validacion
                 */

                $copia = $nCombinacion;
                $diff = $kcalHorario - $kcalAcumulada;
                $esSolucion = $diff > 0 and $diff < $margenKcal;
                if ( $esSolucion ) {

                    if($horario->getId() == CHorario::ALMUERZOID ){

                    }else{
                        $arrCombinaciones[$horario->getId()] = $copia;
                        ;break;
                    }

                    ?>
                    <br>
                    <br>
                    <br>
                    MAX <?= $kcalHorario ?>
                    <br>

                    <table>
                        <thead>
                        <th>GRUPO</th>
                        <th>ALIMENTO</th>
                        <th>CANTIDAD</th>
                        <th>CALORIAS Q APORTA</th>
                        <th>HORARIO</th>

                        </thead>
                        <tbody>
                        <?php
                        $kcalTest = 0;
                        foreach($copia as $producto) :?>
                            <tr>
                                <td><?= $producto->tipo ?></td>
                                <td><?= $producto->nombre ?></td>
                                <td><?= $producto->cantidad." ".$producto->medida ?></td>
                                <td><?= $producto->kcalTotal ?></td>
                                <td><?= $producto->horario ?></td>

                            </tr>
                            <?php
                        endforeach;?>
                        </tbody>
                    </table>
                    <br> TOTAL : <?= $kcalAcumulada ?>
                    <?php


                }
            }




    }


}

?>
