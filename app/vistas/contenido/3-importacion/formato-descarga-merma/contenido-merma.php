<?php
require ('../../../../help.php');
function Estacion($idEstacion, $con) : string
{   
    $estacion = "";
    $sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = ? ";
    $stmt = $con->prepare($sql_listaestacion);
    $stmt->bind_param("i",$idEstacion);
    $stmt->execute();
    $stmt->bind_result($estacion);
    $stmt->fetch();
    $stmt->close();
    return $estacion;
}
?>
<div class="table-responsive">
    <table id="tabla_merma" class="custom-table mt-2" style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr>
                <th class="align-middle text-center">Folio</th>
                <th class="align-middle text-center">Estación</th>
                <th class="align-middle text-center">Fecha y hora</th>
                <th class="align-middle text-center" width="20px"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
                <th class="align-middle text-center" width="20px"><img src="<?= RUTA_IMG_ICONOS; ?>pdf.png">
                </th>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            $consulta = "WHERE id_estacion = '" . $Session_IDEstacion . "' ORDER BY folio desc";
            if ($Session_IDEstacion == 8) :
                $consulta = "ORDER BY folio desc";
            endif;
            $sql_lista = "SELECT * FROM op_descarga_tuxpa $consulta";

            $result_lista = mysqli_query($con, $sql_lista);
            $numero_lista = mysqli_num_rows($result_lista);

            if ($numero_lista > 0) :
                while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) :
                    $id = $row_lista['id'];
                    $folio = $row_lista['folio'];
                    $Estacion = Estacion($row_lista['id_estacion'], $con);
                    $fechallegada = FormatoFecha($row_lista['fecha_llegada']);
                    $horallegada = date("g:i a", strtotime($row_lista['hora_llegada']));

                    echo '<tr>
                            <th class="align-middle text-center"><b>00' . $folio . '</b></th>
                            <td class="align-middle text-center">' . $Estacion . '</td>
                            <td class="align-middle text-">' . $fechallegada . ', ' . $horallegada . '</td>
                            <td class="align-middle text-center"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="Detalle(' . $id . ')"></td>
                            <td class="align-middle text-center" onclick="PDF(' . $id . ')"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'pdf.png"></td>
                        </tr>';
                endwhile;
            else :
                echo "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            endif;
            ?>
        </tbody>
    </table>
</div>