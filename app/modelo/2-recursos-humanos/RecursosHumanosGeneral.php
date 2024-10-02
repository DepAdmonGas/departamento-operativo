<?php
class RecursosHumanosGeneral extends Exception
{

private $con;
private $herramientasDptoOperativo;
public function __construct($con)
{
$this->con = $con;
$this->herramientasDptoOperativo = new herramientasDptoOperativo($this->con);
} 

//---------- AGREGAR ACCESO PERSONAL ----------
function AgregarAcceso($idPersonal){
$result = "";
$sql_val = "SELECT * FROM op_rh_personal_acceso WHERE id_personal = '".$idPersonal."' ";
$result_val = mysqli_query($this->con, $sql_val);
$numero_val = mysqli_num_rows($result_val);	
if($numero_val == 0){
    
$sql_agregar_horario = "INSERT INTO op_rh_personal_acceso
(id_personal, huella, pin) VALUES ('".$idPersonal."', '', 0)";
    
if(mysqli_query($this->con, $sql_agregar_horario)){
$result = true;
}else{
$result = false;
}
    
}
return $result;
}

//---------- ICONO DOCUMENTOS DEL PERSONAL ----------
function generarDetalleIcono($rutaArchivo, $nombreArchivo, $tooltip) {
    
if($nombreArchivo != "") {
$extensionArchivo = $this->herramientasDptoOperativo->obtenerExtensionArchivo($nombreArchivo);
if (in_array($extensionArchivo, ["pdf", "jpg", "png", "txt", "xml", "jpeg", "PDF", "JPG", "PNG", "TXT", "XML", "JPEG"])) {
if($tooltip == "Identificación Oficial" || $tooltip == "Constancia de Situación Fiscal (CSF)"){
if (file_exists($nombreArchivo)) {
$fechaHoy = date("Y-m-d");
$fechaCreacion = filectime($nombreArchivo);
$nuevaFecha = strtotime('+1 year', $fechaCreacion);
$fechaFormateada = date('Y-m-d', $nuevaFecha);
     
if($fechaFormateada <= $fechaHoy){
$detalle = '<a href="'.$rutaArchivo.$nombreArchivo.'" download> <img class="pointer" src="' . RUTA_IMG_ICONOS.'actualizar-tb.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
}else{ 
$detalle = '<a href="'.$rutaArchivo.$nombreArchivo.'" download> <img class="pointer" src="' . RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
}
    
}else{
    $detalle = '<a href="'.$rutaArchivo.$nombreArchivo.'" download> <img class="pointer" src="' . RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
}
        
}else{
$detalle = '<a href="'.$rutaArchivo.$nombreArchivo.'" download> <img class="pointer" src="' . RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="' . $tooltip . '"></a>';
}
    
}else{
$detalle = $nombreArchivo; 
}
    
}else{
$detalle = '<img src="' . RUTA_IMG_ICONOS . 'eliminar.png" data-toggle="tooltip" data-placement="top" title="Sin Información">';
}
    
return $detalle;    
}


//---------- PERSONAL CON ESTADO DE BAJA ----------
public function PersonalBaja($idPersonal)
{
$id_baja = $fecha_baja = $estado_proceso = "";

$sql_baja = "SELECT id, fecha_baja, estado_proceso FROM op_rh_personal_baja WHERE id_personal = ?";
$consulta_baja = $this->con->prepare($sql_baja);

if (!$consulta_baja) {
throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
}

$consulta_baja->bind_param('i', $idPersonal);
$consulta_baja->execute();
$consulta_baja->bind_result($id_baja, $fecha_baja, $estado_proceso);
$consulta_baja->fetch();
$consulta_baja->close();

$array = array(
'num_listaBaja' => ($id_baja != "") ? 1 : 0,
'id_baja' => ($id_baja != "") ? $id_baja : "",
'fecha_baja' => ($fecha_baja != "") ? $this->herramientasDptoOperativo->formatoFecha($fecha_baja) : "S/I",
'estado_proceso' => ($estado_proceso != "") ? $estado_proceso : 0
);

return $array;
}


//---------- PERSONAL CON ESTADO DE BAJA ----------
public function PersonalBajaDetalle($idDetalleBaja)
{
 
$id_estacion = $no_colaborador = $nombre = $puesto= $fecha_ingreso = $ine = $curp = $rfc = $nss = $contrato = $documentos = $idBaja = $fecha_baja = $motivo = $detalle = $proceso = $estado_proceso = $puesto = null;

$sql_baja = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.no_colaborador,
op_rh_personal.nombre_completo,
op_rh_personal.puesto,
op_rh_personal.fecha_ingreso,
op_rh_personal.ine,
op_rh_personal.curp,
op_rh_personal.rfc,
op_rh_personal.nss,
op_rh_personal.contrato, 
op_rh_personal.documentos,
op_rh_personal_baja.id AS idBaja,
op_rh_personal_baja.fecha_baja,
op_rh_personal_baja.motivo,
op_rh_personal_baja.detalle,
op_rh_personal_baja.proceso,
op_rh_personal_baja.estado_proceso,
op_rh_puestos.puesto

FROM op_rh_personal_baja
INNER JOIN op_rh_personal ON op_rh_personal_baja.id_personal = op_rh_personal.id
INNER JOIN op_rh_puestos ON op_rh_personal.puesto = op_rh_puestos.id

WHERE op_rh_personal_baja.id = ?";

$consulta_baja = $this->con->prepare($sql_baja);

if (!$consulta_baja) {
throw new Exception("Error en la preparación de la consulta: " . $this->con->error);
}

$consulta_baja->bind_param('i', $idDetalleBaja);
$consulta_baja->execute();
$consulta_baja->store_result(); // Almacenar el resultado para usar num_rows
$num_registros = $consulta_baja->num_rows;

$consulta_baja->bind_result($id_estacion, $no_colaborador, $nombre, $puesto, $fecha_ingreso, $ine, $curp, $rfc, $nss, $contrato, $documentos, $idBaja, $fecha_baja, $motivo, $detalle, $proceso, $estado_proceso, $puesto);
$consulta_baja->fetch();
$consulta_baja->close();

$array = array(
'num_listaBaja' => $num_registros,
'id_estacion' => ($id_estacion != null) ? $id_estacion : 0,
'no_colaborador' => ($no_colaborador != null) ? $no_colaborador : "S/I",
'nombre_completo' => ($nombre != null) ? $nombre : "",
'puesto' => ($puesto != null) ? $puesto : "",
'fecha_ingreso' => ($fecha_ingreso != null) ? $this->herramientasDptoOperativo->formatoFecha($fecha_ingreso) : "S/I",
'ine' => ($ine != null) ? $ine : "",
'curp' => ($curp != null) ? $curp : "",
'rfc' => ($rfc != null) ? $rfc : "",
'nss' => ($nss != null) ? $nss : "",
'contrato' => ($contrato != null) ? $contrato : "",
'documentos' => ($documentos != null) ? $documentos : "",
'idBaja' => ($idBaja != null) ? $idBaja : "",
'fecha_baja' => ($fecha_baja != null) ? $this->herramientasDptoOperativo->formatoFecha($fecha_baja) : "S/I",
'id_baja' => ($idBaja != null) ? $idBaja : "",
'motivo' => ($motivo != null) ? $motivo : "",
'detalle' => ($detalle != null) ? $detalle : "",
'proceso' => ($proceso != null) ? $proceso : "",
'estado_proceso' => ($estado_proceso != null) ? $estado_proceso : 0,
'puestoUser' => ($puesto != null) ? $puesto : ""
);

return $array;
}

function ToComentarios($idBaja){
$sql_lista = "SELECT id FROM op_rh_personal_baja_comentarios WHERE id_baja = '".$idBaja."' ";
$result_lista = mysqli_query($this->con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);         
}
    
function ToSolicitudBaja($idEstacion){
$sql_lista = "SELECT 
op_rh_personal.id_estacion,
op_rh_personal.estado,
    
op_rh_personal_baja.id,
op_rh_personal_baja.id_personal
    
FROM op_rh_personal_baja
INNER JOIN op_rh_personal ON op_rh_personal_baja.id_personal = op_rh_personal.id
WHERE op_rh_personal.estado = 0 AND op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal_baja.estado_proceso <> 2 ";
    
$result_lista = mysqli_query($this->con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);    
}


//---------- ASISTENCIA DEL PERSONAL ----------//
function Incidencias($id){
$sql = "SELECT * FROM op_rh_personal_asistencia_incidencia WHERE id_asistencia = '".$id."' ";
$result = mysqli_query($this->con, $sql);
return $numero = mysqli_num_rows($result);
}

function Detalle($id,$fecha,$hora_entrada,$hora_salida,$hora_entrada_sensor,$hora_salida_sensor,$retardominutos){

if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){

if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
$resultado = "Día trabajado";  
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);

}else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
$resultado = "Día trabajado";  
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);

}else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
$resultado = "Descanso";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}
      
}else{
      
if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){
   
$ts_fin = strtotime($hora_entrada_sensor);
$ts_ini = strtotime($hora_entrada);
$diferencia = ($ts_fin-$ts_ini);
   
if(is_numeric($diferencia) AND ($diferencia < 0) ){
$resultado = "OK";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}else{
   
$retardo = $retardominutos * 60;
$horainicio = $ts_ini + $retardo;
   
if($horainicio < $ts_fin){
$resultado = "Retardo";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);

}else{
$resultado = "OK";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}
   
}
   
}else{
    
if($this->herramientasDptoOperativo->get_nombre_dia($fecha) == "Sábado" || $this->herramientasDptoOperativo->get_nombre_dia($fecha) == "Domingo"){
$resultado = "Falta fin de semana";  
}else{
$resultado = "Falta";  
}
      
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia); 
}
}
  
