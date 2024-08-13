<?php
error_reporting(0);
require_once 'app/lib/dompdf/vendor/autoload.php';
require 'app/help.php';

$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$GET_idFormato."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$fecha = $row['fecha']; 
$Localidad = $row['id_localidad'];
$formato = $row['formato'];
}

if($formato == 1){
$Formato = "Alta personal";
}else if($formato == 2){
$Formato = "Restructuración persona";
}else if($formato == 3){
$Formato = "Falta personal";
}else if($formato == 4){
$Formato = "Baja personal";
}else if($formato == 4){
$Formato = "Baja personal";
}else if($formato == 5){
$Formato = 'Solicitud de vacaciones';    
}else if($formato == 6){
$Formato = 'Ajuste salarial';    
}

function Estacion($Localidad,$con){
$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$Localidad."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

return $estacion;
}


function Personal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}

function Puesto($idPuesto,$con){
$sql = "SELECT puesto FROM op_rh_puestos WHERE id = '".$idPuesto."' ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$puesto = $row['puesto'];
}
return $puesto;
}

function NombrePersonal($id,$con){

$sql_personal = "SELECT nombre_completo, puesto FROM op_rh_personal WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$nombre = $row_personal['nombre_completo'];
$puesto = Puesto($row_personal['puesto'],$con); 
}
return $arrayName = array('nombre' => $nombre, 'puesto' => $puesto);
}

function NombreEstacion($id,$con){
$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id = '".$id."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$return = $row_listaestacion['localidad'];  
}
return $return;
}

function Firmas($idFormato,$tipo,$con){

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' AND tipo_firma = '".$tipo."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$explode = explode(' ', $row_firma['fecha']);
$firma = $row_firma['firma'];
$id_usuario = $row_firma['id_usuario'];
}


if($tipo == 'A'){

$RutaFirma = "imgs/firma/".$firma;
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$resultado = '';
$Personal = NombrePersonal($id_usuario,$con);
$DetalleFirma = '<div class=""><img src="'.$baseFirma.'" style="width: 200px;"></div>';

$resultado .= '<div class="p-2 border">
<div class="mt-2 text-secondary text-center"><b>Firma del solicitante</b></div>
'.$DetalleFirma.'
<div class="mb-1 text-center border-bottom">'.$Personal['nombre'].'</div>
<div class="mt-2 text-secondary text-center"><b>Nombre del solicitante</b></div>
</div>';
}else if($tipo == 'B'){
  $resultado = '';
if($numero_firma != 0){
$Detalle = '<div class="text-center p-2"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';  
}else{
$Detalle = '<div class="text-center text-danger" style="margin-top: 20px;"><small></small></div>'; 
}

$resultado .= '<div class="p-2 border">
<div class="mt-2 text-secondary text-center"><b>Firma de Recursos Humanos</b></div>
'.$Detalle.'
<div class="text-center order-bottom mb-1">'.Personal($id_usuario,$con).'</div>
<div class="mt-2 text-secondary text-center mb-1"><b>Vo.Bo. de Recursos Humanos</b></div>


</div>';


}else if($tipo == 'C'){
  $resultado = '';
if($numero_firma != 0){
$Detalle = '<div class="text-center p-2"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';  
}else{
$Detalle = '<div class="text-center text-danger"><small>Falta firma</small></div>'; 
}

$resultado .= '<div class="p-2 border">
'.$Detalle.'
<div class="text-center border-bottom mb-1">'.Personal($id_usuario,$con).'</div>
<div class="mt-2 text-secondary text-center"><b>NOMBRE Y FIRMA DE AUTORIZACIÓN</b></div>


</div>';


}


return $resultado;
}

