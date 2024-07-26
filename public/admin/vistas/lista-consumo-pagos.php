<?php
require ('../../../app/help.php');

$idReporte = $_GET['idReporte'];

$sql_credito = "SELECT
op_consumos_pagos.id,
op_consumos_pagos.id_reportedia,
op_consumos_pagos.id_cliente,
op_consumos_pagos.total,
op_consumos_pagos.tipo AS ConsumoTipo,
op_consumos_pagos.pago,
op_consumos_pagos.comprobante,
op_cliente.cuenta,
op_cliente.cliente,
op_cliente.tipo
FROM op_consumos_pagos 
INNER JOIN op_cliente
ON op_consumos_pagos.id_cliente = op_cliente.id
WHERE op_consumos_pagos.id_reportedia = '" . $idReporte . "' ";
$result_credito = mysqli_query($con, $sql_credito);
$numero_credito = mysqli_num_rows($result_credito);

?>

<div class="table-responsive">
  <table class="custom-table " style="font-size: .80em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th class="align-middle" class="text-center">#</th>
        <th class="align-middle" colspan="3">Cliente</th>
        <th class="align-middle">Consumo/Pago</th>
        <th class="align-middle">Forma Pago</th>
        <th class="align-middle text-center" width="20px">
          <img width="20px" src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
        </th>
        <th class="align-middle" class="text-end">Total</th>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      $Toconsumo = 0;
      $Topago = 0;
      if ($numero_credito > 0) {
        while ($row_credito = mysqli_fetch_array($result_credito, MYSQLI_ASSOC)) {

          $id = $row_credito['id'];

          if ($row_credito['ConsumoTipo'] == "Consumo") {
            $consumo = $row_credito['total'];
            $Toconsumo = $Toconsumo + $consumo;
          } else if ($row_credito['ConsumoTipo'] == "Pago") {
            $pago = $row_credito['total'];
            $Topago = $Topago + $pago;
          }

          if ($row_credito['pago'] == "") {
            $TipoPago = "N/A";
          } else {
            $TipoPago = $row_credito['pago'];
          }

          if ($row_credito['comprobante'] == "") {
            $comprobante = "N/A";
          } else {
            $comprobante = '<a href="../../../../archivos/' . $row_credito['comprobante'] . '" download><img class="pointer" width="20px" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
          }

          if ($row_credito['tipo'] == "Crédito") {
            $CTipo = "text-primary";
          } else if ($row_credito['tipo'] == "Débito") {
            $CTipo = "text-success";
          }


          echo '<tr>
                  <th class="align-middle font-weight-light text-center"  style="font-size: 1em;">' . $row_credito['id'] . '</th>
                  <td class="align-middle font-weight-light">' . $row_credito['cuenta'] . '</td>
                  <td class="align-middle font-weight-light">' . $row_credito['cliente'] . '</td>
                  <td class="align-middle font-weight-light ' . $CTipo . ' ">' . $row_credito['tipo'] . '</td>
                  <td class="align-middle font-weight-light">' . $row_credito['ConsumoTipo'] . '</td>
                  <td class="align-middle font-weight-light">' . $TipoPago . '</td>
                  <td class="align-middle font-weight-light text-center">' . $comprobante . '</td>
                  <td class="align-middle text-end"><b>$ ' . number_format($row_credito['total'], 2) . '</b></td>
                </tr>';
        }
        echo '<tr>
                <th colspan="6" class="align-middle text-end"><b>Total Consumo:</b></th>
                <td colspan="2" class="text-end"><b>$ ' . number_format($Toconsumo, 2) . '</b></td>
                </tr>
                <tr>
                <th colspan="6" class="align-middle text-end"><b>Total Pago:</b></th>
                <td colspan="2" class="text-end"><b>$ ' . number_format($Topago, 2) . '</b></td>

              </tr>';
      } else {
        echo '<tr><th colspan="8" class="text-center"><small>No se encontró información</small></th></tr>';
      }
      ?>
    </tbody>
  </table>
</div>