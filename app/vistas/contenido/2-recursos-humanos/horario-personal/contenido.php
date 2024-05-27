<?php
require ('../../../../help.php');

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

function Horarios($idEstacion, $con)
{
    if ($idEstacion == 9) {
        $idEstacion = 2;
    }
    $sql_horario = "SELECT *
FROM op_rh_localidades_horario WHERE id_estacion = '" . $idEstacion . "' ";
    $result_horario = mysqli_query($con, $sql_horario);
    $numero_horario = mysqli_num_rows($result_horario);
    while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
        $array1[] = $row_horario['titulo'];
    }
    return $array1;
}
$Horarios = Horarios($idEstacion, $con);
function BuscarHorario($dia, $idPersonal, $con)
{

    $NomDia = NomDia($dia);

    $sql_horario = "SELECT *
FROM op_rh_personal_horario
WHERE id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
    $result_horario = mysqli_query($con, $sql_horario);
    $numero_horario = mysqli_num_rows($result_horario);
    while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
        $resultado = $row_horario['horario'];
    }

    return $resultado;
}

function BuscarHorarioFormato($dia, $idPersonal, $con)
{
    $NomDia = NomDia($dia);
    $sql_horario = "SELECT *
FROM op_rh_personal_horario
WHERE id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
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

function NomDia($dia)
{
    if ($dia == "1")
        $dia = "Lunes";
    if ($dia == "2")
        $dia = "Martes";
    if ($dia == "3")
        $dia = "Miércoles";
    if ($dia == "4")
        $dia = "Jueves";
    if ($dia == "5")
        $dia = "Viernes";
    if ($dia == "6")
        $dia = "Sábado";
    if ($dia == "7")
        $dia = "Domingo";
    return $dia;
}
if ($idEstacion == 9) {
    $referencia = 'Autolavado';
  } else {
    $referencia = $session_nomestacion;
  }
?>
<div class="table-responsive">
    <table class="custom-table mt-2" style="font-size: .75em;" width="100%">
        <thead class="navbar-bg">
            <tr class="tables-bg">
				<th colspan="10" class="align-middle text-center"><?= $referencia; ?></th>
			</tr>
            <tr>
                <td class="text-center align-middle fw-bold">#</td>
                <th class="text-center align-middle">Nombre completo</th>
                <th class="text-center align-middle">Puesto</th>
                <th class="text-center align-middle " width="150">Lunes</th>
                <th class="text-center align-middle " width="150">Martes</th>
                <th class="text-center align-middle " width="150">Miercoles</th>
                <th class="text-center align-middle " width="150">Jueves</th>
                <th class="text-center align-middle " width="150">Viernes</th>
                <th class="text-center align-middle " width="150">Sabado</th>
                <td class="text-center align-middle fw-bold" width="150">Domingo</td>
            </tr>
        </thead>
        <tbody class="bg-white">
            <?php
            if ($numero_personal > 0) {
                while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
                    $id = $row_personal['id'];

                    $SelHorario1 = BuscarHorario(1, $id, $con);
                    $SelHorario2 = BuscarHorario(2, $id, $con);
                    $SelHorario3 = BuscarHorario(3, $id, $con);
                    $SelHorario4 = BuscarHorario(4, $id, $con);
                    $SelHorario5 = BuscarHorario(5, $id, $con);
                    $SelHorario6 = BuscarHorario(6, $id, $con);
                    $SelHorario7 = BuscarHorario(7, $id, $con);

                    $Dia1 = BuscarHorarioFormato(1, $id, $con);
                    $Dia2 = BuscarHorarioFormato(2, $id, $con);
                    $Dia3 = BuscarHorarioFormato(3, $id, $con);
                    $Dia4 = BuscarHorarioFormato(4, $id, $con);
                    $Dia5 = BuscarHorarioFormato(5, $id, $con);
                    $Dia6 = BuscarHorarioFormato(6, $id, $con);
                    $Dia7 = BuscarHorarioFormato(7, $id, $con);

                    if ($id == 387 || $id == 358 || $id == 296 || $id == 326 || $id == 300 || $id == 335) {

                    } else {

                        echo '<tr>';
                        echo '<td class="text-center align-middle">' . $row_personal['id'] . '</td>';
                        echo '<td class="align-middle">' . $row_personal['nombre_completo'] . '</td>';
                        echo '<td class="align-middle text-center">' . $row_personal['puesto'] . '</td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,1,' . $id . ',' . $idEstacion . ')"><option>' . $Dia1 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,2,' . $id . ',' . $idEstacion . ')"><option>' . $Dia2 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,3,' . $id . ',' . $idEstacion . ')"><option>' . $Dia3 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,4,' . $id . ',' . $idEstacion . ')"><option>' . $Dia4 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,5,' . $id . ',' . $idEstacion . ')"><option>' . $Dia5 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,6,' . $id . ',' . $idEstacion . ')"><option>' . $Dia6 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '<td class="p-0 m-0 align-middle"><select class="p-1 border-0 sel-text" style="width: 100%;" onchange="EditHorario(this,7,' . $id . ',' . $idEstacion . ')"><option>' . $Dia7 . '</option>';
                        for ($i = 0; $i < count($Horarios); $i++) {
                            echo '<option>' . $Horarios[$i] . '</option>';
                        }
                        echo '<option>Descanso</option>';
                        echo '</select></td>';

                        echo '</tr>';

                    }
                }
            } else {
                echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
            }
            ?>
        </tbody>
    </table>
</div>