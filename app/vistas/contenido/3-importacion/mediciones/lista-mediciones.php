<?php
require ('../../../../help.php');

$sql_lista = "SELECT * FROM op_mediciones WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY id ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive">
    <table id="tabla_mediciones" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <th class="align-middle text-center">#</th>
            <th class="align-middle text-center">FECHA</th>
            <th class="align-middle text-center">FACTURA</th>
            <th class="align-middle text-center">NETO</th>
            <th class="align-middle text-center">BRUTO</th>
            <th class="align-middle text-center">CUENTA LITROS</th>
            <th class="align-middle text-center">PROVEEDOR</th>
            <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
        </thead>
        <tbody class="bg-light">
            <?php

            if ($numero_lista > 0) {
                $num = 1;
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {

                    echo '<tr>';
                    echo '<th class="align-middle text-center">' . $num . '</th>';
                    echo '<td class="align-middle">' . FormatoFecha($row_lista['fecha']) . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['factura'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['neto'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['bruto'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['cuenta_litros'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['proveedor'] . '</td>';
                    echo '<td class="text-center align-middle" width="20"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $row_lista['id'] . ')"></td>';
                    echo '</tr>';
                    $num++;
                }
            } else {
                echo "<tr><th colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></th></tr>";
            }
            ?>
        </tbody>
    </table>
</div>