function Formato1($idFormato,$Localidad,$fecha,$con){
  $contenido ='';
$explode = explode(' ', $fecha);
$HoraFormato = date("g:i a",strtotime($explode[1]));

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="margin-top: 20px;font-size: 1.08em;">
<tbody>
<tr>
  <td>Alta personal</td>
  <td rowspan="3" class="text-center align-middle"><b>Alta personal</b></td>
  <td class="align-middle">Sucursal:</td>
  <td class="align-middle">Grupo Admongas</td>
</tr>
<tr>
  <td class="align-middle">Departamento de Recursos Humanos</td>
  <td class="align-middle">Fecha:</td>
  <td class="align-middle">'.FormatoFecha($explode[0]).', '.$HoraFormato.'</td>
</tr>
<tr>
  <td class="align-middle">Depto.Operativo</td>
  <td class="align-middle">No. De control:</td>
  <td class="align-middle"><b>001</b></td>
</tr>
</tbody>
</table>';

$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;">';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;"><b>Lic. Alejandro Guzmán</b></div>';
$contenido .= '<div style="margin-top: 30px;margin-bottom: 20px;font-size: 1.05em;"><b>Departamento de Recursos Humanos</b></div>';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 10px;font-size: 1.05em;">Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes altas de personal.</div>';
$contenido .= '</div>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2" style="font-size: 0.8em;">
<thead>
  <tr>
    <th>Fecha de ingreso</th>
    <th>Nombre empleado</th>
    <th>Estación</th>
    <th>Puesto</th>
    <th>Salario diario</th>
    <th>Detalle</th>
  </tr>
</thead> 
<tbody>';

$sql_lista = "SELECT * FROM op_rh_formatos_alta WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$fecha_ingreso = $row_lista['fecha_ingreso'];
$NombreC = $row_lista['nombres'].' '.$row_lista['apellido_p'].' '.$row_lista['apellido_m'];
$puesto = Puesto($row_lista['puesto'],$con);
$estacion = Estacion($Localidad,$con);

$curp = $row_lista['curp'];
$rfc = $row_lista['rfc'];
$nss = $row_lista['nss'];

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.FormatoFecha($fecha_ingreso).'</td>';
$contenido .= '<td class="align-middle">'.$NombreC.'</td>';
$contenido .= '<td class="align-middle">'.$estacion.'</td>';
$contenido .= '<td class="align-middle">'.$puesto.'</td>';
$contenido .= '<td class="align-middle text-right">$'.number_format($row_lista['sd'],2).'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['detalle'].'</td>';
$contenido .= '</tr>';
}
}else{
$contenido .= "<tr><td colspan='5' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

 
$contenido .= '</tbody></table>';

$contenido .= '<div style="margin-top: 30px;margin-bottom: 30px;font-size: 1.05em;">Sin más por el momento quedo de usted.</div>';



$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DE QUIEN ELABORO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';


return $contenido;
}


function Formato2($idFormato,$Localidad,$fecha,$con){

$explode = explode(' ', $fecha);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$contenido = '';
$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="margin-top: 20px;font-size: 1.08em;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
  $contenido .= '<td>Ref. Alta y baja de personal</td>';
  $contenido .= '<td rowspan="3" class="text-center align-middle"><b>REESTRUCTURACIÓN DE PERSONAL.</b></td>';
  $contenido .= '<td class="align-middle">Sucursal:</td>';
  $contenido .= '<td class="align-middle">Grupo Admongas</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Departamento de Recursos Humanos</td>';
  $contenido .= '<td class="align-middle">Fecha:</td>';
  $contenido .= '<td class="align-middle">'.FormatoFecha($explode[0]).', '.$HoraFormato.'</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Depto.Operativo</td>';
  $contenido .= '<td class="align-middle">No. De control:</td>';
  $contenido .= '<td class="align-middle"><b>010</b></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;">';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;"><b>Lic. Alejandro Guzmán</b></div>';
$contenido .= '<div style="margin-top: 30px;margin-bottom: 20px;font-size: 1.05em;"><b>Departamento de Recursos Humanos</b></div>';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 10px;font-size: 1.05em;">Buenos días por medio del presente solicito de su amable apoyo para realizar los siguientes cambios de personal.</div>';
$contenido .= '</div>';


$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">';
$contenido .= '<thead>';
  $contenido .= '<tr>';
    $contenido .= '<th>Nombre del empleado</th>';
    $contenido .= '<th class="align-middle text-center">Cambio a</th>';
    $contenido .= '<th class="align-middle text-right">Salario diario</th>';
    $contenido .= '<th class="align-middle text-center">A partir de</th>';
    $contenido .= '<th class="align-middle text-center">Detalle</th>';
  $contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';

$sql_lista = "SELECT * FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);
$estacion = NombreEstacion($row_lista['id_estacion'],$con);

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$personal['nombre'].'</td>';
$contenido .= '<td class="align-middle">'.$estacion.'</td>';
$contenido .= '<td class="align-middle text-right">$'.number_format($row_lista['sd'],2).'</td>';
$contenido .= '<td class="align-middle">'.FormatoFecha($row_lista['fecha']).'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['detalle'].'</td>';
$contenido .= '</tr>';
}
}else{
$contenido .= "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

$contenido .= '</tbody>';
$contenido .= '</table>';


$contenido .= '<div style="margin-top: 30px;margin-bottom: 30px;font-size: 1.05em;">Sin más por el momento quedo de usted.</div>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DE QUIEN ELABORO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';


return $contenido;
}

