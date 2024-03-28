<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

for ($i=1; $i <= intval($fecha_mes); $i++) { 
Valida($idEstacion,$i,$fecha_year,$con);
}

function ID($con){
$sql = "SELECT id FROM op_rh_vacaciones_pago ORDER BY id DESC LIMIT 1";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);	
if($numero == 0){
$id = 1;	
}else{
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'] + 1;
}
}
return $id;
}


function Valida($idEstacion,$Mes,$Year,$con){
$sql = "SELECT * FROM op_rh_vacaciones_pago WHERE id_estacion = '".$idEstacion."' AND mes = '".$Mes."' AND year = '".$Year."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero == 0){ 
$ID = ID($con);
AgregarPago($ID,$idEstacion,$Mes,$Year,$con);
AgregarPersonal($ID,$idEstacion,$Mes,$Year,$con);
}
}
 
function AgregarPago($ID,$idEstacion,$Mes,$Year,$con){

$sql = "SELECT id, fecha_ingreso FROM op_rh_personal WHERE id_estacion = '".$idEstacion."' AND MONTH(fecha_ingreso) = '".$Mes."' AND estado = 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero > 0){ 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode('-', $row['fecha_ingreso']);
$YearIngreso = $explode[0]; 
$TotalYear = $Year - $YearIngreso;

if($TotalYear >= 1){

$Total = $Total + 1;

}
}

if($Total >= 1){
$sql_insert = "INSERT INTO op_rh_vacaciones_pago (
id,
id_estacion,
mes,
year,
estado
    )
    VALUES 
    (
    '".$ID."',
    '".$idEstacion."',
    '".$Mes."',
    '".$Year."',
    0
    )";

if(mysqli_query($con, $sql_insert)){
$Result = 1;
}else{
$Result = 0;
}
}

}else{
$Result = 0;	
}

return $Result;
}

function AgregarPersonal($ID,$idEstacion,$Mes,$Year,$con){

$sql = "SELECT id, fecha_ingreso FROM op_rh_personal WHERE id_estacion = '".$idEstacion."' AND MONTH(fecha_ingreso) = '".$Mes."' AND estado = 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if($numero > 0){ 
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$idPersonal = $row['id'];
$explode = explode('-', $row['fecha_ingreso']);
$YearIngreso = $explode[0]; 
$TotalYear = $Year - $YearIngreso;

if($TotalYear >= 1){

$Tabulador = Tabulador($TotalYear,$con);

$sql_insert = "INSERT INTO op_rh_vacaciones_pago_detalle (
id_vacaciones_pago,
id_personal,
year,
dias
    )
    VALUES 
    (
    '".$ID."',
    '".$idPersonal."',
    '".$TotalYear."',
    '".$Tabulador."'
    )";

if(mysqli_query($con, $sql_insert)){
$Result = 1;
}else{
$Result = 0;
}

}
}
}else{
$Result = 0;
}
}

function Tabulador($TotalYear,$con){
$sql = "SELECT dias FROM op_tabulador WHERE year = '".$TotalYear."'";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$dias = $row['dias'];
}	
return $dias;
}

function ToComentarios($idPersonal,$Year,$con){

$sql_lista = "SELECT id FROM op_rh_formatos_vacaciones_comentarios WHERE id_usuario_vacaciones = '".$idPersonal."' AND year = '".$Year."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);

}

$sql_personal = "SELECT
op_rh_personal.id,
op_rh_personal.id_estacion,
op_rh_personal.fecha_ingreso,
op_rh_personal.nombre_completo,
op_rh_personal.puesto AS idPuesto,
op_rh_personal.curp,
op_rh_personal.rfc,
op_rh_personal.nss,
op_rh_personal.sd,
op_rh_puestos.puesto,
op_rh_personal.documentos,
op_rh_personal.estado
FROM op_rh_personal
INNER JOIN op_rh_puestos 
ON op_rh_personal.puesto = op_rh_puestos.id
WHERE op_rh_personal.id_estacion = '".$idEstacion."' AND op_rh_personal.estado = 1 ORDER BY op_rh_personal.id ASC ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);

