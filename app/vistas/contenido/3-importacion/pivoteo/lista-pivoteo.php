<?php
require ('../../../../help.php');

$idEstacion = $_GET['idEstacion'];
$datosEstacion = $ClassHerramientasDptoOperativo->obtenerDatosEstacion($idEstacion);
 

$sql_lista = "SELECT * FROM op_pivoteo WHERE id_estacion = '" . $idEstacion . "' ORDER BY id DESC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

if($session_nompuesto == "Encargado" || $session_nompuesto == "Asistente Administrativo"){
$ocultarOp = "d-none";
$Estacion = '';

}else{ 
$ocultarOp = "";
$Estacion = '('.$datosEstacion['nombre'].')';
          
} 
   
?> 

 
<div class="col-12">
<div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
<ol class="breadcrumb breadcrumb-caret">
<li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Importación</a></li>
<li aria-current="page" class="breadcrumb-item active text-uppercase">Pivoteo <?=$Estacion?></li>
</ol>
</div>

<div class="row">
<div class="col-xl-9 col-lg-9 col-md-6 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"> Pivoteo <?=$Estacion?></h3></div>
<div class="col-xl-3 col-lg-3 col-md-6 col-sm-12"><button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Nuevo(<?=$idEstacion?>)">
<span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
</div>

</div>
<hr>
</div>


<div class="table-responsive">
<table id="tabla_pivoteo_<?=$idEstacion?>" class="custom-table" style="font-size: .8em;" width="100%">
    
<thead class="tables-bg">
<tr>
<th class="text-center align-middle tableStyle font-weight-bold">No. de control</th>
<th class="align-middle text-center tableStyle font-weight-bold">Fecha</th>
<th class="align-middle text-center tableStyle font-weight-bold">Sucursal</th>
<th class="align-middle text-center tableStyle font-weight-bold">Causa</th>
<th class="align-middle text-center" width="20"><i class="fa-solid fa-ellipsis-vertical text-white"></i></th>
</tr>
</thead>
 
<tbody class="bg-white">

  <?php
  if ($numero_lista > 0) {
  while ($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)) {
  $id = $row_lista['id'];
  $nocontrol = $row_lista['nocontrol'];
  $status = $row_lista['estatus'];

  if($status == 0){
  $tableColor = 'style="background-color: #ffb6af"';
  $Detalle = '  <a class="dropdown-item grayscale"><i class="fa-regular fa-eye"></i> Detalle</a> ';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a> ';
  $GMAIL = '<a class="dropdown-item grayscale '.$ocultarOp.'"><i class="fa-regular fa-envelope"></i> Envio por correo</a> ';
  $Editar = '<a class="dropdown-item" onclick="Editar(' . $idEstacion . ',' . $id . ')"><i class="fa-solid fa-pencil"></i> Editar</a> ';
  $Eliminar = '<a class="dropdown-item" onclick="Eliminar(' . $idEstacion . ',' . $id . ')"><i class="fa-regular fa-trash-can"></i> Eliminar</a> ';  

  }else if ($status == 1){
  $tableColor = 'style="background-color: #fcfcda"';
  $Detalle = '<a class="dropdown-item" onclick="VerPivoteo(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a> ';
  $PDF = '<a class="dropdown-item grayscale"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a> ';
  $GMAIL = '<a class="dropdown-item grayscale '.$ocultarOp.'"><i class="fa-regular fa-envelope"></i> Envio por correo</a> ';
  $Editar = ' <a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a> ';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a> ';  


  }else if ($status == 2){
  $tableColor = 'style="background-color: #b0f2c2"';
  $Detalle = '<a class="dropdown-item" onclick="VerPivoteo(' . $id . ')"><i class="fa-regular fa-eye"></i> Detalle</a> ';
  $PDF = '<a class="dropdown-item" onclick="PivoteoPDF(' . $id . ')"><i class="fa-regular fa-file-pdf"></i> Descargar PDF</a> ';
  $GMAIL = '<a class="dropdown-item '.$ocultarOp.'" onclick="GMail('.$idEstacion.','.$id.')"><i class="fa-regular fa-envelope"></i> Envio por correo</a> ';
  $Editar = '<a class="dropdown-item grayscale"><i class="fa-solid fa-pencil"></i> Editar</a> ';
  $Eliminar = '<a class="dropdown-item grayscale"><i class="fa-regular fa-trash-can"></i> Eliminar</a> ';  

  }

  if ($row_lista['fecha'] == '0000-00-00') {
  $Fecha = 'S/N';
  } else {
  $Fecha = FormatoFecha($row_lista['fecha']);
  }

  echo '<tr ' . $tableColor . '>';
  echo '<th class="align-middle text-center">0' . $nocontrol . '</th>';
  echo '<td class="align-middle text-center">' . $Fecha . '</td>';
  echo '<td class="align-middle text-center">' . $row_lista['sucursal'] . '</td>';
  echo '<td class="align-middle text-center">' . $row_lista['causa'] . '</td>';
  echo '<td class="align-middle text-center">
  <div class="dropdown">

  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  '.$Detalle.'
  '.$PDF.'
  '.$GMAIL.'
  '.$Editar.'
  '.$Eliminar.'
  </div>
  </div>
  </td>';

  echo '</tr>';

  }

  }

  ?>
  </tbody>
  </table>
  </div>