function Formato3($idFormato,$Localidad,$fecha,$con){

$explode = explode(' ', $fecha);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$contenido = '';
$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="margin-top: 20px;font-size: 1.08em;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
  $contenido .= '<td>Ref. Incidencias de personal</td>';
  $contenido .= '<td rowspan="3" class="text-center align-middle"><b>INCIDENCIA FALTA</b></td>';
  $contenido .= '<td class="align-middle">Sucursal:</td>';
  $contenido .= '<td class="align-middle">Grupo Admongas</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Departamento de Recursos Humanos</td>';
  $contenido .= '<td class="align-middle">Fecha:</td>';
  $contenido .= '<td class="align-middle">'.FormatoFecha($explode[0]).', '.$HoraFormato.'</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Depto.Operativo</td>';
  $contenido .= '<td class="align-middle">No. De control:</td>';
  $contenido .= '<td class="align-middle"><b>011</b></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;">';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;"><b>Lic. Alejandro Guzmán</b></div>';
$contenido .= '<div style="margin-top: 30px;margin-bottom: 20px;font-size: 1.05em;"><b>Departamento de Recursos Humanos</b></div>';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 10px;font-size: 1.05em;">Departamento de Recursos Humanos</b></br>
Por medio del presente se le notifica las siguientes incidencias que corresponden a faltas.</div>';
$contenido .= '</div>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">';
$contenido .= '<thead>';
  $contenido .= '<tr>';
  $contenido .= '<th>Nombre del empleado</th>';
  $contenido .= '<th>De estación</th>';
  $contenido .= '<th>Días de falta</th>';
  $contenido .= '<th>Observaciónes</th>';
  $contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';

$sql_lista = "SELECT * FROM op_rh_formatos_falta WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);

$estacion = NombreEstacion($row_lista['id_estacion'],$con);
$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$personal['nombre'].'</td>';
$contenido .= '<td class="align-middle">'.$estacion.'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['dias_falta'].'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['observaciones'].'</td>';
$contenido .= '</tr>';
}
}else{
$contenido .= "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 30px;margin-bottom: 30px;font-size: 1.05em;">Sin más por el momento quedo de usted.</div>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DE QUIEN ELABORO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';


return $contenido;
}

function Formato4($idFormato,$Localidad,$fecha,$con){

$explode = explode(' ', $fecha);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$contenido ='';
$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-3" style="margin-top: 20px;font-size: 1.08em;">';
$contenido .= '<tbody>';
$contenido .= '<tr>';
  $contenido .= '<td>Ref. Incidencias de personal</td>';
  $contenido .= '<td rowspan="3" class="text-center align-middle"><b>BAJA DE PERSONAL</b></td>';
  $contenido .= '<td class="align-middle">Sucursal:</td>';
  $contenido .= '<td class="align-middle">Grupo Admongas</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Departamento de Recursos Humanos</td>';
  $contenido .= '<td class="align-middle">Fecha:</td>';
  $contenido .= '<td class="align-middle">'.FormatoFecha($explode[0]).', '.$HoraFormato.'</td>';
$contenido .= '</tr>';
$contenido .= '<tr>';
  $contenido .= '<td class="align-middle">Depto.Operativo</td>';
  $contenido .= '<td class="align-middle">No. De control:</td>';
  $contenido .= '<td class="align-middle"><b>011</b></td>';
$contenido .= '</tr>';
$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;">';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;"><b>Lic. Alejandro Guzmán</b></div>';
$contenido .= '<div style="margin-top: 30px;margin-bottom: 20px;font-size: 1.05em;"><b>Departamento de Recursos Humanos</b></div>';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 10px;font-size: 1.05em;">
Buenos días por medio del presente solicito de su amable apoyo para realizar
la siguiente baja de personal.</div>';
$contenido .= '</div>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">';
$contenido .= '<thead>';
  $contenido .= '<tr>';
  $contenido .= '<th>Nombre del empleado</th>';
  $contenido .= '<th>De estación</th>';
  $contenido .= '<th>Baja</th>';
  $contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';

$sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);
$estacion = NombreEstacion($row_lista['id_estacion'],$con);

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$personal['nombre'].'</td>';
$contenido .= '<td class="align-middle">'.$estacion.'</td>';
$contenido .= '<td class="align-middle">'.$row_lista['baja'].'</td>';
$contenido .= '</tr>';
}
}else{
$contenido .= "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 30px;margin-bottom: 30px;font-size: 1.05em;">Sin más por el momento quedo de usted.</div>';




$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DE QUIEN ELABORO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';


return $contenido;
}