function Vacaciones($id, $year, $con){

$sql = "SELECT 
op_rh_formatos.id,
op_rh_formatos.status,
op_rh_formatos_vacaciones.id_usuario,
op_rh_formatos_vacaciones.num_dias,
op_rh_formatos_vacaciones.fecha_inicio,
op_rh_formatos_vacaciones.fecha_termino,
op_rh_formatos_vacaciones.fecha_regreso,
op_rh_formatos_vacaciones.observaciones
FROM op_rh_formatos 
INNER JOIN op_rh_formatos_vacaciones 
ON op_rh_formatos.id = op_rh_formatos_vacaciones.id_formulario 
WHERE op_rh_formatos_vacaciones.id_usuario = '".$id."' AND YEAR(fecha_inicio) = '".$year."' ORDER BY id DESC LIMIT 1 ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$numdias = $row['num_dias'];
$fechainicio = $row['fecha_inicio'];
$fechatermino = $row['fecha_termino'];
$fecharegreso = $row['fecha_regreso'];
$status = $row['status'];
}
    
$array = array('id' => $id, 'numdias' => $numdias,'fechainicio' => $fechainicio, 'fechatermino' => $fechatermino, 'fecharegreso' => $fecharegreso, 'status' => $status, 'resultado' => $numero);

}else{

$array = array('id' => 0, 'numdias' => 0,'fechainicio' => '', 'fechatermino' => '', 'fecharegreso' => '', 'status' => 0, 'resultado' => $numero);
}

return $array;
}

function FechaVacaciones($fechaFormato){

  if($fechaFormato != ''){
  $formato_fecha = explode("-",$fechaFormato);
  $resultado = $formato_fecha[2]." de ".nombremes($formato_fecha[1])." del ".$formato_fecha[0];
  }else{
  $resultado = '';
  }
  return $resultado;
}


function VacacionesTotal($id, $year, $con){

$diastotal = 0;
$sql = "SELECT 
op_rh_formatos_vacaciones.num_dias
FROM op_rh_formatos 
INNER JOIN op_rh_formatos_vacaciones 
ON op_rh_formatos.id = op_rh_formatos_vacaciones.id_formulario 
WHERE op_rh_formatos_vacaciones.id_usuario = '".$id."' AND YEAR(fecha_inicio) = '".$year."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$diastotal = $diastotal + $row['num_dias'];
}

return $diastotal;
}

function PrimaVacacional($idPersonal, $Year, $con){

$sql = "SELECT doc_nomina_firma FROM op_recibo_nomina_v2 WHERE year = '".$Year."' AND id_usuario = '".$idPersonal."' AND prima_vacacional = 2 ";
$result = mysqli_query($con, $sql);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$documento = $row['doc_nomina_firma'];
} 
return $documento;

}
?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="border-0 p-3">

<div class="row">
<div class="col-10">
<h5><?=$estacion;?> <?=$_GET['Year'];?></h5>
</div>
<div class="col-2">
<img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>agregar.png" onclick="Formulario(5,<?=$idEstacion;?>)">
<img class="float-end pointer ms-2" src="<?=RUTA_IMG_ICONOS;?>buscar-tb.png" onclick="ModalBuscar(<?=$idEstacion;?>)">
</div>
</div>
<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .90em">
<thead class="tables-bg">
  <tr>
    <th colspan="4"></th>
    <th class="align-middle text-center" colspan="2">Prima vacacional</th>
    <th class="align-middle text-center" colspan="8">Vacaciones</th>
  </tr>
  <tr>
    <th class="align-middle text-center">#</th>
    <th class="align-middle text-center">Fecha ingreso</th>
    <th class="align-middle">Nombre completo</th>
    <th class="align-middle">Puesto</th>
    <th class="align-middle text-center">Mes</th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
    <th class="align-middle text-center">Días</th>
    <th class="align-middle text-center">Fecha inicio</th>
    <th class="align-middle text-center">Fecha regreso</th>
    <th class="align-middle text-center">Total días año</th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
    <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  </tr>
