<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$empresa = $_GET['empresa'];

?>

<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
      <tr class="tables-bg">
        <th colspan="4" class="text-center"><?= $empresa ?></th>
      </tr>
      <tr>
        <td class="text-center fw-bold">No. Cierre de lote</td>
        <th class="text-center">Importe</th>
        <th class="text-center">No. De ticktes</th>
        <td class="text-center fw-bold"></td>
      </tr>

    </thead>
    <tbody class="bg-white">
      <?php
      $TotalImporte = 0;
      $TotalTicket = 0;
      $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '" . $idReporte . "' AND empresa = '" . $empresa . "' ";
      $result_listacierre = mysqli_query($con, $sql_listacierre);
      while ($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)) {

        $idCierre = $row_listacierre['id'];
        $nocierre = $row_listacierre['no_cierre_lote'];

        $estado = $row_listacierre['estado'];

        $valimporte = $row_listacierre['importe'];

        if ($row_listacierre['ticktes'] == 0) {
          $noticket = "";
        } else {
          $noticket = $row_listacierre['ticktes'];
        }

        $TotalImporte = $TotalImporte + $row_listacierre['importe'];
        $TotalTicket = $TotalTicket + $row_listacierre['ticktes'];


        ?>
        <tr>
          <td class="no-hover align-middle">
            <?= $nocierre; ?>
          </td>
          <td class="no-hover align-middle text-end">
            $ <?= number_format($valimporte, 2); ?>
          </td>
          <td class="no-hover align-middle text-center">
            <?= $noticket; ?>
          </td>
          <td class="no-hover align-middle text-center">
            <?php
            if ($estado == 0) {
              ?>

              <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>info-24-tb.png"
                onclick="Pendiente('<?= $idReporte; ?>','<?= $idCierre; ?>','<?= $empresa; ?>')">
              <?php
            } else {
              ?>
              <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>info-24-red-tb.png"
                onclick="Activar('<?= $idReporte; ?>','<?= $idCierre; ?>','<?= $empresa; ?>')">
              <?php
            }
            ?>
          </td>
        </tr>
        <?php
      }
      ?>
      <tr id="Total<?= $empresatotal; ?>">
        <th class="no-hover align-middle text-center">TOTAL</th>
        <td class="no-hover align-middle text-end"><b>$ <?= number_format($TotalImporte, 2); ?></b></td>
        <td class="no-hover align-middle text-center"><b><?= $TotalTicket; ?></b></td>
        <td class="no-hover"></td>
      </tr>
    </tbody>
  </table>
</div>