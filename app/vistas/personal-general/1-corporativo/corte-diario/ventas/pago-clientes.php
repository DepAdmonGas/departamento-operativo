<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
endif;
?>
<div class="table-responsive">
    <table class="table table-sm table-bordered pb-0 mb-0" style="font-size: .9em;">
        <thead class="tables-bg">
            <th class="text-center">CONCEPTO</th>
            <th class="text-center">IMPORTE</th>
            <th class="text-center">NOTA</th>
        </thead>
        <tbody>
            <?php

            $sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listaclientes = mysqli_query($con, $sql_listaclientes);
            while ($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)) {

                $idPagoCliente = $row_listaclientes['id'];
                $concepto = $row_listaclientes['concepto'];
                $nota = $row_listaclientes['nota'];

                if ($row_listaclientes['importe'] == 0) {
                    $importe = "";
                } else {
                    $importe = number_format($row_listaclientes['importe'], 2, '.', '');
                }

                ?>

                <tr>
                    <td class="align-middle"><?= $concepto; ?></td>
                    <td class="p-0 align-middle">
                        <input id="importe-<?= $idPagoCliente; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                            onkeyup="EditPCimporte(this,<?= $idReporte; ?>,<?= $idPagoCliente; ?>)" value="<?= $importe; ?>"
                            <?= $estado; ?>>
                    </td>
                    <td class="p-0 align-middle">
                        <input id="nota-<?= $idPagoCliente; ?>" type="text"
                            style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: left;"
                            onkeyup="EditPCnota(this,<?= $idReporte; ?>,<?= $idPagoCliente; ?>)" value="<?= $nota; ?>"
                            <?= $estado; ?>>
                    </td>
                </tr>

                <?php
            }

            ?>
            <tr id="TrClientesTotales"></tr>
        </tbody>
    </table>
</div>