<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
}

function IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con)
{
  $sql_year = "SELECT id, id_estacion, year FROM op_corte_year WHERE id_estacion = '" . $Session_IDEstacion . "' AND year = '" . $GET_year . "' ";
  $result_year = mysqli_query($con, $sql_year);
  while ($row_year = mysqli_fetch_array($result_year, MYSQLI_ASSOC)) {
    $idyear = $row_year['id'];
  }

  $sql_mes = "SELECT id, id_year, mes FROM op_corte_mes WHERE id_year = '" . $idyear . "' AND mes = '" . $GET_mes . "' ";
  $result_mes = mysqli_query($con, $sql_mes);
  $idmes = 0;
  while ($row_mes = mysqli_fetch_array($result_mes, MYSQLI_ASSOC)) {
    $idmes = $row_mes['id'];
  }
  return $idmes;
}

$IdReporte = IdReporte($Session_IDEstacion, $GET_year, $GET_mes, $con);

if ($GET_mes == 1) {
  $Year = $GET_year - 1;
  $Mes = 12;
  if (IdReporte($Session_IDEstacion, $Year, $Mes, $con) == "") {
    $IdReporteA = 0;
  } else {
    $IdReporteA = IdReporte($Session_IDEstacion, $Year, $Mes, $con);
  }
} else {
  $Mes = $GET_mes - 1;
  if (IdReporte($Session_IDEstacion, $GET_year, $Mes, $con) == "") {
    $IdReporteA = 0;
  } else {
    $IdReporteA = IdReporte($Session_IDEstacion, $GET_year, $Mes, $con);
  }
}

$sql_fin = "SELECT id FROM op_consumos_pagos_resumen_finalizar WHERE id_mes = '" . $IdReporte . "' LIMIT 1 ";
$result_fin = mysqli_query($con, $sql_fin);
$numero_fin = mysqli_num_rows($result_fin);
if ($numero_fin == 0) {
  Resumen($IdReporte, $Session_IDEstacion, $con);
  ActSaldoInicial($IdReporte, $IdReporteA, $con);
  ActPagosConsumos($IdReporte, $IdReporteA, $con);
  ActSaldoFinal($IdReporte, $IdReporteA, $con);
} else {
  //ActPagosConsumos($IdReporte,$IdReporteA,$con);
  //ActSaldoFinal($IdReporte,$IdReporteA,$con);
}

function Resumen($IdReporte, $idEstacion, $con)
{
  $sql = "SELECT * FROM op_cliente WHERE id_estacion = '" . $idEstacion . "' AND estado = 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $id = $row['id'];
    ValidaResumen($IdReporte, $id, $con);
  }
}

function ValidaResumen($IdReporte, $id, $con)
{
  $sql = "SELECT * FROM op_consumos_pagos_resumen WHERE id_mes = '" . $IdReporte . "' AND id_cliente = '" . $id . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);

  if ($numero == 0) {
    $sql_insert = "INSERT INTO op_consumos_pagos_resumen (
    id_mes,
    id_cliente,
    saldo_inicial,
    consumos,
    pagos,
    saldo_final
    )
    VALUES
    (
    '" . $IdReporte . "',
    '" . $id . "',
    0,
    0,
    0,
    0
    )";

    mysqli_query($con, $sql_insert);
  }
}

//-----------------------------------------------------------------------------

function ConsumoPago($idResumen, $IdReporte, $idcliente, $con)
{
  $sql = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  $totalCo = 0;
  $totalPa = 0;
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $reportedia = $row['id'];

    $Consumo = TotalCP($reportedia, $idcliente, 'Consumo', $con);
    $totalCo = $totalCo + $Consumo;

    $Pago = TotalCP($reportedia, $idcliente, 'Pago', $con);
    $totalPa = $totalPa + $Pago;

  }

  $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET consumos = '" . $totalCo . "' WHERE id='" . $idResumen . "' ";
  mysqli_query($con, $sql_edit1);

  $sql_edit2 = "UPDATE op_consumos_pagos_resumen SET pagos = '" . $totalPa . "' WHERE id='" . $idResumen . "' ";
  mysqli_query($con, $sql_edit2);
}

function TotalCP($reportedia, $idCliente, $tipo, $con)
{

  $sql_c = "SELECT total FROM op_consumos_pagos WHERE id_reportedia = '" . $reportedia . "' AND id_cliente = '" . $idCliente . "' AND tipo = '" . $tipo . "' ";
  $result_c = mysqli_query($con, $sql_c);
  $numero_c = mysqli_num_rows($result_c);

  if ($numero_c > 0) {
    $total = 0;
    while ($row_c = mysqli_fetch_array($result_c, MYSQLI_ASSOC)) {
      $total = $total + $row_c['total'];
    }
  } else {
    $total = 0;
  }

  return $total;

}

