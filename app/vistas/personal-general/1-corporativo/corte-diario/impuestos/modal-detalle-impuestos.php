<?php
require('../../../../../help.php');
$idDia = $_GET['idDia'];
$fecha = $_GET['fecha'];

?>


<div class="modal-header">

<h5 class="modal-title">Detalle - <?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha)?></h5>
<button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="table-responsive">
<table id="tabla_bitacora" class="custom-table" style="font-size: .9em;" width="100%">
            
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


                      $sql_listayear = "SELECT * FROM op_ventas_dia WHERE idreporte_dia = '" . $idDia . "' ";
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
                            <th class="fw-normal"><?= $producto; ?></th>
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

                        $sql_listaaceites = "SELECT cantidad,precio_unitario FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $idDia . "' ";
                        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
                        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) :

                          $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];
                          $totalPrecio = $totalPrecio + $importe;
                        endwhile;

                        $aceitessiniva = $totalPrecio / 1.16;
                        $aceitesiva = $aceitessiniva * 0.16;
                        ?>


                        <tr>
                          <th colspan="5" class="align-middle text-end fw-normal">SUBTOTAL COMBUSTIBLES</th>
                          <td class="align-middle text-end"><strong><?= number_format($totalVV, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalISI, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalIV2, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalIEPS2, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalneto, 2); ?></strong></td>
                        </tr>
                        <tr>
                          <th colspan="6" class="align-middle text-end fw-normal">ACEITES</th>
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
                          <th colspan="6" class="align-middle text-end fw-normal">TOTAL DEL DÍA</th>
                          <td class="align-middle text-end"><strong><?= number_format($totaldiasi, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totaldiaiva, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totalIEPS2, 2); ?></strong></td>
                          <td class="align-middle text-end"><strong><?= number_format($totaldia, 2); ?></strong></td>
                        </tr>
                        <?php
                      else :
                        echo "<tr><th colspan='10' class='align-middle text-center p-3 fw-normal no-hover2'><small>No se encontró información para mostrar</small> </th></tr>";
                      endif;
                      ?>
                    </tbody>
                  </table>
                </div>

</div>