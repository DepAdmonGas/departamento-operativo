<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
?>

<div class="table-responsive">
  <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
      <tr>
        <th colspan="6" class="align-middle text-center tables-bg">CONCENTRADO DE VENTAS</th>
      </tr>
      <tr>
        <td class="text-center align-middle fw-bold">PRODUCTO</td>
        <th class="text-center align-middle">LITROS</th>
        <th class="text-center align-middle">JARRAS</th>
        <th class="text-center align-middle">TOTAL LITROS</th>
        <th class="text-center align-middle">PRECIO POR LITRO</th>
        <td class="text-center align-middle fw-bold">IMPORTE TOTAL</td>
      </tr>
    </thead>
    <tbody class="bg-white">
      <?php
      $SubTLitros = 0;
      $SubJarras = 0;
      $SubTotalLitros = 0;
      $SubImporteTotal = 0;
      $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idReporte . "' ";
      $result_listayear = mysqli_query($con, $sql_listayear);
      $numero_reporte = mysqli_num_rows($result_listayear);

      while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

        $idventas = $row_listayear['id'];
        $producto = $row_listayear['producto'];
        $litrosventas = $row_listayear['litros'];
        $jarrasventas = $row_listayear['jarras'];
        $precio_litroventas = $row_listayear['precio_litro'];

        $litros = $litrosventas;
        $jarras = $jarrasventas;
        $preciolitro = $precio_litroventas;
        $totalLitros = $litrosventas - $jarrasventas;
        $importeTotal = $totalLitros * $precio_litroventas;

        $SubTLitros = $SubTLitros + $litros;
        $SubJarras = $SubJarras + $jarras;
        $SubTotalLitros = $SubTotalLitros + $totalLitros;
        $SubImporteTotal = $SubImporteTotal + $importeTotal;
        ?>
        <tr>

          <th class="p-0 align-middle no-hover">
            <?= $producto; ?>
          </th>
          <td class="p-0 align-middle no-hover text-end">
            <?= number_format($litros, 2); ?>
          </td>
          <td class="p-0 align-middle no-hover text-end">
            <?= number_format($jarras, 2); ?>
          </td>
          <td class="p-0  align-middle no-hover text-end"><strong><?= number_format($totalLitros, 2); ?></strong></td>
          <td class="p-0 align-middle no-hover text-end">
            <?= number_format($preciolitro, 2); ?>
          </td>
          <td class=" align-middle no-hover text-end"><strong><?= number_format($importeTotal, 2); ?></strong></td>


        </tr>
        <?php
      }
      ?>
      <tr>
        <th class="bg-bold disabledOP">A SUB-TOTAL (1+2+3)</th>
        <td class=" align-middle text-end disabledOP" id="importetotal-<?= $idventas; ?>">
          <strong><?= number_format($SubTLitros, 2); ?></strong>
        </td>
        <td class=" align-middle text-end disabledOP" id="importetotal-<?= $idventas; ?>">
          <strong><?= number_format($SubJarras, 2); ?></strong>
        </td>
        <td class=" align-middle text-end disabledOP" id="importetotal-<?= $idventas; ?>">
          <strong><?= number_format($SubTotalLitros, 2); ?></strong>
        </td>
        <td colspan="2" class=" align-middle text-end disabledOP" id="importetotal-<?= $idventas; ?>">
          <strong><?= number_format($SubImporteTotal, 2); ?></strong>
        </td>
      </tr>

      <?php
      $sumImporte = 0;
      $sql_listaotros = "SELECT * FROM op_ventas_dia_otros WHERE idreporte_dia = '" . $idReporte . "' ";
      $result_listaotros = mysqli_query($con, $sql_listaotros);
      while ($row_listaotros = mysqli_fetch_array($result_listaotros, MYSQLI_ASSOC)) {

        $idOtros = $row_listaotros['id'];
        $concepto = $row_listaotros['concepto'];
        $piezas = $row_listaotros['piezas'];

        $importe = $row_listaotros['importe'];
        $disabled = "";
        $cssaceite = "p-0";
        if ($concepto == "4 ACEITES Y LUBRICANTES") {
          $disabled = "disabled";
          $cssaceite = "bg-light text-end";

        }

        $sumImporte = $sumImporte + $importe;
        ?>
        <tr>
          <th class="no-hover"><?= $concepto; ?></th>
          <td class="no-hover align-middle text-end"><?= $piezas; ?></td>
          <td colspan="4" class="no-hover align-middle text-end fw-bold">
            <?= number_format($importe, 2); ?>
          </td>
        </tr>
      <?php }
      $totalNeto = $SubImporteTotal + $sumImporte; ?>

      <tr>
        <th class="disabledOP">B TOTAL (A+4+5+6)</th>
        <td colspan="5" class="disabledOP align-middle text-end"><strong><?= number_format($totalNeto, 2); ?></strong></td>
      </tr>
    </tbody>
  </table>
</div>