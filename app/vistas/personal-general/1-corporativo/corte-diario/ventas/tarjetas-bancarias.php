<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$deshabilitado="";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
    $deshabilitado="disabledOP";
endif;
?>
<script type="text/javascript">
    $(document).ready(function ($) {
        TarjetasTotal(<?=$idReporte?>);
    });

    function TarjetasTotal(idReporte) {
        $('#TrTCBTotales').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/tarjetas-bancarias-totales.php?idReporte=' + idReporte);
        //$('#TrTCBTotales').load('../../../public/corte-diario/vistas/tarjetas-bancarias-totales.php?idReporte=' + idReporte);
    }
</script>
<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr class="tables-bg">
                <th colspan="5" class="align-middle text-center">MONEDEROS Y BANCOS</th>
            </tr>
            <tr>
                <td class="text-center fw-bold" colspan="2">CONCEPTO / BANCO</td>
                <td class="text-center fw-bold">IMPORTE</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php

            $sql_listatarjetas = "SELECT * FROM op_tarjetas_c_b WHERE idreporte_dia = '" . $idReporte . "' ";
            $result_listatarjetas = mysqli_query($con, $sql_listatarjetas);
            while ($row_listatarjetas = mysqli_fetch_array($result_listatarjetas, MYSQLI_ASSOC)) {

                $idTarjeta = $row_listatarjetas['id'];
                $num = $row_listatarjetas['num'];
                $conceptoTarjeta = $row_listatarjetas['concepto'];

                $baucher = 0;
                if ($row_listatarjetas['baucher'] != 0) {
                    $baucher = number_format($row_listatarjetas['baucher'], 2, '.', '');
                }
                ?>

                <tr>
                    <th class="align-middle text-center no-hover"><b><?= $num; ?></b></th>
                    <td class="align-middle no-hover"><?= $conceptoTarjeta; ?></td>

                    <?php

                    if (
                        $conceptoTarjeta == "TICKETCARD" ||
                        $conceptoTarjeta == "G500 FLETT" ||
                        $conceptoTarjeta == "EFECTICARD" ||
                        $conceptoTarjeta == "SODEXO" ||
                        $conceptoTarjeta == "AMERICAN EXPRESS" ||
                        $conceptoTarjeta == "BBVA BANCOMER SA" ||
                        $conceptoTarjeta == "INBURGAS" ||
                        $conceptoTarjeta == "ULTRAGAS" ||
                        $conceptoTarjeta == "ENERGEX" ||
                        $conceptoTarjeta == "INBURSA" ||
                        $conceptoTarjeta == "SHELL FLEET NAVIGATOR"
                    ) {
                        echo "<td class='align-middle text-end bg-white'>" . number_format($baucher, 2) . "</td>";
                    } else {
                        ?>
                        <td class="p-0 align-middle text-end no-hover">
                            <input class="<?=$deshabilitado?>" id="baucher-<?= $idTarjeta; ?>" type="number" min="0" step="any"
                                style="border: 0px;width: 100%;padding: 3px;height: 100%; text-align: right;"
                                onkeyup="EditTBaucher(this,<?= $idReporte; ?>,<?= $idTarjeta; ?>)" value="<?= $baucher; ?>"
                                <?= $estado; ?>>
                        </td>
                    <?php
                    }
                    ?>

                </tr>

                <?php
            }

            ?>
            <tr id="TrTCBTotales"></tr>
        </tbody>
    </table>
</div>