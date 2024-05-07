<?php
require ('../../../../help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_aceites_factura WHERE id_mes = '" . $IdReporte . "' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="modal-header">
    <h5 class="modal-title">Archivos aceites</h5>
    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div class="col-xl-12 mb-2">
        <div class="mb-1 text-secondary">Fecha</div>
        <input class="form-control" type="date" id="fechaAceite">
    </div>


    <div class="col-12 mb-2">
        <div class="mb-1 text-secondary">Concepto</div>
        <select class="form-select" id="conceptoAceite">
            <option value="">Selecciona una opcion...</option>
            <option value="Nota de remisión QUAKER STATE">Nota de remisión QUAKER STATE</option>
            <option value="Nota de remisión G5">Nota de remisión G5</option>
            <option value="Nota de remisión BARDAHL">Nota de remisión BARDAHL</option>
            <option value="Factura QUAKER STATE">Factura QUAKER STATE</option>
            <option value="Factura G5">Factura G5</option>
            <option value="Factura BARDAHL">Factura BARDAHL</option>
        </select>
    </div>

    <div class="col-xl-12 mb-2">
        <div class="mb-1 text-secondary">Agregar archivo</div>
        <input class="form-control" type="file" id="facturaAceite">
    </div>


    <div class="text-end">
        <button type="button" class="btn btn-primary"
            onclick="GuardarFactura(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">Agregar</button>
    </div>



    <hr>

    <div class="table-responsive">

        <table class="table table-sm table-bordered mb-0 pb-0" style="font-size: .9em;">

            <thead class="tables-bg">
                <th class="text-center align-middle font-weight-bold">Fecha</th>
                <th class="text-center align-middle font-weight-bold">Concepto</th>
                <th class="text-center align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
                </th>
                <th class="text-center align-middle text-center" width="20"><img
                        src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
            </thead>


            <?php
            if ($numero_lista > 0) {
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];
                    $fecha = FormatoFecha($row_lista['fecha']);
                    $anexo = $row_lista['nombre_anexo'];
                    $archivo = $row_lista['archivo'];

                    echo '<tr>';
                    echo '<td class="align-middle text-center">' . $fecha . '</td>';
                    echo '<td class="align-middle text-center">' . $anexo . '</td>';
                    echo '<td class="align-middle text-center"><a href="' . RUTA_ARCHIVOS . 'aceites-facturas/' . $archivo . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarFacturaAceite(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $id . ')"></td>';
                    echo '</tr>';

                }
            } else {
                echo "<tr><td colspan='4' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }

            ?>

        </table>

    </div>

</div>