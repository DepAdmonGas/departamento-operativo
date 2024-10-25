<?php
require ('../../../../help.php');
$idEstacion = $_GET['idEstacion'];
$sql_comodines = "SELECT * FROM op_rh_rol_comodines ORDER BY id DESC"; 
$result_comodines = mysqli_query($con, $sql_comodines);
$numero_comodines = mysqli_num_rows($result_comodines);

if($Session_IDUsuarioBD == 354){
$ocultarDiv = "d-none";
$botonComodines = "";
$claseDropdown = "dropdown-menu-left";
    
}else{
$ocultarDiv = "";
$botonComodines = '<button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="FormularioComodines('.$idEstacion.')">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>';
$claseDropdown = "dropdown-menu-right";

}
?>

<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Recursos Humanos</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Rol de Comodines</li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Rol de Comodines</h3></div>
<div class="col-xl-3 col-lg-3 col-md-12 col-sm-12"><?=$botonComodines?></div>
</div>

<hr>     
</div>

<div class="col-12">
<div class="table-responsive">
<table id="tabla_rol_comodines_<?=$idEstacion?>" class="custom-table" style="font-size: .75em;" width="100%">
<thead class="tables-bg">
<tr>
<th class="text-center align-middle fw-bold" width="48px">#</th>
<th class="text-center align-middle">Fecha de Inicio</th>
<th class="text-center align-middle">Fecha de Termino</th>
<td class="text-center align-middle" width="24"><i class="fas fa-ellipsis-v"></i></td>
</tr>
</thead>

<tbody class="bg-white">
<?php
if ($numero_comodines > 0) {

$num = 1;
while($row_comodines = mysqli_fetch_array($result_comodines, MYSQLI_ASSOC)){
$id = $row_comodines['id'];
$fecha_inicio = $row_comodines['fecha_inicio'];
$fecha_fin = $row_comodines['fecha_fin'];
$status = $row_comodines['status'];

if($fecha_inicio == "0000-00-00"){
$fecha_1 = "Sin información";
}else{
$fecha_1 = $ClassHerramientasDptoOperativo->FormatoFecha($fecha_inicio);
}

if($fecha_fin == "0000-00-00"){
$fecha_2 = "Sin información";
}else{
$fecha_2 = $ClassHerramientasDptoOperativo->FormatoFecha($fecha_fin);
}

if($status == 0){
$trColor = 'style="background-color: #fcfcda"';
$DetalleOP = '<a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a>';
$PdfOP = '<a class="dropdown-item grayscale"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$EliminarOP = '<a class="dropdown-item '.$ocultarDiv.'" onclick="EliminarRol('.$id.','.$idEstacion.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';

}else{
$trColor = 'style="background-color: #b0f2c2"';
$DetalleOP = '<a class="dropdown-item" onclick="ModalDetalleRol('.$id.')"><i class="fa-regular fa-eye"></i> Detalle</a>';
$PdfOP = '<a class="dropdown-item" onclick="DescargarRolPDF('. $id.')"><i class="fa-solid fa-file-pdf"></i> Descargar PDF</a>';
$EliminarOP = '<a class="dropdown-item  '.$ocultarDiv.' grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a>';
}

echo '<tr '.$trColor.'>
<th class="align-middle text-center"><b>'.$num.'</b></th>
<td class="align-middle">'.$fecha_1.'</td>
<td class="align-middle">'.$fecha_2.'</td>

<td class="align-middle text-center">
<div class="dropdown-container">
<a class="btn btn-sm btn-icon-only text-dropdown-light dropdown-menu-left" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
<i class="fas fa-ellipsis-v"></i>
</a>

<div class="dropdown-menu '.$claseDropdown.' dropdown-menu-arrow">
'.$DetalleOP.'
<a class="dropdown-item '.$ocultarDiv.'" onclick="EditarRol('.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
'.$PdfOP.'
'.$EliminarOP.'
</div>
</div>
</td>

</tr>';

$num++;
}
}
?>

</tbody>
</table>

</div>
</div>
 