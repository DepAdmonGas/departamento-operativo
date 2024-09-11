<?php
require ('../../../../help.php');

$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '" . $idEstacion . "' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function Horarios($idEstacion, $con){
$array1 = [];
$sql_horario = "SELECT *FROM op_rh_localidades_horario WHERE id_estacion = '" . $idEstacion . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
$array1[] = $row_horario['titulo'];
}
return $array1;
}


function BuscarHorario($dia, $idPersonal, $idReporte, $con){
$resultado = "";
$ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
$NomDia = $ClassHerramientasDptoOperativo->get_nombre_dia2($dia); 

$sql_horario = "SELECT *FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = '" . $idReporte . "' AND id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
$resultado = $row_horario['horario'];
}
return $resultado;
}

function BuscarHorarioFormato($dia, $idPersonal, $idReporte, $con){
$resultado="";
$ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
$NomDia = $ClassHerramientasDptoOperativo->get_nombre_dia2($dia); 

$sql_horario = "SELECT *
FROM op_rh_personal_horario_programar_detalle
WHERE id_reporte = '" . $idReporte . "' AND id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
if ($row_horario['hora_entrada'] == "00:00:00" && $row_horario['hora_salida'] == "00:00:00") {
$resultado = "Descanso";
} else {
$resultado = date("g:i a", strtotime($row_horario['hora_entrada'])) . ' a ' . date("g:i a", strtotime($row_horario['hora_salida']));
}
}
return $resultado;
}



$referencia = $session_nomestacion;
$Horarios = Horarios($idEstacion, $con);

if($idEstacion == 9):
echo '<hr>';
$referencia = 'Autolavado';
$Horarios = Horarios(2, $con);

endif;

?>

<div class="table-responsive">
    <table class="custom-table " style="font-size: .8em;" width="100%">
        <thead class="navbar-bg">
            <tr class="tables-bg">
				<th colspan="10" class="align-middle text-center"><?= $referencia; ?></th>
			</tr>
            <tr>
                <td class="text-center align-middle fw-bold">#</td>
                <th class="align-middle text-start">Nombre completo</th>
                <th class="align-middle" width="140">Lunes</th>
                <th class="align-middle" width="140">Martes</th>
                <th class="align-middle" width="140">Miercoles</th>
                <th class="align-middle" width="140">Jueves</th>
                <th class="align-middle" width="140">Viernes</th>
                <th class="align-middle" width="140">Sabado</th>
                <td class="align-middle fw-bold" width="140">Domingo</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_personal > 0) {
                while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
                    $id = $row_personal['id'];



                    $SelHorario1 = BuscarHorario(1, $id, $idReporte, $con);
                    $SelHorario2 = BuscarHorario(2, $id, $idReporte, $con);
                    $SelHorario3 = BuscarHorario(3, $id, $idReporte, $con);
                    $SelHorario4 = BuscarHorario(4, $id, $idReporte, $con);
                    $SelHorario5 = BuscarHorario(5, $id, $idReporte, $con);
                    $SelHorario6 = BuscarHorario(6, $id, $idReporte, $con);
                    $SelHorario7 = BuscarHorario(7, $id, $idReporte, $con);

                    $Dia1 = BuscarHorarioFormato(1, $id, $idReporte, $con);
                    $Dia2 = BuscarHorarioFormato(2, $id, $idReporte, $con);
                    $Dia3 = BuscarHorarioFormato(3, $id, $idReporte, $con);
                    $Dia4 = BuscarHorarioFormato(4, $id, $idReporte, $con);
                    $Dia5 = BuscarHorarioFormato(5, $id, $idReporte, $con);
                    $Dia6 = BuscarHorarioFormato(6, $id, $idReporte, $con);
                    $Dia7 = BuscarHorarioFormato(7, $id, $idReporte, $con);

                    if ($id == 387 || $id == 358 || $id == 296 || $id == 326 || $id == 300 || $id == 335) {

                    } else {

                        echo '<tr>';
                        echo '<th class="text-center align-middle fw-normal">' . $row_personal['id'] . '</th>';
                        echo '<td class="align-middle text-start">' . $row_personal['nombre_completo'] . '</td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,1,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia1 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,2,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia2 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,3,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia3 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,4,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia4 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,5,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia5 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,6,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia6 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle no-hover"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,7,' . $id . ',' . $idReporte . ',' . $idEstacion . ')"><option>' . $Dia7 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '</tr>';

                    }
                }

            } else {
                echo "<tr><td colspan='10' class='text-center text-secondary no-hover'><small>No se encontró información para mostrar </small></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>