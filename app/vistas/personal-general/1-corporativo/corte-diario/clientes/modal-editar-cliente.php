<?php
require ('../../../../../help.php');

$idCliente = $_GET['idCliente'];

$sql_reporte = "SELECT * FROM op_cliente WHERE id = '" . $idCliente . "' ";
$result_reporte = mysqli_query($con, $sql_reporte);
while ($row_reporte = mysqli_fetch_array($result_reporte, MYSQLI_ASSOC)) {
    $cuenta = $row_reporte['cuenta'];
    $cliente = $row_reporte['cliente'];
    $tipo = $row_reporte['tipo'];
    $rfc = $row_reporte['rfc'];


    if ($row_reporte['doc_cc'] != "") {
        $CC = '<a target="_blank" href="../../../archivos/' . $row_reporte['doc_cc'] . '"><img class="pointer float-end" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
    } else {
        $CC = '<img class="float-end" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
    }

    if ($row_reporte['doc_ac'] != "") {
        $AC = '<a target="_blank" href="../../../archivos/' . $row_reporte['doc_ac'] . '"><img class="pointer float-end" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
    } else {
        $AC = '<img class="float-end" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
    }

    if ($row_reporte['doc_cd'] != "") {
        $CD = '<a target="_blank" href="../../../archivos/' . $row_reporte['doc_cd'] . '"><img class="pointer float-end" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
    } else {
        $CD = '<img class="float-end" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
    }

    if ($row_reporte['doc_io'] != "") {
        $IO = '<a target="_blank" href="../../../archivos/' . $row_reporte['doc_io'] . '"><img class="pointer float-end" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a>';
    } else {
        $IO = '<img class="float-end" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
    }


}
?>
<div class="modal-header">
    <h5 class="modal-title">Editar Cliente</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

    <h6>* Cuenta</h6>
    <textarea class="form-control rounded-0" id="EditCuenta"><?= $cuenta; ?></textarea>

    <h6>* Cliente</h6>
    <textarea class="form-control rounded-0" id="EditCliente"><?= $cliente; ?></textarea>

    <h6>* Tipo</h6>
    <select class="form-select rounded-0" id="EditTipo">
        <option value="<?= $tipo; ?>"><?= $tipo; ?></option>
        <option value="Crédito">Crédito</option>
        <option value="Débito">Débito</option>_
    </select>

    <?php if ($tipo == "Crédito") { ?>
        <label class="text-secondary mt-2">RFC</label>
        <input type="text" class="form-control rounded-0" value="<?= $rfc; ?>" id="EditRFC">


        <div class="row">


            <div class="col-12 mt-3 mb-2">


                <div class="border p-3 mb-3">

                    <label class="mt-2 mb-1">
                        <b>Carta de crédito</b>
                    </label>

                    <?= $CC; ?>

                    <hr>
                    <input type="file" class="form-control" id="EditCartaCredito">

                </div>



                <div class="border p-3 mb-3">

                    <label class="mt-2 mb-1">
                        <b>Acta constitutiva</b>
                    </label>

                    <?= $AC; ?>

                    <hr>
                    <input type="file" class="form-control" id="EditActaConstitutiva">

                </div>


                <div class="border p-3 mb-3">

                    <label class="mt-2 mb-1">
                        <b>Comprobante de domicilio</b>
                    </label>

                    <?= $CD; ?>

                    <hr>
                    <input type="file" class="form-control" id="EditComprobanteDom">

                </div>



                <div class="border p-3 mb-3">

                    <label class="mt-2 mb-1">
                        <b>Identificación</b>
                    </label>

                    <?= $IO; ?>

                    <hr>
                    <input type="file" class="form-control" id="EditIdentificacion">

                </div>

            </div>

        </div>

        <?php
    } ?>

</div>
<div class="modal-footer">
    <?php if ($tipo == "Crédito") { ?>
        <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarCliente(<?=$idCliente?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
    <?php } ?>

    <?php if ($tipo == "Débito") { ?>
        <button type="button" class="btn btn-labeled2 btn-success" onclick="EditarClienteDebito(<?=$idCliente?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Guardar</button>
    <?php } ?>
</div>