<?php
require('../../../app/help.php');

if($_POST['categoria'] == 1){

$sql1 = "DELETE FROM op_pedido_materiales WHERE id = '".$_POST['id']."' ";
  if (mysqli_query($con, $sql1)) {
    echo 1;
  } else {
    echo 0;
  }
  
}else if($_POST['categoria'] == 2){

$sql1 = "DELETE FROM op_pedido_materiales_detalle WHERE id = '".$_POST['id']."' ";
  if (mysqli_query($con, $sql1)) {
    echo 1;
  } else {
    echo 0;
  }
  
}else if($_POST['categoria'] == 3){

$sql1 = "DELETE FROM op_pedido_materiales_evidencia_foto WHERE id = '".$_POST['id']."' ";
  if (mysqli_query($con, $sql1)) {
    echo 1;
  } else {
    echo 0;
  }
  
}else if($_POST['categoria'] == 4){

  $sql1 = "DELETE FROM op_pedido_materiales_evidencia_foto WHERE id_evidencia = '".$_POST['id']."' ";
  if (mysqli_query($con, $sql1)) {
  
  $sql2 = "DELETE FROM op_pedido_materiales_evidencia_archivo WHERE id = '".$_POST['id']."' ";
  if (mysqli_query($con, $sql2)) {
    echo 1;
  } else {
    echo 0;
  }

  } else {
    echo 0;
  }


}else if($_POST['categoria'] == 5){
  $sql1 = "DELETE FROM op_pedido_materiales_instalacion WHERE id = '".$_POST['id']."' ";

  if (mysqli_query($con, $sql1)) {
    echo 1;
  } else {
    echo 0;
  }

}


 

//------------------
mysqli_close($con);
//------------------
?>