function Formato5($idFormato,$Localidad,$fecha,$con){

$sqlDetalle = "SELECT * FROM op_rh_formatos_vacaciones WHERE id_formulario = '".$idFormato."' ";
$resultDetalle = mysqli_query($con, $sqlDetalle);
$numeroDetalle = mysqli_num_rows($resultDetalle);
while($rowDetalle = mysqli_fetch_array($resultDetalle, MYSQLI_ASSOC)){
$idusuario = $rowDetalle['id_usuario']; 
$numdias = $rowDetalle['num_dias'];
$fechainicio = $rowDetalle['fecha_inicio'];
$fechatermino = $rowDetalle['fecha_termino'];
$fecharegreso = $rowDetalle['fecha_regreso'];
$observaciones = $rowDetalle['observaciones'];
}

$Personal = NombrePersonal($idusuario,$con);
$contenido ='';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.5em;">Solicitud de vacaciones</div>';
$contenido .= '<table class="table table-bordered" style>
    <tr>
      <td><b>Área o Departamento:</b></td>
      <td>'.NombreEstacion($Localidad,$con).'</td>
    </tr>
    <tr>
      <td><b>Nombre completo:</b></td>
      <td>'.$Personal['nombre'].'</td>
    </tr>
    <tr>
      <td><b>Número de días a disfrutar:</b></td>
      <td>'.$numdias.'</td>
    </tr>
    <tr>
      <td><b>Del:</b></td>
      <td>'.FormatoFecha($fechainicio).'</td>
    </tr>
    <tr>
      <td><b>Al:</b></td>
      <td>'.FormatoFecha($fechatermino).'</td>
    </tr>
    <tr>
      <td><b>Regresando el:</b></td>
      <td>'.FormatoFecha($fecharegreso).'</td>
    </tr>
  </table>';

$contenido .= '<div><b>Observaciones:</b></div>';
$contenido .= '<div class="border p-2 mt-1">'.$observaciones.'</div>';

$Autorizacion = Firmas($idFormato,'C',$con);


$contenido .= '
<div style="margin-top: 10px;"><b>Firma:</b></div>
<table style="width: 100%;margin-top: 10px;">
<tr>
<td width="35%">'.$Autorizacion.'</td>
<td width="35%"></td>
<td width="30%"></td>
</tr>
</table>';

return $contenido;
}

