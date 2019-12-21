<?php


class CHoja
{

    function procesarHoja($hoja){
        $data = array();
        $cabecera = [];
        foreach ($hoja->getRowIterator() as  $index=> $row) {
            if ($index == 1){
                //Leer Cabecera
                $cells = $row->getCells();
                foreach ($cells as $column) {
                    $columna = $column->getValue();
                    $cabecera[] = $columna;
                    $data[ $columna ] = array();
                }
            }else{
                //Leer el resto de filas
                $cells = $row->getCells();
                foreach ($cells as $j=> $cell){
                    $data[$cabecera[$j]][] = $cell->getValue();
                }
            }
        }


        return $data;
    }

}