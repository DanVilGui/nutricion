<?php

require 'vendor/autoload.php';
include 'Clases/imports.php';
include 'Datos/imports.php';
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

$tiempo_inicial = microtime(true);
$todoProduc = new DProducto();
$listaDisponibles= $todoProduc->buscarDisponibles();
//echo json_encode($listaDisponibles);




/*
 *
 */


$stepsMedibles = [30,50,60,80,90,100,120,150,180,200];
$stepsUnidades = [0.5,1,1.5,2];
$horarios = (new DHorario())->listarHorarios();
$cantSolucionesHorario = 6;

function buscarHorarioTipo($listaProductos, $idtipo){
    $arr = array();
    foreach ($listaProductos as $producto){
        if($producto["idtipo"] == $idtipo){
            $arr[] = $producto;
        }
    }
    return $arr;
}

function validarDesayuno($listaCombinacion, $comb){

    $copiaLista = $listaCombinacion;
    $copiaLista[] = $comb;
    $cantAvena = 0;
    $cantCafe = 0;
    foreach ($copiaLista as $combinacion){
        foreach ($combinacion as $producto){
            /*
            * La avena se puede recomendar máximo 3 veces por semana
            */

            if(strpos($producto["nombre"], 'AVENA') !== false){
                $cantAvena += 1;
            }
            if(strpos($producto["nombre"], 'CAFE') !== false
                or strpos($producto["nombre"], 'CAFÉ') !== false
            ){
                $cantCafe += 1;
            }
        }

    }

    /*
     * La cantidad de yemas no puede ser mayor a la de claras
     */
    $cantClaras = 0; $cantYemas = 0;
    foreach ($comb as $pro){
        if(strpos($pro["nombre"], 'YEMA') !== false){
            $cantYemas += 1;
        }
        if(strpos($pro["nombre"], 'CLARA') !== false){
            $cantClaras += 1;
        }
    }
    if($cantYemas>$cantClaras) return false;
    if($cantAvena > 3)  return false;
    if($cantCafe> 2) return false;
    return true;
}

function validarAlmuerzo($listaCombinacion, $comb){

    $copiaLista = $listaCombinacion;
    $copiaLista[] = $comb;
    $cantCarneRes = 0;
    foreach ($copiaLista as $index=>$combinacion){
        /*
         * Buscar Sgte combinacion
         */

        $sgteCombinacion  = ( $index+1< sizeof($copiaLista) )? $copiaLista[$index]: null;
        $recomendoPescado = false;
        $cantArrozOFideo = 0;
        foreach ($combinacion as $producto){
            /*
            * La CARNE DE RES se puede recomendar máximo 1 veces por semana
            */

            if(strpos($producto["nombre"], 'CARNE DE RES') !== false){
                $cantCarneRes += 1;
            }
            /*
            if(strpos($producto["nombre"], 'PESCADO') !== false){
                echo json_encode($producto)."<br><br><br>";
                $recomendoPescado = true;
            }
            */

            if(strpos($producto["nombre"], 'ARROZ') !== false or
                strpos($producto["nombre"], 'FIDEO') !== false){
                $cantArrozOFideo += 1;

            }
            if($cantArrozOFideo>0){
                if(strpos($producto["nombre"], 'PAPA AMARILLA') !== false or
                    strpos($producto["nombre"], 'PAPA BLANCA') !== false or
                    strpos($producto["nombre"], 'OLLUCO') !== false
                ) {

                    return false;
                }
            }
        }
        /*
        if($recomendoPescado and $sgteCombinacion !=null){
            foreach ($sgteCombinacion as $producto){
                if(strpos($producto["nombre"], 'PESCADO') !== false){
                    return false;
                }
            }
        }
        */
        echo $recomendoPescado;
    }
    if($cantCarneRes>1) return false;
    return true;
}

