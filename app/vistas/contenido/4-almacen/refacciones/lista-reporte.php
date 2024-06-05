<?php
require ('../../../../help.php');

$sql_lista = "SELECT * FROM op_refacciones_reporte WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $Session_IDEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $estacion = $row_listaestacion['nombre'];
}

function Personal($idusuario, $con)
{
    $sql = "SELECT nombre FROM tb_usuarios WHERE id = '" . $idusuario . "' ";
    $result = mysqli_query($con, $sql);
    while ($row = mysqli_fetch_array($result, MYSQLI_ASSOC)) {
        $nombre = $row['nombre'];
    }
    return $nombre;
}

function Refaccion($idrefaccion, $con)
{

    $sql_lista = "SELECT * FROM op_refacciones WHERE id = '" . $idrefaccion . "' ";
    $result_lista = mysqli_query($con, $sql_lista);
    $numero_lista = mysqli_num_rows($result_lista);
    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

        $nombre = $row_lista['nombre'];
    }
    return $nombre;
}
?>

<div class="table-responsive">
    <table class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr>
                <th class="text-center align-middle tableStyle font-weight-bold">#</th>
                <td class="text-center align-middle tableStyle font-weight-bold">Personal</td>
                <td class="text-center align-middle tableStyle font-weight-bold">Fecha y hora</td>
                <td class="text-center align-middle tableStyle font-weight-bold">Motivo</td>
                <td class="text-center align-middle tableStyle font-weight-bold">Dispensario</td>
                <td class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></td>
                <td class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></td>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_lista > 0) {

                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];
                    $status = $row_lista['status'];

                    if ($status == 0) {
                        $tableColor = 'style="background-color: #fcfcda"';
                    } else {
                        $tableColor = "";
                    }
                    echo '<tr '.$tableColor.'>';
                    echo '<th class="align-middle text-center"><b>' . $id . '</b></th>';
                    echo '<td class="align-middle text-center">' . Personal($row_lista['id_usuario'], $con) . '</td>';
                    echo '<td class="align-middle text-center">' . FormatoFecha($row_lista['fecha']) . ', ' . date('g:i a', strtotime($row_lista['hora'])) . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['motivo'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['dispensario'] . '</td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="ModalDetalleReporte(' . $id . ')"></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="EditarReporte(' . $id . ')"></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="EliminarReporte(' . $id . ')"></td>';
                    echo '</tr>';

                }
            } else {
                echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>