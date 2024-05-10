<?php
require '../../../../help.php';
$GET_year = $_GET['year'];
$GET_mes = $_GET['mes'];
$IdReporte = $corteDiarioGeneral->idReporte($Session_IDEstacion, $GET_year, $GET_mes);
$InventarioFin = $corteDiarioGeneral->inventarioFin($IdReporte);
$disabled = "";
$disabledStyle = "";
if ($InventarioFin == 1):
    $disabled = "disabled";
    $disabledStyle = "inputD";
endif;
$corteDiarioGeneral->listaAceite($Session_IDEstacion,$IdReporte, $InventarioFin);
$corteDiarioGeneral->pagoDiferencias($IdReporte);
$Pdia = $corteDiarioGeneral->primerDia($GET_year, $GET_mes);
$Udia = $corteDiarioGeneral->ultimoDia($GET_year, $GET_mes);
?>

<table class="table table-bordered" style="font-size: .8em;">
    <thead class="tables-bg">
        <tr>
            <th class="align-middle text-center">#</th>
            <th colspan="2" class="align-middle text-center">Concepto</th>
            <th class="align-middle text-center">Precio Unitario</th>
            <th class="align-middle text-center">Bodega</th>
            <th class="align-middle text-center">Exhibidores</th>
            <th class="align-middle text-center">Inventario Inicial</th>
            <th class="align-middle text-center">Compras / Pedido</th>
            <th class="align-middle text-center">Ventas del mes</th>
            <th class="align-middle text-center">Inventario Final</th>
            <th class="align-middle text-center">Inventario fisico Bodega</th>
            <th class="align-middle text-center">Inventario fisico Exhibidores</th>
            <th class="align-middle text-center">Inventario fisico Final</th>
            <th class="align-middle text-center">Diferencia</th>
            <th class="align-middle text-center">Diferencia $</th>
            <th class="align-middle text-center">Prod. Facturados</th>
            <th class="align-middle text-center">Factura venta mostrador</th>
            <th class="align-middle text-center">Fac. total</th>
            <th class="align-middle text-center">Dif. En Facturacion</th>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
                echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
            }
            ?>
            <th class="align-middle text-center ">Total</th>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {
                echo "<th class='align-middle text-center'>" . $Pdia . "</th>";
            }
            ?>
            <th class="align-middle text-center">Total</th>
        </tr>
    </thead>
    <tbody>
        <?php
        $sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' AND id_aceite <> 0 ORDER BY id_aceite ASC";
        #$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes_reporte WHERE id_mes = '" . $IdReporte . "' ORDER BY id_aceite ASC ";
        $result_listaaceites = mysqli_query($con, $sql_listaaceites);
        $idaceite = 0;
        $noaceite = 0;
        $totalBodegas = 0;
        $totalExibidores = 0;
        $totalInventarioI = 0;
        $totalPedido = 0;
        $totalVentasM = 0;
        $totalInventarioF = 0;
        $totalInventarioBodega = 0;
        $totalInventarioExibidores = 0;
        $totalInventarioFinal = 0;
        $totalDiferencia = 0;
        $totalDigPrecio = 0;
        $sumt = 0;
        $importeneto = 0;
        $ventas = 0;
        while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

            $idaceite = $row_listaaceites['id'];
            $noaceite = $row_listaaceites['id_aceite'];
            $preciou = $row_listaaceites['precio'];
            $bodega = (int) $row_listaaceites['bodega'];
            $exibidores = (int) $row_listaaceites['exibidores'];
            $pedido = (int) $row_listaaceites['pedido'];

            $inventario_bodega = (int) $row_listaaceites['inventario_bodega'];
            $inventario_exibidores = (int) $row_listaaceites['inventario_exibidores'];

            $producto_facturado = (int) $row_listaaceites['producto_facturado'];
            $factura_venta_mostrador = (int) $row_listaaceites['factura_venta_mostrador'];

            $totalaceites = $corteDiarioGeneral->totalaceites($IdReporte, $noaceite);

            $inventarioI = $bodega + $exibidores;
            $inventarioF = $inventarioI + $pedido - $totalaceites;

            $inventario_final = $inventario_bodega + $inventario_exibidores;

            $diferencia = $inventario_final - $inventarioF;
            $difPrecio = $row_listaaceites['precio'] * $diferencia;

            $factotal = $factura_venta_mostrador + $producto_facturado;
            $diffactura = $factotal - $ventas;
            $iconDiferencia = '';

            if (is_numeric($diferencia) and ($diferencia < 0)) {

                if ($InventarioFin == 1) {
                    $ValidaPagoD = $corteDiarioGeneral->validaPagoD($idaceite);

                    if ($ValidaPagoD == 0) {
                        $iconDiferencia = '<div class="float-start"><img src="' . RUTA_IMG_ICONOS . 'merma-si.png" onclick="ModalDiferencia(' . $idaceite . ',' . $GET_year . ',' .
                            $GET_mes . ')"></div>';
                    } else {
                        $iconDiferencia = '<div class="float-start"><img src="' . RUTA_IMG_ICONOS . 'merma-no.png" onclick="ModalDetalle(' . $idaceite . ')"></div>';
                    }

                }
            }

            $totalBodegas = $totalBodegas + $bodega;
            $totalExibidores = $totalExibidores + $exibidores;
            $totalInventarioI = $totalInventarioI + $inventarioI;
            $totalPedido = $totalPedido + $pedido;
            $totalVentasM = $totalVentasM + $totalaceites;
            $totalInventarioF = $totalInventarioF + $inventarioF;
            $totalInventarioBodega = $totalInventarioBodega + $inventario_bodega;
            $totalInventarioExibidores = $totalInventarioExibidores + $inventario_exibidores;
            $totalInventarioFinal = $totalInventarioFinal + $inventario_final;
            $totalDiferencia = $totalDiferencia + $diferencia;
            $totalDigPrecio = $totalDigPrecio + $difPrecio;

            ?>

            <tr>
                <td class="align-middle p-1 text-center"><?= $idaceite;?></td>
                <td class="align-middle p-1"><b><?= $noaceite; ?></b></td>
                <td class="align-middle p-1"><b><?= $row_listaaceites['concepto']; ?></b></td>
                <td class="align-middle text-end p-1"><?= number_format($row_listaaceites['precio'], 2); ?></td>
                <td class="align-middle text-end"><?= $bodega; ?></td>

                <td class="align-middle text-end"><?= $exibidores; ?></td>

                <td id="inventarioi-<?= $idaceite; ?>" class="align-middle bg-light text-end">
                    <?= number_format($inventarioI, 2); ?></td>

                <td class="align-middle p-0"><input id="pedido-<?= $idaceite; ?>" class="<?= $disabledStyle; ?>" type="number"
                        name="" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                        value="<?= $pedido; ?>" onkeyup="EditPedido(this,<?= $idaceite; ?>)" <?= $disabled; ?>></td>

                <td id="ventas-<?= $idaceite; ?>" class="align-middle bg-light text-end"><?= $totalaceites; ?></td>

                <td id="inventariof-<?= $idaceite; ?>" class="align-middle bg-light text-end">
                    <?= number_format($inventarioF, 2); ?></td>

                <td class="align-middle p-0"><input id="fisicoB-<?= $idaceite; ?>" class="<?= $disabledStyle; ?>" type="number"
                        name="" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                        value="<?= $inventario_bodega; ?>" onkeyup="EditFisicoBodega(this,<?= $idaceite; ?>)" <?= $disabled; ?>>
                </td>

                <td class="align-middle p-0"><input id="fisicoE-<?= $idaceite; ?>" class="<?= $disabledStyle; ?>" type="number"
                        name="" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                        value="<?= $inventario_exibidores; ?>" onkeyup="EditFisicoExhibidor(this,<?= $idaceite; ?>)"
                        <?= $disabled; ?>></td>

                <td class="align-middle text-end" id="fisicoFin-<?= $idaceite; ?>"><?= $corteDiarioGeneral->valRow($inventario_final); ?></td>

                <td id="diferencia-<?= $idaceite; ?>" class="align-middle bg-light text-end">
                    <?= number_format($diferencia, 2); ?>     <?= $iconDiferencia; ?></td>

                <td class="align-middle p-1 text-end">$ <?= number_format($difPrecio, 2); ?></td>

                <td class="align-middle p-0"><input id="facturado-<?= $idaceite; ?>" class="<?= $disabledStyle; ?>"
                        type="number" name="" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                        value="<?= $producto_facturado; ?>" onkeyup="EditFacturados(this,<?= $idaceite; ?>)" <?= $disabled; ?>>
                </td>

                <td class="align-middle p-0"><input id="mostrador-<?= $idaceite; ?>" class="<?= $disabledStyle; ?>"
                        type="number" name="" style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                        value="<?= $factura_venta_mostrador; ?>" onkeyup="EditMostrador(this,<?= $idaceite; ?>)"
                        <?= $disabled; ?>></td>

                <td id="factotal-<?= $idaceite; ?>" class="align-middle bg-light text-end"><?= number_format($factotal, 2); ?>
                </td>

                <td id="diffactura-<?= $idaceite; ?>" class="align-middle bg-light text-end">
                    <?= number_format($diffactura, 2); ?></td>

                <?php

                for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

                    $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
                    $cantidad = $corteDiarioGeneral->cantidadaceites($IdReporte, $fecha, $noaceite);

                    echo "<td class='align-middle text-center'>" . $cantidad . "</td>";

                }


                $sumt = $sumt + $totalaceites;
                ?>
                <td class="align-middle text-center bg-light"><?= $totalaceites; ?></td>
                <?php
                $TotalSumaAceites = 0;
                for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

                    $fechap = $GET_year . "-" . $GET_mes . "-" . $Pdia;
                    $precioaceite = $corteDiarioGeneral->precioAceite($IdReporte, $fechap, $noaceite);
                    $TotalSumaAceites = $TotalSumaAceites + $precioaceite;
                    echo "<td class='align-middle text-center'>" . number_format($precioaceite, 2) . "</td>";
                }
                $totalprecio = $corteDiarioGeneral->precioAceite($IdReporte, $fecha, $noaceite);
                $importeneto = $importeneto + $totalprecio;
                ?>
                <td class="align-middle text-center bg-light"><?= number_format($TotalSumaAceites, 2); ?></td>
            </tr>

            <?php
        }
        ?>
        <tr>
            <td class="text-end" colspan="4">TOTAL</td>

            <td class="align-middle p-1 text-end"><?= number_format($totalBodegas, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalExibidores, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalInventarioI, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalPedido, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalVentasM, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalInventarioF, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalInventarioBodega, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalInventarioExibidores, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalInventarioFinal, 2); ?></td>
            <td class="align-middle p-1 text-end"><?= number_format($totalDiferencia, 2); ?></td>
            <td class="align-middle p-1 text-end">$<?= number_format($totalDigPrecio, 2); ?></td>
            <td></td>
            <td></td>
            <td></td>
            <td></td>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

                $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
                $totalcantidad = $corteDiarioGeneral->cantidadAceites($IdReporte, $fecha, $noaceite);
                echo "<td class='align-middle text-center'>" . $totalcantidad . "</td>";
            }
            ?>
            <td class="align-middle text-center bg-light"><?php echo $sumt; ?></td>
            <?php
            for ($Pdia = 1; $Pdia <= $Udia; $Pdia++) {

                $fecha = $GET_year . "-" . $GET_mes . "-" . $Pdia;
                $totalimporte = $corteDiarioGeneral->precioAceite($IdReporte, $fecha, $noaceite);

                echo "<td class='align-middle text-center'>" . number_format($totalimporte, 2) . "</td>";
            }
            ?>
            <td class="align-middle text-center bg-light"><?= number_format($importeneto, 2); ?></td>
        </tr>
    </tbody>
</table>