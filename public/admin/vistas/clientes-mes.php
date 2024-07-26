<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}


function IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $GET_idEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }
  return $idmes;
}

$IdReporte = IdReporte($GET_idEstacion, $GET_year, $GET_mes, $con);

?>

<html lang="es">

<head>
  <meta charset="utf-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge,chrome=1">
  <title>Dirección de operaciones</title>
  <meta name="description" content="">
  <meta name="viewport" content="width=device-width initial-scale=1.0">
  <link rel="shortcut icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="apple-touch-icon" href="<?= RUTA_IMG_ICONOS ?>/icono-web.png">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>alertify.css">
  <link rel="stylesheet" href="<?= RUTA_CSS2 ?>themes/default.rtl.css">
  <link href="<?= RUTA_CSS2; ?>bootstrap.min.css" rel="stylesheet" />
  <link href="<?= RUTA_CSS2; ?>navbar-general.min.css" rel="stylesheet" />
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.3.0/css/all.min.css">

  <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.6.3/jquery.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <style media="screen">
    .inputD:disabled {
      background: white;
    }
  </style>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ReporteClientes(<?= $IdReporte; ?>);
    });

    function ReporteClientes(IdReporte) {
      $('#DivReporteClientes').load('../../../../public/admin/vistas/reporte-clientes-mes.php?IdReporte=' + IdReporte, function () {
        function initializeDataTable(tableId) {
          // Clonar y remover las filas antes de inicializar DataTables
          var $lastRows = $('#' + tableId + ' tr.ultima-fila').clone();
          $('#' + tableId + ' tr.ultima-fila').remove();

          // Inicializar DataTables
          $('#' + tableId).DataTable({
            "language": {
              "url": '<?= RUTA_JS2 ?>' + "/es-ES.json"
            },
            "order": [[0, "desc"]],
            "lengthMenu": [15, 30, 50, 100],
            "columnDefs": [
              { "orderable": false, },
              { "searchable": false, }
            ],
            "drawCallback": function (settings) {
              // Remover cualquier fila 'ultima-fila' existente para evitar duplicados
              $('#' + tableId + ' tr.ultima-fila').remove();
              // Añadir las filas clonadas al final del tbody
              $('#' + tableId + ' tbody').append($lastRows.clone());
            }
          });

          // Añadir las filas clonadas al final del tbody inicial
          $('#' + tableId + ' tbody').append($lastRows);
        }
        // Inicializar ambas tablas
        initializeDataTable('resumen-clientes-credito');
        initializeDataTable('resumen-clientes-debito');

      });

    }


    function Actualizar(IdReporte, idEstacion, year, mes) {

      var parametros = {
        "IdReporte": IdReporte,
        "idEstacion": idEstacion,
        "year": year,
        "mes": mes
      };

      $.ajax({
        data: parametros,
        url: '../../../../public/admin/modelo/actualizar-cliente-mes.php',
        type: 'post',
        beforeSend: function () {
          $(".LoaderPage").show();
        },
        complete: function () {

        },
        success: function (response) {

          if (response == 1) {
            $(".LoaderPage").hide();
            location.reload();
          } else {
            $(".LoaderPage").hide();
            alertify.error('Error al actualizar')
          }

        }
      });

    }

  </script>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <link
    href="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.css"
    rel="stylesheet">

</head>

<body>
  <div class="LoaderPage"></div>

  <!---------- DIV - CONTENIDO ---------->
  <div id="content">
    <!---------- NAV BAR - PRINCIPAL (TOP) ---------->
    <?php include_once "public/navbar/navbar-perfil.php"; ?>
    <!---------- CONTENIDO PAGINA WEB---------->
    <div class="contendAG">
      <div class="row">

        <div class="col-12">
          <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
            <ol class="breadcrumb breadcrumb-caret">
              <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i
                    class="fa-solid fa-chevron-left"></i>
                  Corte Diario, <?= $ClassHerramientasDptoOperativo->nombreMes($GET_mes) ?> <?= $GET_year ?></a></li>
              <li aria-current="page" class="breadcrumb-item active text-uppercase">
                Resumen Clientes (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?> <?= $GET_year ?>)
              </li>
            </ol>
          </div>
          <div class="row">
            <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Resumen Clientes (<?= $ClassHerramientasDptoOperativo->nombremes($GET_mes) ?> <?= $GET_year ?>)
              </h3>
            </div>
            <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
              <?php if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Comercializadora" && $session_nompuesto != "Dirección de operaciones servicio social") { ?>
                <button type="button" class="btn btn-labeled2 btn-primary float-end m-2" onclick="Actualizar(<?= $IdReporte; ?>,<?= $GET_idEstacion; ?>,<?= $GET_year; ?>,<?= $GET_mes; ?>)">
                <span class="btn-label2"><i class="fa fa-rotate"></i></span>Actualizar</button>

              <?php } ?>
            </div>
          </div>
          <hr>
        </div>

        <div id="DivReporteClientes"></div>

      </div>
    </div>

  </div>

  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>
  <script src="<?= RUTA_JS2 ?>navbar-functions.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>
  <!---------- LIBRERIAS DEL DATATABLE ---------->
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/pdfmake.min.js"></script>
  <script src="https://cdnjs.cloudflare.com/ajax/libs/pdfmake/0.2.7/vfs_fonts.js"></script>
  <script
    src="https://cdn.datatables.net/v/bs5/jszip-3.10.1/dt-2.0.3/b-3.0.1/b-colvis-3.0.1/b-html5-3.0.1/b-print-3.0.1/datatables.min.js"></script>

</body>

</html>