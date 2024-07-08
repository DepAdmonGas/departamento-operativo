<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];

$sql_lista = "SELECT * FROM op_rh_permisos WHERE id_estacion = '" . $idEstacion . "' OR estacion_cubre = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

?>
 
    <div class="row">
    <div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
            <thead class="navbar-bg">
                <tr>
                    <th class="text-center align-middle tableStyle font-weight-bold">#</t>
                    <th class="text-center align-middle tableStyle font-weight-bold">Colaborador</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Del</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Hasta</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Dias tomados</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Quien cubre</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Motivo</th>
                    <th class="text-center align-middle tableStyle font-weight-bold">Observaciones</th>

                    <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>ver-tb.png"></th>
                    <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>icon-firmar-w.png">
                    </th>
                    <!--
  <th class="text-center align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>editar-tb.png"></th>
  -->
                    <th class="align-middle text-center" width="20"><img src="<?= RUTA_IMG_ICONOS; ?>eliminar.png"></th>
                </tr>
            </thead>
            <tbody>

    <?php
    if ($numero_lista > 0) {

    while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
    $id = $row_lista['id'];
    $idpersonal = $row_lista['id_personal'];
    
    $datosPersonal = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($idpersonal);
    $Responsable = $datosPersonal['nombre'];         
                        
    $FechaInicio = $row_lista['fecha_inicio'];
    $FechaTermino = $row_lista['fecha_termino'];
    $Cubre = $row_lista['cubre_turno'];

    $datosPersonal2 = $ClassHerramientasDptoOperativo->obtenerDatosUsuario($Cubre);
    $Comodin = $datosPersonal2['nombre'];    

    if ($row_lista['estado'] == 0) {
    $trColor = 'style="background-color: #ffb6af"';
    $btnEliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $id . ',' . $idEstacion . ')">';

                        } else if ($row_lista['estado'] == 1) {
                            $trColor = 'style="background-color: #fcfcda"';
                            $btnEliminar = '<img class="pointer" src="' . RUTA_IMG_ICONOS . 'eliminar.png" onclick="Eliminar(' . $id . ',' . $idEstacion . ')">';

                        } else if ($row_lista['estado'] == 2) {
                            $trColor = 'style="background-color: #b0f2c2"';
                            $btnEliminar = '<img class="grayscale" src="' . RUTA_IMG_ICONOS . 'eliminar.png">';

                        }

                        echo '<tr '.$trColor.'>
                            <th class="text-center align-middle">' . $id . '</th>
                            <td class="text-center align-middle">' . $Responsable . '</td>

                            <td class="text-center align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($FechaInicio) . '</td>
                            <td class="text-center align-middle">' . $ClassHerramientasDptoOperativo->FormatoFecha($FechaTermino) . '</td>
                            <td class="text-center align-middle">' . $row_lista['dias_tomados'] . '</td>
                            <td class="text-center align-middle"><b>' . $Comodin . '</b></td>

                            <td class="text-center align-middle">' . $row_lista['motivo'] . '</td>
                            <td class="text-center align-middle">' . $row_lista['observaciones'] . '</td>
                            <td class="text-center align-middle"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'ver-tb.png" onclick="DetallePermiso(' . $id . ')"></td>
                            <td class="text-center align-middle"><img class="pointer" src="' . RUTA_IMG_ICONOS . 'icon-firmar.png" onclick="Firmar(' . $id . ')"></td>';

                        // echo '<td class="text-center align-middle"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="Editar('.$id.')"></td>';
                
                        echo ' <td class="text-center align-middle">' . $btnEliminar . '</td>
                            </tr>';

                    }

                } else {
                    echo "<tr><td colspan='11' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
                }
                ?>
            </tbody>
        </table>
        </div>
    </div>
    