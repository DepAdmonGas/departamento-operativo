<?php 
require('../../../../../app/help.php');
$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosLocalidades($idEstacion);

//---------- VISUALIZACIONES PUESTOS ----------
if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$estacion = "";
$ocultarbtn = "d-none";
       
}else{
$estacion = '('.$datosEstacion['localidad'].')';
$ocultarbtn = "";
            
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



<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-home"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Formatos <?=$estacion?></li>
</ol>
</div>
   
<div class="row"> 
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"> <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Formatos <?=$estacion?></h3> </div>
  
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"> 
    
<div class="text-end">
<div class="dropdown d-inline ms-2">
<button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
Formatos
</button>

<ul class="dropdown-menu">
<li onclick="Formulario(1,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 1. Alta de personal</a></li>
<li onclick="Formulario(2,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 2. Baja de personal</a></li>
<li onclick="Formulario(3,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 3. Falta de personal</a></li>
<li onclick="Formulario(4,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 4. Reestructuración de personal</a></li>
<li onclick="Formulario(5,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 5. Ajuste Salarial</a></li>
<li onclick="Formulario(6,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 6. Formato de Vacaciones</a></li>
<li onclick="Formulario(7,<?=$idEstacion;?>)"><a class="dropdown-item pointer"> 7. Solicitud de Prima Vacacional</a></li>
</ul>
</div>
</div>

</div>
</div>

<hr>
</div>

 
<div class="table-responsive">
<table id="tabla_formatos_<?=$idEstacion?>" class="custom-table" style="font-size: .75em;" width="100%">
<thead class="tables-bg">
<tr>
<th class="text-center">#</th>
<th class="align-middle text-center">Fecha y Hora</th>
<th class="align-middle text-center">Nombre del empleado</th>
<th class="align-middle text-center">Formato</th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-firmar-w.png"></th>
<th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>icon-comentario-tb.png"></th>
<th class="text-center align-middle" width="20"><i class="fas fa-ellipsis-v"></i></th>
</tr>
</thead>
<tbody class="bg-white">
  
<?php
$sql_lista = "SELECT * FROM op_rh_formatos WHERE id_localidad = '".$idEstacion."' AND (formato IN (1, 2, 3, 4, 5, 6, 7)) ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if ($numero_lista > 0) {
$num = 1;
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$id = $row_lista['id'];
$formato = $row_lista['formato'];


//---------- FORMATO NO. 1 - ALTAS PERSONAL ----------
if($row_lista['formato'] == 1){
$Formatos = "Alta de personal";

$sql_lista1 = "SELECT nombre FROM op_rh_formatos_alta WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista1 = mysqli_query($con, $sql_lista1);
$numero_lista1 = mysqli_num_rows($result_lista1);

if ($numero_lista1 > 0) {
while($row_lista1 = mysqli_fetch_array($result_lista1, MYSQLI_ASSOC)){
$NombreC = $row_lista1['nombre']; 
}

$tdName = '<td class="align-middle">'.$NombreC.'</td>';

}else{
$tdName = '<td class="align-middle"></td>';
}


//---------- FORMATO NO. 2 - BAJA DE PERSONAL ----------
}else if($row_lista['formato'] == 2){
$Formatos = "Baja de Personal";

$sql_lista2 = "SELECT id_personal FROM op_rh_formatos_baja WHERE id_formulario = '".$id ."' LIMIT 1 ";
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


//---------- FORMATO NO. 3 - FALTA DE PERSONAL ----------
}else if($row_lista['formato'] == 3){
$Formatos = "Falta de Personal";
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

 
//---------- FORMATO NO. 4 - REESTRUCTURACIÓN DE PERSONAL ----------
}else if($row_lista['formato'] == 4){
$Formatos = "Reestructuración de personal";

$sql_lista4 = "SELECT id_personal FROM op_rh_formatos_restructuracion WHERE id_formulario = '".$id ."' LIMIT 1 ";
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
  

//---------- FORMATO NO. 5 - AJUSTE SALARIAL ----------
}else if($row_lista['formato'] == 5){
$Formatos = "Ajuste Salarial";

$sql_lista5 = "SELECT id_personal FROM op_rh_formatos_ajuste_salarial WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista5 = mysqli_query($con, $sql_lista5);
$numero_lista5 = mysqli_num_rows($result_lista5);
  
if ($numero_lista5 > 0) {
while($row_lista5 = mysqli_fetch_array($result_lista5, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista5['id_personal'],$con);
}
  
$tdName = '<td class="align-middle">'.$NombreC.'</td>';
  
}else{
$tdName = '<td class="align-middle"></td>';
}  


}else if($row_lista['formato'] == 6){
$Formatos = "Formato Vacaciones";

$sql_lista6 = "SELECT id_usuario FROM op_rh_formatos_vacaciones WHERE id_formulario = '".$id ."' LIMIT 1 ";
$result_lista6 = mysqli_query($con, $sql_lista6);
$numero_lista6 = mysqli_num_rows($result_lista6);
  
if ($numero_lista6 > 0) {
while($row_lista6 = mysqli_fetch_array($result_lista6, MYSQLI_ASSOC)){
$NombreC = NombrePersonal($row_lista6['id_usuario'],$con);
}
  
$tdName = '<td class="align-middle">'.$NombreC.'</td>';
  
}else{
$tdName = '<td class="align-middle"></td>';
}  
  

 
}else if($row_lista['formato'] == 7){
$Formatos = "Solicitud de Prima Vacacional";
$sql_lista3 = "SELECT id_personal FROM op_rh_formatos_prima_vacacional WHERE id_formulario = '".$id ."' LIMIT 1 ";
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
       
}

$explode = explode(" ", $row_lista['fecha']);
$HoraFormato = date("g:i a",strtotime($explode[1]));

if($row_lista['status'] == 0){
$trColor = 'style="background-color: #ffb6af"';
$detalle = '  <a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
$Editar = '<a class="dropdown-item" onclick="EditFormulario('.$idEstacion.','.$id.','.$formato.')"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="DeleteFormulario('.$id.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>';


}else if($row_lista['status'] == 1){
$trColor = 'style="background-color: #fcfcda"';
$detalle = '  <a class="dropdown-item" onclick="DetalleFormulario('.$id.','.$formato.')"><i class="fa-regular fa-eye"></i> Detalle</a>';  
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="DeleteFormulario('.$id.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar('.$idEstacion.','.$id.')">';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>';


}else if($row_lista['status'] == 2){
$trColor = 'style="background-color: #fcfcda"';
$detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$id.','.$formato.')"><i class="fa-regular fa-eye"></i> Detalle</a>';  
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item" onclick="DeleteFormulario('.$id.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-firmar-vb.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar('.$idEstacion.','.$id.')">';
$PDF = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>';


}else if($row_lista['status'] == 3){
$trColor = 'style="background-color: #b0f2c2"';
$detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$id.','.$formato.')"><i class="fa-regular fa-eye"></i> Detalle</a>';  
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar formato" onclick="Firmar('.$idEstacion.','.$id.')">';
$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.','.$formato.')"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>';


}else if($row_lista['status'] == 4){
$trColor = 'style="background-color: #b0f2c2"';
$detalle = '<a class="dropdown-item" onclick="DetalleFormulario('.$id.','.$formato.')"><i class="fa-regular fa-eye"></i> Detalle</a>';  
$Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a>';
$Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
$Firmar = '<img class="grayscale" src="'.RUTA_IMG_ICONOS.'icon-firmar-ao.png" data-toggle="tooltip" data-placement="top" title="Firmar formato">';
$PDF = '<a class="dropdown-item" onclick="DescargarPDF('.$id.','.$formato.')"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a>';
  
}


  $ToComentarios = ToComentarios($id,$con);

  if($ToComentarios > 0){
  $Nuevo = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-danger text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$ToComentarios.' </span></span></div>';
    
  }else{
  $Nuevo = ''; 
  } 

  echo '<tr '.$trColor.'>';
  echo '<th class="align-middle text-center">'.$num.'</th>';
  echo '<td class="align-middle">'.$ClassHerramientasDptoOperativo->FormatoFecha($explode[0]).', '.$HoraFormato.'</td>';
  echo ''.$tdName.'';
  echo '<td class="align-middle">'.$Formatos.'</td>';
  echo '<td class="align-middle">'.$Firmar.'</td>';
  echo '<td class="align-middle text-center position-relative" onclick="ModalComentario('.$id.','.$idEstacion.')">'.$Nuevo.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'icon-comentario-tb.png" data-toggle="tooltip" data-placement="top" title="Comentarios"></td>';
  echo '<td class="align-middle">
  
<div class="dropdown-container">
<a class="btn btn-sm btn-icon-only text-dropdown-light dropdown-menu-left" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu dropdown-menu-left dropdown-menu-arrow">
  '.$detalle.'
  '.$PDF.'
  '.$Editar.'
  '.$Eliminar.'
  </div>
  </div>
       
  </td>';

  echo '</tr>';
  $num++;
  }
  }
  ?>
  </tbody>
  </table>
  </div>