return $resultado;  
}

function BuscarIncidencias($incidencia){
$sql = "SELECT * FROM op_rh_lista_incidencias WHERE detalle = '".$incidencia."' ";
$result = mysqli_query($this->con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
}
return $id;
}


function EditIncidencias($id,$idIncidencia){

$sql_edit = "UPDATE op_rh_personal_asistencia SET incidencia = '".$idIncidencia."' WHERE id = '".$id."'  ";
if(mysqli_query($this->con, $sql_edit)) {
$result = true;
}else{
$result = false;
}

return $result;
}

function ValAsistencia($idEstacion,$tipo){
 
if($tipo == 0){
$consulta = "op_rh_personal.id_estacion = '".$idEstacion."' AND";
}else{
$consulta = "";
}

$sql_asistencia = "SELECT 
op_rh_personal_asistencia.id,
op_rh_personal_asistencia.id_personal,
op_rh_personal_asistencia.fecha,
op_rh_personal_asistencia.hora_entrada,
op_rh_personal_asistencia.hora_salida,
op_rh_personal_asistencia.hora_entrada_sensor,
op_rh_personal_asistencia.hora_salida_sensor,
op_rh_personal_asistencia.retardo_minutos,
op_rh_personal_asistencia.incidencia_dias,
op_rh_personal_asistencia.incidencia,
op_rh_personal_asistencia.sd,
op_rh_personal.nombre_completo,
op_rh_personal.id_estacion
FROM op_rh_personal_asistencia 
INNER JOIN op_rh_personal 
ON op_rh_personal_asistencia.id_personal = op_rh_personal.id WHERE $consulta op_rh_personal_asistencia.incidencia = 0";
$result_asistencia = mysqli_query($this->con, $sql_asistencia);
$numero_asistencia = mysqli_num_rows($result_asistencia);

if ($numero_asistencia > 0) {
while($row_asistencia = mysqli_fetch_array($result_asistencia, MYSQLI_ASSOC)){
  
$id = $row_asistencia['id'];
$fecha = $row_asistencia['fecha'];
$hora_entrada = $row_asistencia['hora_entrada'];
$hora_salida = $row_asistencia['hora_salida'];
$hora_entrada_sensor = $row_asistencia['hora_entrada_sensor'];
$hora_salida_sensor = $row_asistencia['hora_salida_sensor'];
$retardominutos = $row_asistencia['retardo_minutos'];
  
if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00"){
if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor == "00:00:00"){
$resultado = "Día trabajado";  
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}else if($hora_entrada_sensor != "00:00:00" && $hora_salida_sensor != "00:00:00"){
$resultado = "Día trabajado";  
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}else if($hora_entrada == "00:00:00" && $hora_salida == "00:00:00" && $hora_entrada_sensor == "00:00:00" && $hora_salida_sensor == "00:00:00"){
$resultado = "Descanso";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}
}else{
     
if($hora_entrada_sensor != "00:00:00" || $hora_salida_sensor != "00:00:00"){
$ts_fin = strtotime($hora_entrada_sensor);
$ts_ini = strtotime($hora_entrada);
$diferencia = ($ts_fin-$ts_ini);
  
if(is_numeric($diferencia) AND ($diferencia < 0) ){
$resultado = "OK";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);

}else{
$retardo = $retardominutos * 60;
$horainicio = $ts_ini + $retardo;

if($horainicio < $ts_fin){
$resultado = "Retardo";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);

}else{
$resultado = "OK";
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia);
}

}
   
}else{
  
if($this->herramientasDptoOperativo->get_nombre_dia($fecha) == "Sábado" || $this->herramientasDptoOperativo->get_nombre_dia($fecha) == "Domingo"){
$resultado = "Falta fin de semana";  
}else{
$resultado = "Falta";  
}
$idIncidencia = $this->BuscarIncidencias($resultado);
$this->EditIncidencias($id,$idIncidencia); 
}
}
}
}
}


