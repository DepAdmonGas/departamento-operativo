<?php
require ('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_aceites_factura WHERE id_mes = '" . $IdReporte . "' ORDER BY fecha ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="modal-header">
    <h5 class="modal-title">Archivos aceites</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

    <div class="col-xl-12 mb-2">
        <h6 class="mb-2 mt-1 text-secondary fw-bold">* FECHA</h6>
        <input class="form-control" type="date" id="fechaAceite">
    </div>


    <div class="col-12 mb-2">
        <h6 class="mb-2 mt-2 text-secondary fw-bold">* CONCEPTO</h6>
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
        <h6 class="mb-2 mt-2 text-secondary fw-bold">* AGREGAR ARCHIVO</h6>
        <input class="form-control" type="file" id="facturaAceite">
    </div>

    <hr>
    <div class="text-end mb-2">
        <button type="button" class="btn btn-labeled2 btn-success" onclick="GuardarFactura(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">
        <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
    </div>
    

    <div class="table-responsive">
    <table class="custom-table" style="font-size: .75em;" width="100%">
    <thead class="navbar-bg">
                <th class="text-center align-middle font-weight-bold">Fecha</th>
                <th class="text-center align-middle font-weight-bold">Concepto</th>
                <th class="text-center align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
                </th>
                <th class="text-center align-middle text-center" width="20"><img
                        src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
            </thead>

            <tbody class="bg-light">

            
            <?php
            if ($numero_lista > 0) {
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];
                    $fecha = $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']);
                    $anexo = $row_lista['nombre_anexo'];
                    $archivo = $row_lista['archivo'];

                    echo '<tr>';
                    echo '<th class="align-middle text-center">' . $fecha . '</th>';
                    echo '<td class="align-middle text-center">' . $anexo . '</td>';
                    echo '<td class="align-middle text-center"><a href="' . RUTA_ARCHIVOS . 'aceites-facturas/' . $archivo . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></a></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarFacturaAceite(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $id . ')"></td>';
                    echo '</tr>';

                }
            } else {
                echo "<tr><th colspan='4' class='text-center text-secondary bg-light'><small>No se encontró información para mostrar </small></th></tr>";
            }

            ?>
        </tbody>
        </table>

    </div>

</div>