function SaldoInicial($IdReporteA, $idResumen, $idcliente, $con)
{

  $sql = "SELECT saldo_final FROM op_consumos_pagos_resumen WHERE id_mes = '" . $IdReporteA . "' AND id_cliente = '" . $idcliente . "' LIMIT 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  if ($numero == 1) {

    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
      $saldoFinal = $row['saldo_final'];
    }

    if ($saldoFinal != 0) {

      $sql_edit = "UPDATE op_consumos_pagos_resumen SET saldo_inicial = '" . $saldoFinal . "' WHERE id='" . $idResumen . "' ";
      mysqli_query($con, $sql_edit);

    }
  }
}

function SaldoFinal($idResumen, $saldoFinal, $con)
{
  $sql_edit1 = "UPDATE op_consumos_pagos_resumen SET saldo_final = '" . $saldoFinal . "' WHERE id='" . $idResumen . "' ";
  mysqli_query($con, $sql_edit1);
}

//-----------------------------------------------------------------

function ActSaldoInicial($IdReporte, $IdReporteA, $con)
{
  $saldoFinal = 0;
  $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '" . $IdReporte . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $idResumen = $row['id'];
    $idcliente = $row['id_cliente'];
    SaldoInicial($IdReporteA, $idResumen, $idcliente, $con);
    ConsumoPago($idResumen, $IdReporte, $idcliente, $con);
  }
}

function ActPagosConsumos($IdReporte, $IdReporteA, $con)
{
  $saldoFinal = 0;
  $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '" . $IdReporte . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $idResumen = $row['id'];
    $idcliente = $row['id_cliente'];
    ConsumoPago($idResumen, $IdReporte, $idcliente, $con);
  }
}

function ActSaldoFinal($IdReporte, $IdReporteA, $con)
{
  $saldoFinal = 0;
  $sql = "SELECT id, id_mes, id_cliente,saldo_inicial,consumos,pagos FROM op_consumos_pagos_resumen WHERE id_mes = '" . $IdReporte . "' ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
    $idResumen = $row['id'];
    $idcliente = $row['id_cliente'];
    $saldoFinal = $row['saldo_inicial'] + $row['consumos'] - $row['pagos'];
    SaldoFinal($idResumen, $saldoFinal, $con);
  }
}
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/2.9.2/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">


  <style media="screen">
    .inputD:disabled {
      background: white;
    }

    .tableFixHead {
      overflow-y: scroll;
    }

    .tableFixHead thead th {
      position: sticky;
      top: 0px;
      box-shadow: 2px 2px 7px #ECECEC;
    }
  </style>

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");
      ReporteClientes(<?= $IdReporte; ?>);

    });

    function Regresar() {
      window.history.back();
    }

    function ReporteClientes(IdReporte) {
      $('#DivReporteClientes').load('../../public/corte-diario/vistas/reporte-clientes-mes.php?IdReporte=' + IdReporte);
    }

    function ESICredito(id) {


      var total = $('#ESICredito' + id).val();


      var parametros = {
        "id": id,
        "total": total
      };

      $.ajax({
        data: parametros,
        url: '../../public/corte-diario/modelo/editar-saldo-inicial.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {

          $('#SaldoF' + id).text(response)

        }
      });

    }

    function Finalizar(IdReporte) {

      var parametros = {
        "IdReporte": IdReporte,
        "accion":"finaliza-resumen-cliente-mes"
      };

      $.ajax({
        data: parametros,
        url: '../../app/controlador/1-corporativo/controladorCorteDiario.php',
        //url:   '../../public/corte-diario/modelo/finalizar-resumen-clientes-mes.php',
        type: 'post',
        beforeSend: function () {
        },
        complete: function () {

        },
        success: function (response) {
          ReporteClientes(IdReporte);

        }
      });
    }

  </script>
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

        <div class="col-12 mb-3">
          <div class="cardAG">
            <div class="border-0 p-3">

              <div class="row">

                <div class="col-12">

                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="Regresar()">
                  <div class="row">

                    <div class="col-12">

                      <h5>
                        Clientes, <?= nombremes($GET_mes); ?> <?= $GET_year; ?>
                      </h5>

                    </div>

                  </div>

                </div>

              </div>

              <hr>

              <div id="DivReporteClientes"></div>


            </div>
          </div>
        </div>

      </div>
    </div>

  </div>



  <!---------- FUNCIONES - NAVBAR ---------->
  <script
    src="https://cdnjs.cloudflare.com/ajax/libs/malihu-custom-scrollbar-plugin/3.1.5/jquery.mCustomScrollbar.concat.min.js"></script>

  <script src="<?= RUTA_JS2 ?>bootstrap.min.js"></script>

</body>

</html>