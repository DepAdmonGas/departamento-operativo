<?php
require 'app/vistas/contenido/header.php';
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
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
                      <h5>Resumen Impuestos, <?= $ClassHerramientasDptoOperativo->nombremes($GET_mes); ?> <?= $GET_year; ?></h5>
                    </div>
                  </div>
                </div>
              </div>
              <hr>
              <?php
              // Llamar a la función para obtener la lista de días
              $listaDias = $corteDiarioGeneral->obtenerListaDias($Session_IDEstacion, $GET_year, $GET_mes);
              // Recorrer la lista de días y mostrar los resultados
              foreach ($listaDias as $dia) :
                  $idDias = $dia['idDia'];
                  $fecha = $dia['fecha'];
                echo '<div class="border p-3 mt-3 mb-3">';
                echo '<b>' . $ClassHerramientasDptoOperativo->FormatoFecha($fecha) . '</b>
          <hr>';
                ?>
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


                      $preciosiniva = 0;
                      $iva1 = 0;
                      $volumenv = 0;
                      $importesiniva = 0;
                      $iva2 = 0;
                      $ieps2 = 0;
                      $total = 0;
                      $totalVV = 0;
                      $totalISI = 0;
                      $totalIV2 = 0;
                      $totalIEPS2 = 0;
                      $totalneto = 0;
                      $importe = 0;
                      $totalPrecio = 0;
                      $aceitessiniva = 0;
                      $aceitesiva = 0;

                      $totaldiasi = 0;
                      $totaldiaiva = 0;
                      $totaldia = 0;


                      $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idDias . "' ";
                      $result_listayear = mysqli_query($con, $sql_listayear);
                      $numero_reporte = mysqli_num_rows($result_listayear);

                      if ($numero_reporte > 0) :
                        while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) :
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
                        endwhile;

                        $sql_listaaceites = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $idDias . "' ";
                        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
                        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) :

                          $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];
                          $totalPrecio = $totalPrecio + $importe;
                        endwhile;

                        $aceitessiniva = $totalPrecio / 1.16;
                        $aceitesiva = $aceitessiniva * 0.16;
                        ?>


                        <tr>
                          <td colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</td>
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
                          <td colspan="2" class="align-middle text-end"><?= number_format($totalPrecio, 2); ?></td>
                        </tr>
                        <tr>
                          <?php
                          $totaldiasi = $totalISI + $aceitessiniva;
                          $totaldiaiva = $totalIV2 + $aceitesiva;
                          $totaldia = $totalneto + $totalPrecio;
                          ?>
                          <td colspan="6" class="align-middle text-end">TOTAL DEL DÍA</td>
                          <td class="align-middle text-end"><strong><?= number_format($totaldiasi, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totaldiaiva, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalIEPS2, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totaldia, 2); ?></strong></td>
                        </tr>
                        <?php
                      else :
                        echo "<tr><td colspan='10' class='align-middle text-center p-3'>No se encontró información para mostrar </td></tr>";
                      endif;
                      ?>
                    </tbody>
                  </table>
                </div>
                <?php
              echo '</div>';
                    endforeach;
              ?>
              <div class="border p-3 mt-3 mb-0">
                <b>Resumen Impuestos</b>
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
                      function ProductoResultado($IdReporte, $producto, $con)
                      {
                        $sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
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

                      function TotalAceites($IdReporte, $con)
                      {

                        $sql_dia = "SELECT id FROM op_corte_dia WHERE id_mes = '" . $IdReporte . "' ";
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
                        ON op_ventas_dia.idreporte_dia = op_corte_dia.id WHERE op_corte_dia.id_mes =  '" . $IdReporte . "' GROUP BY op_ventas_dia.producto ORDER BY op_ventas_dia.id asc";
                      $result_listayear = mysqli_query($con, $sql_listayear);
                      $numero_reporte = mysqli_num_rows($result_listayear);
                      if ($numero_reporte > 0) {

                        while ($row_listayear = mysqli_fetch_array($result_listayear, MYSQLI_ASSOC)) {

                          $producto = $row_listayear['producto'];
                          $ieps = $row_listayear['ieps'];

                          $ProductoR = ProductoResultado($IdReporte, $producto, $con);



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
                            <td><?= $producto; ?></td>
                            <td class="align-middle text-end">$<?= number_format($ProductoR['PrecioPublico'], 4); ?></td>
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

                        $Totalaceites = TotalAceites($IdReporte, $con);
                        $totalPrecio = $Totalaceites['Totalimporte'];
                        $aceitessiniva = $totalPrecio / 1.16;
                        $aceitesiva = $aceitessiniva * 0.16;
                        ?>
                        <tr>
                          <td colspan="5" class="align-middle text-end">SUBTOTAL COMBUSTIBLES</td>
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
                        <tr>
                          <?php
                          $totaldiasi = $totalISI + $aceitessiniva;
                          $totaldiaiva = $totalIV2 + $aceitesiva;
                          $totaldia = $totalneto + $totalPrecio;
                          ?>
                          <td colspan="6" class="align-middle text-end">TOTAL DEL DÍA</td>
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
  </div>
</body>

</html>