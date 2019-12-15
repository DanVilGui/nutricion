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
$arrCombinaciones = new CCombinacionSemana();

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

            while($nroCombinacionGeneradas< $maxCombinacionGeneradas){
                $nCombinacion = $generador->generarCombinacion();
                $nCombinacion->idhorario = $horario->id;
                $nroCombinacionGeneradas +=1;
               // $diff = $kcalHorario - $nCombinacion->kcalTotal;
                /*
                 * validar estructura combinacion
                 */
                if ( $arrCombinaciones->validaCombinacionSemanal($kcalHorario,$i, $nCombinacion) ) {
                    ?>
                    <br>
                    <br>
                    <br>
                    MAX <?= $kcalHorario ?><br>
                    <?php
                    $nCombinacion->imprimir();
                    $arrCombinaciones->agregarCombinacion($i,$nCombinacion);
                    ;break;

                }
            }
    }


}
?>