function Formato6($idFormato,$Localidad,$fecha,$con){

$explode = explode(' ', $fecha);
$HoraFormato = date("g:i a",strtotime($explode[1]));

$contenido ='';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;">';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 20px;font-size: 1.05em;"><b>Lic. Alejandro Guzmán</b></div>';
$contenido .= '<div style="margin-top: 30px;margin-bottom: 20px;font-size: 1.05em;"><b>Departamento de Recursos Humanos</b></div>';
$contenido .= '<div style="margin-top: 20px;margin-bottom: 10px;font-size: 1.05em;">
Por medio del presente, solicito su apoyo para el ajuste salarial al siguiente colaborador .</div>';
$contenido .= '</div>';

$contenido .= '<table class="table table-sm table-bordered pb-0 mb-0 mt-2">';
$contenido .= '<thead>';
  $contenido .= '<tr>';
  $contenido .= '<th>Colaborador</th>';
  $contenido .= '<th>De estación</th>';
  $contenido .= '<th>Sueldo</th>';
  $contenido .= '<th>Puesto</th>';
  $contenido .= '</tr>';
$contenido .= '</thead>'; 
$contenido .= '<tbody>';

$sql_lista = "SELECT * FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];

$personal = NombrePersonal($row_lista['id_personal'],$con);
$estacion = NombreEstacion($row_lista['id_estacion'],$con);

$contenido .= '<tr>';
$contenido .= '<td class="align-middle">'.$personal['nombre'].'</td>';
$contenido .= '<td class="align-middle">'.$estacion.'</td>';
$contenido .= '<td class="align-middle">$'.number_format($row_lista['sueldo'],2).'</td>';
$contenido .= '<td class="align-middle">'.$personal['puesto'].'</td>';
$contenido .= '</tr>';
}
}else{
$contenido .= "<tr><td colspan='3' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}

$contenido .= '</tbody>';
$contenido .= '</table>';

$contenido .= '<div style="margin-top: 30px;margin-bottom: 30px;font-size: 1.05em;">Sin más por el momento quedo de usted.</div>';

$contenido .= '<table class="table table-sm table-bordered mt-2" style="width: 100%;">';
$contenido .= '<tr>';

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);
while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){

$explode = explode(' ', $row_firma['fecha']);

if($row_firma['tipo_firma'] == "A"){

$TipoFirma = '<div class="border-bottom mb-2"></div><div style="padding-top: 10px;">NOMBRE Y FIRMA DE QUIEN ELABORO</div>';
$RutaFirma = "imgs/firma/".$row_firma['firma'];
$DataFirma = file_get_contents($RutaFirma);
$baseFirma = 'data:image/;base64,' . base64_encode($DataFirma);
$Detalle = '<div style="margin-top: 10px;"><img src="'.$baseFirma.'" style="width: 200px;"></br></br></div>';

}else if($row_firma['tipo_firma'] == "B"){
$TipoFirma = "NOMBRE Y FIRMA DE VOBO";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';


}else if($row_firma['tipo_firma'] == "C"){
$TipoFirma = "NOMBRE Y FIRMA DE AUTORIZACIÓN";
$Detalle = '<div class="border-bottom text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.<br><br><br><br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';
}

$contenido .= '<td><div class="text-secondary text-center"><div>'.Personal($row_firma['id_usuario'],$con).'</div>'.$Detalle.'<div style="margin-top: 10px;">'.$TipoFirma.'</div></div></td>';

}

$contenido .= '</tr>';
$contenido .= '</table>';


return $contenido;
}

use Dompdf\Dompdf;
$dompdf = new Dompdf();

$contenido .= '<html lang="es">';
$contenido .= '<head>';
$contenido .= '<style type="text/css">';
$contenido .= '
@page {margin: 1.5cm 1.5cm;}
*,
*::before,
*::after {
  box-sizing: border-box;
}
html {
  font-family: sans-serif;
   line-height: 1.15;
  -webkit-text-size-adjust: 100%;
  -ms-text-size-adjust: 100%;
  -ms-overflow-style: scrollbar;
  -webkit-tap-highlight-color: transparent;
}

@-ms-viewport {
  width: device-width;
}

article, aside, dialog, figcaption, figure, footer, header, hgroup, main, nav, section {
  display: block;
}

body {
  margin: 0;
  font-family: -apple-system, BlinkMacSystemFont, "Segoe UI", Roboto, "Helvetica Neue", Arial, sans-serif, "Apple Color Emoji", "Segoe UI Emoji", "Segoe UI Symbol";
  font-size: .9rem;
  font-weight: 400;
  line-height: 1.15;
  color: #212529;
  text-align: left;
  background-color: #fff;
}
  .row {
  display: -webkit-box;
  display: -ms-flexbox;
  display: flex;
  -ms-flex-wrap: wrap;
  flex-wrap: wrap;
  margin-right: -15px;
  margin-left: -15px;
}
.no-gutters {
  margin-right: 0;
  margin-left: 0;
}

.no-gutters > .col,
.no-gutters > [class*="col-"] {
  padding-right: 0;
  padding-left: 0;
}

.col-1, .col-2, .col-3, .col-4, .col-5, .col-6, .col-7, .col-8, .col-9, .col-10, .col-11, .col-12, .col,
.col-auto, .col-sm-1, .col-sm-2, .col-sm-3, .col-sm-4, .col-sm-5, .col-sm-6, .col-sm-7, .col-sm-8, .col-sm-9, .col-sm-10, .col-sm-11, .col-sm-12, .col-sm,
.col-sm-auto, .col-md-1, .col-md-2, .col-md-3, .col-md-4, .col-md-5, .col-md-6, .col-md-7, .col-md-8, .col-md-9, .col-md-10, .col-md-11, .col-md-12, .col-md,
.col-md-auto, .col-lg-1, .col-lg-2, .col-lg-3, .col-lg-4, .col-lg-5, .col-lg-6, .col-lg-7, .col-lg-8, .col-lg-9, .col-lg-10, .col-lg-11, .col-lg-12, .col-lg,
.col-lg-auto, .col-xl-1, .col-xl-2, .col-xl-3, .col-xl-4, .col-xl-5, .col-xl-6, .col-xl-7, .col-xl-8, .col-xl-9, .col-xl-10, .col-xl-11, .col-xl-12, .col-xl,
.col-xl-auto {
  position: relative;
  width: 100%;
  min-height: 1px;
  padding-right: 15px;
  padding-left: 15px;
}
.col-5 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 41.666667%;
  flex: 0 0 41.666667%;
  max-width: 41.666667%;
}
.col-7 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 58.333333%;
  flex: 0 0 58.333333%;
  max-width: 58.333333%;
}

