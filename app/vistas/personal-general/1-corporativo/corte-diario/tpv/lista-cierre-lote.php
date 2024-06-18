<?php
require ('../../../../../help.php');
$idReporte = $_GET['idReporte'];
$empresa = $_GET['empresa'];
$tpv = $corteDiarioGeneral->getTpv($idReporte);
$empresatotal = str_replace(' ', '', $empresa);
$disabled = "";
// se implemento addslashes ya que al llamar la funcion del js no me lo mandaba como string
$agregarTPV = '<button type="button" class="btn btn-primary text-white pointer"
                    onclick="AgregarCierre('.$idReporte.',\'' . addslashes($empresa) . '\')">
                    <i class="fa fa-plus"></i>
                </button>';

if ($tpv == 1) :
    $disabled = "disabled";
    $agregarTPV = '';
endif;

?>
<script type="text/javascript" src="<?php echo RUTA_CORTEDIARIO_JS ?>cierre-lote-function.js"></script>
<script type="text/javascript">


    function TotalCierre(idReporte, empresa) {

        var empresatotal = empresa.replace(/ /g, "");

        var parametros = {
            "idReporte": idReporte,
            "empresa": empresa
        };

        $.ajax({
            data: parametros,
            url: '../../../app/vistas/personal-general/1-corporativo/corte-diario/tpv/cierre-lotes-totales.php',
            //url: '../../../public/corte-diario/vistas/cierre-lotes-totales.php',
            type: 'get',
            beforeSend: function () {
            },
            complete: function () {

            },
            success: function (response) {

                $('#Total' + empresatotal).html(response);

            }
        });
    }
</script>
<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr class="tables-bg">
                <th colspan="4" class="align-middle text-center"><?=$empresa?></th>
            </tr>
            <tr>
                <td class="text-center align-middle fw-bold">No. Cierre de lote</td>
                <td class="text-center align-middle fw-bold">Importe</td>
                <td class="text-center align-middle fw-bold">No. De ticktes</td>
                <td class="text-center"><?=$agregarTPV?></td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            $sql_listacierre = "SELECT * FROM op_cierre_lote WHERE idreporte_dia = '" . $idReporte . "' AND empresa = '" . $empresa . "' ";
            $result_listacierre = mysqli_query($con, $sql_listacierre);
            $TotalImporte = 0;
            $TotalTicket = 0;
            while ($row_listacierre = mysqli_fetch_array($result_listacierre, MYSQLI_ASSOC)) {

                $idCierre = $row_listacierre['id'];
                $nocierre = $row_listacierre['no_cierre_lote'];

                $estado = $row_listacierre['estado'];

                if ($row_listacierre['importe'] == 0) {
                    $valimporte = "";
                } else {
                    $valimporte = number_format($row_listacierre['importe'], 2, '.', '');
                }

                if ($row_listacierre['ticktes'] == 0) {
                    $noticket = "";
                } else {
                    $noticket = $row_listacierre['ticktes'];
                }

                $TotalImporte = $TotalImporte + $row_listacierre['importe'];
                $TotalTicket = $TotalTicket + $row_listacierre['ticktes'];


                ?>
                <tr>
                    <th class="p-2 align-middle">
                        <input id="nocierre-<?= $idCierre; ?>" type="text"
                            style="border: 0px;width: 100%;height: 100%; text-align: left;"
                            onkeyup="EditNoCierre(this,<?= $idReporte; ?>,<?= $idCierre; ?>,'<?= $empresa; ?>')"
                            value="<?= $nocierre; ?>" <?= $disabled; ?>>
                    </th>
                    <td class="p-2 align-middle">
                        <input id="importe-<?= $idCierre; ?>" type="number" min="0" step="any"
                            style="border: 0px;width: 100%;height: 100%; text-align: right;"
                            onkeyup="EditImporte(this,<?= $idReporte; ?>,<?= $idCierre; ?>,'<?= $empresa; ?>')"
                            value="<?= $valimporte; ?>" <?= $disabled; ?>>
                    </td>
                    <td class="p-2 align-middle">
                        <input id="noticket-<?= $idCierre; ?>" type="number" min="0"
                            style="border: 0px;width: 100%;height: 100%; text-align: center;"
                            onkeyup="EditNoTicket(this,<?= $idReporte; ?>,<?= $idCierre; ?>,'<?= $empresa; ?>')"
                            value="<?= $noticket; ?>" <?= $disabled; ?>>
                    </td>
                    <td class="p-2 align-middle text-center">
                        <?php
                        if ($estado == 0) {
                            ?>

                            <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>info-24-tb.png"
                                onclick="Pendiente('<?= $idReporte; ?>','<?= $idCierre; ?>','<?= $empresa; ?>',1)">
                            <?php
                        } else {
                            ?>
                            <img class="pointer" src="<?= RUTA_IMG_ICONOS; ?>info-24-red-tb.png"
                                onclick="Pendiente('<?= $idReporte; ?>','<?= $idCierre; ?>','<?= $empresa; ?>',0)">
                            <?php
                        }
                        ?>
                    </td>
                </tr>
                <?php
            }
            ?>
            <tr id="Total<?= $empresatotal; ?>">
                <td class="align-middle text-center">Total</td>
                <td class="align-middle text-end"><b><?= number_format($TotalImporte, 2); ?></b></td>
                <td class="align-middle text-center"><b><?= $TotalTicket; ?></b></td>
                <td></td>
            </tr>
        </tbody>
    </table>

</div>