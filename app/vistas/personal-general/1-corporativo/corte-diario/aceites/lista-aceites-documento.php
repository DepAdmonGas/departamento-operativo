<?php
require ('../../../../../help.php');

$IdReporte = $_GET['IdReporte'];
$year = $_GET['year'];
$mes = $_GET['mes'];

$sql_lista = "SELECT * FROM op_aceites_documento WHERE id_mes = '" . $IdReporte . "' ORDER BY id desc";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<div class="modal-header">
    <h5 class="modal-title">Documentos</h5>
    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">
<div class="text-end mb-2">

<button type="button" class="btn btn-labeled2 btn-primary" onclick="Nuevo(<?= $IdReporte; ?>,<?= $year; ?>,<?= $mes; ?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Nuevo</button>

</div>
<hr>
    <div class="table-responsive">
    <table class="custom-table" style="font-size: .75em;" width="100%">
    <thead class="navbar-bg">
                <th class="align-middle text-center">FECHA</th>
                <th class="align-middle text-center">FICHA DEPOSITO FALTANTE</th>
                <th class="align-middle text-center">IMAGEN DE BODEGA</th>
                <th class="align-middle text-center">FACTURA VENTA MOSTRADOR</th>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
            </thead>
            <tbody class="bg-light">

                <?php
                if ($numero_lista > 0) {
                    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

                        if ($session_nompuesto != "Contabilidad" && $session_nompuesto != "Dirección de operaciones servicio social") {
                            $eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $row_lista['id'] . ')">';
                        } else {
                            $eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" >';
                        }

                        if ($row_lista['ficha_deposito']) {
                            $ficha = '<a href="../../archivos/' . $row_lista['ficha_deposito'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png"></a>';
                        } else {
                            $ficha = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
                        }

                        if ($row_lista['imagen_bodega']) {
                            $imagen = '<a href="../../archivos/' . $row_lista['imagen_bodega'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png"></a>';
                        } else {
                            $imagen = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
                        }

                        if ($row_lista['factura_venta']) {
                            $factura = '<a href="../../archivos/' . $row_lista['factura_venta'] . '" download><img class="pointer" src="' . RUTA_IMG_ICONOS . 'descargar.png"></a>';
                        } else {
                            $factura = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
                        }

                        echo '<tr>';
                            echo '<th class="align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($row_lista['fecha']) . '</th>';

                            echo '<td class="text-center align-middle">' . $ficha . '</td>';
                            echo '<td class="text-center align-middle">' . $imagen . '</td>';
                            echo '<td class="text-center align-middle">' . $factura . '</td>';


                            echo '<td class="align-middle" width="20"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $IdReporte . ',' . $year . ',' . $mes . ',' . $row_lista['id'] . ')"></td>';
                            echo '<td class="align-middle" width="20">' . $eliminar . '</td>';
                        echo '</tr>';

                    }
                } else {
                    echo "<tr><th colspan='7' class='text-center text-secondary bg-light'><small>No se encontró información para mostrar </small></th></tr>";
                }
                ?>
            </tbody>
        </table>
    </div>

</div>