foreach ($horarios as $horario) {

    $tiempo_ejecucion_horario = microtime(true);
    $solucionesPorHorario = array();

    $arrCombinaciones = array();
    $dProducto = new DProducto();
    $idHorario = $horario["id"];
    $dProducto->setIdhorario($horario["id"]);
    $tipos = $dProducto->buscarHorarioTipoProductos();

    $kcalHorario = $imc * $horario["porcentaje"];
    $dProducto->setMaxKCal($kcalHorario);

    $productosLista = $dProducto->buscarProductosHorarios();

    ?>

    <b>HORARIO: <?= $horario["nombre"] ?> </b>
    <br>
    <b>CALORIAS MAXIMAS: <?= $kcalHorario ?> </b>
    <br>
    <?php

    for ($i = 0; $i < 100000; $i++) {
        $kcalAcumulada = 0;
        $productosGenerados = [];
        $arrIdsProducto = array();
        $cantIntentos = 0;
        foreach ($tipos as $tipo) {
            $maximo = $tipo["maximo"];
            $obligatorio = $tipo["obligatorio"];
            $dProducto->setIdtipo($tipo["idtipo"]);
            $kcalTotal = 0;
            $decisionProcesarNoObligatorio = rand(0, 1);

            if ($obligatorio == 1 or $decisionProcesarNoObligatorio) {
                $contadorProductoHorario = 0;
                $contadorMaxProductoHorario = rand(1, $maximo);
                do {
                    $filtro = buscarHorarioTipo($productosLista, $tipo["idtipo"]);
                    $productoAleatorio = $filtro[rand(0,sizeof($filtro)-1)];
                   // $productoAleatorio = $dProducto->buscarProductoHorarioTipo();
                    $idproducto = $productoAleatorio["id"];
                    $yaExiste = intval(array_search($idproducto, $arrIdsProducto));
                    if ($yaExiste == 0) {
                        $kcal = $productoAleatorio["kcal"];
                        if ($productoAleatorio["medida"] == "unidad") {
                           do {
                                $cantidad  = round($stepsUnidades[array_rand($stepsUnidades)], 2);
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
                        if($kcalTotal + $kcalAcumulada <= $kcalHorario ){
                            $cantIntentos = 0;
                        }
                        $productoAleatorio["cantidad"] = round($cantidad, 2);
                        $productoAleatorio["kcaltotal"] = round($kcalTotal, 2);
                        $kcalAcumulada += $kcalTotal;
                        $productosGenerados[] = $productoAleatorio;
                        $arrIdsProducto[] = $productoAleatorio["id"];
                    }
                    $contadorProductoHorario++;
                } while ($maximo > 1 and $contadorProductoHorario < $contadorMaxProductoHorario);

            }
        }
        $copia = $productosGenerados;
        $diff = $kcalHorario - $kcalAcumulada;
        if ( $diff > 0 and $diff < $margenKcal ) {
            $valido = true;
            switch ($horario["alias"]){
                case "DESAYUNO":
                       $valido =  validarDesayuno($arrCombinaciones, $copia);
                    ;break;
                case "ALMUERZO":
                        $valido = validarAlmuerzo($arrCombinaciones, $copia);
                    ;break;
                case "CENA":

                    ;break;
            }
            if($valido) $arrCombinaciones [] = $copia;
        }

        if(sizeof($arrCombinaciones) == $cantSolucionesHorario){
            ;break;
        }
       // echo json_encode($copia)."<br></br>";
    }

    $totalCombinaciones = array();
    $filtroCombinaciones = array();
    foreach ($arrCombinaciones as $combinacion) {
        $obj = array();
        $kcalTotal = 0;
        foreach ($combinacion as $producto) {
            $kcalTotal += $producto["kcaltotal"];
        }
        $obj["maximo"] = $kcalHorario;
        $obj["kcaltotal"] = $kcalTotal;
        $obj["dif"] = $kcalHorario - $kcalTotal;

        if ($obj["dif"] > 0 and $obj["dif"] < $margenKcal ) {
            $totalCombinaciones[] = $obj;
            $filtroCombinaciones[] = $combinacion;
        }
    }


  ?>
    <b>CANT DE COMBINACIONES: <?= sizeof($filtroCombinaciones) ?> </b>
    <?php foreach ($filtroCombinaciones as $i=> $combinacion): ?>


        <br>
        Calorias totales <?= $totalCombinaciones[$i]["kcaltotal"] ?>
        </br>
        <table>
            <thead>
            <th>GRUPO</th>
            <th>ALIMENTO</th>
            <th>CANTIDAD</th>
            <th>CALORIAS Q APORTA</th>
            </thead>
            <tbody>
            <?php foreach($combinacion as $producto) :?>
                <tr>
                    <td><?= $producto["tipo"] ?></td>
                    <td><?= $producto["nombre"] ?></td>
                    <td><?= $producto["cantidad"]." ".$producto["medida"] ?></td>
                    <td><?= $producto["kcaltotal"] ?></td>
                </tr>
            <?php endforeach;?>
            </tbody>
        </table>

    <?php endforeach;  ?>
    <br>
    <br>
    <br>
    <br>
    <br>
<?php

    $tiempo_ejecucion_horario_final = microtime(true);
    echo "El tiempo de ejecución del horario <b>". $horario["nombre"]  ."</b> fue de " . ($tiempo_ejecucion_horario_final-$tiempo_ejecucion_horario) . " segundos";
    echo "<br><br>";
}
$tiempo_final = microtime(true);
$tiempo = $tiempo_final - $tiempo_inicial;
echo "El tiempo de ejecución fue  de " . $tiempo . " segundos";
echo "<br><br>";

//echo json_encode($arrCombinaciones);
//echo json_encode($totalCombinaciones);
//echo json_encode($filtroCombinaciones);
//die();
?>
</body>
</html>
