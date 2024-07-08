<?php
require ('../../../../help.php');
$idReporte = $_GET['idReporte'];
$idEstacion = $_GET['idEstacion'];

$sql_empresa = "SELECT * FROM op_rh_personal_horario_programar WHERE id = '" . $idReporte . "' AND estado >= 1 ";
$result_empresa = mysqli_query($con, $sql_empresa);
$numero_empresa = mysqli_num_rows($result_empresa);
while ($row_empresa = mysqli_fetch_array($result_empresa, MYSQLI_ASSOC)) {
$fecha = $row_empresa['fecha'];
}
  
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
WHERE op_rh_personal.id_estacion = '" . $idEstacion . "' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function Horarios($idEstacion, $con){ 
$array1 = [];
$sql_horario = "SELECT * FROM op_rh_localidades_horario WHERE id_estacion = '" . $idEstacion . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
$array1[] = $row_horario['titulo'];
}
return $array1;
}

$Horarios = Horarios($idEstacion, $con);
 
function BuscarHorario($dia, $idPersonal, $idReporte, $con){
$ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
$NomDia = $ClassHerramientasDptoOperativo->get_nombre_dia2($dia); 
    
$sql_horario = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = '" . $idReporte . "' AND id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
$resultado = $row_horario['horario'];
}
return $resultado;
}

function BuscarHorarioFormato($dia, $idPersonal, $idReporte, $con){
$ClassHerramientasDptoOperativo = new HerramientasDptoOperativo($con);
$NomDia = $ClassHerramientasDptoOperativo->get_nombre_dia2($dia); 
        
$sql_horario = "SELECT * FROM op_rh_personal_horario_programar_detalle WHERE id_reporte = '" . $idReporte . "' AND id_personal = '" . $idPersonal . "' AND dia = '" . $NomDia . "' ";
$result_horario = mysqli_query($con, $sql_horario);
$numero_horario = mysqli_num_rows($result_horario);

if ($numero_horario > 0) {
while ($row_horario = mysqli_fetch_array($result_horario, MYSQLI_ASSOC)) {
if ($row_horario['hora_entrada'] == "00:00:00" && $row_horario['hora_salida'] == "00:00:00") {
$resultado = "Descanso";
}else{
$resultado = date("g:i a", strtotime($row_horario['hora_entrada'])) . ' a ' . date("g:i a", strtotime($row_horario['hora_salida']));
}
}
    
}else{
$resultado = "S/I";
}
return $resultado;
}

$tbTitle = "";
if($idEstacion == 9){
echo '<hr>';  
$tbTitle = "Autolavado <br>";  
}

?>


<div class="table-responsive">
<table id="tabla_horario_detalle_<?=$idEstacion?>" class="custom-table" style="font-size: .9em;" width="100%">

<thead class="title-table-bg">
<tr class="tables-bg">
<th colspan="9" class="text-center align-middle"><?=$tbTitle?> Fecha programada <br> <?=$ClassHerramientasDptoOperativo->FormatoFecha($fecha);?></th>  
</tr>

<tr>
<td class="text-center align-middle fw-bold">#</td>
<th class="text-center align-middle">Nombre completo</th>
<th class="text-center align-middle" width="170">Lunes</th>
<th class="text-center align-middle" width="170">Martes</th>
<th class="text-center align-middle" width="170">Miercoles</th>
<th class="text-center align-middle" width="170">Jueves</th>
<th class="text-center align-middle" width="170">Viernes</th>
<th class="text-center align-middle" width="170">Sabado</th>
<td class="text-center align-middle fw-bold" width="170">Domingo</td>
</tr>
</thead>
                                    
<tbody style="background-color: #fff">                            
<?php
if ($numero_personal > 0) {
while ($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)) {
$id = $row_personal['id'];

$Dia1 = BuscarHorarioFormato(1, $id, $idReporte, $con);
$Dia2 = BuscarHorarioFormato(2, $id, $idReporte, $con);
$Dia3 = BuscarHorarioFormato(3, $id, $idReporte, $con);
$Dia4 = BuscarHorarioFormato(4, $id, $idReporte, $con);
$Dia5 = BuscarHorarioFormato(5, $id, $idReporte, $con);
$Dia6 = BuscarHorarioFormato(6, $id, $idReporte, $con);
$Dia7 = BuscarHorarioFormato(7, $id, $idReporte, $con);

if ($Dia1 != "S/I" || $Dia2 != "S/I" || $Dia3 != "S/I" || $Dia4 != "S/I" || $Dia5 != "S/I" || $Dia6 != "S/I" || $Dia7 != "S/I") {

echo '<tr>';
echo '<th class="text-center align-middle">' . $row_personal['id'] . '</th>';
echo '<td class="align-middle"><b>' . $row_personal['nombre_completo'] . '</b></td>';
echo '<td class="align-middle">' . $Dia1 . '</td>';
echo '<td class="align-middle">' . $Dia2 . '</td>';
echo '<td class="align-middle">' . $Dia3 . '</td>';
echo '<td class="align-middle">' . $Dia4 . '</td>';
echo '<td class="align-middle">' . $Dia5 . '</td>';
echo '<td class="align-middle">' . $Dia6 . '</td>';
echo '<td class="align-middle">' . $Dia7 . '</td>';
echo '</tr>';
}
}

}
?>

</tbody>
</table>
</div>