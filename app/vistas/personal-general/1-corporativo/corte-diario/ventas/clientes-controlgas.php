<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$deshabilitado="";
$hover ='no-hover';
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
    $deshabilitado="disabledOP";
    $hover ='';
endif;
?>
<script type="text/javascript">

    $(document).ready(function ($) {

        ControlGTotal(<?= $idReporte; ?>);

    });

    function ControlGTotal(idReporte) {
        $('#TrControlGTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/controlgas-totales.php?idReporte=' + idReporte);
        //$('#TrControlGTotales').load('../../../public/corte-diario/vistas/controlgas-totales.php?idReporte=' + idReporte);
    }
</script>

<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr class="tables-bg">
                <th colspan="3" class="align-middle text-center">CLIENTES (ATIO)</th>
            </tr>
            <tr>
                <td class="text-center fw-bold">CONCEPTO</td>
                <td class="text-center fw-bold">PAGOS</td>
                <td class="text-center fw-bold">CONSUMOS</td>
            </tr>

        </thead>
        <tbody class="bg-white">
            <?php

            $sql_listacontrol = "SELECT * FROM op_clientes_controlgas WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listacontrol = mysqli_query($con, $sql_listacontrol);
            while ($row_listacontrol = mysqli_fetch_array($result_listacontrol, MYSQLI_ASSOC)) {

                $idControl = $row_listacontrol['id'];
                $concepto = $row_listacontrol['concepto'];

                if ($row_listacontrol['pago'] == 0) {
                    $pago = 0;
                } else {
                    $pago = number_format($row_listacontrol['pago'], 2, '.', '');
                }

                if ($row_listacontrol['consumo'] == 0) {
                    $consumo = 0;
                } else {
                    $consumo = number_format($row_listacontrol['consumo'], 2, '.', '');
                }

                ?>

                <tr>
                    <th class="align-middle p-3 no-hover"><?= $concepto; ?></th>
                    <td class="align-middle p-0 <?=$deshabilitado?> <?=$hover?>">$ 
                        <input class="p-3" id="pago-<?= $idControl; ?>" type="number" min="0" step="any"
                        style="border: 0px;width: 80%;height: 80%; text-align: right;"
                        onkeyup="EditCGPago(this,<?= $idReporte; ?>,<?= $idControl; ?>)" value="<?= $pago; ?>" <?= $estado; ?>>
                    </td>
                    <td class="align-middle p-0 <?=$deshabilitado?> <?=$hover?>">$ 
                        <input class="p-3" id="consumo-<?= $idControl; ?>" type="number" min="0" step="any"
                        style="border: 0px;width: 80%;height: 80%; text-align: right;"
                            onkeyup="EditCGConsumo(this,<?= $idReporte; ?>,<?= $idControl; ?>)" value="<?= $consumo; ?>"
                            <?= $estado; ?>>
                    </td>
                </tr>

                <?php
            }

            ?>
            <tr id="TrControlGTotales"></tr>
        </tbody>
    </table>
</div>