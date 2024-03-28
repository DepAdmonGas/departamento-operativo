<?php 
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];

$sql_listaestacion = "SELECT localidad FROM op_rh_localidades WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['localidad'];
}

function ToComentarios($IdReporte,$con){

$sql_lista = "SELECT id FROM op_recibo_formatos_comentarios WHERE id_formato = '".$IdReporte."' ";
$result_lista = mysqli_query($con, $sql_lista);
return $numero_lista = mysqli_num_rows($result_lista);
   
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
?>
 
<script type="text/javascript">
$(document).ready(function($){
$('[data-toggle="tooltip"]').tooltip();
});
</script>
 
<div class="border-0 p-3">

<div class="row">
 
<div class="col-9">
<?php if($idEstacion != $Session_IDEstacion){ ?>
<div><h5><?=$estacion;?></h5></div>
<?php }else{ ?>
   
    <div class="row">
    <div class="col-9">

    <img class="float-start pointer" src="<?=RUTA_IMG_ICONOS;?>regresar.png" onclick="Regresar()">
    
    <div class="row">
    <div class="col-12">

     <h5>Recursos humanos (Formatos) - <?=$session_nomestacion;?></h5>
    
    </div>
    </div>

    </div>
    </div> 

<?php } ?>

</div>
  
<?php if($session_idpuesto == 13 || $session_idpuesto == 14){ ?>
<div class="col-3">
<div class="float-end"> 

<div class="btn-group dropstart">
  <button type="button" class="btn btn-secondary dropdown-toggle btn-sm" data-bs-toggle="dropdown" aria-expanded="false">
    Formatos
  </button>
  <ul class="dropdown-menu">
  <a class="dropdown-item pointer" onclick="Formulario(1,<?=$idEstacion;?>)">1. Alta personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(2,<?=$idEstacion;?>)">2. Restructuración personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(3,<?=$idEstacion;?>)">3. Falta personal</a>
  <a class="dropdown-item pointer" onclick="Formulario(4,<?=$idEstacion;?>)">4. Baja personal</a>
  <!--<a class="dropdown-item" onclick="Formulario(5,<?=$idEstacion;?>)">5. Vacaciones personal</a>-->
  <a class="dropdown-item pointer" onclick="Formulario(6,<?=$idEstacion;?>)">5. Ajuste salarial</a>
  <!--    
  <a class="dropdown-item" onclick="Formulario4(4,<?=$idEstacion;?>)">4. Permisos</a>
  <a class="dropdown-item" onclick="Formulario5(5,<?=$idEstacion;?>)">5. Incapacidad</a>
  <a class="dropdown-item" onclick="Formulario6(6,<?=$idEstacion;?>)">6. Cambio y restructuración de personal</a>
  <a class="dropdown-item" onclick="Formulario7(7,<?=$idEstacion;?>)">7. Pago día festivo</a>
  <a class="dropdown-item" onclick="Formulario8(8,<?=$idEstacion;?>)">8. Nuevo puesto</a>
  <a class="dropdown-item" onclick="Formulario9(9,<?=$idEstacion;?>)">9. Rol de comodines</a>
  -->
  </ul>
</div>

</div>
</div>
<?php } ?>

</div>


<hr>
<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .90em">
<thead class="tables-bg">
<tr>
<th class="text-center">#</th>
<th>Fecha y Hora</th>
<th>Nombre del empleado</th>
<th>Formato</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>ver-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>pdf.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
</tr>
</thead>
<tbody>
  
<?php
$sql_lista = "SELECT * FROM op_rh_formatos WHERE id_localidad = '".$idEstacion."' AND (formato IN (1, 2, 3, 4, 6)) ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$formato = $row_lista['formato'];


//---------- FORMATO NO. 1 - ALTAS PERSONAL ----------
if($row_lista['formato'] == 1){
$Formato = "Alta personal";

$sql_lista1 = "SELECT nombres, apellido_p, apellido_m FROM op_rh_formatos_alta WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista1 = mysqli_query($con, $sql_lista1);
$numero_lista1 = mysqli_num_rows($result_lista1);

if ($numero_lista1 > 0) {
while($row_lista1 = mysqli_fetch_array($result_lista1, MYSQLI_ASSOC)){
$NombreC = $row_lista1['nombres'].' '.$row_lista1['apellido_p'].' '.$row_lista1['apellido_m']; 
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}


//---------- FORMATO NO. 2 - REESTRUCTURACION PERSONAL ----------
}else if($row_lista['formato'] == 2){
$Formato = "Restructuración personal";

$sql_lista2 = "SELECT id_personal FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista2 = mysqli_query($con, $sql_lista2);
$numero_lista2 = mysqli_num_rows($result_lista2);

if ($numero_lista2 > 0) {
while($row_lista2 = mysqli_fetch_array($result_lista2, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista2['id_personal'],$con);
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}

 
//---------- FORMATO NO. 3 - FALTA PERSONAL ----------
}else if($row_lista['formato'] == 3){
$Formato = "Falta personal";

$sql_lista3 = "SELECT id_personal FROM op_rh_formatos_falta WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista3 = mysqli_query($con, $sql_lista3);
$numero_lista3 = mysqli_num_rows($result_lista3);

if ($numero_lista3 > 0) {
while($row_lista3 = mysqli_fetch_array($result_lista3, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista3['id_personal'],$con);
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}

 
//---------- FORMATO NO. 4 - BAJA PERSONAL ----------
}else if($row_lista['formato'] == 4){
$Formato = "Baja personal";

$sql_lista4 = "SELECT id_personal FROM op_rh_formatos_baja WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista4 = mysqli_query($con, $sql_lista4);
$numero_lista4 = mysqli_num_rows($result_lista4);

if ($numero_lista4 > 0) {
while($row_lista4 = mysqli_fetch_array($result_lista4, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista4['id_personal'],$con);
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}

 

//---------- FORMATO NO. 5 - VACACIONES PERSONAL ----------
}else if($row_lista['formato'] == 5){
$Formato = "Vacaciones personal";

$sql_lista5 = "SELECT id_usuario FROM op_rh_formatos_vacaciones WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista5 = mysqli_query($con, $sql_lista5);
$numero_lista5 = mysqli_num_rows($result_lista5);

if ($numero_lista5 > 0) {
while($row_lista5 = mysqli_fetch_array($result_lista5, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista5['id_usuario'],$con);
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}

  
 
}else if($row_lista['formato'] == 6){
$Formato = "Ajuste salarial";

$sql_lista6 = "SELECT id_personal FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista6 = mysqli_query($con, $sql_lista6);
$numero_lista6 = mysqli_num_rows($result_lista6);

if ($numero_lista6 > 0) {
while($row_lista6 = mysqli_fetch_array($result_lista6, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista6['id_personal'],$con);
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}

}  
 

$explode = explode(" ", $row_lista['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));

if($row_lista['status'] == 0){
$trColor = 'style="background-color: #ffb6af"';
$Editar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar" onclick="EditFormulario('.$idEstacion.','.$id.','.$formato.')">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="DeleteFormulario('.$idEstacion.','.$id.')">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="PDF">';

}else if($row_lista['status'] == 1){
$trColor = 'style="background-color: #fcfcda"';  
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="DeleteFormulario('.$idEstacion.','.$id.')">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar('.$idEstacion.','.$id.')">';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="PDF">';

}else if($row_lista['status'] == 2){
$trColor = 'style="background-color: #fcfcda"';  
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar" onclick="DeleteFormulario('.$idEstacion.','.$id.')">';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar('.$idEstacion.','.$id.')">';
$PDF = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="PDF">';


}else if($row_lista['status'] == 3){
$trColor = 'style="background-color: #b0f2c2"';  
$Editar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'editar-tb.png" data-toggle="tooltip" data-placement="top" title="Editar">';
$Eliminar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'eliminar.png" data-toggle="tooltip" data-placement="top" title="Eliminar">';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
$PDF = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'pdf.png" data-toggle="tooltip" data-placement="top" title="PDF" onclick="DescargarPDF('.$id.')" >';
}

  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="float-end" style="margin-bottom: -5px"><span class="badge bg-danger text-white rounded-circle"><small>'.$ToComentarios.'</small></span></div>';
  }else{
  $Nuevo = ''; 
  }

  echo '<tr '.$trColor.'>';
  echo '<td class="align-middle text-center"><b>'.$row_lista['id'].'</b></td>';
  echo '<td class="align-middle"><b>'.FormatoFecha($explode[0]).', '.$HoraFormato.'</b></td>';
  echo ''.$tdName.'';
  echo '<td class="align-middle">'.$Formato.'</td>';
  echo '<td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'ver-tb.png" data-toggle="tooltip" data-placement="top" title="Detalle" onclick="DetalleFormulario('.$id.','.$formato.')"></td>';
  echo '<td class="align-middle">'.$PDF.'</td>';
  echo '<td class="align-middle">'.$Firmar.'</td>';
  echo '<td class="align-middle text-center">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" onclick="ModalComentario('.$id.','.$idEstacion.')" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
  echo '<td class="align-middle">'.$Editar.'</td>';
  echo '<td class="align-middle">'.$Eliminar.'</td>';
  echo '</tr>';
  }
  }else{
  echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";
  }
  ?>
  </tbody>
  </table>
  </div>
  </div>

