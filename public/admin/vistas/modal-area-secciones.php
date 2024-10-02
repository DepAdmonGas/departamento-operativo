<?php
require('../../../app/help.php');

$id = $_GET['id'];

$sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id = '".$id."' ";
$result_lista = mysqli_query($con, $sql_lista);
$numero_lista = mysqli_num_rows($result_lista);
while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
$idPedido = $row_lista['id_pedido'];
$Area = $row_lista['area'];
}

$sql_pedido = "SELECT * FROM op_pedido_materiales WHERE id = '".$idPedido."' ";
$result_pedido = mysqli_query($con, $sql_pedido);
$numero_pedido = mysqli_num_rows($result_pedido);
while($row_pedido = mysqli_fetch_array($result_pedido, MYSQLI_ASSOC)){
$id_estacion = $row_pedido['id_estacion'];
}

if($Area == 'Zona de despacho'){

Dispensario($id_estacion,$id,1,$con);

}else if($Area == 'Zona de tanques'){

Tanques($id_estacion,$id,2,$con);
	
}else if($Area == 'Baños clientes'){
Banos($id,3,'Hombre',$con);
Banos($id,3,'Mujer',$con);	
}

function Dispensario($idEstacion,$id,$cate,$con){

$sqlList = "SELECT * FROM tb_dispensarios WHERE id_estacion = '".$idEstacion."' ";
$resultList = mysqli_query($con, $sqlList);
$numeroList = mysqli_num_rows($resultList);
while($rowList = mysqli_fetch_array($resultList, MYSQLI_ASSOC)){

$DispensarioA = 'Dispensario: '.$rowList['no_dispensario'].', Lado: A';
$DispensarioB = 'Dispensario: '.$rowList['no_dispensario'].', Lado: B';

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND sub_area = '".$DispensarioA."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){
$sql_insert = "INSERT INTO op_pedido_materiales_area_otros (
id_area,
categoria,
sub_area,
estatus
    )
    VALUES 
    (
    '".$id."',
    '".$cate."',
    '".$DispensarioA."',
    0 
    )
    ";

mysqli_query($con, $sql_insert);
}

$sql2 = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND sub_area = '".$DispensarioB."' ";
$result2 = mysqli_query($con, $sql2);
$numero2 = mysqli_num_rows($result2);

if($numero2 == 0){
$sql_insert2 = "INSERT INTO op_pedido_materiales_area_otros (
id_area,
categoria,
sub_area,
estatus
    )
    VALUES 
    (
    '".$id."',
    '".$cate."',
    '".$DispensarioB."',
    0 
    )
    ";

mysqli_query($con, $sql_insert2);
}

}

}

function Tanques($idEstacion,$id,$cate,$con){

$sqlList = "SELECT * FROM tb_tanque_almacenamiento WHERE id_estacion = '".$idEstacion."' ";
$resultList = mysqli_query($con, $sqlList);
$numeroList = mysqli_num_rows($resultList);
while($rowList = mysqli_fetch_array($resultList, MYSQLI_ASSOC)){

$TanqueEstacion = 'Tanque: '.$rowList['no_tanque'].', '.$rowList['capacidad'].', '.$rowList['producto'];

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND sub_area = '".$TanqueEstacion."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){
$sql_insert = "INSERT INTO op_pedido_materiales_area_otros (
id_area,
categoria,
sub_area,
estatus
    )
    VALUES 
    (
    '".$id."',
    '".$cate."',
    '".$TanqueEstacion."',
    0 
    )";

mysqli_query($con, $sql_insert);
}

}

}

function Banos($id,$cate,$area,$con){

$sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND sub_area = '".$area."' ";
$result = mysqli_query($con, $sql);
$numero = mysqli_num_rows($result);

if($numero == 0){
$sql_insert = "INSERT INTO op_pedido_materiales_area_otros (
id_area,
categoria,
sub_area,
estatus
    )
    VALUES 
    (
    '".$id."',
    '".$cate."',
    '".$area."',
    0 
    )";

mysqli_query($con, $sql_insert);
}

}


?>
<div class="modal-header">
  <h5 class="modal-title"><?=$Area;?></h5>
  <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal" aria-label="Close"></button>
</div>

<div class="modal-body">

<?php 

if($Area == 'Zona de despacho'){

echo '<table class="table table-bordered table-sm">';
echo '<tbody>';

  $sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND categoria = 1 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

   $idSA  = $row['id'];

    if($row['estatus'] == 1){
    $checked = 'checked';  
    }else{
    $checked = '';
    $EditArea = '';
    }

  echo '<tr>
       <td>'.$row['sub_area'].'</td>
       <td class="align-middle text-center" width="30"><input type="checkbox" '.$checked.' id="Dispensario'.$idSA.'" onChange="EditRC('.$idSA.', 5, 0)"></td>
       </tr>';
  }

echo '</tbody>';
echo '</table>';

}

if($Area == 'Zona de tanques'){

echo '<table class="table table-bordered table-sm">';
echo '<tr class="table-light">
	<td colspan="2"><b>Tanque, Capacidad, Producto</b></td>
</tr>';
echo '<tbody>';

  $sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND categoria = 2 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

   $idSA  = $row['id'];

    if($row['estatus'] == 1){
    $checked = 'checked';  
    }else{
    $checked = '';
    $EditArea = '';
    }

  echo '<tr>
       <td>'.$row['sub_area'].'</td>
       <td class="align-middle text-center" width="30"><input type="checkbox" '.$checked.' id="Tanques'.$idSA.'" onChange="EditRC('.$idSA.', 6, 0)"></td>
       </tr>';
  }

echo '</tbody>';
echo '</table>';

}

if($Area == 'Baños clientes'){

echo '<table class="table table-bordered table-sm">';
echo '<tbody>';

  $sql = "SELECT * FROM op_pedido_materiales_area_otros WHERE id_area = '".$id."' AND categoria = 3 ";
  $result = mysqli_query($con, $sql);
  $numero = mysqli_num_rows($result);
  while($row = mysqli_fetch_array($result, MYSQLI_ASSOC)){

   $idSA  = $row['id'];

    if($row['estatus'] == 1){
    $checked = 'checked';  
    }else{
    $checked = '';
    $EditArea = '';
    }

  echo '<tr>
       <td>'.$row['sub_area'].'</td>
       <td class="align-middle text-center" width="30"><input type="checkbox" '.$checked.' id="BanosCliente'.$idSA.'" onChange="EditRC('.$idSA.', 7, 0)"></td>
       </tr>';
  }

echo '</tbody>';
echo '</table>';

}

?>

</div>

<div class="modal-footer">
<button type="button" class="btn btn-labeled2 btn-primary" onclick="FinSubArea()">
<span class="btn-label2"><i class="fa fa-check"></i></span>Finalizar</button>
</div>
