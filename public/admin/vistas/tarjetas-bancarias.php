<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th colspan="3" class="text-center fw-bold">MONEDEROS Y BANCOS</th>
      <tr class="title-table-bg">
        <td class="text-center fw-bold" colspan="2">CONCEPTO / BANCO</td>
        <td class="text-center fw-bold">IMPORTE</td>
      </tr>

    </thead>

    <tbody class="bg-white">
      <?php
      $baucherTotal = 0;
      $sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' ";
      $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
      while ($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)) {

        $idTarjeta = $row_listatarjetas['id'];
        $num = $row_listatarjetas['num'];
        $conceptoTarjeta = $row_listatarjetas['concepto'];
        $baucher = $row_listatarjetas['baucher'];
        $baucherTotal = $baucherTotal + $baucher;
        ?>

        <tr>
          <th class="no-hover align-middle text-center"><b><?= $num; ?></b></th>
          <td class="no-hover align-middle"><?= $conceptoTarjeta; ?></td>

          <td class="no-hover align-middle text-end">
            <?= number_format($baucher, 2); ?>
          </td>


        </tr>

        <?php
      }

      ?>
      <tr>
        <th class="text-center disabledOP" colspan="2">TOTAL 2</th>
        <td class="align-middle text-end disabledOP"><strong><?= number_format($baucherTotal, 2); ?></strong></td>
      </tr>
    </tbody>
  </table>

</div>