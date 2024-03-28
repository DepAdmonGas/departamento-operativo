<?php
require('../../../app/help.php');

if($_POST['categoria'] == 1){

$sql1 = "UPDATE op_pedido_materiales SET 
tipo_servicio = '".$_POST['valor']."'
WHERE id ='".$_POST['idPedido']."' ";
mysqli_query($con, $sql1);

}else if($_POST['categoria'] == 2){

$sql1 = "UPDATE op_pedido_materiales SET 
orden_trabajo = '".$_POST['valor']."'
WHERE id ='".$_POST['idPedido']."' ";
mysqli_query($con, $sql1);
 


}else if($_POST['categoria'] == 3){

$sql_lista = "SELECT * FROM op_pedido_materiales_area WHERE id = '".$_POST['idPedido']."' ";
  $result_lista = mysqli_query($con, $sql_lista);
  $numero_lista = mysqli_num_rows($result_lista);
  while($row_lista = mysqli_fetch_array($result_lista, MYSQLI_ASSOC)){
    
    if($row_lista['area'] == 'Zona de despacho'){
    $Result = 5;
    }else if($row_lista['area'] == 'Zona de tanques'){
    $Result = 5;
    }else if($row_lista['area'] == 'Baños clientes'){
    $Result = 5;
    }
  
  }

$sql1 = "UPDATE op_pedido_materiales_area SET 
estatus = '".$_POST['valor']."'
WHERE id ='".$_POST['idPedido']."' ";
mysqli_query($con, $sql1);

echo $Result;

}else if($_POST['categoria'] == 4){

  $sql_insert2 = "INSERT INTO op_pedido_materiales_area (
        id_pedido,
        area,
        estatus
    )
    VALUES 
    (
    '".$_POST['idPedido']."',
    '".$_POST['Area']."',
    1
    )"; 

    mysqli_query($con, $sql_insert2);

}else if($_POST['categoria'] == 5 || $_POST['categoria'] == 6 || $_POST['categoria'] == 7){

$sql1 = "UPDATE op_pedido_materiales_area_otros SET 
estatus = '".$_POST['valor']."'
WHERE id ='".$_POST['idPedido']."' ";
mysqli_query($con, $sql1);

}else if($_POST['categoria'] == 8){

$sql1 = "UPDATE op_pedido_materiales SET 
orden_riesgo = '".$_POST['valor']."'
WHERE id ='".$_POST['idPedido']."' ";
mysqli_query($con, $sql1);

  
}



//------------------
mysqli_close($con);
//------------------