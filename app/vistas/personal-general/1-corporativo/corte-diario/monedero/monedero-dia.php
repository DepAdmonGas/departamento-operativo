<?php
require 'app/vistas/contenido/header.php';
$dia = $corteDiarioGeneral->getDia($GET_idReporte);
  $bancomer = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "BBVA BANCOMER SA");
  $amex = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "AMERICAN EXPRESS");
  $inburgas = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "INBURGAS");
  $inbursa = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "INBURSA");

  $totalTB = $bancomer + $amex + $inburgas + $inbursa;

  $ticketcard = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "TICKETCARD");
  $g500fleet = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "G500 FLETT");
  $efecticard = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "EFECTICARD");
  $sodexo = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "SODEXO");

  $totalTarjetas = $ticketcard + $g500fleet + $efecticard + $sodexo;

  $valaccord = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "VALE ACCORD");
  $valefectivale = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "VALE EFECTIVALE");
  $valsodexo = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "VALE SODEXO");
  $valvale = $corteDiarioGeneral->tarjetasCB($GET_idReporte, "SI VALE");

  $totalVales = $valaccord + $valefectivale + $valsodexo + $valvale;
  $pago = "pago";
  $consumo = "consumo";
  $conceptoCredito = "CRÉDITO (ANEXO) LIMIT 1";
  $conceptoDebito = "DEBITO (ANEXO) LIMIT 1";
  $pagoC = $corteDiarioGeneral->clientesControlgas($pago,$GET_idReporte,$conceptoCredito);
  $consumoC = $corteDiarioGeneral->clientesControlgas($consumo,$GET_idReporte,$conceptoCredito);
  $pagoD = $corteDiarioGeneral->clientesControlgas($consumo,$GET_idReporte,$conceptoDebito);
  $consumoD = $corteDiarioGeneral->clientesControlgas($consumo,$GET_idReporte,$conceptoDebito);
  $totalPago = $pagoC + $pagoD;
  $totalConsumo = $consumoC + $consumoD;
?>
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
                  <img class="float-start pointer" src="<?= RUTA_IMG_ICONOS; ?>regresar.png" onclick="history.back()">
                  <div class="row">
                    <div class="col-12">
                      <h5>Monedero, <?= FormatoFecha($dia); ?></h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <div class="table-responsive">
                <table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
                  <thead>
                    <tr>
                      <th class="text-center align-middle" colspan="14"></th>
                      <th class="text-center align-middle" colspan="2">CRÉDITO</th>
                      <th class="text-center align-middle" colspan="2">DÉBITO</th>
                      <th class="text-center align-middle">PAGOS</th>
                      <th class="text-center align-middle">CONSUMOS</th>
                    </tr>

                    <tr>
                      <th class="text-center align-middle" colspan="5">TARJETAS BANCARIAS</th>
                      <th class="text-center align-middle" colspan="4">TARJETAS</th>
                      <th class="text-center align-middle" colspan="5">VALES</th>
                      <th class="text-center align-middle" colspan="6">Cartera de Clientes ATIO </th>
                    </tr>

                    <tr class="tables-bg">
                      <th class="text-center align-middle">BANCOMER</th>
                      <th class="text-center align-middle">AMEX</th>
                      <th class="text-center align-middle">INBURGAS</th>
                      <th class="text-center align-middle">INBURSA</th>
                      <th class="text-center align-middle">TOTAL</th>

                      <th class="text-center align-middle">TICKETCARD</th>
                      <!-- <th class="text-center align-middle" >G500 FLETT</th> -->
                      <th class="text-center align-middle">EFECTICARD</th>
                      <th class="text-center align-middle">SODEXO</th>
                      <th class="text-center align-middle">TOTAL</th>

                      <th class="text-center align-middle">VALE ACCORD</th>
                      <th class="text-center align-middle">VALE EFECTIVALE</th>
                      <th class="text-center align-middle">VALE SODEXO</th>
                      <th class="text-center align-middle">SI VALE</th>
                      <th class="text-center align-middle">TOTAL</th>

                      <th class="text-center align-middle">Pagos</th>
                      <th class="text-center align-middle">Consumos</th>
                      <th class="text-center align-middle">Pagos</th>
                      <th class="text-center align-middle">Consumos</th>
                      <th class="text-center align-middle">TOTAL</th>
                      <th class="text-center align-middle">TOTAL</th>
                    </tr>
                  </thead>
                  <tbody>
                    <tr class="bg-light">
                      <td class="align-middle text-end">
                        $<?= number_format($bancomer, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $<?= number_format($amex, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $<?= number_format($inburgas, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $<?= number_format($inbursa, 2); ?>
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

                      <!----------------------------------------------------->
                      <td class="align-middle text-end">
                        $
                        <?= number_format($valaccord, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($valefectivale, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($valsodexo, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($valvale, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        <strong>$
                          <?= number_format($totalVales, 2); ?>
                        </strong>
                      </td>

                      <!----------------------------------------------------->
                      <td class="align-middle text-end">
                        $
                        <?= number_format($pagoC, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($consumoC, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($pagoD, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        $
                        <?= number_format($consumoD, 2); ?>
                      </td>
                      <td class="align-middle text-end">
                        <strong>$
                          <?= number_format($totalPago, 2); ?>
                        </strong>
                      </td>
                      <td class="align-middle text-end">
                        <strong>$
                          <?= number_format($totalConsumo, 2); ?>
                        </strong>
                      </td>
                    </tr>
                  </tbody>
                </table>
              </div>



            </div>
          </div>
        </div>

      </div>
    </div>

  </div>
</body>
</html>