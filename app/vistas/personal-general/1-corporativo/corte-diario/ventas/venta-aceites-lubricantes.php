<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$estado = "";
$deshabilitado="";
$nohover = "no-hover";
$ventas = $corteDiarioGeneral->ventas($idReporte);
if ($ventas == 1):
    $estado = "disabled";
    $deshabilitado="disabledOP";
    $nohover = "";
endif;

$sql_listaaceites = "SELECT * FROM op_aceites_lubricantes WHERE idreporte_dia = '" . $idReporte . "' ORDER BY id_aceite ASC ";
$result_listaaceites = mysqli_query($con, $sql_listaaceites);
$numero_listaaceites = mysqli_num_rows($result_listaaceites);
?>
<script type="text/javascript">

    $(document).ready(function ($) {

        AceitesLTotal(<?= $idReporte; ?>);

    });

    function AceitesLTotal(idReporte) {
        $('#TrAceitesTotal').load('../../../app/vistas/personal-general/1-corporativo/corte-diario/ventas/aceites-lubricantes-totales.php?idReporte=' + idReporte);
        //$('#TrAceitesTotal').load('../../../public/corte-diario/vistas/aceites-lubricantes-totales.php?idReporte=' + idReporte);
    }
</script>

<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr class="tables-bg">
                <th colspan="5" class="align-middle text-center">RELACION DE VENTA DE ACEITES Y LUBRICANTES</th>
            </tr>
            <tr>
                <td class="align-middle text-center fw-bold">#</td>
                <th class="align-middle text-center">CONCEPTO</th>
                <th class="align-middle text-center">CANTDAD</th>
                <th class="align-middle text-center">PRECIO UNITARIO</th>
                <td class="align-middle text-center fw-bold">IMPORTE</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_listaaceites > 0) {
                while ($row_listaaceites = mysqli_fetch_array($result_listaaceites, MYSQLI_ASSOC)) {

                    $idAceite = $row_listaaceites['id'];
                    $numAceite = $row_listaaceites['id_aceite'];
                    $concepto = $row_listaaceites['concepto'];
                    $preciounitario = $row_listaaceites['precio_unitario'];


                    if ($row_listaaceites['cantidad'] == 0) {
                        $cantidad = "";
                    } else {
                        $cantidad = $row_listaaceites['cantidad'];
                    }

                    if ($row_listaaceites['precio_unitario'] == 0) {
                        $precio = "";
                    } else {
                        $precio = number_format($row_listaaceites['precio_unitario'], 2, '.', '');
                    }

                    $importe = $row_listaaceites['cantidad'] * $row_listaaceites['precio_unitario'];
                    ?>

                    <tr>
                        <th class="p-0 align-middle no-hover"><?= $numAceite; ?></th>
                        <td class="p-0 align-middle no-hover"><?= $concepto; ?></td>
                        <td class="p-0 align-middle <?= $deshabilitado,$nohover?> ">
                            <input class="p-3 "id="cantidadAL-<?= $idAceite; ?>" type="number" min="0"
                                style="border: 0px;width: 100%;height: 100%; text-align: center;"
                                onkeyup="EditALCantidad(this,<?= $idReporte; ?>,<?= $idAceite; ?>)" value="<?= $cantidad; ?>"
                                <?=$estado?>>
                        </td>
                        <!-- <td class="align-middle text-end" id="precioAL-<?= $idAceite; ?>"> -->
                        <td class="p-0 align-middle text-end <?= $deshabilitado,$nohover?>">

                            <input class="p-3 "id="precioAL-<?= $idAceite; ?>" type="number" min="0"
                                style="border: 0px;width: 100%;height: 100%; text-align: center;"
                                onkeyup="EditALPrecio(this,<?= $idReporte; ?>,<?= $idAceite; ?>)" value="<?= $preciounitario; ?>" <?=$estado?>>
                            <!--<?= $precio; ?> -->
                        </td>
                        <td class=" align-middle text-end no-hover" id="importeAL-<?= $idAceite; ?>"><?= number_format($importe, 2); ?></td>
                    </tr>

                    <?php
                }

                echo '<tr id="TrAceitesTotal"></tr>';
            } else {
                echo '<tr><th colspan="5" class="text-center p-3 no-hover"><small>No se encontró información, verifica que el inventario del mes pasado este finalizado.</small></th></tr>';

            }
            ?>

        </tbody>
    </table>
</div>