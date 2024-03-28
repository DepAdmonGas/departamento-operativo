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
$contenido .= '<table class="table table-sm" style="font-size: .8em;">';
$contenido .= '<tbody>';
while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){
$contenido .= '<tr>
<td class="text-center align-middle">'.$row['titulo'].'</td>
<td class="text-center align-middle">'.$row['detalle'].'</td>
</tr>';
}
$contenido .= '</tbody>';
$contenido .= '</table>';
return $contenido;
}
?>
   
 
<div class="border-0 p-3">

<div class="row">

<div class="col-9">
<h5><?=$titulo;?></h5>
</div>


<div class="col-3">
<img src="<?=RUTA_IMG_ICONOS;?>agregar.png" class="ms-2 float-end pointer" onclick="Agregar(<?=$Senalamiento;?>)">
<img src="<?=RUTA_IMG_ICONOS;?>archivo-tb.png" class="ms-2 float-end pointer" onclick="AgregarManual(<?=$Senalamiento;?>)">
</div>

</div>

<hr>


<div class="table-responsive">
<table class="table table-sm table-bordered mb-0" style="font-size: .9em;">
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
          <td class="align-middle text-center"><img src="'.RUTA_ARCHIVOS.''.$row_lista['imagen'].'" width="100px" /></td>
          <td class="align-middle text-center">'.$row_lista['dimension'].'</td>
          <td class="text-center p-0 m-0">'.Colores($id,$con).'</td>
          <td class="align-middle text-center">'.$row_lista['ubicacion'].'</td>
          <td class="align-middle text-center">'.$row_lista['reproduccion'].'</td>
          <td class="align-middle text-center">'.$row_lista['vinil'].'</td>
          <td class="align-middle text-center">'.$row_lista['placa'].'</td>
          <td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'editar-tb.png" onclick="ModalEditar('.$Senalamiento.','.$id.')"></td>
          <td class="align-middle text-center"><img class="pointer" src="'.RUTA_IMG_ICONOS.'eliminar.png" onclick="Eliminar('.$Senalamiento.','.$id.')"></td>
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