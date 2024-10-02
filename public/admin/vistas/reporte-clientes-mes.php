<?php
require ('../../../app/help.php');

$IdReporte = $_GET['IdReporte'];

$sql_credito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Crédito' AND op_cliente.estado = 1 ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

$sql_debito = "SELECT 
op_consumos_pagos_resumen.id,
op_consumos_pagos_resumen.id_mes,
op_consumos_pagos_resumen.id_cliente,
op_consumos_pagos_resumen.saldo_inicial,
op_consumos_pagos_resumen.consumos,
op_consumos_pagos_resumen.pagos,
op_consumos_pagos_resumen.saldo_final,
op_cliente.id_estacion,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo,
op_cliente.estado
FROM op_consumos_pagos_resumen
INNER JOIN op_cliente 
ON op_consumos_pagos_resumen.id_cliente = op_cliente.id
WHERE op_consumos_pagos_resumen.id_mes = '" . $IdReporte . "' AND op_cliente.tipo = 'Débito' AND op_cliente.estado = 1 ";
$result_debito = mysqli_query($con, $sql_debito);
$numero_debito = mysqli_num_rows($result_debito);


?>

<div class="col-12">
  <div class="table-responsive">
    <table id="resumen-clientes-credito" class="custom-table" style="font-size: .80em;" width="100%">
      <thead class="title-table-bg">
        <tr class="tables-bg">
          <th class="text-center align-middle fw-bold" colspan="7">Crédito</th>
        </tr>
        <tr>
          <td class="text-center align-middle fw-bold">#</td>
          <th class="align-middle text-center">Cuenta</th>
          <th class="align-middle text-center">Cliente</th>
          <th class="align-middle text-center">Saldo inicio</th>
          <th class="align-middle text-center">Consumos</th>
          <th class="align-middle text-center">Pagos</th>
          <td class="align-middle text-center fw-bold">Saldo final</td>
        </tr>
      </thead>
      <tbody class="bg-white">
        <?php
        $Csaldoinicial = 0;
        $Cconsumos = 0;
        $Cpagos = 0;
        $CSaFi = 0;
        $TSIC = 0;
        $TCC = 0;
        $TPC = 0;
        $TSFC = 0;
        if ($numero_credito > 0) {
          while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {
            $id = $row_credito['id'];

            $saldofinalC = $row_credito['saldo_inicial'] + $row_credito['consumos'] - $row_credito['pagos'];

            $Csaldoinicial = $Csaldoinicial + $row_credito['saldo_inicial'];
            $Cconsumos = $Cconsumos + $row_credito['consumos'];
            $Cpagos = $Cpagos + $row_credito['pagos'];
            $CSaFi = $CSaFi + $saldofinalC;

            echo '<tr>
                    <th class="align-middle text-center"  style="font-size: .9em;">' . $row_credito['id'] . '</th>
                    <td class="align-middle"  style="font-size: .9em;">' . $row_credito['cuenta'] . '</td>
                    <td class="align-middle"  style="font-size: .9em;">' . $row_credito['cliente'] . '</td>
                    <td class="text-end">$ ' . number_format($row_credito['saldo_inicial'], 2) . '</td>
                    <td class="text-end">$ ' . number_format($row_credito['consumos'], 2) . '</td>
                    <td class="text-end">$ ' . number_format($row_credito['pagos'], 2) . '</td>
                    <td class="text-end">$ ' . number_format($saldofinalC, 2) . '</td>
                  </tr>';

            $TSIC = $TSIC + $row_credito['saldo_inicial'];
            $TCC = $TCC + $row_credito['consumos'];
            $TPC = $TPC + $row_credito['pagos'];
            $TSFC = $TSFC + $row_credito['saldo_final'];

          }

          echo '<tr class="ultima-fila">
                  <th colspan="3" class="text-end">Total Crédito</th>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSIC, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TCC, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TPC, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSFC, 2) . '</td>
                </tr>';

        }
        ?>
      </tbody>
    </table>
  </div>
</div>
<br>
  <div class="col-12">
    <div class="table-responsive">
      <table id="resumen-clientes-debito" class="custom-table" style="font-size: .75em;" width="100%">
        <thead class="title-table-bg">
          <tr class="tables-bg">
            <th class="text-center align-middle fw-bold" colspan="7">Débito</th>
          </tr>
          <tr>
            <td class="align-middle text-center fw-bold">#</td>
            <th class="align-middle text-center">Cuenta</th>
            <th class="align-middle text-center">Cliente</th>
            <th class="align-middle text-center">Saldo inicio</th>
            <th class="align-middle text-center">Consumos</th>
            <th class="align-middle text-center">Pagos</th>
            <td class="align-middle text-center fw-bold">Saldo final</td>
          </tr>
        </thead>
        <tbody class="bg-white">
          <?php
          $Dsaldoinicial = 0;
          $Dconsumos = 0;
          $Dpagos = 0;
          $DSaFi = 0;
          $TSID = 0;
          $TCD = 0;
          $TPD = 0;
          $TSFD = 0;
          if ($numero_debito > 0) {
            while ($row_debito = mysqli_fetch_array($result_debito, MYSQLI_ASSOC)) {
              $id = $row_debito['id'];

              $saldofinalD = $row_debito['saldo_inicial'] + $row_debito['consumos'] - $row_debito['pagos'];

              $Dsaldoinicial = $Dsaldoinicial + $row_debito['saldo_inicial'];
              $Dconsumos = $Dconsumos + $row_debito['consumos'];
              $Dpagos = $Dpagos + $row_debito['pagos'];
              $DSaFi = $DSaFi + $saldofinalD;

              echo '<tr>
                  <th class="align-middle text-center" style="font-size: .9em;">' . $row_debito['id'] . '</th>
                  <td class="align-middle" style="font-size: .9em;">' . $row_debito['cuenta'] . '</td>
                  <td class="align-middle" style="font-size: .9em;">' . $row_debito['cliente'] . '</td>
                  <td class="text-end">$ ' . number_format($row_debito['saldo_inicial'], 2) . '</td>
                  <td class="text-end">$ ' . number_format($row_debito['consumos'], 2) . '</td>
                  <td class="text-end">$ ' . number_format($row_debito['pagos'], 2) . '</td>
                  <td class="text-end">$ ' . number_format($saldofinalD, 2) . '</td>
                  </tr>';

              $TSID = $TSID + $row_debito['saldo_inicial'];
              $TCD = $TCD + $row_debito['consumos'];
              $TPD = $TPD + $row_debito['pagos'];
              $TSFD = $TSFD + $row_debito['saldo_final'];
            }

            echo '<tr class="ultima-fila">
                  <th colspan="3">Total Débito</th>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSID, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TCD, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TPD, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSFD, 2) . '</td>
                </tr>
                <tr class="ultima-fila">
                  <th colspan="3" class="font-weight-bold">GRAN TOTAL</th>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSIC + $TSID, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TCC + $TCD, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TPC + $TPD, 2) . '</td>
                  <td class="text-end font-weight-bold">$ ' . number_format($TSFC + $TSFD, 2) . '</td>
                </tr>';
          }
          ?>
        </tbody>
      </table>
    </div>

  </div>