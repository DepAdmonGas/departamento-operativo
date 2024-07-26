<?php
require ('app/help.php');

if ($Session_IDUsuarioBD == "") {
  header("Location:" . PORTAL . "");
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
  <script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.14.0/umd/popper.min.js"></script>
  <script src="https://ajax.googleapis.com/ajax/libs/jqueryui/1.12.1/jquery-ui.min.js"></script>
  <script type="text/javascript" src="<?= RUTA_JS2 ?>alertify.js"></script>
  <link href="https://fonts.googleapis.com/css?family=Montserrat" rel="stylesheet">
  <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/3.7.0/animate.min.css">

  <script type="text/javascript">

    $(document).ready(function ($) {
      $(".LoaderPage").fadeOut("slow");

    });

    function Regresar() {
      window.history.back();
    }


  </script>
</head>

<body>
  <div class="LoaderPage"></div>
  <?php

  $sql_dia = "SELECT fecha FROM op_corte_dia WHERE id = '" . $GET_idReporte . "' ";
  $result_dia = mysqli_query($con, $sql_dia);
  while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
    $dia = $row_dia['fecha'];
  }

  function TarjetasCB($idReporte, $concepto, $con)
  {
    $sql_cb = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' AND concepto = '" . $concepto . "' LIMIT 1 ";
    $result_cb = mysqli_query($con, $sql_cb);
    while ($row_cb = mysqli_fetch_array($result_cb, MYSQLI_ASSOC)) {
      $baucher = $row_cb['baucher'];
    }

    return $baucher;
  }


  $bancomer = TarjetasCB($GET_idReporte, "BBVA BANCOMER SA", $con);
  $amex = TarjetasCB($GET_idReporte, "AMERICAN EXPRESS", $con);
  $inburgas = TarjetasCB($GET_idReporte, "INBURSA", $con);

  $totalTB = $bancomer + $amex + $inburgas;

  $ticketcard = TarjetasCB($GET_idReporte, "TICKETCARD", $con);
  $g500fleet = TarjetasCB($GET_idReporte, "G500 FLETT", $con);
  $efecticard = TarjetasCB($GET_idReporte, "EFECTICARD", $con);
  $sodexo = TarjetasCB($GET_idReporte, "SODEXO", $con);

  $totalTarjetas = $ticketcard + $g500fleet + $efecticard + $sodexo;

  $sql_CCPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $GET_idReporte . "' AND concepto = 'CRÉDITO (ANEXO)' LIMIT 1 ";
  $result_CCPC = mysqli_query($con, $sql_CCPC);
  while ($row_CCPC = mysqli_fetch_array($result_CCPC, MYSQLI_ASSOC)) {
    $pagoC = $row_CCPC['pago'];
    $consumoC = $row_CCPC['consumo'];
  }

  $sql_CDPC = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $GET_idReporte . "' AND concepto = 'DEBITO (ANEXO)' LIMIT 1 ";
  $result_CDPC = mysqli_query($con, $sql_CDPC);
  while ($row_CDPC = mysqli_fetch_array($result_CDPC, MYSQLI_ASSOC)) {
    $pagoD = $row_CDPC['pago'];
    $consumoD = $row_CDPC['consumo'];
  }

  $totalPago = $pagoC + $pagoD;
  $totalConsumo = $consumoC + $consumoD;

  ?>

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
              <li aria-current="page" class="breadcrumb-item active text-uppercase">Monedero
                (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia) ?>)</li>
            </ol>
          </div>
          <div class="row">
            <div class="col-12">
              <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
                Monedero (<?= $ClassHerramientasDptoOperativo->FormatoFecha($dia); ?>)
              </h3>
            </div>
          </div>
          <hr>
        </div>

        <div class="table-responsive">
          <table class="custom-table " style="font-size: .80em;" width="100%">
            <thead class="tables-bg">
              <tr>
                <th class="text-center align-middle" colspan="8">MÉTODOS DE PAGO</th>
                <th class="text-center align-middle" colspan="6">CARTERA DE CLIENTES ATIO</th>
              </tr>
              <tr class="title-table-bg">
                <td class="text-center align-middle fw-bold" colspan="4">TARJETAS BANCARIAS</td>
                <th class="text-center align-middle" colspan="4">OTRAS TARJETAS</th>
                <th class="text-center align-middle" colspan="2">CRÉDITO</th>
                <th class="text-center align-middle" colspan="2">DÉBITO</th>
                <th class="text-center align-middle">PAGOS</th>
                <td class="text-center align-middle fw-bold">CONSUMOS</td>
              </tr>
              <tr class="title-table-bg">
                <td class="text-center align-middle fw-bold">BANCOMER</td>
                <th class="text-center align-middle">AMEX</th>
                <th class="text-center align-middle">INBURSA</th>
                <th class="text-center align-middle">TOTAL</th>

                <th class="text-center align-middle">EDENRED</th>
                <!-- <th class="text-center align-middle" >G500 FLETT</th> -->
                <th class="text-center align-middle">EFECTIVALE</th>


                <th class="text-center align-middle">SODEXO</th>
                <th class="text-center align-middle">TOTAL</th>
                <th class="text-center align-middle">Pagos</th>
                <th class="text-center align-middle">Consumos</th>
                <th class="text-center align-middle">Pagos</th>
                <th class="text-center align-middle">Consumos</th>
                <th class="text-center align-middle">TOTAL</th>
                <td class="text-center align-middle fw-bold">TOTAL</td>
              </tr>
            </thead>
            <tbody class="bg-white">
              <tr>
                <th class="align-middle text-end">
                  $<?= number_format($bancomer, 2); ?>
                </th>
                <td class="align-middle text-end">
                  $<?= number_format($amex, 2); ?>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($inburgas, 2); ?>
                </td>
                <td class="align-middle text-end">
                  <strong>$<?= number_format($totalTB, 2); ?></strong>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($ticketcard, 2); ?>
                </td>

                <!-- 
                        <td class="align-middle text-end">
                        $<?= number_format($g500fleet, 2); ?>
                        </td>
                        -->

                <td class="align-middle text-end">
                  $<?= number_format($efecticard, 2); ?>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($sodexo, 2); ?>
                </td>
                <td class="align-middle text-end">
                  <strong>$<?= number_format($totalTarjetas, 2); ?></strong>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($pagoC, 2); ?>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($consumoC, 2); ?>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($pagoD, 2); ?>
                </td>
                <td class="align-middle text-end">
                  $<?= number_format($consumoD, 2); ?>
                </td>
                <td class="align-middle text-end">
                  <strong>$<?= number_format($totalPago, 2); ?></strong>
                </td>
                <td class="align-middle text-end">
                  <strong>$<?= number_format($totalConsumo, 2); ?></strong>
                </td>
              </tr>
            </tbody>
          </table>
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