</thead>
<tbody>
  <?php
  if ($numero_personal > 0) {
  while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){

    $explode = explode("-", $row_personal['fecha_ingreso']);
    $Mes = $explode[1];
    $Vacaciones = Vacaciones($row_personal['id'], $_GET['Year'], $con);

    $FechaInicio = FechaVacaciones($Vacaciones['fechainicio']);
    $FechaTermino = FechaVacaciones($Vacaciones['fechatermino']);

    $FechaRegreso = FechaVacaciones($Vacaciones['fecharegreso']);

    $VacacionesTotal = VacacionesTotal($row_personal['id'], $_GET['Year'], $con);

    $fechaActual = date('Y-m-d');
    $fechaActual2 = FechaVacaciones($fechaActual);

    if($fechaActual2 < $FechaInicio ){
      $colorFechas = "text-warning";
    
    }if ($fechaActual2 >= $FechaInicio && $fechaActual2 <= $FechaTermino) {
      $colorFechas = "text-primary";

    }else if($FechaTermino < $fechaActual2){
      $colorFechas = "text-success";
    }

 

    if($Vacaciones['resultado'] == 0){

      $trColor = "";
      $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="DetalleFormulario('.$row_personal['id'].','.$_GET['Year'].',5)">';
      $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png">';
      $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
    
    }else{
      $Detalle = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" onclick="DetalleFormulario('.$row_personal['id'].','.$_GET['Year'].',5)">';
      
      if($Vacaciones['status'] == 1){
      $Editar = '<img src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="EditFormulario('.$idEstacion.','.$Vacaciones['id'].',5)">';
      $Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" onclick="Firmar('.$idEstacion.','.$Vacaciones['id'].')">';
      $PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png">';
      }else if($Vacaciones['status'] == 2){
      $trColor = ""; 
      $Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png">';
      $Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png">';
      $PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" >';
      }
    }

    $ToComentarios = ToComentarios($row_personal['id'], $_GET['Year'],$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  }

  $PrimaVacacional = PrimaVacacional($row_personal['id'], $_GET['Year'], $con);
  if($PrimaVacacional == ""){
    $PrimaV = '';
  }else{
    $PrimaV = '<a href="archivos/recibos-nomina-v2/firmados/'.$PrimaVacacional.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png"></a>';
  }


  
  echo '<tr class="'.$trColor.'">
        <td class="align-middle text-center">'.$row_personal['id'].'</td>
        <td class="align-middle text-center">'.$row_personal['fecha_ingreso'].'</td>
        <td class="align-middle">'.$row_personal['nombre_completo'].'</td>
        <td class="align-middle">'.$row_personal['puesto'].'</td>
        <td class="align-middle text-center">'.nombremes($Mes).' '.$_GET['Year'].'</td>
        <td class="align-middle">'.$PrimaV.'</td>
        <td class="align-middle text-center"><b>'.$Vacaciones['numdias'].'</b></td>
        <td class="align-middle text-center '.$colorFechas.'">'.$FechaInicio.'</td>
        <td class="align-middle text-center '.$colorFechas.'">'.$FechaRegreso.'</td>
        <td class="align-middle text-center "><b>'.$VacacionesTotal.'</b></td>
        <td class="align-middle">'.$Detalle.'</td>
        <td class="align-middle">'.$Firmar.'</td>
        <td class="align-middle">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$idEstacion.','.$row_personal['id'].','.$_GET['Year'].')"></td>
        <td class="align-middle">'.$Editar.'</td>
        </tr>';
  }
  }else{
  echo "<tr><td colspan='9' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
  }
  ?>
</tbody>
</table>
</div>



</div>
</div>

</div>