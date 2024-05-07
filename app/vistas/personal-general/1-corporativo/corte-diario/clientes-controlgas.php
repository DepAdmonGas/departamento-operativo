<?php
require ('../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
endif;
?>
<script type="text/javascript">

    $(document).ready(function ($) {

        ControlGTotal(<?= $idReporte; ?>);

    });

    function ControlGTotal(idReporte) {
        $('#TrControlGTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/controlgas-totales.php?idReporte=' + idReporte);
        //$('#TrControlGTotales').load('../../../public/corte-diario/vistas/controlgas-totales.php?idReporte=' + idReporte);
    }
</script>

<div class="table-responsive">
    <table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
        <thead class="tables-bg">
            <th class="text-center">CONCEPTO</th>
            <th class="text-center">PAGOS</th>
            <th class="text-center">CONSUMOS</th>
        </thead>
        <tbody>
            <?php

            $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listacontrol = mysqli_query($con, $sql_listacontrol);
            while ($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)) {

                $idControl = $row_listacontrol['id'];
                $concepto = $row_listacontrol['concepto'];

                if ($row_listacontrol['pago'] == 0) {
                    $pago = "";
                } else {
                    $pago = number_format($row_listacontrol['pago'], 2, '.', '');
                }

                if ($row_listacontrol['consumo'] == 0) {
                    $consumo = "";
                } else {
                    $consumo = number_format($row_listacontrol['consumo'], 2, '.', '');
                }

                ?>

                <tr>
                    <td class="align-middle"><?= $concepto; ?></td>
                    <td class="p-0 align-middle">
                        <input id="pago-<?= $idControl; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                            onkeyup="EditCGPago(this,<?= $idReporte; ?>,<?= $idControl; ?>)" value="<?= $pago; ?>" <?= $estado; ?>>
                    </td>
                    <td class="p-0 align-middle">
                        <input id="consumo-<?= $idControl; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                            onkeyup="EditCGConsumo(this,<?= $idReporte; ?>,<?= $idControl; ?>)" value="<?= $consumo; ?>"
                            <?= $estado; ?>>
                    </td>
                </tr>

                <?php
            }

            ?>
            <tr id="TrControlGTotales"></tr>

            <tr>
                <td class="p-2" colspan="3"></td>
            </tr>
        </tbody>
    </table>
</div>