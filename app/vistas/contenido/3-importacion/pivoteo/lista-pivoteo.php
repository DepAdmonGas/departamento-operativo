<?php
require ('../../../../help.php');

$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_pivoteo WHERE id_estacion = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
?>
<div class="table-responsive">
    <table class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr>
                <th class="text-center align-middle tableStyle font-weight-bold">No. de control</th>
                <td class="align-middle text-center tableStyle font-weight-bold">Fecha</td>
                <td class="align-middle text-center tableStyle font-weight-bold">Sucursal</td>
                <td class="align-middle text-center tableStyle font-weight-bold">Causa</td>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png"></th>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
                <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
            </tr>
        </thead>
        <tbody class="bg-light">
            <?php
            if ($numero_lista > 0) {

                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];
                    $nocontrol = $row_lista['nocontrol'];
                    $status = $row_lista['estatus'];

                    if ($status == 0) {
                        $tableColor = 'style="background-color: #fcfcda"';
                        $Detalle = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'ver-tb.png">';
                        $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
                        $Editar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="Editar(' . $idEstacion . ',' . $id . ')">';
                        $Eliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $idEstacion . ',' . $id . ')">';
                    } else if ($status == 1) {
                        $tableColor = 'style="background-color: #ffb6af"';
                        $Detalle = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="VerPivoteo(' . $id . ')">';
                        $PDF = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'pdf.png">';
                        $Editar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'editar-tb.png">';
                        $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
                    } else if ($status == 2) {
                        $tableColor = 'style="background-color: #b0f2c2"';
                        $Detalle = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="VerPivoteo(' . $id . ')">';
                        $PDF = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png" onclick="PivoteoPDF(' . $id . ')">';
                        $Editar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'editar-tb.png">';
                        $Eliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';
                    }

                    if ($row_lista['fecha'] == '0000-00-00') {
                        $Fecha = 'S/N';
                    } else {
                        $Fecha = FormatoFecha($row_lista['fecha']);
                    }

                    echo '<tr ' . $tableColor . '>';
                    echo '<th class="align-middle text-center"><b>0' . $nocontrol . '</b></th>';
                    echo '<td class="align-middle text-center">' . $Fecha . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['sucursal'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['causa'] . '</td>';
                    echo '<td class="align-middle text-center">' . $Detalle . '</td>';
                    echo '<td class="align-middle text-center">' . $PDF . '</td>';
                    echo '<td class="align-middle text-center">' . $Editar . '</td>';
                    echo '<td class="align-middle text-center">' . $Eliminar . '</td>';
                    echo '</tr>';

                }
            } else {
                echo "<tr><td colspan='8' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>