<?php
  session_start();
  $validarUsuario = true;
include 'validar_usuario.php';
include 'imports.php';

?>
<!doctype html>
<html lang="es">
  <head>
    <meta charset="utf-8">
    <meta name="viewport" content="width=device-width, initial-scale=1, shrink-to-fit=no">
    <meta name="description" content="">
    <meta name="author" content="">
    <link rel="icon" href="/images/logo.png">

    <title><?= $title ?></title>

    <link rel="canonical" href="https://getbootstrap.com/docs/4.0/examples/sticky-footer-navbar/">

    <!-- Bootstrap core CSS -->
    <link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/css/bootstrap.min.css" integrity="sha384-ggOyR0iXCbMQv3Xipma34MD+dH/1fQ784/j6cY/iJTQUOhcWr7x9JvoRxT2MZw1T" crossorigin="anonymous">


    <link href="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.3.1/main.css" rel="stylesheet" >
    <link href="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.css" rel="stylesheet" >
    <link href="https://fonts.googleapis.com/icon?family=Material+Icons" rel="stylesheet">
    <link href="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/css/toastr.min.css" rel="stylesheet">

      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>
      <link rel="stylesheet" type="text/css" href="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.css"/>

    <link rel="stylesheet" type="text/css" href="https://cdn.jsdelivr.net/npm/sweetalert2@9.6.1/dist/sweetalert2.min.css" />
    <!-- Custom styles for this template -->
    <link href="public/css/fixed_navbar.css" rel="stylesheet">
    <script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.4.1/jquery.min.js" ></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.7/umd/popper.min.js" integrity="sha384-UO2eT0CpHqdSJQ6hJty5KVphtPhzWj9WO1clHTMGa3JDZwrnQq4sF86dIHNDz0W1" crossorigin="anonymous"></script>
    <script src="https://stackpath.bootstrapcdn.com/bootstrap/4.3.1/js/bootstrap.min.js" integrity="sha384-JjSmVgyd0p3pXB1rRibZUAYoIIy6OrQ6VrjIEaFf/nJGzIxFDsf4x0xIM+B07jRM" crossorigin="anonymous"></script>

    <script src="https://cdn.jsdelivr.net/npm/@fullcalendar/core@4.3.1/main.min.js"></script>

    <script src="https://unpkg.com/@fullcalendar/daygrid@4.3.0/main.min.js" ></script>
    <script src="https://unpkg.com/@fullcalendar/interaction@4.3.0/main.min.js"></script>

    <script src="https://www.jsviews.com/download/jsrender.min.js"></script>
    <script src="https://www.jsviews.com/download/jsviews.min.js"></script>
    <script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/js/toastr.min.js"></script>
      <script src="https://cdn.jsdelivr.net/npm/sweetalert2@9.6.1/dist/sweetalert2.min.js"></script>
    <script>
        var ruta_imagenes = '<?= $ruta_imagenes_js?>';
    </script>
      <script src="public/js/jquery.form.min.js"></script>
    <script src="public/js/funs.js?v=1s112"></script>

    <script type="text/javascript" src="https://cdn.datatables.net/v/bs4/dt-1.10.20/datatables.min.js"></script>
      <script>
          function languageDataTable(){
              return  {

                  "sProcessing":     "Procesando...",
                  "sLengthMenu":     "Mostrar _MENU_ registros",
                  "sZeroRecords":    "No se encontraron resultados",
                  "sEmptyTable":     "Ningún dato disponible en esta tabla",
                  "sInfo":           "Total  <span class='badge badge-dark'> _TOTAL_  </span> registros",
                  "sInfoEmpty":      "",
                  "sInfoFiltered":   "",
                  "sInfoPostFix":    "",
                  "sSearch":         "Buscar:",
                  "sUrl":            "",
                  "sInfoThousands":  ",",
                  "sLoadingRecords": "Cargando...",
                  "oPaginate": {
                      "sFirst":    "Primero",
                      "sLast":     "Último",
                      "sNext":     "Siguiente",
                      "sPrevious": "Anterior"
                  },
                  "oAria": {
                      "sSortAscending":  ": Activar para ordenar la columna de manera ascendente",
                      "sSortDescending": ": Activar para ordenar la columna de manera descendente"
                  }
              }
          }

          function drawCallbackDataTable(){
              return function(oSettings) {
                  if (oSettings._iDisplayLength > oSettings.fnRecordsDisplay()) {
                      // $(oSettings.nTableWrapper).find('.dataTables_paginate').hide();
                  }
              };
          }
      </script>
    <style>

    #modalEvento .material-icons{
      font-size: 18px;
    }
    .mayusculas{
      text-transform: uppercase;
    }
    .minusculas{
      text-transform: lowercase;
    }

    @media screen and (min-width: 780px) {
        
      .modal-80{
        width: 80%;
        max-width: 80%;
        margin-left: 10.5%;
      }
      
    }
 
    </style>
    
  </head>

  <body>