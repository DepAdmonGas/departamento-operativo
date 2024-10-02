<?php
require ('../../../app/help.php');

$sql_lista = "SELECT * FROM op_terminales_tpv WHERE id_estacion = '" . $Session_IDEstacion . "' AND status = 1 ORDER BY tpv ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '" . $Session_IDEstacion . "' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while ($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)) {
    $estacion = $row_listaestacion['nombre'];
}

function Reporte($id, $con)
{

    $sql = "SELECT * FROM op_terminales_tpv_reporte WHERE id_tpv = '" . $id . "' AND status = 0 ";
    $result = mysqli_query($con, $sql);
    $numero = mysqli_num_rows($result);

    return $numero;
}
?>

<div class="table-responsive">
        <table id="terminales-punto-venta" class="custom-table mt-2" style="font-size: .75em;" width="100%">
            <thead class="navbar-bg">
            <th class="align-middle text-center">#</th>
            <th class="align-middle text-center">TPV´S</th>
            <th class="align-middle text-center">No DE SERIE</th>
            <th class="align-middle text-center">MODELO/MARCA</th>
            <th class="align-middle text-center">No LOTE</th>
            <th class="align-middle text-center">TIPO DE CONEXIÓN</th>
            <th class="align-middle text-center">NUMERO DE AFILIACION</th>
            <th class="align-middle text-center">TELEFONO ATENCION A CLIENTES</th>
            <th class="align-middle text-center">ACTIVAS</th>
            <th class="align-middle text-center">ROLLOS</th>
            <th class="align-middle text-center">CARGADORES</th>
            <th class="align-middle text-center">PEDESTALES EN BUEN ESTADO</th>
            <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
            <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
            <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>falla-icon.png"></th>
        </thead>
        <tbody>
            <?php
            if ($numero_lista > 0) {
                $num = 1;
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
                    $id = $row_lista['id'];

                    if (Reporte($id, $con) == 1) {
                        $fondo = "table-danger";
                    } else {
                        $fondo = "";
                    }

                    echo '<tr class="' . $fondo . '">';
                    echo '<td class="align-middle text-center">' . $num . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['tpv'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['no_serie'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['modelo'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['no_lote'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['tipo_conexion'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['no_afiliacion'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['telefono'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['estado'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['rollos'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['cargadores'] . '</td>';
                    echo '<td class="align-middle text-center">' . $row_lista['pedestales'] . '</td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="ModalDetalle(' . $id . ')"></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'editar-tb.png" onclick="ModalEditar(' . $id . ')"></td>';
                    echo '<td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'falla-icon.png" onclick="ModalFalla(' . $id . ')"></td>';

                    echo '</tr>';

                    $num++;
                }
            } else {
                echo "<tr><td colspan='16' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }

            if ($Session_IDEstacion == 1) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">BOULEVARD MAGNO CENTRO No 8 BOSQUES DE LAS PALMAS HUIXQUILUCAN EDO DE MEX C.P. 52787 MEXICO RFC: AGI990422EL7 MAIL: g500interlomas@admongas.com.mx TELF: 5552907260 </td>
                    </tr>
                    <tr class="ultima-fila">
                    <td class="text-center bg-warning" colspan="16">CODIGO POSTAL PARA BANCOMER ES : 52760</td>
                    </tr>';
            } else if ($Session_IDEstacion == 2) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">AV. PALO SOLO 3515 PALO SOLO  C.P. 52778 HUIXQUILUCAN ESTADO DE MEXICO RFC AGA960830CW6 TELF: 5550490431</td>
                        </tr>';
            } else if ($Session_IDEstacion == 3) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">CALZADA SAN AGUSTIN No 1 COLONIA 10 DE ABRIL  C. P. 53320  NAUCALPAN DE JUAREZ EDO DE MEXICO  RFC AGS9904221T6  TELF: 5553600789 </td>
                    </tr>';
            } else if ($Session_IDEstacion == 4) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">CARR RIO HONDO HUIXQUILUCAN No 401 SAN BARTOLOME COATEPEC C.P. 52796  MEXICO  HUIXQUILUCAN EDO DE MEX  C.P para bancomer(52773) MAIL: gasomira@hotmail.com Telf: 5582889447 (G500) </td>
                    </tr>';
            } else if ($Session_IDEstacion == 5) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16"> CARRETERA LAGO DE GAUDALUPE KM 5.5 COL VILLAS DE LAS HACIENDA C.P. 52929 ATIZAPAN DE ZARAGOZA  EDO. DE MEXICO RFC:GVG310114GU6 TELF: 5558195682 </td>
                    </tr>';
            } else if ($Session_IDEstacion == 6) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">AV. JORGE JIMENEZ CANTU 30 MZ. 1 LT .2  BOSQUE ESMERALDA, ATIZAPAN DE ZARAGOZA CP52930 MAIL: esmegas@admongas.com.mx</td>
                    </tr>';
            } else if ($Session_IDEstacion == 7) {
                echo '<tr class="ultima-fila">
                        <td class="text-center bg-light" colspan="16">AV PROLONGACION DIVISION DEL NORTE 5322 COL AMPLIACION SAN MARCOS NORTE C. P. 16050 XOCHIMILCO CDMX MAIL. admongasxochimilco5679@hotmail.com telf: 5553349220 RFC: AGX151117TQ8 </td>
                    </tr>';
            }
            ?>
        </tbody>
    </table>
</div>