<?php
require('../../../app/help.php');
$Senalamiento = $_GET['Senalamiento'];

if($_GET['Senalamiento'] == 1){
$titulo = 'NOM-003-SEGOB-2011';

}else if($_GET['Senalamiento'] == 2){
$titulo = 'NOM-005-ASEA-2016';

}else if($_GET['Senalamiento'] == 3){
$titulo = 'IMAGEN G500';
}

$sql_lista = "SELECT * FROM op_senalamientos WHERE id_imagen = '".$Senalamiento."' AND status = 1 ORDER BY id ASC";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Colores($id,$con){
 
$sql = "SELECT * FROM op_senalamientos_colores WHERE id_senalamiento = '".$id."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

$contenido = "";

$contenido .= '<table class="custom-table" style="font-size: .8em;" width="100%">';
$contenido .= '<tbody class="bg-light">';
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$contenido .= '<tr>
<th class="text-center align-middle fw-normal no-hover">'.$row['titulo'].'</th>
<td class="text-center align-middle no-hover">'.$row['detalle'].'</td>
</tr>';
}
$contenido .= '</tbody>';
$contenido .= '</table>';
return $contenido;
}
?>
   

  <div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item"><a onclick="history.back()" class="text-uppercase text-primary pointer"><i class="fa-solid fa-chevron-left"></i> Inventario</a></li>
  <li aria-current="page" class="breadcrumb-item active"><?=strtoupper($titulo)?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-xl-9 col-lg-9 col-md-12 col-sm-12"><h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;"><?=$titulo?></h3></div>
  <div class="col-xl-3 col-lg-3 col-md-12 col-sm-12">

 <div class="text-end">
 <div class="dropdown d-inline">
 <button type="button" class="btn dropdown-toggle btn-primary" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
 <i class="fa-solid fa-screwdriver-wrench"></i></span>
 </button>

  <ul class="dropdown-menu">
  <li onclick="Agregar(<?=$Senalamiento;?>)"><a class="dropdown-item pointer"><i class="fa-solid fa-plus text-dark"></i> Agregar Señalamiento</a></li>
  <li onclick="AgregarManual(<?=$Senalamiento;?>)"><a class="dropdown-item pointer"><i class="fa-regular fa-file-lines"></i> Documentación</a></li>

  </ul>
  </div>
  </div>

  </div>

  </div>
 
  <hr> 
  </div>


  <div class="table-responsive">
  <table id="tabla_señalamientos_<?=$Senalamiento?>" class="custom-table" style="font-size: .9em;" width="100%">
  <thead class="tables-bg">
    <tr>
    <th class="text-center align-middle tableStyle font-weight-bold">#</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Diseño</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Dimensión</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Colores</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Ubicación</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Reproducción</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Stock vinil</th>
    <th class="text-center align-middle tableStyle font-weight-bold">Stock placa</th>
    <th class="align-middle text-center" width="20"><i class="fas fa-ellipsis-v"></i></th>
    </tr>
  </thead> 

    <tbody class="bg-white">
    <?php
    if ($numero_lista > 0) { 
      $num = 1;
      while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
      $id = $row_lista['id'];

      $imagen = $row_lista['imagen'];

  if($imagen == ""){
  $valImg = "S/I";
  }else{
  $valImg = '<img src="'.RUTA_ARCHIVOS.''.$row_lista['imagen'].'" width="100px" />';
  }


  echo '<tr>
  <th class="align-middle text-center">'.$num.'</th>
  <td class="align-middle text-center">'.$valImg.'</td>
  <td class="align-middle text-center">'.$row_lista['dimension'].'</td>
  <td class="text-center p-2 m-0">'.Colores($id,$con).'</td>
  <td class="align-middle text-center">'.$row_lista['ubicacion'].'</td>
  <td class="align-middle text-center">'.$row_lista['reproduccion'].'</td>
  <td class="align-middle text-center">'.$row_lista['vinil'].'</td>
  <td class="align-middle text-center">'.$row_lista['placa'].'</td>


  <th class="align-middle text-center" width="20">
  <div class="dropdown">

  <a class="btn btn-sm btn-icon-only text-dropdown-light" type="button" id="dropdownMenuButton1" data-bs-toggle="dropdown" aria-expanded="false">
  <i class="fas fa-ellipsis-v"></i>
  </a>

  <div class="dropdown-menu dropdown-menu-right dropdown-menu-arrow">
  <a class="dropdown-item" onclick="ModalEditar('.$Senalamiento.','.$id.')"><i class="fa-solid fa-pencil"></i> Editar</a>
  <a class="dropdown-item" onclick="Eliminar('.$Senalamiento.','.$id.')"><i class="fa-regular fa-trash-can"></i> Eliminar</a>
  </div>
  </div>
       
  </th>
  </tr>';

  $num++;
  }

  }


    ?>
    </tbody>
  </table>
  </div>
