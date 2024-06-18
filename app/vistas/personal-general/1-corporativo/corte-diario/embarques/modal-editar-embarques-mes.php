<?php
require '../../../../../help.php';

$id = $_GET['id'];
$IdReporte = $_GET['idReporte'];
$idestacion = $_GET['idestacion'];


$sql_lista = "SELECT * FROM op_embarques WHERE id = '" . $id . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

    $fecha = $row_lista['fecha'];
    $embarque = $row_lista['embarque'];
    $documento = $row_lista['documento'];
    $documentocv = $row_lista['documentocv'];
    $importef = $row_lista['importef'];
    $merma = $row_lista['merma'];
    $nomtransporte = $row_lista['nom_transporte'];


    if ($embarque == "Pemex") {
        $display = 'display: none;';
        $display_m = 'display: none;';

    } else if ($embarque == "Delivery") {
        $display = 'display: none;';
        $display_m = 'display: block;';


    } else if ($embarque == "Pick Up") {
        $display = 'display: block;';
        $display_m = 'display: block;';

    } else {
        $display = 'display: none;';
        $display_m = 'display: none;';
    }


    $producto = $row_lista['producto'];
    $chofer = $row_lista['chofer'];
    $unidad = $row_lista['unidad'];

    $PrecioLitro = $row_lista['precio_litro'];
    $TAD = $row_lista['tad'];
}

?>

