<?php
require ('../../../app/help.php');
$idReporte = $_GET['idReporte'];
$idStatus = $_GET['idStatus'];

if ($idStatus == 0) {
  $ocultarTb = "";
  $habilitadoCheck = "";
} else {
  $ocultarTb = "d-none";
  $habilitadoCheck = "disabled";
}



$sql = "SELECT *
  FROM op_orden_compra 
  WHERE id = '" . $idReporte . "' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {

  $estatus = $row['estatus'];
  $iva_tb = $row['iva'];

}

?>



<div class="table-responsive">
  <table id="tabla-principal" class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="tables-bg">
      <tr>
        <th colspan="20" class="text-center">CUADRO COMPARATIVO DE PROVEEDORES</th>
      </tr>
      <tr class="title-table-bg">
        <td class="text-center fw-bold"> Mejor Oferta</td>
        <th class="text-center">Concepto</th>
        <th class="text-center">Unidades</th>
        <th class="text-center">Estatus</th>
        <th class="text-end">Precio Unitario</th>
        <th class="text-end">Subtotal</th>

        <th class="text-end" width="40px">IVA</th>
        <th class="text-end">Total (Subtotal * IVA)</th>

        <th class="text-end">Total</th>
        <td class="text-end <?= $ocultarTb ?>" width="16px"><img src="<?= RUTA_IMG_ICONOS ?>eliminar.png" width="20px"></td>
      </tr>
    </thead>
    <tbody class="bg-light">
      <?php



      $sqlP = "SELECT * FROM op_orden_compra_proveedor WHERE id_ordencompra = '" . $idReporte . "' ";
      $resultP = mysqli_query($con, $sqlP);
      $numeroP = mysqli_num_rows($resultP);

      if ($numeroP > 0) {
        $num = 1;

        while ($rowP = mysqli_fetch_array($resultP, MYSQLI_ASSOC)) {
          $idProveedor = $rowP['id'];
          $razonsocialP = $rowP['razon_social'];

          $descuento = $rowP['descuento'];
          $envio_cp = $rowP['envio_cp'];

          $CheckProveedor = $rowP['check_p'];

          $totalUnidades = 0;
          $totalPrecioU = 0;
          $totalSubTotal = 0;
          $totalIVA = 0;
          $totalGeneral = 0;
          $numerolista = 0;


          echo '<tr>';
          echo '<th style="background-color: #cff4fc"> 
                  <div class="form-check form-check-inline d-flex justify-content-center">
                  <input class="form-check-input  p-2" type="radio" name="TipoServicio" id="Proveedor' . $idProveedor . '" value="' . $num . '" onChange="SelProveedor(' . $idReporte . ',' . $idProveedor . ', 1,' . $num . ')" ' . $habilitadoCheck . ' ';
                  if ($CheckProveedor == 1) {
                    echo "checked";
                  }

          echo '> </div>
          </th>';
          echo '<td colspan="10" style="background-color: #cff4fc" class="text-center"><b>Proveedor: ' . $razonsocialP . '</b></td>';
          echo '</tr>';


          $sql_lista = "SELECT * FROM op_orden_compra_articulo WHERE id_ordencompra = '" . $idReporte . "' AND id_proveedor = '" . $idProveedor . "' ORDER BY id ASC";
          $result_lista = mysqli_query($con, $sql_lista);
          $numero_lista = mysqli_num_rows($result_lista);
          $contador = 1;
          if ($numero_lista > 0) {
            while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
              $id = $row_lista['id'];
              $GET_idProveedor = $row_lista['id_proveedor'];

              $unidades = $row_lista['unidades'];
              $precio_unitario = $row_lista['precio_unitario'];
              $subtotal_tb = $unidades * $precio_unitario;
              $subtotalPU_IVA = ($subtotal_tb - $descuento + $envio_cp) * $iva_tb;
              $Total = $subtotal_tb + $subtotalPU_IVA;

              echo '<tr>';
              echo '<th class="align-middle text-center">'.$contador.'</th>';

              echo '<td class="align-middle text-center">' . $row_lista['concepto'] . ' </td>';
              echo '<td class="align-middle text-center">' . $row_lista['unidades'] . '</td>';
              echo '<td class="align-middle text-center">' . $row_lista['estatus_r'] . '</td>';
              echo '<td class="align-middle text-end">$ ' . number_format($row_lista['precio_unitario'], 2) . '</td>';
              echo '<td class="align-middle text-end">$ ' . number_format($subtotal_tb, 2) . '</td>';

              echo '<td class="align-middle text-end">16%</td>';
              echo '<td class="align-middle text-end">$ ' . number_format($subtotalPU_IVA, 2) . '</td>';


              echo '<td class="align-middle text-end">$ ' . number_format($Total, 2) . '</td>';
              echo '<td class="align-middle text-center ' . $ocultarTb . '"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" width="20px" onclick="Eliminar(' . $id . ',' . $idReporte . ')"></td>';
              echo '</tr>';

              $totalUnidades = $totalUnidades + $row_lista['unidades'];
              $totalPrecioU = $totalPrecioU + $row_lista['precio_unitario'];
              $totalSubTotal = $totalSubTotal + $subtotal_tb;
              $totalIVA = $totalIVA + $subtotalPU_IVA;
              $totalGeneral = $totalGeneral + $Total;
              $contador ++ ;
            }


            $subtotal3 = $totalSubTotal - $descuento + $envio_cp;
            $totalFinal = $totalIVA + $subtotal3;


            if ($idStatus == 0) {
              $valueDescuento = '<div class="input-group">
              <span class="input-group-text">$</span>
              <input type="text" class="form-control" id="descuento' . $GET_idProveedor . '" onchange="costosProveedor(' . $GET_idProveedor . ',1)" value="' . $descuento . '">
              </div>';

              $valueEnvio = '<div class="input-group">
                <span class="input-group-text">$</span>
                <input type="text" class="form-control" id="envio' . $GET_idProveedor . '" onchange="costosProveedor(' . $GET_idProveedor . ',2)" value="' . $envio_cp . '">
                </div>';

            } else {
              $valueDescuento = '$ ' . number_format($descuento, 2) . ' ';
              $valueEnvio = '$ ' . number_format($envio_cp, 2) . ' ';
            }


            echo '<tr class="bg-light">
              <th colspan="5" class="align-middle text-end"></th>
              <th class="align-middle text-center">SUMA</th>
              <th colspan="5" class="align-middle text-start">$ ' . number_format($totalSubTotal, 2) . '</th>
              </tr>';


            echo '<tr class="bg-light">
                  <th colspan="5" class="align-middle text-end"></th>
                  <th class="align-middle text-center">DESCUENTO</th>
                  <th colspan="5" class="align-middle text-start">
                  ' . $valueDescuento . ' 
                  </th>
                  </tr>';

            echo '<tr class="bg-light">
                  <th colspan="5" class="align-middle text-end"></th>
                  <th class="align-middle text-center">ENVIO</th>
                  <th colspan="5" class="align-middle text-start">
                  ' . $valueEnvio . '
                  </th>
                  </tr>';

            echo '<tr class="bg-light">
                  <th colspan="5" class="align-middle text-end"></th>
                  <th class="align-middle text-center">SUBTOTAL</th>
                  <th colspan="5" class="align-middle text-start">$ ' . number_format($subtotal3, 2) . '</th>
                  </tr>';

            echo '<tr class="bg-light">
                  <th colspan="5" class="align-middle text-end"></th>
                  <th class="align-middle text-center">IVA</th>
                  <th colspan="5" class="align-middle text-start">$ ' . number_format($totalIVA, 2) . '</th>
                  </tr>';

            echo '<tr class="bg-light">
                  <th colspan="5" class="align-middle text-end"></th>
                  <th class="align-middle text-center">TOTAL A PAGAR</th>
                  <th colspan="5" class="align-middle text-start">$ ' . number_format($totalFinal, 2) . '</th>
                  </tr>';

          }

          $numerolista = $numerolista + $numero_lista;

          if ($numerolista == 0) {
            echo "<tr><th colspan='20' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
          } else {

          }
          $num++;
        }
      }

      ?>

    </tbody>
  </table>
</div>