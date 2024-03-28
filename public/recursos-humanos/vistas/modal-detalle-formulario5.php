<?php
require('../../../app/help.php');

$idPersonal = $_GET['idPersonal'];
$Year = $_GET['Year'];

$sql = "SELECT 
op_rh_formatos.id,
op_rh_formatos.id_localidad,
op_rh_formatos.status,
op_rh_formatos_vacaciones.id_usuario,
op_rh_formatos_vacaciones.num_dias,
op_rh_formatos_vacaciones.fecha_inicio,
op_rh_formatos_vacaciones.fecha_termino,
op_rh_formatos_vacaciones.fecha_regreso,
op_rh_formatos_vacaciones.observaciones
FROM op_rh_formatos 
RIGHT JOIN op_rh_formatos_vacaciones 
ON op_rh_formatos.id = op_rh_formatos_vacaciones.id_formulario 
WHERE op_rh_formatos_vacaciones.id_usuario = '".$idPersonal."' AND YEAR(fecha_inicio) = '".$Year."' ORDER BY id DESC ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);


function NombrePersonal($id,$con){
$sql_personal = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$id."' ";
$result_personal = mysqli_query($con, $sql_personal);
$numero_personal = mysqli_num_rows($result_personal);
while($row_personal = mysqli_fetch_array($result_personal, MYSQLI_ASSOC)){
$return = $row_personal['nombre_completo'];	
}
return $return;
}

function NombreEstacion($id,$con){
$sql_listaestacion = "SELECT id, localidad FROM op_rh_localidades WHERE id = '".$id."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$return = $row_listaestacion['localidad'];	
}
return $return;
}

function Personal($idusuario,$con){
$sql = "SELECT nombre_completo FROM op_rh_personal WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre_completo'];
}
return $nombre;
}

function PersonalPortal($idusuario,$con){
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
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

$resultado .= '
<div>
<h6 class="text-secondary text-center">
Firma del solicitante
</h6>
</div>

<div class="">
<img src="imgs/firma/'.$firma.'" style="width: 100%;">
</div>

<div class="mb-1 text-center border-bottom">'.Personal($id_usuario,$con).'
</div>

<div>
<h6 class="mt-2 text-secondary text-center">
Nombre del solicitante</h6>
</div>';


}else if($tipo == 'B'){

if($numero_firma != 0){
$Detalle = '<div class="text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';  
}else{
$Detalle = '<div class="text-center text-danger p-4"><small></small></div>'; 
}

$resultado .= '<div class="p-2 border">
<div><h6 class="mt-2 text-secondary text-center">Firma de Recursos Humanos</h6></div>
'.$Detalle.'
<div><h6 class="mt-2 text-secondary text-center border-top mt-1">Vo.Bo. de Recursos Humanos</h6></div>
<div class="text-center mt-1">'.PersonalPortal($id_usuario,$con).'</div>

</div>';


}else if($tipo == 'C'){

if($numero_firma != 0){
$Detalle = '<div class="text-center p-2" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>';  
}else{
$Detalle = '<div class="text-center text-danger"><small>Falta firma</small></div>'; 
}

$resultado .= '<div class="p-2 border">
'.$Detalle.'
<div class="text-center border-bottom mb-1">'.PersonalPortal($id_usuario,$con).'</div>
<div><h6 class="mt-2 text-secondary text-center">NOMBRE Y FIRMA DE AUTORIZACIÓN</h6></div>
</div>';


}


return $resultado;
}
?>
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="modal-header">
<h5 class="modal-title">Detalle Solicitud de Vacaciones</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php if ($numero > 0) {
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$id = $row['id'];
$numdias = $row['num_dias'];
$fechainicio = $row['fecha_inicio'];
$fechatermino = $row['fecha_termino'];
$fecharegreso = $row['fecha_regreso'];
$status = $row['status'];
$Localidad = $row['id_localidad'];
$observaciones = $row['observaciones'];

echo '<div class="table-responsive">
  <div class="text-end">
  <img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" onclick="DescargarPDF('.$id.')" >
  </div>
  <table class="table table-bordered mt-2">

    <tr>
    <td class="font-weight-bold bg-light"><b>Área o Departamento:</b></td>
    <td class="font-weight-bold bg-light"><b>Nombre completo:</b></td>
    <td class="font-weight-bold bg-light"><b>Número de días a disfrutar:</b></td>
    </tr>
    <tr>
    <td>'.NombreEstacion($Localidad,$con).'</td>
    <td>'.Personal($idPersonal,$con).'</td>
    <td>'.$numdias.'</td>
    </tr>


    <tr>
      <td class="font-weight-bold bg-light"><b>Del:</b></td>
      <td class="font-weight-bold bg-light"><b>Al:</b></td>
      <td class="font-weight-bold bg-light"><b>Regresando el:</b></td>
    </tr>
    <tr>
      <td>'.FormatoFecha($fechainicio).'</td>
      <td>'.FormatoFecha($fechatermino).'</td>
      <td>'.FormatoFecha($fecharegreso).'</td>
    </tr>

  </table>
</div>';

echo '<div class="row"> 
<div class="col-12 mb-3"> 
<div class="border p-3"> 
<div class="font-weight-bold"><b>Observaciones:</b></div>
<hr>
<div class="">'.$observaciones.'</div>
</div>
</div>
</div>';

$Solicitante = Firmas($idFormato,'C',$con);

echo '<div class="border p-3"> 
<div class="font-weight-bold"><b>Firma:</b></div>
<hr>

<div class="row justify-content-md-center">
<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12">
    '.$Solicitante.' 
</div>

</div>
</div>';


echo '<div class="text-end"><button class="btn btn-sm btn-danger mt-2" type="button" onclick="DeleteFormulario('.$Localidad.','.$idPersonal.','.$Year.','.$id.')">Eliminar</button></div>';

echo '<hr>';
}
}else{
echo '<div class="text-center"><small>No se encontró información para mostrar </small></div>';
} ?>

<?php 

?>

</div>
 