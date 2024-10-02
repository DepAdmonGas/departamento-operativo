<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$idYear = $_GET['idYear'];

$sql_listaestacion = "SELECT nombre FROM tb_estaciones WHERE id = '".$idEstacion."' ";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['nombre'];
}

function Total($idDocumento,$idEstacion,$idYear,$con){

$sql_lista = "SELECT * FROM op_miselanea_documentos_archivo WHERE id_estacion = '".$idEstacion."' AND year = '".$idYear."' AND id_documento = '".$idDocumento."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

return $numero_lista;
}
?>


<div class="col-12">
  <div aria-label="breadcrumb" style="padding-left: 0; margin-bottom: 0;">
  <ol class="breadcrumb breadcrumb-caret">
  <li class="breadcrumb-item" onclick="history.back()"><a class="text-uppercase text-primary pointer"><i class="fa-solid fa-house"></i> Miselanea 30, 31 (Ejercicio <?=$idYear;?>)</a></li>
  <li aria-current="page" class="breadcrumb-item active text-uppercase">Certificación (<?=$estacion;?>), <?=$idYear;?></li>
  </ol>
  </div>

  <div class="row">
  <div class="col-12">
  <h3 class="text-secondary" style="padding-left: 0; margin-bottom: 0; margin-top: 0;">Certificación (<?=$estacion;?>), <?=$idYear;?></h3>
  </div>

  </div>

  <hr>

  <div class="table-responsive">
  <table id="tabla_certificacion_<?=$idEstacion ?>_<?=$idYear?>" class="custom-table" style="font-size: 12.5px;" width="100%"> 
  
  <thead class="tables-bg">
    <tr>
    <th class="align-middle text-center">#</th>
    <th class="align-middle">Documento</th>
    <th class="text-center align-middle" width="24">
    <img src="<?=RUTA_IMG_ICONOS?>archivo-tb.png">
    </th>
    </tr>
  </thead> 

  <tbody class="bg-white">
 
  <?php
  $sql_lista = "SELECT * FROM op_miselanea_documentos WHERE categoria = 2 ORDER BY id_lista ASC";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
  $id = $row_lista['id'];

  $Total = Total($id,$idEstacion,$idYear,$con);
  if($Total != 0){
  $DocT = '<div class="position-absolute" style="margin-bottom: -15px; right: 2px;"><span class="badge bg-primary text-white rounded-circle"><span class="fw-bold" style="font-size: 10px;">'.$Total.'</span></span></div>';
  }else{
  $DocT = '';	
  }

  echo '<tr>';
  echo '<th class="align-middle text-center" width="60px">'.$row_lista['id_lista'].'</th>';
  echo '<td class="align-middle text-start">'.$row_lista['documento'].'</td>';
  echo '<td class="align-middle text-center position-relative" onclick="Modal('.$id.','.$idEstacion.','.$idYear.')">'.$DocT.'<img class="pointer" src="'.RUTA_IMG_ICONOS.'archivo-tb.png" ></td>';

  echo '</tr>';

  }
  ?>

  </tbody>
  </table>
  </div>


  </div>








