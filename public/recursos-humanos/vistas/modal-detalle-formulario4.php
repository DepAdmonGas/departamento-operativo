<?php
require('../../../app/help.php');

$idFormato = $_GET['idFormato'];

$sql = "SELECT * FROM op_rh_formatos WHERE id = '".$idFormato."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$explode = explode(' ', $row['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));
$Localidad = $row['id_localidad'];
}

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
$sql = "SELECT nombre FROM tb_usuarios WHERE id = '".$idusuario."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$nombre = $row['nombre'];
}
return $nombre;
}
?>
  <script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>

<div class="modal-header">
<h5 class="modal-title">Detalle Baja de Personal</h5>
<button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
</div>


<div class="modal-body">

<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0">
<tbody>
<tr>
  <td class="align-middle text-center">Ref. Incidencias de personal</td>
  <td rowspan="3" class="text-center align-middle" width="250"><b>BAJA DE PERSONAL</b></td>
  <td class="align-middle text-center">Sucursal:</td>
  <td class="align-middle text-center">Grupo Admongas</td>
</tr>
<tr>
  <td class="align-middle text-center">Departamento de Recursos Humanos</td>
  <td class="align-middle text-center">Fecha:</td>
  <td class="align-middle text-center"><?=FormatoFecha($explode[0]).', '.$HoraFormato;?></td>
</tr>
<tr>
  <td class="align-middle text-center">Depto.Operativo</td>
  <td class="align-middle text-center">No. De control:</td>
  <td class="align-middle text-center"><b>011</b></td>
</tr>
</tbody>
</table>
</div>

<div class="mt-3">
<div class="border">
<div class="p-3">

<b>Lic. Alejandro Guzmán</b>
<br>
<b>Departamento de Recursos Humanos</b><br>
<hr>
Buenos días por medio del presente solicito de su amable apoyo para realizar las siguientes bajas de personal:<br>


<div class="table-responsive">
<table class="table table-sm table-bordered pb-0 mb-0 mt-2">
<thead class="tables-bg">
  <tr>
  <th>Fecha de baja</th>
  <th>Nombre del empleado</th>
  <th>Motivo de baja</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png" data-toggle="tooltip" data-placement="top" title="Archivo"></th>
  </tr>
</thead> 
<tbody>
<?php
$sql_lista = "SELECT * FROM op_rh_formatos_baja WHERE id_formulario = '".$idFormato."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$fecha_baja = FormatoFecha($row_lista['fecha_baja']);
$archivo = $row_lista['archivo'];

if($fecha_baja == ""){
$fecha_tb = "S/I";
}else{
$fecha_tb = $fecha_baja;
}

if($archivo == ""){
$archivo_tb = '<th class="align-middle text-center" width="32"><img src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar"></th>';
}else{
$archivo_tb = '<th class="align-middle text-center" width="32"><a href="'.RUTA_ARCHIVOS.'documentos-personal/solicitud-baja/'.$archivo.'" download><img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="Archivos"></a></th>';  
}

$personal = NombrePersonal($row_lista['id_personal'],$con);

echo '<tr>';
echo '<td class="align-middle">'.$fecha_tb.'</td>';
echo '<td class="align-middle">'.$personal.'</td>';
echo '<td class="align-middle">'.$row_lista['baja'].'</td>';
echo $archivo_tb;
echo '</tr>';
}
}else{
echo "<tr><td colspan='7' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
}
?>
</tbody>
</table>
</div>

<hr>

<div class="mt-3 text-center justify-content-md-center">
Sin más por el momento quedo de usted.
</div>

<div class="row justify-content-md-center">
<?php

$sql_firma = "SELECT * FROM op_rh_formatos_firma WHERE id_formato = '".$idFormato."' ";
$result_firma = mysqli_query($con, $sql_firma);
$numero_firma = mysqli_num_rows($result_firma);


while($row_firma = mysqli_fetch_array($result_firma, MYSQLI_ASSOC)){
$explode = explode(' ', $row_firma['fecha']);


    if($row_firma['tipo_firma'] == "A"){
   
    $Detalle = '
    <div class="border p-3">
    <h6 class="mt-2 text-secondary text-center">Elaboró</h6><hr>
    <div class="border p-1 text-center"><img src="'.RUTA_IMG.'/firma/'.$row_firma['firma'].'" width="70%"></div>
    <div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>
    </div>';


    }else if($row_firma['tipo_firma'] == "B"){

    $Detalle = '
    <div class="border p-3">
    <h6 class="mt-2 text-secondary text-center">Vo.Bo</h6><hr>
    <div class="border p-1 text-center">
    <div class="border-bottom text-center p-2"><small>La solicitud de cheque se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div></div>
    <div class="text-center mt-2">'.Personal($row_firma['id_usuario'],$con).'</div>
    </div>';



    }else if($row_firma['tipo_firma'] == "C"){
   
    $Detalle = ' <div class="border p-3"><div class="mb-1 text-center">
    <b>Atentamente</b></br>'.Personal($row_firma['id_usuario'],$con).'</div>
    <br>
    <div class="border-bottom text-center p-3" style="font-size: 0.9em;"><small>El formato se firmó por un medio electrónico.</br> <b>Fecha: '.FormatoFecha($explode[0]).', '.date("g:i a",strtotime($explode[1])).'</b></small></div>
    <h6 class="mt-2 text-secondary text-center">NOMBRE Y FIRMA DE AUTORIZACIÓN</h6>
    </div> </div>';

    }

    echo '<div class="col-xl-6 col-lg-6 col-md-6 col-sm-12 mt-3">';
    echo $Detalle;
    echo '</div>';


}

?> 


</div>

</div>