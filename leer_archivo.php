<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
require 'vendor/autoload.php';
include 'Clases/imports.php';
include 'Datos/imports.php';
use Box\Spout\Reader\Common\Creator\ReaderEntityFactory;
use Box\Spout\Reader\XLSX\Sheet;
use Box\Spout\Reader\XLSX\Helper\CellHelper;
use Box\Spout\Common\Entity\Cell;

$archivo = "datasource.xlsx";
$reader = ReaderEntityFactory::createReaderFromFile($archivo);
$reader->open($archivo);
$hojaHorarios = null;
$hojaTipos = null;
$hojaProductos = null;
//Leer las hojas del archivo excel

foreach ($reader->getSheetIterator() as  $sheet){
    if($sheet instanceof Sheet){
        $name=   $sheet->getName();
        $hojaHorarios =  (  $name == "horario_comida" ) ? $sheet : $hojaHorarios ;
        $hojaTipos =  (  $name == "tipo_comida" ) ? $sheet : $hojaTipos ;
        $hojaProductos =  (  $name == "productos" ) ? $sheet : $hojaProductos ;
    }
}

$cHoja = new CHoja();
$dataHorarios = $cHoja->procesarHoja($hojaHorarios);
$dataTipos =  $cHoja->procesarHoja($hojaTipos);
$dataProductos =  $cHoja->procesarHoja($hojaProductos);

$reader->close();
/*
 * Procesar de horarios
 *
 */
$horarios = [];
for ($i = 0; $i< count( array_values( $dataHorarios)[0]);$i++){
    $cHorario = new CHorario();
    $cHorario->setId( array_values( $dataHorarios["ID"])[$i]);
    $cHorario->setAlias( array_values( $dataHorarios["ALIAS"])[$i]);
    $cHorario->setNombre(array_values( $dataHorarios["NOMBRE"])[$i]);
    $cHorario->setPorcentaje(array_values( $dataHorarios["PORCENTAJE"])[$i]);
    $horarios[] = $cHorario;
}



/*
 * Procesar tipos
 */

$tipos = [];
for ($j = 0; $j< count( array_values( $dataTipos)[0]);$j++){
    $cTipo = new CTipoProducto();
    $cTipo->setId( array_values( $dataTipos["ID"])[$j]);
    $cTipo->setAlias( array_values( $dataTipos["ALIAS"])[$j]);
    $cTipo->setNombre(array_values( $dataTipos["NOMBRE"])[$j]);
    $tipos[] = $cTipo;
}


/*
 *  Procesar restriciones horarios tipo
 */



$horarioTipoRestricciones = [];
foreach($horarios as $i=>$horario){
    $maximoStr = $horario->getAlias()."_MAXIMO";
    $obligatorioStr = $horario->getAlias()."_OBLIGATORIO";
    for ($j = 0; $j< count( array_values( $dataTipos)[0]);$j++){
        $horarioTipoRestriccion = new CHorarioTipoRestriccion();
        $horarioTipoRestriccion->setIdhorario($horario->getId());
        $horarioTipoRestriccion->setIdtipo(array_values( $dataTipos["ID"])[$j]);
        $horarioTipoRestriccion->setMaximo(array_values( $dataTipos[$maximoStr])[$j]);
        $obligatorio = strtoupper( array_values( $dataTipos[$obligatorioStr])[$j]);
        $horarioTipoRestriccion->setObligatorio( ($obligatorio == "SI")? 1: 0 );
        $horarioTipoRestricciones[] = $horarioTipoRestriccion;
    }
}

/*
 * Procesar productos
 */

$idtipo = function ($alias) use ($tipos){
    foreach ($tipos as $tipo){
        if($tipo->getAlias() == trim($alias)) return $tipo->getId();
    }
    return null;
};

$productos = [];
for ($k = 0; $k< count( array_values( $dataProductos)[0]);$k++){
    $cProducto = new CProducto();
    $cProducto->setId( array_values( $dataProductos["ID"])[$k]);
    $cProducto->setNombre(mb_strtoupper( array_values($dataProductos["NOMBRE"])[$k]));
    $cProducto->setKcal(array_values( $dataProductos["KCAL"])[$k]);
    $cProducto->setMedida(array_values( $dataProductos["MEDIDA"])[$k]);
    $tipo = array_values( $dataProductos["TIPO"])[$k];
    $cProducto ->setIdtipo( $idtipo($tipo)  );
    $productos [] = $cProducto;
}

$horarioProductoRestricciones = [];

foreach($horarios as $i=>$horario){
    $alias = $horario->getAlias();
    for ($l = 0; $l< count( array_values( $dataProductos)[0]);$l++){
        $horarioProductoRestriccion = new CHorarioProductoRestriccion();
        $horarioProductoRestriccion->setIdhorario($horario->getId());
        $horarioProductoRestriccion->setIdproducto(array_values( $dataProductos["ID"])[$l]);
        $consumir = strtoupper( array_values( $dataProductos[$alias])[$l]);
        $horarioProductoRestriccion->setConsumir( ($consumir == "SI")? 1: 0 );
        $horarioProductoRestricciones[] = $horarioProductoRestriccion;
    }
}



/*
 * Carga de datos
 */

DConexion::desabilitarKeys();


(new DProducto())->limpiar();
(new DHorarioTipoRestriccion())->limpiar();
(new DHorarioProductoRestriccion())->limpiar();
(new DTipoProducto())->limpiar();
(new DHorario())->limpiar();


foreach ($horarios as $horario){
    (new DHorario())->registrar($horario);
}
foreach ($tipos as $tipo){
    (new DTipoProducto())->registrar($tipo);
}
foreach ($horarioTipoRestricciones as $horarioTipoRestriccion){
    (new DHorarioTipoRestriccion())->registrar($horarioTipoRestriccion);
}
foreach ($productos as $producto){
   (new DProducto())->registrar($producto);
}

foreach ($horarioProductoRestricciones as $horarioproductoRestriccionx){
    (new DHorarioProductoRestriccion())->registrar($horarioproductoRestriccionx);
}

(new DFactRecomendacion())->cargarHechos();
DConexion::habilitarKeys();

echo "Archivos cargados correctamente";