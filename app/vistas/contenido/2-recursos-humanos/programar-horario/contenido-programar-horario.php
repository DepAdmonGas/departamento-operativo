<?php
require ('../../../../help.php');

$idEstacion = $Session_IDEstacion;

$sql_empresa = "SELECT * FROM op_rh_personal_horario_programar WHERE id_estacion = '" . $idEstacion . "' AND estado >= 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
?>
<div class="table-responsive">
<table id="tabla_horario" class="custom-table mt-2" style="font-size: .8em;" width="100%">

        <thead class="navbar-bg">
            <tr>
                <th class="text-center align-middle" width="48px">#</th>
                <th class="text-center">Fecha programada</th>
                <th class="text-center align-middle" width="32px"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png" /></th>
        </thead>
        </tr>

        <tbody>
            <?php
            if ($numero_empresa > 0) {
                while ($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)) {

                    $id = $row_empresa['id'];

                    if ($row_empresa['estado'] == 1) {
                        $trcolor = 'style="background-color: #fcfcda"';
                        $eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" class="pointer" onclick="Eliminar(' . $id . ')"/>';
                    } else if ($row_empresa['estado'] == 2) {
                        $trcolor = 'style="background-color: #b0f2c2"';
                        $eliminar = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" class="pointer"/>';
                    }

                    echo '<tr '. $trcolor.' pointer">';
                    echo '<th class="text-center align-middle" onclick="Detalle(' . $id . ')">' . $row_empresa['id'] . '</th>';
                    echo '<td class="text-start" onclick="Detalle(' . $id . ')">' . FormatoFecha($row_empresa['fecha']) . '</td>';
                    echo '<td class="text-center align-middle">' . $eliminar . '</td>';
                    echo '</tr>';

                }
            } else {
                echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }

            ?>
        </tbody>
    </table>
</div>