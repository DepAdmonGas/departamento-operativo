<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];

?>



<div class="modal-header">

  <h5 class="modal-title">Resumen de Impuestos Totales </h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">



  <div class="table-responsive">
    <table class="custom-table" style="font-size: .9em;" width="100%">
      <thead class="tables-bg">

        <tr>
          <th class="align-middle text-center">Producto</th>
          <th class="align-middle text-center">Precio al Público</th>
          <th class="align-middle text-center">IEPS</th>
          <th class="align-middle text-center">PRECIO SIN IVA</th>
          <th class="align-middle text-center">IVA</th>
          <th class="align-middle text-center">VOLUMEN VENDIDO</th>
          <th class="align-middle text-center">IMPORTE SIN IVA</th>
          <th class="align-middle text-center">IVA</th>
          <th class="align-middle text-center">IEPS</th>
          <th class="align-middle text-center">TOTAL</th>
        </tr>
      </thead>

      <tbody class="bg-light">
        <?php
        function ProductoResultado($idReporte, $producto, $con)
        {
          $sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $idReporte . "' ";
          $result_dia = mysqli_query($con, $sql_dia);
          while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
            $id = $row_dia['id'];

            $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $id . "' AND producto = '" . $producto . "' ";
            $result_listayear = mysqli_query($con, $sql_listayear);
            $numero_reporte = mysqli_num_rows($result_listayear);
            $tolitros = 0;
            $tojarras = 0;
            $toprecio = 0;
            while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

              $litros = $row_listayear['litros'];
              $jarras = $row_listayear['jarras'];
              $precio = $row_listayear['precio_litro'];

              $tolitros = $tolitros + $litros;
              $tojarras = $tojarras + $jarras;

              $toprecio = ($toprecio + $precio) / 2;
              $precioP = $toprecio / 30.5;
            }
          }
          $array = array(
            'Litros' => $tolitros,
            'Jarras' => $tojarras,
            'PrecioPublico' => $precioP,
          );

          return $array;
        }

        function TotalAceites($idReporte, $con)
        {

          $sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $idReporte . "' ";
          $result_dia = mysqli_query($con, $sql_dia);
          while ($row_dia = mysqli_fetch_array($result_dia, MYSQLI_ASSOC)) {
            $id = $row_dia['id'];

            $sql_listatotal = "SELECT cantidad, precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $id . "' ";
            $result_listatotal = mysqli_query($con, $sql_listatotal);
            $totalimporte = 0;
            while ($row_listatotal = mysqli_fetch_array($result_listatotal, MYSQLI_ASSOC)) {
              $cantidad = $row_listatotal['cantidad'];
              $precio = $row_listatotal['precio_unitario'];

              $total = $cantidad * $precio;
              $totalimporte = $totalimporte + $total;

            }

          }

          $array = array(
            'Totalimporte' => $totalimporte
          );

          return $array;
        }

        $sql_listayear = "SELECT
                        op_ventas_dia.id,
                        op_ventas_dia.producto,
                        op_ventas_dia.ieps,
                        op_corte_dia.id_mes
                        FROM op_ventas_dia
                        INNER JOIN op_corte_dia
                        ON op_ventas_dia.idreporte_dia = op_corte_dia.id WHERE op_corte_dia.id_mes =  '" . $idReporte . "' GROUP BY op_ventas_dia.producto ORDER BY op_ventas_dia.id asc";
        $result_listayear = mysqli_query($con, $sql_listayear);
        $numero_reporte = mysqli_num_rows($result_listayear);
        if ($numero_reporte > 0) {

          $totalVV = 0;
          $totalISI = 0;
          $totalIV2 = 0;
          $totalIEPS2 = 0;
          $totalneto = 0;

          while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

            $producto = $row_listayear['producto'];
            $ieps = $row_listayear['ieps'];

            $ProductoR = ProductoResultado($idReporte, $producto, $con);

            $preciosiniva = ($ProductoR['PrecioPublico'] - $ieps) / 1.16;
            $iva1 = $preciosiniva * 0.16;

            $volumenv = $ProductoR['Litros'] - $ProductoR['Jarras'];
            $importesiniva = $volumenv * $preciosiniva;
            $iva2 = $importesiniva * 0.16;
            $ieps2 = $volumenv * $ieps;
            $total = $importesiniva + $iva2 + $ieps2;

            $totalVV = $totalVV + $volumenv;
            $totalISI = $totalISI + $importesiniva;
            $totalIV2 = $totalIV2 + $iva2;
            $totalIEPS2 = $totalIEPS2 + $ieps2;
            $totalneto = $totalneto + $total;
            ?>

            <tr>
              <th class=""><?= $producto; ?></th>
              <td class="align-middle text-end">$<?= number_format($ProductoR['PrecioPublico'], 4); ?></td>
              <td class="align-middle text-end">$<?= $ieps; ?></td>
              <td class="align-middle text-end">$ <?= number_format($preciosiniva, 4); ?></td>
              <td class="align-middle text-end">$<?= number_format($iva1, 4); ?></td>
              <td class="align-middle text-end"><?= number_format($volumenv, 2); ?></td>
              <td class="align-middle text-end">$ <?= number_format($importesiniva, 2); ?></td>
              <td class="align-middle text-end">$<?= number_format($iva2, 2); ?></td>
              <td class="align-middle text-end">$<?= number_format($ieps2, 2); ?></td>
              <td class="align-middle text-end">$<?= number_format($total, 2); ?></td>
            </tr>
            <?php
          }

          $Totalaceites = TotalAceites($idReporte, $con);
          $totalPrecio = $Totalaceites['Totalimporte'];
          $aceitessiniva = $totalPrecio / 1.16;
          $aceitesiva = $aceitessiniva * 0.16;
          ?>
          <tr>
            <th colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</th>
            <td class="align-middle text-end"><strong><?= number_format($totalVV, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totalISI, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totalIV2, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totalIEPS2, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totalneto, 2); ?></strong></td>
          </tr>
          <tr>
            <th colspan="6" class="align-middle text-end">ACEITES</th>
            <td class="align-middle text-end">$<?= number_format($aceitessiniva, 2); ?></td>
            <td class="align-middle text-end">$<?= number_format($aceitesiva, 2); ?></td>
            <td colspan="2" class="align-middle text-end">$<?= number_format($totalPrecio, 2); ?></td>
          </tr>
          <tr>
            <?php
            $totaldiasi = $totalISI + $aceitessiniva;
            $totaldiaiva = $totalIV2 + $aceitesiva;
            $totaldia = $totalneto + $totalPrecio;
            ?>
            <th colspan="6" class="align-middle text-end">TOTAL DEL DÍA</th>
            <td class="align-middle text-end"><strong>$<?= number_format($totaldiasi, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totaldiaiva, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totalIEPS2, 2); ?></strong></td>
            <td class="align-middle text-end"><strong>$<?= number_format($totaldia, 2); ?></strong></td>
          </tr>
          <?php
        } else {
          echo "<tr><th colspan='10' class='align-middle text-center fw-normal no-hover2'>No se encontró información para mostrar </th></tr>";
        }
        ?>
      </tbody>
    </table>
  </div>

</div>