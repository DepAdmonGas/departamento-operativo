<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$deshabilitado="";
$hover="no-hover";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $hover="";
    $estado = "disabled";
    $deshabilitado="disabledOP";
endif;
?>
<script type="text/javascript">

    $(document).ready(function ($) {

        PagoCTotal(<?= $idReporte; ?>);

    });

    function PagoCTotal(idReporte) {
        $('#TrClientesTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/pagoclientes-totales.php?idReporte=' + idReporte);
        //$('#TrClientesTotales').load('../../../public/corte-diario/vistas/pagoclientes-totales.php?idReporte=' + idReporte);
    }
</script>

<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr class="tables-bg">
                <th colspan="3" class="align-middle text-center">PAGO CLIENTES</th>
            </tr>
            <tr>
                <td class="text-center align-middle fw-bold">CONCEPTO</td>
                <td class="text-center align-middle fw-bold">IMPORTE</td>
                <td class="text-center align-middle fw-bold">NOTA</td>
            </tr>
            
        </thead>
        <tbody class="bg-white">
            <?php

            $sql_listaclientes = "SELECT * FROM op_pago_clientes WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listaclientes = mysqli_query($con, $sql_listaclientes);
            while ($row_listaclientes = mysqli_fetch_array($result_listaclientes, MYSQLI_ASSOC)) {

                $idPagoCliente = $row_listaclientes['id'];
                $concepto = $row_listaclientes['concepto'];
                $nota = $row_listaclientes['nota'];

                if ($row_listaclientes['importe'] == 0) {
                    $importe = 0;
                } else {
                    $importe = number_format($row_listaclientes['importe'], 2, '.', '');
                }

                ?>

                <tr>
                    <th class="align-middle no-hover"><?= $concepto; ?></th>
                    <td class="align-middle p-0 <?=$deshabilitado, $hover?>">$ 
                        <input class="p-3" id="importe-<?= $idPagoCliente; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 80%;height: 80%; text-align: right;"
                            onkeyup="EditPCimporte(this,<?= $idReporte; ?>,<?= $idPagoCliente; ?>)" value="<?= $importe; ?>"
                            <?= $estado; ?>>
                    </td>
                    <td class="align-middle p-0 <?=$deshabilitado, $hover?>">
                        <input class="p-3" id="nota-<?= $idPagoCliente; ?>" type="text"
                            style="border: 0px;width: 100%;height: 100%; text-align: right;"
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