<div class="modal-header">
    <h5 class="modal-title">Editar embarque</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div style="font-size: 0.8em"><b>ANEXO IV: EXPEDIENTE DE TRANPORTE PARA LA RECLAMACION DE PRODUCTO</b></div>
    <div class="mt-2" style="font-size: 0.8em"><b>Estación de servicio debe recabar:</b></div>
    <div class="mt-2" style="font-size: 0.8em">De manera enunciativa mas no limitativa, el expediente de transporte de
        cada entrega deberá contar con al menos los siguientes documentos:</div>

    <div class="mt-2" style="font-size: 0.8em">
        1. Hoja 1 “Acta de Balance (Estación)”<br>
        2. Factura final de producto.<br>
        3. Nota de Embarque de Axfaltec.<br>
        4. Check List. “LISTA DE VERIFICACIÓN DE LA DESCARGA”<br>
        5. Tirillas de inventarios (Veeder Root) inicial, final y de aumento.<br>
        6. Reporte de ventas (de ser el caso de acuerdo al punto 10 de checklist)<br>
        7. Firmas autógrafas de ambas partes.<br>
    </div>
    <hr>

    <div class="mb-1 mt-2 text-secondary">Agregar fecha</div>
    <input type="date" class="form-control" id="Fecha" value="<?= $fecha; ?>">

    <div class="mb-1 mt-2 text-secondary">Embarque</div>
    <select class="form-control" id="Embarque" onchange="Embarque()">
        <?php
        if ($embarque == "") {
            ?>
            <option></option>
            <option>Pemex</option>
            <option>Delivery</option>
            <option>Pick Up</option>
            <?php
        } else {
            ?>

            <option><?= $embarque; ?></option>
            <?php
            if ($embarque == "Pemex") {
                echo '<option>Delivery</option>
          <option>Pick Up</option>';
            } else if ($embarque == "Delivery") {
                echo '<option>Pemex</option>
          <option>Pick Up</option>';
            } else if ($embarque == "Pick Up") {
                echo '<option>Pemex</option>
          <option>Delivery</option>';
            }
            ?>

            <?php
        }
        ?>
    </select>


    <div class="mb-1 mt-2 text-secondary">Producto</div>
    <select class="form-control" id="Producto">
        <option><?= $producto; ?></option>
        <?php
        if ($producto == "G SUPER") {
            echo '<option>G PREMIUM</option>
          <option>G DIESEL</option>';
        } else if ($producto == "G PREMIUM") {
            echo '<option>G SUPER</option>
          <option>G DIESEL</option>';
        } else if ($producto == "G DIESEL") {
            echo '<option>G SUPER</option>
          <option>G PREMIUM</option>';
        } else if ($producto == "") {
            echo '<option>G SUPER</option>
          <option>G PREMIUM</option>
          <option>G DIESEL</option>';
        }
        ?>
    </select>


    <div class="mb-1 mt-2 text-secondary">Agregar documento</div>
    <input class="form-control" type="file" id="Documento">

    <div class="mb-1 mt-2 text-secondary">No. Documento CV</div>
    <input type="text" class="form-control" id="NoDocumento" value="<?= $documentocv; ?>">

    <div class="mb-1 mt-2 text-secondary">Litros Factura</div>
    <input type="number" class="form-control" id="ImporteF" step="any" value="<?= $importef; ?>">

    <div class="mb-1 mt-2 text-secondary">Precio por litro</div>
    <input type="number" class="form-control" id="PrecioLitro" step="any" value="<?= $PrecioLitro; ?>">


    <div class="mb-1 mt-2 text-secondary">TAD</div>
    <select class="form-control" id="Tad">
        <option><?= $TAD; ?></option>
        <option>906 Tizayuca</option>
        <option>904 Tuxpan</option>
        <option>Pemex</option>
        <option>903 Atlacomulco</option>
        <option>901 Vopack</option>
        <option>908 Monterra</option>
        <option>907 Puebla</option>
    </select>


    <hr>


    <!---------- FACTURAS XML Y PDF ---------->
    <div class="border p-3 mb-2" id="FacturasUP" style="<?= $display; ?>">
        <div class="text-secondary"><b>Factura</b></div>
        <hr>

        <div class=" mb-1 text-secondary">PDF:</div>
        <input class="form-control" type="file" id="PDF">

        <div class="mt-2 mb-1 text-secondary">XML:</div>
        <input class="form-control" type="file" id="XML">
    </div>


    <!---------- COMPROBANTE DE PAGO ---------->
    <div class="border p-3 mb-2" id="ComprobantePagoUp" style="<?= $display; ?>">
        <div class="text-secondary"><b>Comprobante de pago</b></div>
        <hr>
        <input class="form-control" type="file" id="CoPa">
    </div>

    <!---------- NOTA DE CREDITO ---------->
    <div class="border p-3 mb-2" id="NotaCreditoUp" style="<?= $display; ?>">
        <div class="text-secondary"><b>Nota de credito</b></div>
        <hr>
        <div class="mb-1 text-secondary">PDF:</div>
        <input class="form-control" type="file" id="NCPDF">

        <div class="mb-1 mt-2 text-secondary">XML:</div>
        <input class="form-control" type="file" id="NCXML">
    </div>


    <!---------- COMPLEMENTO XML Y PDF ---------->
    <div id="ComplementoUp" style="<?= $display; ?>">
        <div class="border p-3 mb-2">
            <div class="text-secondary"><b>Complemento de pago</b></div>
            <hr>

            <div class=" mb-1 text-secondary">PDF:</div>
            <input class="form-control" type="file" id="ComPDF">

            <div class="mt-2 mb-1 text-secondary">XML:</div>
            <input class="form-control" type="file" id="ComXML">
        </div>
        <hr>
    </div>


    <div class="mt-2 mb-1 text-secondary">Chofer</div>
    <input type="text" class="form-control" id="Chofer" value="<?= $chofer; ?>">

    <div class="mt-2 mb-1 text-secondary">Unidad</div>
    <input type="text" class="form-control" id="Unidad" value="<?= $unidad; ?>">


    <div id="DivMerma" style="<?= $display_m; ?>">

        <hr>
        <div class="mt-2 mb-1 text-secondary">Merma</div>
        <input type="number" class="form-control" id="Merma" step="any" value="<?= $merma; ?>">

        <div class="mb-1 mt-2 text-secondary">Nombre del transporte</div>
        <select class="form-control" id="NombreTransporte">
            <option><?= $nomtransporte; ?></option>
            <?php
            $sql_unidades = "SELECT nombre_transporte FROM tb_lista_transportes WHERE estado = 0 ORDER BY nombre_transporte ASC";
            $result_unidades = mysqli_query($con, $sql_unidades);
            $numero_unidades = mysqli_num_rows($result_unidades);

            while ($row_unidades = mysqli_fetch_array($result_unidades, MYSQLI_ASSOC)) {
                $nombre_transporte = $row_unidades['nombre_transporte'];

                echo '<option>' . $nombre_transporte . '</option>';

            }

            ?>

        </select>

    </div>

</div>

<div class="modal-footer">
    <button type="button" class="btn btn-labeled2 btn-success float-end m-2" onclick="EditarE(<?= $IdReporte; ?>,<?= $id; ?>,<?= $idestacion; ?>)">
        <span class="btn-label2"><i class="fa fa-check"></i></span>Editar
    </button>
</div>