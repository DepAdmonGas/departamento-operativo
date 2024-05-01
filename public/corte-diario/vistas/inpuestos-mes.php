<?php
require 'app/vistas/contenido/header.php';
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

                      <h5>Impuestos, <?= FormatoFecha($dia); ?></h5>

                    </div>
                  </div>

                </div>
              </div>

              <hr>


              <div class="table-responsive">
                <table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
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
                  <tbody>

                    <?php
                    $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $GET_idReporte . "' ";
                    $result_listayear = mysqli_query($con, $sql_listayear);
                    $numero_reporte = mysqli_num_rows($result_listayear);
                    if ($numero_reporte > 0) {

                      $totalVV = 0;
                      $totalISI = 0;
                      $totalIV2 = 0;
                      $totalIEPS2 = 0;
                      $totalneto = 0;
                      while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

                        $idventas = $row_listayear['id'];
                        $producto = $row_listayear['producto'];
                        $litrosventas = $row_listayear['litros'];
                        $jarrasventas = $row_listayear['jarras'];
                        $precio_litroventas = $row_listayear['precio_litro'];
                        $ieps = $row_listayear['ieps'];

                        $preciosiniva = ($precio_litroventas - $ieps) / 1.16;
                        $iva1 = $preciosiniva * 0.16;

                        $volumenv = $litrosventas - $jarrasventas;
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
                          <td><?= $producto; ?></td>
                          <td class="align-middle text-end">$<?= number_format($precio_litroventas, 2); ?></td>
                          <td class="align-middle text-end"><?= $ieps; ?></td>
                          <td class="align-middle text-end"><?= number_format($preciosiniva, 4); ?></td>
                          <td class="align-middle text-end"><?= number_format($iva1, 4); ?></td>
                          <td class="align-middle text-end"><?= number_format($volumenv, 2); ?></td>
                          <td class="align-middle text-end"><?= number_format($importesiniva, 2); ?></td>
                          <td class="align-middle text-end"><?= number_format($iva2, 2); ?></td>
                          <td class="align-middle text-end"><?= number_format($ieps2, 2); ?></td>
                          <td class="align-middle text-end"><?= number_format($total, 2); ?></td>
                        </tr>
                        <?php
                      }

                      $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $GET_idReporte . "' ";
                      $result_listaaceites = mysqli_query($con, $sql_listaaceites);
                      $aceitessiniva = 0;
                      $aceitesiva = 0;
                      $totalPrecio = 0;
                      while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

                        $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];
                        $totalPrecio = $totalPrecio + $importe;
                      }

                      $aceitessiniva = $totalPrecio / 1.16;
                      $aceitesiva = $aceitessiniva * 0.16;
                      ?>


                      <tr>
                        <th colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</th>
                        <td class="align-middle text-end"><strong><?= number_format($totalVV, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totalISI, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totalIV2, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totalIEPS2, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totalneto, 2); ?></strong></td>
                      </tr>
                      <tr>
                        <td colspan="6" class="align-middle text-end">ACEITES</td>
                        <td class="align-middle text-end"><?= number_format($aceitessiniva, 2); ?></td>
                        <td class="align-middle text-end"><?= number_format($aceitesiva, 2); ?></td>
                        <td></td>
                        <td class="align-middle text-end"><?= number_format($totalPrecio, 2); ?></td>
                      </tr>
                      <tr class="bg-light">
                        <?php
                        $totaldiasi = $totalISI + $aceitessiniva;
                        $totaldiaiva = $totalIV2 + $aceitesiva;
                        $totaldia = $totalneto + $totalPrecio;
                        ?>
                        <th colspan="6" class="align-middle text-end">TOTAL DEL DÍA</th>
                        <td class="align-middle text-end"><strong><?= number_format($totaldiasi, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totaldiaiva, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totalIEPS2, 2); ?></strong></td>
                        <td class="align-middle text-end"><strong><?= number_format($totaldia, 2); ?></strong></td>
                      </tr>
                      <?php
                    } else {
                      echo "<tr><td colspan='10' class='align-middle text-center p-3'>No se encontró información para mostrar </td></tr>";
                    }
                    ?>
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