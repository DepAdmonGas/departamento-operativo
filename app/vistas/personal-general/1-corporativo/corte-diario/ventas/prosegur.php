<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$deshabilitado = "";
$hover = "no-hover";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
    $deshabilitado="disabledOP";
    $hover = "";
endif;
?>
<script type="text/javascript">

    $(document).ready(function ($) {

        ProsegurTotal(<?= $idReporte; ?>);

    });

    function ProsegurTotal(idReporte) {
        $('#TrProTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/prosegur-totales.php?idReporte=' + idReporte);
        //$('#TrProTotales').load('../../../public/corte-diario/vistas/prosegur-totales.php?idReporte=' + idReporte);
    }

</script>

<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="title-table-bg">
            <tr class="tables-bg">
            <th colspan="5" class="align-middle text-center">PROSEGUR</th>
            </tr>
            <tr>
                <td class="text-center fw-bold">DENOMINACION</td>
                <td class="text-center fw-bold">RECIBO</td>
                <td class="text-center fw-bold">IMPORTE</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php

            $sql_listaprosegur = "SELECT * FROM op_prosegur WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listaprosegur = mysqli_query($con, $sql_listaprosegur);
            $totalImporte = 0;
            while ($row_listaprosegur = mysqli_fetch_array($result_listaprosegur, MYSQLI_ASSOC)) {

                $idProsegur = $row_listaprosegur['id'];
                $denominacion = $row_listaprosegur['denominacion'];
                $recibo = $row_listaprosegur['recibo'];

                if ($row_listaprosegur['importe'] == 0) {
                    $valimporte = 0;
                } else {
                    $valimporte = number_format($row_listaprosegur['importe'], 2, '.', '');
                }

                $importe = $row_listaprosegur['importe'];

                $totalImporte = $totalImporte + $importe;

                ?>

                <tr>
                    <th class="align-middle no-hover p-3"><?= $denominacion; ?></th>
                    <td class="p-0 align-middle <?=$deshabilitado, $hover?>">
                        <input class="p-3" id="recibo-<?= $idProsegur; ?>" type="text"
                            style="border: 0px;width: 100%;height: 100%; text-align: right;"
                            onkeyup="EditPRecibo(this,<?= $idReporte; ?>,<?= $idProsegur; ?>)" value="<?= $recibo; ?>"
                            <?=$estado?>>
                    </td>
                    <td class="p-0 align-middle <?=$deshabilitado, $hover?>">$ 
                        <input class="p-3" id="importe-<?= $idProsegur; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 80%;height: 80%; text-align: right;"
                            onkeyup="EditPImporte(this,<?= $idReporte; ?>,<?= $idProsegur; ?>)" value="<?= $valimporte; ?>"
                            <?=$estado?>>
                    </td>
                    
                </tr>

                <?php
            }

            ?>
            <tr id="TrProTotales">
            </tr>
        </tbody>
    </table>
</div>