.mt-2,
.my-2 {
  margin-top: 0.5rem !important;
}
.bg-light {
  background-color: #f8f9fa !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.text-center {
  text-align: center !important;
}
.border {
  border: 1px solid #dee2e6 !important;
}
table {
  border-collapse: collapse;
}
th {
  text-align: inherit;
}
.table {
  width: 100%;
  max-width: 100%;
  margin-bottom: 1rem;
  background-color: transparent;
}

.table th,
.table td {
  padding: 0.75rem;
  vertical-align: top;
  border-top: 1px solid #dee2e6;
}

.table thead th {
  vertical-align: bottom;
  border-bottom: 2px solid #dee2e6;
}

.table tbody + tbody {
  border-top: 2px solid #dee2e6;
}

.table .table {
  background-color: #fff;
}

.table-sm th,
.table-sm td {
  padding: 0.3rem;
}

.table-bordered {
  border: 1px solid #dee2e6;
}

.table-bordered th,
.table-bordered td {
  border: 1px solid #dee2e6;
}

.table-bordered thead th,
.table-bordered thead td {
  border-bottom-width: 2px;
}

.table-striped tbody tr:nth-of-type(odd) {
  background-color: rgba(0, 0, 0, 0.05);
}
.pb-0,
.py-0 {
  padding-bottom: 0 !important;
}
.mb-0,
.my-0 {
  margin-bottom: 0 !important;
}
.align-middle {
  vertical-align: middle !important;
}
.text-right {
  text-align: right !important;
}
.p-1 {
  padding: 0.25rem !important;
}
.border-0 {
  border: 0 !important;
}
.p-2 {
  padding: 0.5rem !important;
}

.border-bottom {
  border-bottom: 1px solid #dee2e6 !important;
}

.col-6 {
  -webkit-box-flex: 0;
  -ms-flex: 0 0 50%;
  flex: 0 0 50%;
  max-width: 50%;
}
.text-secondary {
  color: #6c757d !important;
}
.mb-1,
.my-1 {
  margin-bottom: 0.25rem !important;
}
.mt-1,
.my-1 {
  margin-top: 0.25rem !important;
}
.pb-1,
.py-1 {
  padding-bottom: 0.25rem !important;
}';
$contenido .= '</style>';
$contenido .= '<body>';

$RutaLogo = RUTA_IMG_ICONOS.'Logo.png';
$DataLogo = file_get_contents($RutaLogo);
$baseLogo = 'data:image/;base64,' . base64_encode($DataLogo);

$contenido .= '<img src="'.$baseLogo.'" style="width: 180px;">';

if($formato == 1){
$contenido .= Formato1($GET_idFormato,$Localidad,$fecha,$con);
}else if($formato == 2){
$contenido .= Formato2($GET_idFormato,$Localidad,$fecha,$con);
}else if($formato == 3){
$contenido .= Formato3($GET_idFormato,$Localidad,$fecha,$con);
}else if($formato == 4){
$contenido .= Formato4($GET_idFormato,$Localidad,$fecha,$con);
}else if($formato == 5){
$contenido .= Formato5($GET_idFormato,$Localidad,$fecha,$con);
}else if($formato == 6){
$contenido .= Formato6($GET_idFormato,$Localidad,$fecha,$con);
}




$contenido .= '</head>';
$contenido .= '</html>';


$dompdf->loadHtml($contenido);
$dompdf->setPaper("A4", "portrait");
$dompdf->render();
$dompdf->get_canvas()->page_text(540,820,"Pagina: {PAGE_NUM} de {PAGE_COUNT}", $font, 6, array(0,0,0));
$dompdf->stream("Formato ".$Formato.".pdf");