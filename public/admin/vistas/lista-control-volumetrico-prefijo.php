<?php
require ('../../../app/help.php');

$IdReporteYear = $_GET['IdReporteYear'];
$GET_mes = $_GET['GET_mes'];
$IdReporte = $_GET['IdReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_control_volumetrico_prefijos WHERE id_mes = '" . $IdReporte . "' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>

<div class="table-responsive mt-3">
    <table class="custom-table " style="font-size: .8em;" width="100%">
    <thead class="title-table-bg">
    <tr class="tables-bg">
                <th colspan="3" class="align-middle text-center">PREFIJOS Y SERIES DE FACTURACIÓN</th>
            </tr>
            <tr>
                <td class="fw-bold">SERIE</td>
                <th>DETALLE</th>
                <td class="text-end fw-bold">TOTAL</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_lista > 0) {
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];

                    if ($row_lista['total'] == 0) {
                        $total = 0;
                    } else {
                        $total = $row_lista['total'];
                    }
                    
                    echo '<tr>';
                    echo '<th class="p-0 no-hover">' . $row_lista['serie'] . '</th>';
                    echo '<td id="product-description" class="text-start no-hover lowercase">' . ucwords(strtolower($row_lista['descripcion'])) . '</td>';
                    echo '<td class="text-end no-hover p-0">
                            $ <input type="number" id="Total' . $id . '" step="any" style="width: 90%;" class="text-end border-0 p-3" value="' . $total . '" onkeyup="EditPrefijo(' . $id . ',' . $IdReporte . ',' . $IdReporteYear . ',' . $GET_mes . ',' . $idEstacion . ')"></td>';
                    echo '</tr>';
                }
            } else {
                echo "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>