<?php
require('../../../app/help.php');

$idEstacion = $_GET['idEstacion'];
$sql_listaestacion = "SELECT razonsocial FROM tb_estaciones WHERE id = '".$idEstacion."'";
$result_listaestacion = mysqli_query($con, $sql_listaestacion);
while($row_listaestacion = mysqli_fetch_array($result_listaestacion, MYSQLI_ASSOC)){
$estacion = $row_listaestacion['razonsocial'];
} 


$sql_lista = "SELECT * FROM op_senalamientos_dispensarios WHERE id_estacion = '".$idEstacion."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);

function Especificaciones($id,$con){
$sql = "SELECT * FROM op_senalamientos_dispensarios_especificaciones WHERE id_senalamiento = '".$id."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);
$contenido .= '<table class="table table-sm" style="font-size: .8em;">';
$contenido .= '<thead class="bg-light">
<tr class="text-center align-middle">
<th>Dimensión</th>
<th>Aprobación del modelo prototipo</th>
<th>Modelo</th>
<th>Número de serie</th>
<th>Material</th>
</tr></thead>';
$contenido .= '<tbody>';
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$contenido .= '<tr class="text-center align-middle">
<td>'.$row['dimension'].'</td>
<td>'.$row['aprobacion'].'</td>
<td>'.$row['modelo'].'</td>
<td>'.$row['no_serie'].'</td>
<td>'.$row['material'].'</td>
</tr>';
}
$contenido .= '</tbody>';
$contenido .= '</table>';
return $contenido;
}

?>

 
<div class="border-0 p-3">

<div class="row">

<div class="col-10">
<h5><?=$estacion;?></h5>
</div>

<div class="col-2">
  <img class="float-end pointer" src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ml-2" onclick="Agregar(<?=$idEstacion;?>)">
</div>

</div>

<hr>

<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
<thead class="tables-bg">
  <tr>
  <th class="text-center align-middle tableStyle font-weight-bold">#</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Dispensario</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Diseño</th>
  <th class="text-center align-middle tableStyle font-weight-bold">Especificaciones</th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>editar-tb.png"></th>
  <th class="align-middle text-center" width="20"><img src="<?=RUTA_IMG_ICONOS;?>eliminar.png"></th>
  </tr>
</thead> 
  <tbody>
  <?php
  if ($numero_lista > 0) { 
    $num = 1;
    while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    $id = $row_lista['id'];

     echo '<tr>
          <td class="align-middle text-center"><b>'.$num.'</b></td>
          <td class="align-middle text-center">'.$row_lista['dispensario'].'</td>
          <td class="align-middle text-center"><img src="../archivos/'.$row_lista['imagen'].'" width="100px" /></td>
          <td class="p-0 m-0">'.Especificaciones($id, $con).'</td>
          <td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$idEstacion.','.$id.')"></td>
          <td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$idEstacion.','.$id.')"></td>
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

</div>