public function mostrarEstacion(int $idEstacion) :string {
$nombre = "";
$registro = "";
$calle = "";
$exterior = "";
$colonia = "";
$cp = "";
$estado = "";
$municipio ="";
$telefono = "";
$stmt = "SELECT nombre, registro_patronal,calle,numero_exterior,colonia,codigo_postal, estado,municipio,numero_telefono FROM tb_organigrama_estaciones WHERE id = ?";
$result = $this->con->prepare($stmt);
$result->bind_param("i",$idEstacion);
$result->execute();
$result->bind_result($nombre,$registro,$calle,$exterior,$colonia,$cp,$estado,$municipio,$telefono);
$result->fetch();
$result->close();
$estacion = '
<div class="table-responsive">
<table class="custom-table mt-3" style="font-size: .8em;" width="100%">
<thead class="tables-bg">
<th>Nombre de la empresa</th>
<th>'.$nombre.'</th>
</thead>
<tbody class="bg-white">

<tr >
<th class="no-hover">Registro Patronal</th>
<td class="no-hover">'.$registro.'</td>
</tr>

<tr>
<th class="no-hover">Calle</th>
<td class="no-hover">'.$calle.'</td>
</tr>

<tr>
<th class="no-hover">Numero Ext.</th>
<td class="no-hover">'.$exterior.'</td>
</tr>

<tr>
<th class="no-hover">Numero Int. </th>
<td class="no-hover"> S/N </td>
</tr>

<tr>
<th class="no-hover">Colonia</th>
<td class="no-hover">'.$colonia.'</td>
</tr>

<tr>
<th class="no-hover">Codigo Postal</th>
<td class="no-hover">'.$cp.'</td>
</tr>

<tr>
<th class="no-hover">Estado</th>
<td class="no-hover">'.$estado.'</td>
</tr>

<tr>
<th class="no-hover">Municipio</th>
<td class="no-hover">'.$municipio.'</td>
</tr>

<tr>
<th class="no-hover">Numero de telefono</th>
<td class="no-hover">'.$telefono.'</td>
</tr>


</tbody>
</table>
</div>';
return $estacion;
}


}