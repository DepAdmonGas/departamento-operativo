<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <th colspan="3" class="text-center fw-bold">Prosegur</th>
      <tr class="title-table-bg">
        <td class="text-center fw-bold">DENOMINACION</td>
        <th class="text-center">RECIBO</th>
        <td class="text-center fw-bold">IMPORTE</td>
      </tr>

    </thead>

    <tbody class="bg-white">
      <?php
      $totalImporte = 0;
      $sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '" . $idReporte . "' ";
      $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
      while ($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)) {

        $idProsegur = $row_listaprosegur['id'];
        $denominacion = $row_listaprosegur['denominacion'];
        $recibo = $row_listaprosegur['recibo'];

        $valimporte = $row_listaprosegur['importe'];

        $importe = $row_listaprosegur['importe'];

        $totalImporte += $importe;

        ?>

        <tr>
          <th class="align-middle no-hover"><?= $denominacion; ?></th>
          <td class="align-middle no-hover">
            <?= $recibo; ?>
          </td>
          <td class="align-middle no-hover text-end">
            <?= number_format($valimporte, 2); ?>
          </td>
        </tr>

        <?php
      }

      ?>
      <tr>
        <th class="text-center disabledOP" colspan="2">TOTAL 1</th>
        <td class="align-middle text-end disabledOP"><strong><?= number_format($totalImporte, 2); ?></strong></td>
      </tr>
    </tbody>

  </table>
</div>