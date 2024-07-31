<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
} 


$sql_lista = "SELECT * FROM op_senalamientos_dispensarios WHERE id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Especificaciones($id,$con){
$sql = "SELECT * FROM op_senalamientos_dispensarios_especificaciones WHERE id_senalamiento = '".$id."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
$contenido = "";

$contenido .= '<table class="custom-table" style="font-size: .9em;" width="100%">';
$contenido .= '<thead>
<tr class="text-center align-middle">
<th class="title-table-bg">Dimensión</th>
<th class="title-table-bg">Aprobación del modelo prototipo</th>
<th class="title-table-bg">Modelo</th>
<th class="title-table-bg">Número de serie</th>
<th class="title-table-bg">Material</th>
</tr>
</thead>';
$contenido .= '<tbody>';

if($numero > 0){
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$contenido .= '<tr class="text-center align-middle">
<th class="bg-light fw-normal">'.$row['dimension'].'</th>
<td class="bg-light">'.$row['aprobacion'].'</td>
<td class="bg-light">'.$row['modelo'].'</td>
<td class="bg-light">'.$row['no_serie'].'</td>
<td class="bg-light">'.$row['material'].'</td>
</tr>';
}
}else{
$contenido .=  "<tr><th colspan='5' class='text-center text-secondary bg-light fw-normal'><small>No se encontró información para mostrar </small></th></tr>";  

}
$contenido .= '</tbody>';
$contenido .= '</table>';
return $contenido;
}

?>



<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Señalamientos</a></li>
  <li aria-current="page" class="breadcrumb-item active">CALCOMANIAS PROFECO <?= strtoupper($estacion)?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">
  Calcomanias PROFECO (<?=$estacion?>)</h3></div>

  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">
  <button type="button" class="btn btn-labeled2 btn-primary float-end" onclick="Agregar(<?=$idEstacion;?>)">
  <span class="btn-label2"><i class="fa fa-plus"></i></span>Agregar</button>
  </div>

  </div>
 
  <hr> 
  </div>


<div class="table-responsive">
<table id="tabla_señalamientos_<?=$idEstacion?>" class="custom-table" style="font-size: .9em;" width="100%">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Dispensario</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Diseño</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Especificaciones</th>
  <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
  </tr>
</thead> 
  <tbody class="bg-white">
    
  <?php
  if ($numero_lista > 0) { 
  $num = 1;
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];

  if($row_lista['imagen'] == ""){
  $valImg = "S/I";
  }else{
  $valImg = '<img src="'.RUTA_ARCHIVOS.''.$row_lista['imagen'].'" width="100px" />';
  }
  

  echo '<tr>
  <td class="align-middle text-center"><b>'.$num.'</b></td>
  <td class="align-middle text-center">'.$row_lista['dispensario'].'</td>
  <td class="align-middle text-center">'. $valImg.'</td>
  <td class="p-3 m-0">'.Especificaciones($id, $con).'</td>

  <th class="align-middle text-center" width="20">
  <div class="dropdown">

  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  <a class="dropdown-item" onclick="ModalEditar('.$idEstacion.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
  <a class="dropdown-item" onclick="Eliminar('.$idEstacion.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
  </div>
  </div>
       
  </th>
  </tr>


  </tr>';

  $num++;
  }

  }else{
  echo "<tr><td colspan='10' class='text-center text-secondary'><small>No se encontró información para mostrar </small></td></tr>";  
  }
  ?>
  </tbody>
</table>
</div>
